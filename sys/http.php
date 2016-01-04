<?php
namespace Sys;
class HTTP {
	public static function server() {
		return $_SERVER['SERVER_NAME'];
	}

	public static function host() {
		return self::scheme() . '://' . self::server() . '/';
	}

	public static function scheme() {
		return !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	}

	public static function request() {
		return rtrim($_SERVER['REQUEST_URI'], '/');
	}

	public static function buildUrl(array $a = array('pathStr','queryStr')) {
		$r = '';
		foreach ($a as $c)
			$r.= ($c == 'queryStr' ? '?' : '') . self::$c();

		return $r;
	}

	public static function uri() {
		return filter_var(self::host() . self::request(), FILTER_SANITIZE_URL);
	}

	public static function pathStr() {
		if (!filter_var(self::uri(), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED))
			return '';

		return trim(parse_url(self::uri(), PHP_URL_PATH), '/');
	}

	public static function path() {
		return !empty(self::pathStr()) ? explode('/', self::pathStr()) : array();
	}

	public static function queryStr() {
		if (!filter_var(self::uri(), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED))
			return '';

		return parse_url(self::uri(), PHP_URL_QUERY);
	}

	public static function query() {
		parse_str(self::queryStr(), $p);
		return $p;
	}

	public static function ssl() {
		if (self::scheme() == 'http') {
			$url = self::buildUrl(array('host','pathStr','queryStr'));
			$url = str_replace('http://', 'https://', $url);
			header("Location: $url");
			exit;
		}
	}

	public static function cli() {
		return (php_sapi_name() === 'cli');
	}

	public static function ip(bool $p = true) {
		$ip = $_SERVER['REMOTE_ADDR'];
		return $p ? inet_pton($ip) : $ip;
	}

	public static function agent() {
		return trim($_SERVER['HTTP_USER_AGENT']);
	}

	public static function locale() {
		return locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	}

	public static function xmlhttprequest() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}

	public static function jsPost() {
		self::header('nocache');
		self::header('json');
		if (!self::xmlhttprequest())
			return array();

		parse_str(file_get_contents('php://input'), $post);
		return $post;
	}

	public static function jsReply($r) {
    self::header('nocache');
    self::header('json');
		exit(json_encode($r));
	}

	public static function jsRedirect(string $url) {
		self::header('nocache');
    self::header('json');
		exit(json_encode('<script>window.location.replace("'.$url.'");</script>'));
	}

	public static function redirect(string $uri = null, array $p = array()) {
	  $url = self::host() . (empty($uri) ? $_SESSION['redirect'] : $uri);
	  if (in_array('ssl', $p) && self::scheme() == 'http')
	    $url = str_replace('http://', 'https://', $url);

	  // Reset
	  unset($_SESSION['redirect']);

	  // Permanently
	  if (in_array('permanent', $p))
	    self::header(301);

	  // JS
	  if (in_array('js', $p))
	    self::jsRedirect($url);

	  header("Location: $url");
	  exit;
	}

	public static function header(string $c) {
		switch ($c) {
			case 'nocache':
			case 'no-cache':
				header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
				header('Cache-Control: post-check=0, pre-check=0', false);
				header('Pragma: no-cache');
				break;
			case 'json':
			case 'js':
				header('Accept: application/json, text/javascript, */*; q=0.01');
				break;
			case 400:
			case 'bad-request':
				header('HTTP/1.0 400 Bad Request');
				break;
			case 404:
			case 'not-found':
				header('HTTP/1.0 404 Not Found');
				break;
			case 550:
			case 'permission-denied':
				header('HTTP/1.0 550 Permission Denied');
				break;
			case 500:
			case 'error':
			case 'server-error':
			case 'fatal-error':
				header('HTTP/1.1 500 Internal Server Error');
				break;
			case 301:
			case 'permanent':
				header('HTTP/1.1 301 Moved Permanently');
				break;
		}
	}
}
?>

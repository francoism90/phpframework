<?php
namespace Sys;
class JS {
	public static function valid(string $s = '') {
    json_decode($s);
    return (json_last_error() == JSON_ERROR_NONE);
  }

	public static function out($s) {
		$s = (is_array($s) || !self::valid($s)) ? json_encode($s) : $s;
		HTTP::header('nocache');
		HTTP::header('json');
		exit($s);
	}

	public static function post() {
		$p = HTTP::post();
		if (!HTTP::xmlhttprequest() || empty($p))
			return array();

		HTTP::header('nocache');
		HTTP::header('json');
		return $p;
	}

	public static function redirect(string $url, string $m = 'href') {
		View::mSet(array('url' => $url, 'method' => "window.location.$m"));
		self::out(View::inc('js-redirect', true));
	}
}
 ?>

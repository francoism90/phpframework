<?php
namespace Sys;
class Session {
  public function __construct() {
    $c = Arr::merge('config/session/handler');
    ini_set('session.save_handler', $c['init']['savehandler']);
    ini_set('session.gc_maxlifetime', $c['init']['maxlifetime']);
    session_save_path($c['init']['savepath']);
    session_set_cookie_params(
      $c['cookie']['lifetime'],
      $c['cookie']['path'],
      $c['cookie']['domain'],
      $c['cookie']['secure'],
      $c['cookie']['httponly']);
    session_start();

    // Pop. Session
    self::set(Arr::merge('config/session/start'));
    self::set(Arr::merge('config/session/update'), true);
  }

  public static function set(array $a, bool $force = false) {
    foreach ($a as $k => $v) {
      if (empty($_SESSION[$k]) || $force)
        $_SESSION[$k] = $v;
    }
  }

  public static function destroy(string $n) {
		$p = session_get_cookie_params();
		setcookie($n, '', time() - $p['lifetime'], $p['path'],
			$p['domain'], $p['secure'], $p['httponly']);
	}
}
?>

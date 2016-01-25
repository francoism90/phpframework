<?php
namespace Sys;
class View {
  public static $var = array();

  public static function set(string $k, $v) {
    self::$var[$k] = $v;
  }

  public static function mSet(array $a) {
    foreach ($a as $k => $v)
      self::set($k, $v);
  }

  public static function get(string $k) {
    return self::$var[$k];
  }

  public static function inc(string $n, bool $b = false) {
    if ($b) ob_start();
		include("tpl/$n.php");
    if ($b) return ob_get_clean();
	}

  public static function except(array $e = array(), $h = 400) {
    HTTP::header('nocache');
    HTTP::header($h);
    self::mSet(array_merge(Arr::merge('config/view/except')[$h] ?: array(), $e));
    exit(self::inc('except'));
  }
}
?>

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

  public static function inc(string $n, bool $b = null) {
    if ($b) ob_start();
		include("tpl/$n.php");
    if ($b) return ob_get_clean();
	}

  public static function js($e) {
    HTTP::header('nocache');
    HTTP::header('json');
    exit(json_encode($e));
  }

  public static function except($e, string $h = 'bad-request') {
    if (empty(self::get('title')))
      self::set('title', _('Oops! An error has occurred'));

    HTTP::header('nocache');
    HTTP::header($h);
    self::$var['e'] = $e;
    exit(self::inc('except'));
  }
}
?>

<?php
namespace Sys;
class Locale {
	public function __construct() {
		$c = Arr::merge('config/locale/init');
		$u = $c['system'][self::lookup($c['default'], $c['available'])];
		putenv("LANG=$u");
		setlocale(LC_MESSAGES, $u);
		bindtextdomain($c['domain'], $c['path']);
		textdomain($c['domain']);
		bind_textdomain_codeset($c['domain'], 'UTF-8');
	}

	public static function lookup(string $s = 'en_US', array $a) {
		$c = $_SESSION['loc'] ?: HTTP::locale();
		return locale_lookup($a, $c, true, $s);
	}

	public static function validDate(string $s, string $form = 'd-m-Y H:i:s') {
    $d = \DateTime::createFromFormat($form, $s);
    return ($d && $d->format($form) == $s);
  }
}
 ?>

<?php
namespace Sys;
class Locale {
	public static function isDateTime(string $s, string $form = 'd-m-Y H:i:s') {
    $d = \DateTime::createFromFormat($form, $s);
    return ($d && $d->format($form) == $s);
  }
}
 ?>

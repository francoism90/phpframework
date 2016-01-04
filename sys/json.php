<?php
namespace Sys;
class JSON {
	public static function isJSON(string $s) {
    json_decode($s);
    return (json_last_error() == JSON_ERROR_NONE);
  }
}
 ?>

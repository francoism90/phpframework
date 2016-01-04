<?php
namespace Sys;
class Arr {
	public static function merge(string $n) {
		$a = array();
		foreach (array(SYS_DIR . "$n.php", APP_DIR . "$n.php") as $v) {
			if (file_exists($v))
				$a = array_replace($a, include($v));
		}
		return $a;
	}

	public static function prefix(array $a, string $p = '%') {
		foreach ($a as $k => $v) {
   		$a["$p$k"] = $v;
			unset($a[$k]);
		}
		return $a;
	}

	public static function match(string $k, $v, string $p) {
    return (${$p}[$k] == $v);
  }

	public static function set(array $a, string $p, bool $force = false) {
    foreach ($a as $k => $v) {
      if (empty(${$p}[$k] || $force))
        ${$p}[$k] = $v;
    }
  }
}
 ?>

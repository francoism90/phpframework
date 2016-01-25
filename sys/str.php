<?php
namespace Sys;
class Str {
	public static function random(int $l = 16, array $a = array()) {
		$c = array_merge(Arr::merge('config/str/random'), $a);
		$ch = implode('', $c);
		for ($i = 0; $i < $l; $i++) {
			$s.= $ch[mt_rand(0,strlen($ch))];
		}
		return $s;
	}

	public static function trim(&$s) {
		if (is_string($s)) return trim($s);
		return $s; // skip array
	}

	public static function replace(string $s, array $a = array(), string $p = '%') {
		if (!empty($p))	$a = Arr::prefix($a, $p);
		return str_replace(array_keys($a), array_values($a), $s);
	}

	public static function count(string $s, string $e = '-|_|@') {
		foreach (count_chars($s, 1) as $i => $v) {
			if (ctype_lower(chr($i))) $c['lower'] += $v;
			elseif (ctype_upper(chr($i))) $c['upper'] += $v;
			elseif (ctype_digit(chr($i)))	$c['digit'] += $v;
			elseif (!empty($e) && in_array(chr($i), explode('|', $e))) $c['extra'] += $v;
			else $c['unknown'] += $v;
		}
		return $c;
	}

	public static function match(string $a, string $b) {
    return (mb_strtolower($a, 'UTF-8') === mb_strtolower($b, 'UTF-8'));
  }

	public static function length(string $s, int $min = 0, int $max = 5) {
    return ((strlen($s) >= $min) && (strlen($s) <= $max));
  }

	public static function word(string $s, array $a) {
    foreach ($a as $w) {
      if (stristr($s, $w) !== false)
        return true;
    }
    return false;
  }

	public static function chars(string $s, array $a, string $e = '') {
		$r = array();
		$c = self::count($s, $e);
    foreach ($a as $k => $v) {
      $m = array(0 => substr($k, 0, 2), 1 => substr($k, 3));
      if ($m[0] == 'min' && $c[$m[1]] < $v)
        $r[$m] = $v;
 			elseif ($c[$m[1]] > $v)
        $r[$m] = $v;
    }
    return $r;
  }

	public static function strstr(string $s, string $n = '@') {
		return substr($s, 0, strpos($s, $n));
	}
}
?>

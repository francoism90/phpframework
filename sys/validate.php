<?php
namespace Sys;
class Validate {
  public $out = array();
  public $res = array();

  public function __construct(string $n, array $p = array()) {
    foreach (Arr::merge("config/form/$n") as $k => $v) {
      $val = $p[$k] ?? $v['value'];

      // array
      if (is_array($val) && in_array($v['type'], array('radio','checkbox','select'))) {
        foreach ($val as $aKey => $aVal) {
          if (!array_key_exists($aVal, $v['option']))
            $this->res[$k][] = _('Please select a valid option');
        }
        if (!empty($this->res[$k])) continue;
      }

      // Santize
      if (!empty($v['sanitize'])) $val = filter_var($val, $v['sanitize'], $v['sanitize_flags']);
      if (!empty($v['sanitize_call'])) {
        foreach ($v['sanitize_call'] as $a => $s)
          $val = self::call($val, $s[0], $s[1]);
      }

      // Empty
      if (empty($val)) {
        if (empty($v['optional'])) $this->res[$k][] = _('This field is required');
        continue;
      }

      // Filter
      $this->out[$k] = $val;
      if (!empty($v['filter']) && !filter_var($val, $v['filter'], $v['filter_flags']))
        $this->res[$k][] = $v['filter'];
      if (!empty($v['filter_call'])) {
        foreach ($v['filter_call'] as $a => $s)
          if (!self::call($val, $s[0], $s[1]))
            $this->res[$k][] = $s[0];
      }
    }

    if (empty($this->out))
      HTTP::jsReply(_('Invalid data'));

    if (!empty($this->res)) {
      $m = Arr::merge('config/validate');
      foreach ($this->res as $k => $v) {
        if (ctype_graph($v))
          $this->res[$k] = $m[$v] ?? $v;
      }
      HTTP::jsReply($this->res);
    }
  }

  public static function call($v, string $m, $a = array()) {
    if (function_exists($m)) return !empty($a) ? $m($v, implode(',', $a)) : $m($v);
    return !empty($a) ? call_user_func($m, $v, implode(',', $a)) : call_user_func($m, $v);
  }
}
?>

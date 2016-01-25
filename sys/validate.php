<?php
namespace Sys;
class Validate {
  public $form = array();
  public $out = array();
  public $res = array();

  public function __construct(string $n, array $p = array(), bool $fatal = false) {
    $this->form = Arr::merge("config/form/$n");
    foreach ($this->form as $k => $v) {
      $val = $p[$k] ?: $v['value'];
      if (in_array($v['type'], array('radio','checkbox','select'))) {
        $arr = !is_array($val) ? array(0 => $val) : $val;
        foreach ($arr as $aKey => $aVal) {
          if (!array_key_exists($aVal, $v['option'])) {
            $this->res[$k][] = _('Please select a valid option');
            continue;
          }
        }
        $this->out[$k] = $val;
        continue;
      }

      // Santize
      if (!empty($v['sanitize'])) $val = filter_var($val, $v['sanitize'], $v['sanitize_flags']);
      if (!empty($v['sanitize_call'])) {
        foreach ($v['sanitize_call'] as $a => $s)
          $val = self::call($val, $s[0], $s[1]);
      }

      // Empty
      if (empty($val)) {
        $this->out[$k] = null;
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
            $this->res[$k][] = array($s[0], $s[1]);
      }
    }

    // On empty result/out
    if (empty($this->out) || !empty($this->res)) {
      if ($fatal) exit(var_dump($this->res));
      throw new Except\JS($this->result());
    }
  }

  public function result() {
    $m = Arr::merge('config/validate/out');
    $r = array();
    foreach ($this->res as $k => $v) {
      foreach ($v as $s) {
        $l = $this->form[$k]['label'] ?: $k;
        if (!is_array($s)) {
          $r[$l][] = $m[$s] ?: $s;
          continue;
        }
        // Replace with parameters (if needed)
        $r[$l][] = !empty($m[$s[0]]) && is_array($s[1]) ? \Sys\Str::replace($m[$s[0]], $s[1]) : $m[$s[0]] ?: $s[0];
      }
    }
    return $r;
  }

  public static function call($v, string $m, $a = array()) {
    return !empty($a) ? call_user_func_array($m, array_merge(array(0 => $v), $a)) : call_user_func($m, $v);
  }
}
?>

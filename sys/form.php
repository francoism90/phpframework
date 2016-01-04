<?php
namespace Sys;
class Form {
  public $out = array();

  public function __construct(string $n, array $p = array()) {
    foreach (Arr::merge("config/form/$n") as $k => $v) {
      $val = $p[$k] ?? $v['value'];
      $val = json_decode($val, true) ?? $val;
      if ($v['type'] == 'hidden') {
        $this->out[] = $this->input($k, 'hidden', null, $val);
        continue;
      }

      $this->out[] = '<div class="row">';
      $this->out[] = $this->label($k, $v['label'], $v['optional']);
      switch ($v['type']) {
        case 'text':
        case 'number':
        case 'password':
        case 'email':
          $this->out[] = self::input($k, $v['type'], $v['placeholder'], $val);
          break;
        case 'radio':
        case 'select':
        case 'checkbox':
          $this->out[] = self::{$v['type']}($k, $v['option'], $val);
          break;
        case 'textarea':
          $this->out[] = self::textarea($k, $v['placeholder'], $val);
          break;
      }
      $this->out[] = '</div>';
    }
  }

  public function __toString() {
    return implode(null, $this->out);
  }

  public static function label(string $k, string $v = null, bool $o = null) {
    return '<label for="'.$k.'">'.$v.(!isset($o) ? '*' : '').'</label>';
  }

  public static function input(string $k, string $t = 'text', string $p = null, string $v = null) {
    return '<input type="'.$t.'" id="'.$k.'" name="'.$k.'" placeholder="'.$p.'" value="'.$v.'">';
  }

  public static function select(string $k, array $a, $c = 0) {
    $r = '<select name="'.$k.'"';
    foreach ($a as $x => $v) {
      $r.= '<option value="'.$x.'"';
      if (is_array($c) && in_array($x, array_values($c)) || $x == $c)
        $r.= ' selected="selected"';
      $r.= ">$v</option>";
    }
    return $r . '</select>';
  }

  public static function radio(string $k, array $a, $c = 0) {
    foreach ($a as $x => $v) {
      $r.= '<input type="radio" id="'.$k.'-'.$x.'" name="'.$k.'" value="'.$x.'"';
      if (is_array($c) && in_array($x, array_values($c)) || $x == $c)
        $r.= ' checked="checked"';
      $r.= '> '.self::label("$k-$x", $v, true);
    }
    return $r;
  }

  public static function checkbox(string $k, array $a, $c = 0) {
    foreach ($a as $x => $v) {
      $r.= '<input type="checkbox" id="'.$k.'-'.$x.'" name="'.$k.'[]" value="'.$x.'"';
      if (is_array($c) && in_array($x, array_values($c)) || $x == $c)
        $r.= ' checked="checked"';
      $r.= '> '.self::label("$k-$x", $v, true);
    }
    return $r;
  }

  public static function textarea(string $k, string $p = null, string $v = null, int $r = 4, int $c = 50) {
    return '<textarea name="'.$k.'" id="'.$k.'" placeholder="'.$p.'" rows="'.$r.'" cols="'.$c.'">'.$v.'</textarea>';
  }
}
?>

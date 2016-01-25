<?php
namespace Sys;
class Form {
  public $out = array();

  public function __construct(string $n, array $p = array()) {
    foreach (Arr::merge("config/form/$n") as $k => $v) {
      // Value
      $v = array_merge(Arr::merge('config/form/default'), $v);
      $v['value'] = $p[$k] ?: $v['value'];
      if (is_string($v['value']) && JS::valid($v['value'])) $v['value'] = json_decode($v['value'], true);

      // Hidden
      if ($v['type'] == 'hidden') {
        $this->out[] = $this->input($k, 'hidden', '', $v['value']);
        continue;
      }

      $this->out[] = '<div class="row">';
      $this->out[] = $this->label($k, $v['label'], $v['optional'], $v['class']);
      switch ($v['type']) {
        case 'text':
        case 'number':
        case 'password':
        case 'email':
          $this->out[] = self::input($k, $v['type'], $v['placeholder'], $v['value']);
          break;
        case 'radio':
        case 'select':
        case 'checkbox':
          $this->out[] = self::{$v['type']}($k, $v['option'], $v['value']);
          break;
        case 'textarea':
          $this->out[] = self::textarea($k, $v['placeholder'], $v['value']);
          break;
      }
      $this->out[] = '</div>';
    }
  }

  public function __toString() {
    return implode('', $this->out);
  }

  public static function label(string $k, string $v = '', bool $o = false, string $c = '') {
    return '<label class="'.$c.'" for="'.$k.'">'.$v.(empty($o) ? '*' : '').'</label>';
  }

  public static function input(string $k, string $t = 'text', string $p = '', string $v = '') {
    return '<input type="'.$t.'" id="'.$k.'" name="'.$k.'" placeholder="'.$p.'" value="'.$v.'">';
  }

  public static function select(string $k, array $a, $c = 0) {
    $r = '<select id="'.$k.'" name="'.$k.'">';
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
      $r.= '> '.self::label("$k-$x", $v, true, 'label-radio');
    }
    return $r;
  }

  public static function checkbox(string $k, array $a, $c = 0) {
    foreach ($a as $x => $v) {
      $r.= '<input type="checkbox" id="'.$k.'-'.$x.'" name="'.$k.'[]" value="'.$x.'"';
      if (is_array($c) && in_array($x, array_values($c)) || $x == $c)
        $r.= ' checked="checked"';
      $r.= '> '.self::label("$k-$x", $v, true, 'label-checkbox');
    }
    return $r;
  }

  public static function textarea(string $k, string $p = '', string $v = '', int $r = 4, int $c = 50) {
    return '<textarea name="'.$k.'" id="'.$k.'" placeholder="'.$p.'" rows="'.$r.'" cols="'.$c.'">'.$v.'</textarea>';
  }
}
?>

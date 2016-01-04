<?php
namespace Sys\Tpl;
use Sys\HTTP;
class Widget {
  public static function topnav($n = '') {
    $c = \Sys\Arr::merge("config/widget/topnav/$n");
    foreach ($c as $k => $v) {
      $r.= '<li><a href="'.$v['href'].'"';
      foreach ($v['match'] as $p) if ($p == HTTP::pathStr()) $r.= ' class="active"';
      $r.= '>'.$v['title'].'</a></li>';
    }
    return $r;
  }

  public static function topsearch() {
    $r = '<input type="text" name="q" placeholder="Search..">';
    $r.= '<button type="submit"><i class="fa fa-search"></i></button>';
    return $r;
  }

}
?>

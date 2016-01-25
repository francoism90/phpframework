<?php
return array(
  'start' => time(),
  'hit' => time(),
  'uid' => $_COOKIE['uid'] ?: 0,
  'xid' => Sys\Str::random(16, array('upper' => '', 'extra' => ''))
);
?>

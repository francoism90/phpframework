<?php
return array(
  'init' => array(
    'savehandler' => 'redis',
    'savepath' => '/var/run/redis/redis.sock?persistent=1&weight=1&database=1',
    'maxlifetime' => 3600 // how long an unused PHP session will be kept alive
  ),

  'cookie' => array(
    'lifetime' => 31556926,
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => true
  ),

  'start' => array(
    'start' => time(),
    'uid' => !empty($_COOKIE['uid']) ? $_COOKIE['uid'] : 0,
    'xid' => Sys\Str::random(16, array('upper' => '', 'extra' => ''))
  ),

  'update' => array(
    'hit' => time()
  )
);
?>

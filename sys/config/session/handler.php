<?php
return array(
  'init' => array(
    'savehandler' => 'redis',
    'savepath' => '/var/run/redis/redis.sock?persistent=1&weight=1&database=1',
    'maxlifetime' => 15778463 // how long an unused PHP session will be kept alive
  ),

  'cookie' => array(
    'lifetime' => 2629743,
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => true
  )
);
?>

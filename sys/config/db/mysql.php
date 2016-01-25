<?php
return array(
  'class' => 'pdo',
  'dsn' => 'mysql:unix_socket=/run/mysqld/mysqld.sock;dbname=phpsimple;charset=UTF8',
  'user' => 'myuser',
  'pass' => 'mypass',
  'parm' => array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
  )
);
?>

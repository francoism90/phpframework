<?php
// Set Globals
define('ROOT_DIR', dirname(__DIR__).'/');
define('SYS_DIR', ROOT_DIR.'sys/');
define('APP_DIR', ROOT_DIR.'app/');

// autoloader
set_include_path(get_include_path().':'.ROOT_DIR.':'.APP_DIR.':'.SYS_DIR);
spl_autoload_extensions('.php,.class.php,.inc.php');
spl_autoload_register();

// CLI
if (Sys\HTTP::cli())
  return new Sys\CLI();

// Classes
$sess = new Sys\Session();
//$loc = new Sys\Cl\Locale();

// App
require_once(APP_DIR . 'init.php');
?>

<?php
namespace App;
use \Sys\{File, HTTP, User, Validate, View};
class Core {
	public function __construct() {
		// Authentication
		User::auth();

		// Path Requested
		$m = HTTP::path()[0];
		switch ($m) {
			case '':
			case 'home':
				return self::home();
				break;
			default:
				View::set('title', _('404 - Not Found'));
				View::except('This page does not exists (anymore).', 'not-found');
		}
	}

	public static function home() {
		// Init View
		View::set('title', _('Home'));
		View::inc('home');
	}
}
?>

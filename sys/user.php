<?php
namespace Sys;
class User {
  public function __construct() {
    if (HTTP::path()[0] !== 'account')
      return;

    HTTP::ssl();
    HTTP::header('nocache');
    $p = HTTP::path()[1];
    switch ($p) {
      case 'login':
      case 'signup':
      case 'recovery':
      case 'activate':
      case 'reset':
        if ($_SESSION['uid'] > 0)
          View::except(_('Cannot be performed while logged in.'));

        exit(self::$p());
        break;
      case 'logout':
        if ($_SESSION['uid'] == 0)
          View::except(_('You need to be logged before you can access this page.'));

        exit(self::{$p}());
        break;
    }
  }

  public static function get(array $a, string $s = 'OR') {
    $valid = new Validate('user-get', $a, true);
    return DB::sql(array(
      'table' => 'users',
      'data' => $valid->out,
      'sep' => $s
    ));
  }

  public static function update(array $a) {
    $valid = new Validate('user-update', $a, true);
    return DB::sql(array(
      'mode' => 'update',
      'table' => 'users',
      'data' => $valid->out,
      'extra' => 'WHERE id = :id LIMIT 1')
    );
  }

  public static function inGroup(int $uid, int $gid) {
    return self::get(array('id' => $uid, 'groups' => json_encode($gid), 'AND'));
  }

  public static function auth(int $gid = 1) {
    // Logged?
    if ($_SESSION['uid'] < 1) {
      if (HTTP::path()[0] !== 'account')
        $_SESSION['redirect'] = HTTP::buildUrl();

      return HTTP::redirect('account/login', array('ssl'));
    }

    // Permission
    if (!self::inGroup($_SESSION['uid'], $gid))
      View::except("You don't have the permission to view this content", 'permission-denied');
  }

  public static function logout() {
    unset($_SESSION['uid']);

    // Redirect
    header('Location: '.HTTP::host());
    exit;
  }

  public static function login() {
    if (!empty(JS::post())) {
      try {
        // Validate $_POST
        $valid = new Validate('user-login', JS::post());

        // Check User
        $a = self::get(array('email' => $valid->out['email']));
        if (empty($a))
          throw new Except\JS(array('email' => _('User does not exists')));
        elseif (!password_verify($valid->out['password'], $a['passhash']))
          throw new Except\JS(array('password' => _('Invalid password given')));
        elseif ($a['status'] == 1)
          throw new Except\JS(array('email' => _('This user needs to complete activation')));

        // Set Cookie?
        $_SESSION['uid'] = $a['id'];
        if ($valid->out['remember'][0] == 1)
          $_COOKIE['uid'] = $a['id'];

        // Redirect
        HTTP::redirect('', array('js'));
        exit;
      }
      catch (Except\JS $e) { $e->out(); }
    }
    View::set('title', _('Account Login'));
    View::inc('user/login');
  }
}
?>

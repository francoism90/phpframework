<?php
namespace Sys;
class Email {
  private static $mailer;

  public static function smtp(string $n = 'noreply') {
    // Init PHPMailer
    require_once('phpmailer/PHPMailerAutoload.php');
    self::$mailer = new \PHPMailer();
    self::$mailer->isSMTP();
    foreach (Arr::merge("config/email/$n") as $k => $v)
      self::$mailer->$k = $v;

    return self::$mailer;
  }

  public static function get(array $a, string $s = 'AND') {
    $valid = new Validate('email/get', $a, true);
    return DB::sql(array(
      'table' => 'mailing',
      'data' => $valid->out,
      'sep' => $s
    ));
  }

  public static function update(array $a) {
    $valid = new Validate('email/update', $a, true);
    return DB::sql(array(
      'mode' => 'update',
      'table' => 'mailing',
      'data' => $valid->out,
      'extra' => 'WHERE id = :id LIMIT 1'
    ));
  }

  public static function insert(array $a) {
    $a['body'] = htmlspecialchars($a['body'], ENT_COMPAT | ENT_HTML5);
    $a['created'] = date('Y-m-d H:i:s');
    foreach (array('sendto','cc','bcc') as $s)
      if (!empty($a[$s])) $a[$s] = json_encode($a[$s]);

    $valid = new Validate('email/insert', $a, true);
    return DB::sql(array(
      'mode' => 'insert',
      'table' => 'mailing',
      'data' => $valid->out
    ));
  }

  public static function pending() {
		return DB::sql(array(
			'table' => 'mailing',
			'extra' => 'WHERE status = 0 ORDER BY priority DESC',
			'fetchall' => true
		));
	}

  public static function send() {
    foreach (self::pending() as $a) {
      self::smtp($a['profile']);
      self::$mailer->Body = htmlspecialchars_decode($a['body']);
      self::$mailer->Subject = htmlspecialchars_decode($a['subject']);
      self::$mailer->IsHTML(true);

      // Decode Sendto, CC, BCC
  		foreach (array('sendto' => 'addAddress', 'cc' => 'addCC', 'bcc' => 'addBCC') as $k => $m) {
        if (!empty($a[$k])) {
          foreach (json_decode($a[$k], true) as $addr)
            self::$mailer->$m($addr[0], $addr[1]);
        }
      }

      // Send
      if (!self::$mailer->send()) {
        //Log::insert(self::$mailer->ErrorInfo);
        echo self::$mailer->ErrorInfo;
        continue;
      }

      // Update
      self::update(array('id' => $a['id'], 'status' => 1, 'posted' => date('Y-m-d H:i:s')));
      self::$mailer = 'null';
    }
  }
}
?>

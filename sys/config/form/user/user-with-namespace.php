<?php
return array(
  'email' => array(
    'type' => 'email',
    'label' => _('Your Email Address'),
    'placeholder' => 'email@example.com',
    'sanitize' => FILTER_SANITIZE_EMAIL,
    'filter' => FILTER_VALIDATE_EMAIL
  ),

  'password' => array(
    'type' => 'password',
    'label' => _('Your Password'),
    'sanitize' => FILTER_SANITIZE_STRING,
    'sanitize_options' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH,
    'filter_call' => array(
      array('\Sys\Locale::datetime', 'd-m-Y H:i:s')
    )
  )
);
?>

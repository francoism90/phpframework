<?php
return array(
  'email' => array(
    'optional' => true,
    'type' => 'email',
    'label' => _('Email Address'),
    'placeholder' => 'email@example.com',
    'sanitize' => FILTER_SANITIZE_EMAIL,
    'filter' => FILTER_VALIDATE_EMAIL
  ),

  'username' => array(
    'optional' => true,
    'type' => 'text',
    'label' => _('Username'),
    'sanitize' => FILTER_SANITIZE_STRING,
    'sanitize_flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH,
    'filter_call' => array(
      array('\Sys\Str::length', array(3, 15))
    )
  ),

  'id' => array(
    'optional' => true,
    'type' => 'number',
    'label' => _('Id'),
    'sanitize' => FILTER_SANITIZE_NUMBER_INT
  )
);
?>

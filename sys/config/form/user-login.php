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
    'placeholder' => _('Password'),
    'sanitize' => FILTER_SANITIZE_STRING,
    'sanitize_flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH
  ),

  'remember' => array(
    'type' => 'checkbox',
    'label' => _('Remember me?'),
    'value' => 1,
    'option' => array(1 => ' Stay signed in'),
    'filter_call' => array(
      array('is_array')
    )
  )
);
?>

<?php
return array(
  'profile' => array(
    'type' => 'text',
    'label' => _('Profile'),
    'value' => 'noreply',
    'optional' => true,
    'sanitize' => FILTER_SANITIZE_STRING
  ),

  'priority' => array(
    'type' => 'number',
    'label' => _('Priority'),
    'value' => 1,
    'optional' => true,
    'sanitize' => FILTER_SANITIZE_NUMBER_INT,
    'filter' => FILTER_VALIDATE_INT
  ),

  'sendto' => array(
    'type' => 'text',
    'label' => _('To'),
    'optional' => true,
    'filter_method' => array(
      array('\Sys\JS::valid')
    )
  ),

  'cc' => array(
    'type' => 'text',
    'label' => _('To'),
    'optional' => true,
    'filter_method' => array(
      array('\Sys\JS::valid')
    )
  ),

  'bcc' => array(
    'type' => 'text',
    'label' => _('To'),
    'optional' => true,
    'filter_method' => array(
      array('\Sys\JS::valid')
    )
  ),

  'subject' => array(
    'type' => 'text',
    'label' => _('Profile'),
    'optional' => true,
    'sanitize' => FILTER_SANITIZE_STRING,
    'sanitize_flags' => FILTER_FLAG_STRIP_LOW
  ),

  'body' => array(
    'type' => 'textarea',
    'label' => _('Body'),
    'sanitize' => FILTER_SANITIZE_STRING
  ),

  'created' => array(
    'type' => 'text',
    'label' => _('Datetime'),
    'filter_call' => array(
      array('ctype_print'),
      array('\Sys\Locale::validDate', array('Y-m-d H:i:s'))
    )
  )
);
?>

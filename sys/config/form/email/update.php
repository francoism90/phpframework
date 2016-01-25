<?php
return array(
  'id' => array(
    'label' => _('Id'),
    'sanitize' => FILTER_SANITIZE_NUMBER_INT,
    'filter' => FILTER_VALIDATE_INT
  ),

  'status' => array(
    'label' => _('Status'),
    'optional' => true,
    'sanitize' => FILTER_SANITIZE_NUMBER_INT,
    'filter' => FILTER_VALIDATE_INT
  ),

  'posted' => array(
    'type' => 'text',
    'label' => _('Datetime'),
    'filter_call' => array(
      array('ctype_print'),
      array('\Sys\Locale::validDate', array('Y-m-d H:i:s'))
    )
  )
);
?>

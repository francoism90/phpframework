<?php
namespace Sys\Except;
use Exception;
class JS extends Exception {
  public function __construct($message, $code = 0, Exception $previous = null) {
    parent::__construct(json_encode($message), $code, $previous);
  }

  public function __toString() {
    return $this->getMessage();
  }

  public function out() {
    if (!empty($this->getMessage()))
		  \Sys\JS::out($this->getMessage());
  }
}
?>

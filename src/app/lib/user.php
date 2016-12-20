<?php

class User {

  public $name = 'Alex';

  public function get($key, $val) {
    if($key === 'token') return TRUE;
  }
}

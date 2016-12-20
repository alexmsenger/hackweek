<?php

class Controller {

  protected
    $db,
    $view;

  public function __construct() {
    Session::init();

    $this->db = new Db();
    $this->view = new View();
  }

  protected function load($model) {
    $file = MODEL.strtolower($model).'.php';
    if(file_exists($file)) {
      require $file;
      $model = $model;
      return new $model($this->db);
    }
  }
}

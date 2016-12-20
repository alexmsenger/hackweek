<?php

class Error extends Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->view->render('error/index');
  }

  public function err_404() {
    $this->view->render('_errors/404');
  }

  public function err_500() {
    $this->view->render('_errors/500');
  }
}

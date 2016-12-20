<?php

class OrderController extends Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $order = $this->load('order');
    
    $this->list();
  }

  public function show($id) {
    $this->view->render('order/show');
  }

  public function add() {
    $order = $this->load('order');
  }

}

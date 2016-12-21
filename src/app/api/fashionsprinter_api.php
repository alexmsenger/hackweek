<?php

class FashionSprinterAPI extends API {

  protected $user;

  public function __construct($request, $origin) {
    parent::__construct($request);

    // Abstracted out for example
    $user = new User();

    try {
      Auth::API($user, $this->request);
    }
    catch(Exception $e) {
      //TODO handle Exception!
    }


    $this->user = $user;
  }

  protected function example() {
    if ($this->method == 'GET') {
      return "Your name is " . $this->user->name;
    } else {
      return "Only accepts GET requests";
    }
 }

 protected function orders() {
   if($this->method == 'GET') {
     $orders = $this->load('order');
     return $orders->listAllOrders();
   }
   else {
     return NULL;
   }
 }

 protected function order($id) {
   if($this->method == 'GET') {
     $orders = $this->load('order');
     return $orders->getOrder($id);
   }
   else {
     return NULL;
   }
 }

 protected function alternatives($id) {
   if($this->method == 'GET') {
     $order = $this->load('order');
     return $order->getAlternative($id);
   }
   else return NULL;
 }
}

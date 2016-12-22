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

 protected function orders() {
   if($this->method == 'GET') {
     $orders = $this->load('order');
     return $orders->listAllOrders();
   }
   else {
     return NULL;
   }
 }

 protected function order($id = -1) {
   if($this->method == 'GET' && $id !== -1) {
     $order = $this->load('order');
     return $order->getOrder($id);
   }
   elseif($this->method == 'POST' && $id !== -1) {
     $order = $this->load('order');
     $this->order->update();
   }
   else {
     return NULL;
   }
 }

 protected function address($id = null) {
   if($this->method == 'POST') {
     $this->file = json_decode($this->file);
     if(json_last_error() === JSON_ERROR_NONE) {
       $address = $this->load('address');
       $success = $address->create($this->file);
       if($success) {
         return $success;
       }
       else return false;
     }
     else return null;
   }
   elseif($this->method == 'GET' && empty($id)) {
     $address = $this->load('address');
     return $address->index();
   }
   elseif($this->method == 'GET' && !empty($id)) {
     $address = $this->load('address');
     return $address->show($id);
   }
   elseif($this->method == 'DELETE' && !empty($id)) {
     $address = $this->load('address');
     return $address->delete($id);
   }
 }

 protected function alternative($id = -1) {
   if($this->method == 'POST' && empty($id)) {
     $this->file = json_decode($this->file);
     if(json_last_error() === JSON_ERROR_NONE) {
       $order = $this->load('order');
       $success = $order->saveAlternative($this->file);
       if($success) {
         return $success;
       }
       else return FALSE;
     }
     else return NULL;
   }
 }

 protected function alternatives($id) {
   if($this->method == 'GET') {
     $order = $this->load('order');
     return $order->getAlternative($id);
   }
   else return NULL;
 }

 protected function endpointTypes() {
   if($this->method == 'GET') {
     $order = $this->load('order');
     return $order->getEndpointTypes();
   }
   else return NULL;
 }


}

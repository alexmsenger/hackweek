<?php

class Order {

  private
    $db,
    $table = 'order';

  public function __construct(Db $db) {
    //Auth::handleLogin();
    $this->db = $db;
  }

  public function listAllOrders() {
    $stmt = "SELECT * FROM `".$this->table."`";
    $this->db->prepare($stmt);
    $res = $this->db->execute();
    return $res;//->fetch_assoc();
  }
}

<?php

class Address {

  private $db;

  public function __construct(Db $db) {
    $this->db = $db;
  }

  public function index() {
    $stmt = "SELECT * FROM `address` ORDER BY `zip` LIMIT 50";
    $this->db->prepare($stmt);
    if($this->db->execute()) {
      return $this->db->result();
    }
    else return false;
  }

  public function show($id) {
    $stmt = "SELECT * FROM `address` WHERE `id` = ?";
    $this->db->prepare($stmt);
    $this->db->bind($id);
    if($this->db->execute()) {
      return $this->db->result();
    }
    return null;
  }


  public function create($data) {
    $address = ['street', 'adendum', 'zip', 'city', 'country'];
    $address = $this->_extract($data, $address);

    $stmt = "INSERT INTO `address` (".implode(', ', array_keys($address)).") VALUES (".implode(', ', array_fill(0, count($address), '?')).")";
    $this->db->prepare($stmt);
    $this->db->bind($address);
    if($this->db->execute()) return true;
    //TODO handle error message
    return false;
  }

  public function delete($id) {
    $old = $this->show($id);
    $stmt = "DELETE FROM `address` WHERE id = ?";
    $this->db->prepare($stmt);
    $this->db->bind($id);
    if($this->db->execute()) {
      return $old;
    }
    else return false;
  }

  private function _extract($data, $keys) {
    $data = (array) $data;
    $extracted = array();
    foreach ($keys as $value) {
      if(isset($data[$value]) && !empty($data[$value])) $extracted[$value] = $data[$value];
    }
    return $extracted;
  }

  private function _placeholder($data) {
    return array_fill(0, count($data), '?');
  }
}

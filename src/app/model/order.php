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
    $stmt =
    "SELECT *
    FROM (SELECT `order`.`id` AS order_id, `complete`, `route_id`, height, width, depth, weight FROM `order`) `order`
    JOIN `route`
    ON `order`.`route_id`=`route`.`id`

    JOIN (SELECT id, name AS pickup_name, address_id, endpoint_type_id FROM `endpoint`) `pickup_endpoint`
    ON `route`.`pickup_endpoint_id`=`pickup_endpoint`.`id`

    JOIN (SELECT id, name AS pickup_type FROM `endpoint_type`) `pickup_endpoint_type`
    ON `pickup_endpoint`.`endpoint_type_id`=`pickup_endpoint_type`.`id`

    JOIN (SELECT id, street AS pickup_street, adendum AS pickup_adendum, zip AS pickup_zip, city AS pickup_city, country AS pickup_country FROM `address`) `pickup_address`
    ON `pickup_endpoint`.`address_id`=`pickup_address`.`id`

    JOIN (SELECT id, name AS dropoff_name, address_id, endpoint_type_id FROM `endpoint`) `dropoff_endpoint`
    ON `route`.`dropoff_endpoint_id`=`dropoff_endpoint`.`id`

    JOIN (SELECT id, name AS dropoff_type FROM `endpoint_type`) `dropoff_endpoint_type`
    ON `dropoff_endpoint`.`endpoint_type_id`=`dropoff_endpoint_type`.`id`

    JOIN (SELECT id, street AS dropoff_street, adendum AS dropoff_adendum, zip AS dropoff_zip, city AS dropoff_city, country AS dropoff_country FROM `address`) `dropoff_address`
    ON `dropoff_endpoint`.`address_id`=`dropoff_address`.`id`
    WHERE `complete` = 0
    LIMIT 30";

    $this->db->prepare($stmt);
    $this->db->execute();
    return $this->db->result();
  }

  public function getOrder($id) {
    $stmt =
    "SELECT *
    FROM (SELECT `order`.`id` AS order_id, `complete`, `route_id`, height, width, depth, weight FROM `order`) `order`
    JOIN `route`
    ON `order`.`route_id`=`route`.`id`

    JOIN (SELECT id, name AS pickup_name, address_id, endpoint_type_id FROM `endpoint`) `pickup_endpoint`
    ON `route`.`pickup_endpoint_id`=`pickup_endpoint`.`id`

    JOIN (SELECT id, name AS pickup_type FROM `endpoint_type`) `pickup_endpoint_type`
    ON `pickup_endpoint`.`endpoint_type_id`=`pickup_endpoint_type`.`id`

    JOIN (SELECT id, street AS pickup_street, adendum AS pickup_adendum, zip AS pickup_zip, city AS pickup_city, country AS pickup_country FROM `address`) `pickup_address`
    ON `pickup_endpoint`.`address_id`=`pickup_address`.`id`

    JOIN (SELECT id, name AS dropoff_name, address_id, endpoint_type_id FROM `endpoint`) `dropoff_endpoint`
    ON `route`.`dropoff_endpoint_id`=`dropoff_endpoint`.`id`

    JOIN (SELECT id, name AS dropoff_type FROM `endpoint_type`) `dropoff_endpoint_type`
    ON `dropoff_endpoint`.`endpoint_type_id`=`dropoff_endpoint_type`.`id`

    JOIN (SELECT id, street AS dropoff_street, adendum AS dropoff_adendum, zip AS dropoff_zip, city AS dropoff_city, country AS dropoff_country FROM `address`) `dropoff_address`
    ON `dropoff_endpoint`.`address_id`=`dropoff_address`.`id`
    WHERE `complete` = 0 AND `order`.`order_id` = ?
    LIMIT 30";

    $this->db->prepare($stmt);
    $this->db->bind($id);
    $this->db->execute();
    return $this->db->result();
  }

  public function getAlternative($id) {
    $stmt =
    "SELECT * FROM `endpoint_alternative`
    JOIN `endpoint`
    ON `endpoint_alternative`.`alternative_endpoint_id`=`endpoint`.`id`
    JOIN `address`
    ON `endpoint`.`address_id`=`address`.`id`
    JOIN `endpoint_type`
    ON `endpoint`.`endpoint_type_id`=`endpoint_type`.`id`
    WHERE `original_endpoint_id` = ?
    LIMIT 30";

    $this->db->prepare($stmt);
    $this->db->bind($id);
    $this->db->execute();
    return $this->db->result();
  }

  public function getDropoffAddress($order_id) {
    $stmt =
    "SELECT route_id
    FROM `order`
    , route
    , endpoint
    , address
    WHERE `order`.`id` = ?
    AND `order`.`route_id`=`route`.`id`
    AND `route`.`dropoff_endpoint_id`=`endpoint`.`id`
    LIMIT 1
    ";

    $this->db->prepare($stmt);
    $this->db->bind($order_id);
    $this->db->execute();
    return $this->db->result();
  }

  private function extract($data, $keys) {
    $data = (array) $data;
    $extracted = array();
    foreach ($keys as $value) {
      if(isset($data[$value]) && !empty($data[$value])) $extracted[$value] = $data[$value];
    }
    return $extracted;
  }

  private function placeholder($data) {
    return array_fill(0, count($data), '?');
  }

  public function saveAlternative($data) {
    $address = ['street', 'adendum', 'zip', 'city', 'country'];
    $address = $this->extract($data, $address);

    $stmt = "INSERT INTO `address` (".implode(', ', array_keys($address)).") VALUES (".implode(', ', array_fill(0, count($address), '?')).")";
    $this->db->prepare($stmt);
    $this->db->bind($address);
    if($this->db->execute()) return true;
    //TODO handle error message
    return false;
  }

  public function getEndpointTypes() {
    $stmt = "SELECT * FROM `endpoint_type` ORDER BY name ASC";
    $this->db->prepare($stmt);
    $this->db->execute();
    return $this->db->result();
  }
}

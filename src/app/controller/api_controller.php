<?php

class ApiController {

  public function __construct() {}

  public function v1() {
    // Requests from the same server don't have a HTTP_ORIGIN header
    if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
      $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
    }

    try {
      $file = API.'fashionsprinter_api.php';
      require $file;
      $API = new FashionSprinterAPI($_REQUEST['url'], $_SERVER['HTTP_ORIGIN']);
      echo $API->processAPI();
    } catch (Exception $e) {
        echo json_encode(Array('error' => $e->getMessage()));
    }
  }
}

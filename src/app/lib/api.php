<?php
abstract class API {
  protected
    $method = '',
    $endpoint = '',
    $verb = '',
    $args = array(),
    $file = NULL;

  protected
    $db;

  public function __construct($request) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");


    $this->args = explode('/', rtrim($request, '/'));

    //unset the first two keys "api" and "v1".
    //this is necessary due to the infrastructure of the framework
    unset($this->args[0]);
    unset($this->args[1]);

    //now the actual endpoint
    $this->endpoint = array_shift($this->args);
    if(array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
      $this->verb = array_shift($this->args);
    }

    $this->method = $_SERVER['REQUEST_METHOD'];
    if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
      if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
        $this->method = 'DELETE';
      } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
        $this->method = 'PUT';
      } else {
        throw new Exception("Unexpected Header");
      }
    }

    switch($this->method) {
      case 'DELETE':
      case 'POST':
        $this->request = $this->_cleanInputs($_POST);
        $this->file = file_get_contents("php://input"); //POST expects JSON data as well! 
        break;
      case 'GET':
        $this->request = $this->_cleanInputs($_GET);
        break;
      case 'PUT':
        $this->request = $this->_cleanInputs($_GET);
        $this->file = file_get_contents("php://input");
        break;
      default:
        $this->_response('Invalid Method', 405);
        break;
      }

      $this->db = new Db();
  }

  public function processAPI() {
       if (method_exists($this, $this->endpoint)) {
           return $this->_response($this->{$this->endpoint}($this->args));
       }
       return $this->_response("No Endpoint: $this->endpoint", 404);
   }

   protected function load($model) {
     $file = MODEL.strtolower($model).'.php';
     if(file_exists($file)) {
       require $file;
       $model = $model;
       return new $model($this->db);
     }
   }

   private function _response($data, $status = 200) {
       header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
       return json_encode($data);
   }

   private function _cleanInputs($data) {
       $clean_input = Array();
       if (is_array($data)) {
           foreach ($data as $k => $v) {
               $clean_input[$k] = $this->_cleanInputs($v);
           }
       } else {
           $clean_input = trim(strip_tags($data));
       }
       return $clean_input;
   }

   private function _requestStatus($code) {
       $status = array(
           200 => 'OK',
           404 => 'Not Found',
           405 => 'Method Not Allowed',
           500 => 'Internal Server Error',
       );
       return ($status[$code])?$status[$code]:$status[500];
   }

}

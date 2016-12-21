<?php

class Db {

  public static $numQueries;

  private
    $connection,
    $query,
    $stmt,
    $res,
    $join = array(),
    $as = array(),
    $cols = array();

  public function __construct() {
    $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT, DB_SOCK);
    if($this->connection->connect_error) {
      die('Connection Error: ('.$this->connection->connect_errno.') '.$this->connection->connect_error);
    }
    else {
      $this->connection->set_charset('utf8');
      return TRUE;
    }
  }

  public function prepare($query) {
    if($this->connection->prepare($query)) {
      $this->statement = $this->connection->prepare($query);
      return $this;
    }
    else {
      die('DB Error: ('.$this->connection->error.') Statement failed to prepare.');
    }
  }

  public function bind($params) {
    $values[] = $this->getTypes($params);
    foreach($params as $key => &$val) {
      $values[] = &$val;
    }
    call_user_func_array([$this->statement, 'bind_param'], $values);
    return $this;
  }

  public function execute() {
    if($this->statement->execute()) {
      Db::$numQueries++;
      return TRUE;
    }
    else {
      die('DB Error: Statement failed to execute.');
    }
  }

  public function result() {
    $res = $this->statement->get_result();
    if($this->statement->affected_rows == 1) {
      return $res->fetch_assoc();
    }
    elseif ($this->statement->affected_rows > 1) {
      $array = array();
      while ($row = $res->fetch_assoc()) {
        $array[] = $row;
      }
      return $array;
    }
    else return NULL;
  }



  private function getTypes($params) {
    $str = '';
    foreach($params as $key => $val) {
      if(filter_var($val, FILTER_VALIDATE_INT)) $str .= 'i';
      else $str .= 's';
    }
    return $str;
  }



}

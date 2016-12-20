<?php

class App {
  private
    $controller,
    $action,
    $param1,
    $param2,
    $param3;

  public function __construct() {
    $this->splitUrl();

    $this->loadController();
    if($this->controller === FALSE) {
      header('location: ' . URL . 'error/err_404');
      die();
    }

    $this->callAction();
    if($this->action === FALSE) {
      header('location: ' . URL . 'error/err_500');
      die();
    }
  }
  protected function loadController() {
    if(!isset($this->controller)) $this->controller = 'order';
    $file = CONTROLLER.strtolower($this->controller).'_controller.php';
    if(file_exists($file)) {
      $controller = ucfirst($this->controller).'Controller';
      require $file;
      $this->controller = new $controller();
    }
    else $this->controller = FALSE;
  }

  protected function callAction() {
    if(method_exists($this->controller, $this->action)) {
      if(isset($this->param3)) {
        $this->controller->{$this->action}($this->param1, $this->param2, $this->param3);
      }
      elseif(isset($this->param2)) {
        $this->controller->{$this->action}($this->param1, $this->param2);
      }
      elseif(isset($this->param1)) {
        $this->controller->{$this->action}($this->param1);
      }
      else {
        $this->controller->{$this->action}();
      }
    }
    else {
      $this->action = FALSE;
    }
  }

  private function splitUrl() {
    if(isset($_GET['url'])) $url = $_GET['url'];
    if(isset($url)) {
      $url = rtrim($url);
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);

      $this->controller = (isset($url[0]) ? $url[0] : NULL);
      $this->action = (isset($url[1]) ? $url[1] : NULL);
      $this->param1 = (isset($url[2]) ? $url[2] : NULL);
      $this->param2 = (isset($url[3]) ? $url[3] : NULL);
      $this->param3 = (isset($url[4]) ? $url[4] : NULL);
    }
  }
}

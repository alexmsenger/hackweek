<?php

class Template {
  private $tpl_string;

  public function __construct($file) {
    $ext = (end(explode('.', $file)) == 'html') ? '' : '.html';
    $file = VIEW.'_templates/tpl.'.$file.$html;
    if(file_exists($file)) {
      $this->tpl_string = file_get_contents($file);
    }
    else {
      die();
    }
  }

  public function assign($var, $value) {
    $this->tpl_string = preg_replace("/{{".$var."}}/", $value, $this->tpl_string);
    return $this;
  }

  public function get($clean = TRUE) {
    if($clean) {
      $this->tpl_string = preg_replace("/{{[a-zA-Z0-9:_-]+}}/", "", $this->tpl_string);
    }
    return $this->tpl_string;
  }
}

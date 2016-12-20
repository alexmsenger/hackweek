<?php

class View {

  protected $tpl;
  private static $data;

  public function render($file) {
    require VIEW.'_templates/header.php';
    require VIEW.$file.'.php';
    require VIEW.'_templates/footer.php';
  }

  public function renderFeedback() {
    require VIEW.'_templates/feedback.php';
    Session::set('feedback', NULL);
  }

  public function create($type, $value, $attributes = array()) {
    $this->tpl = new Template('generic');
    $this->tpl->assign('TAG', $type);
    $this->tpl->assign('VALUE', $value);
    $this->tpl->assign('ATTRIBUTES', $this->setAttributes($attributes));

    return $this->tpl->get();
  }

  private function setAttributes($attributes) {
    if(empty($attributes)) return '';
    foreach($attributes as $key => $val) {
      $attributes[$key] = $key.'="'.$value.'"';
    }
    return implode(' ', $attirbutes);
  }
}

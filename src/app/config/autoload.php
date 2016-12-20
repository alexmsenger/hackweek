<?php
function autoload($class) {
  $class = strtolower($class);
  $file = LIB.$class.'.php';
  if(file_exists($file)) require $file;
  else exit('The file '.$file.' is missing in the lib directory.');
}

spl_autoload_register('autoload');

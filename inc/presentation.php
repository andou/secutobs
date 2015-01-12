<?php

define('VIEWS', 'views');

function bit_include_template($tpl, $echo = TRUE) {
  $file = sprintf("%s/%s/%s.phtml", ABSPATH, VIEWS, rtrim($tpl, "/"));
  if (!file_exists($file)) {
    $file = sprintf("%s/%s/%s.phtml", ABSPATH, VIEWS, 'errors/404');
  }
  $out = bit_render_template($file);
  if ($echo) {
    echo $out;
  }
  return $out;
}

function bit_render_template($file) {
  ob_start();
  include $file;
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}
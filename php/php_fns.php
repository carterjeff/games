<?php
  // function user to clean inputs for mysql
  function cleanInput($v){
    global $m;
    $v = stripslashes($v);
    $v = $m->real_escape_string($v);
    $v = trim($v);
    return $v;
  }
?>
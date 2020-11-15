<?php
  // function user to clean inputs for mysql
  function cleanInput($v){
    global $m;
    $v = stripslashes($v);
    $v = $m->real_escape_string($v);
    $v = trim($v);
    return $v;
  }

  // log and respond function
  function log_and_respond($response){
    global $m, $ip, $user_agent, $_REQUEST;    

    // roll back transaction for anything that might not have been properly committed    
    $m->rollback();      
    // begin transaction - auto commit off
    $m->autocommit(FALSE);

    $uri = $_SERVER['PHP_SELF'];
    $uname = '';
    if(isset($_REQUEST['user'])){
      $uname = $_REQUEST['user'];
    } else if (isset($apache_headers['user'])){
      $uname = $apache_headers['user'];
    }
    if (isset($_REQUEST['password'])){
      $_REQUEST['password'] = md5($_REQUEST['password']);
    }
    $request = json_encode($_REQUEST);
    $resp = json_encode($response);
    $sql = "INSERT INTO `log` (`uri`,`user`,`ip_address`,`user_agent`,`response`,`request`) VALUES ('$uri','$uname','$ip','$user_agent','$resp','$request')";

    $m->query($sql);
    echo $resp;
    $m->commit();
    exit;
  }
?>
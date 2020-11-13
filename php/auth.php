<?php
  if(!isset($_REQUEST['token'])){
    $response['content'] = "No token supplied.";
    echo json_encode($response);exit;
    // log_and_respond($response);
  }

  $token = $_REQUEST['token'];

  // get today
  $today = date('Y-m-d');

  $nowToken = md5(date("Y-m-d").'games');

  $tomorrow_token = md5(date('Y-m-d',strtotime($today.' +1 days')).'games');
  $yesterday_token = md5(date('Y-m-d',strtotime($today.' -1 days')).'games');
   

  if($token!=$nowToken && $token != $tomorrow_token && $token != $yesterday_token){
    $response['content'] = 'invalid_session';
    echo json_encode($response);exit;
    log_and_respond($response);   
  }  
?>
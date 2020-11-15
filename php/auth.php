<?php
  if(!isset($_REQUEST['token'])){
    $response['content'] = "No token supplied.";
    log_and_respond($response);
    echo json_encode($response);exit;
  }

  $token = $_REQUEST['token'];

  // get today
  $today = date('Y-m-d');

  // create today token
  $nowToken = md5(date("Y-m-d").'games');

  // create tokens from yesterday and tomorrow
  $tomorrow_token = md5(date('Y-m-d',strtotime($today.' +1 days')).'games');
  $yesterday_token = md5(date('Y-m-d',strtotime($today.' -1 days')).'games');   

  // check the token being sent against all 3, just in case they are in different timezones
  if($token!=$nowToken && $token != $tomorrow_token && $token != $yesterday_token){
    $response['content'] = 'invalid_session';
    log_and_respond($response);
    // echo json_encode($response);exit;
  }  
?>
<?php  
	header('Access-Control-Allow-Origin: *');
  header("Content-Type: application/json");   
  
  // User info for logging
  $ip = $_SERVER['REMOTE_ADDR'];
  $user_agent = 'Not Available';
  if(isset($_SERVER['HTTP_USER_AGENT'])){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
  }

  //get app type for logging
  $is_android = false;
  $android_pos = stripos($user_agent,"android");
  if ($android_pos > 0){
    $is_android = true;
  }
  
  //  init the response array which is used in all services
  $response = array();
  $response['status'] = 'NO';

  // connection to mysql db 
  $dbHost = 'localhost';
  $dbUser = '';
  $dbPass = '';
  $dbName = 'games';
  
  $m = new mysqli($dbHost,$dbUser,$dbPass,$dbName);
  if ($m->connect_errno){
    $response['content'] = 'Error connecting to the database.';
    echo json_encode($response);exit;
  }  

  // include the php functions page which has all the reused functions
  include 'php_fns.php';  
?>

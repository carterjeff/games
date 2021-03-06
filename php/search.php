<?php
	/**
	 * Query games from db
	 */
	ini_set("memory_limit","500M");
	include 'connection.php';
	include 'auth.php';
	
	$info = array();
	
	// required params
	$params = ['query'];

	foreach ($params as $key => $value) {
	  if(!isset($_REQUEST[$value])){
	    $response['content'] = 'Missing parameter: '.$value.' not set.';
	    log_and_respond($response);	    
	  }
	  // clean input for query insert
	  $_REQUEST[$value] = cleanInput($_REQUEST[$value]);
	}

	extract($_REQUEST);

	// query length must be longer than 2
	if (strlen($query) < 2){
		$response['content'] = $info;
		$response['status'] = "OK";
		log_and_respond($response);				
	}

	// query to search through games
  $sql = "SELECT `id`,`publisher`,`name`,`nickname`,`rating` FROM `games` WHERE `name` LIKE '%$query%' OR `publisher` LIKE '%$query%' OR `nickname` LIKE '%$query%' OR `rating` LIKE '%$query%' ORDER BY `name` ASC";
  $res = $m->query($sql);  
  while ($e = $res->fetch_assoc()){
  	$e['rating'] = ucwords($e['rating']);
		// build output array 
		$info[] = $e;
  }	
	
	// output
  $response['status'] = 'OK';
	$response['content'] = $info;	
	log_and_respond($response);
	// echo json_encode($response); exit;	 
?>
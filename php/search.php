<?php
	/**
	 * Query games from db
	 */
	include 'connection.php';
	include 'auth.php';
	
	$info = array();
	
	// required params
	$params = ['query'];

	foreach ($params as $key => $value) {
	  if(!isset($_REQUEST[$value])){
	    $response['content'] = 'Missing '.$value.' set.';
	    log_and_respond($response);
	  }
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
  $sql = "SELECT `id`,`publisher`,`name`,`nickname`,`rating` FROM `games` WHERE `name` LIKE '%$query%' OR `publisher` LIKE '%$query%' OR `nickname` LIKE '%$query%' ORDER BY `name` ASC";
  $res = $m->query($sql);  
  while ($e = $res->fetch_assoc()){
		// build output array
  // 	$info[] = array(
  // 		'id'=>$e['id'],
		// 	'value'=>$e['id'],
		// 	'label'=>$e['name'].' ['.$e['publisher'].']',
		// 	'rating'=>$e['rating'],
		// 	'nickname'=>$e['nickname'],
		// );
		$info[] = $e;
  }
	
	
	// output
  $response['status'] = 'OK';
	$response['content'] = $info;	
	echo json_encode($response); exit;	 
?>
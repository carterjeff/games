<?php
	include 'cononection.php';
	include 'auth.php';

	$object = array();

	// build list of params accepted
	$params = ['publisher','name','nickname','rating'];

	// loop through verifying they are sent, and clean inputs for sql query
	foreach ($params as $key => $value) {
		if(!isset($_REQUEST[$value])){
			$response['content'] = 'No '.$value.' set: add game';
			echo json_encode($response);exit;
			// log_and_respond($response);
    }
    $_REQUEST[$value] = cleanInput($_REQUEST[$value]);
    $object[$value] = $_REQUEST[$value];
  }

  // break out the requst
  extract($_REQUEST);

  // init transaction
  $m->autocommit(FALSE);

  // dynamically create the query based off inputs
  $fields = '`created_at`,';
  $vals = 'CURRENT_TIMESTAMP,';
  foreach ($object as $key => $value) {
    $fields .= "`$key`,";
    $vals .= "'$value',";
  }
  $fields = rtrim($fields,',');
  $vals = rtrim($vals,',');

  // run isnert query
  $sql = "INSERT INTO `games` ($fields) VALUES ($vals)";
  if (!$m->query($sql)){
  	$response['content'] = "Query Error: Unable to update per diem.";
  	echo json_encode($response);exit;
  	// log_and_respond($response);
  }

  // commit transaction
  $m->commit();

  // new game id is insert it, might not be used
  $game_id = $m->insert_id);

	// success response
	$response['content'] = 'Game successfully added';
	$response['status'] = 'OK';
	echo json_encode($response);
?>
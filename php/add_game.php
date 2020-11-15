<?php
	/*
		add_game.php

		This web service is used to create new games and add them to the table `games.

		Will validate the auth token is sent with the request, and loop through the available params we require.
		Will validate the fields are sent, as well as clean them and add to the $object array.
		Also validates that the rating is part of the accepted 3, checks if the publisher/name combo is already in the DB
	*/
	include 'connection.php';
	include 'auth.php';

	// init the object array, which is used to dynamically create queries 
	$object = array();

	// array of valid ratings
	$ratings = ['meh','favorite','dislike'];

	// build list of params accepted
	$params = ['publisher','name','nickname','rating'];

	// loop through verifying they are sent, and clean inputs for sql query
	foreach ($params as $key => $value) {
		if(!isset($_REQUEST[$value])){
			$response['content'] = 'Missing parameter: '.$value.' not set.';
			log_and_respond($response);
    }
    $_REQUEST[$value] = cleanInput($_REQUEST[$value]);
    // add to object for dynamic query creation
    $object[$value] = $_REQUEST[$value];
  }

  // break out the requst
  extract($_REQUEST);

  // verify the rating is within the correct 3
  if (!in_array($rating, $ratings)){
  	$response['content'] = "Please select a valid rating type.";
  	log_and_respond($response);
  }

  // check if publisher/name already exists
  $sql = "SELECT * FROM `games` WHERE `name` = '$name' AND `publisher` = '$publisher'";
  $res = $m->query($sql);
  if ($res->num_rows > 0){
  	$response['content'] = 'Game with same Publisher/Name already taken. Please try another';
  	log_and_respond($response);
  }

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
  	$response['content'] = "Query Error: Unable to add new game";
  	log_and_respond($response);  	
  }

  // commit transaction
  $m->commit();

  // new game id is insert it, might not be used
  $game_id = $m->insert_id;

	// success response
	$response['content'] = 'Game successfully added';
	$response['status'] = 'OK';
	log_and_respond($response);
	// echo json_encode($response);
?>
<?php
	/*

	 	script to quickly loop 500,000 times to create random publish/game/ratings

	*/
 	ini_set("memory_limit","500M");
	include 'connection.php';

	$info = array();

	$max = 500000;
	$publisher = 'Publisher';
	$count = 0;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$char_length = strlen($characters);
	$rating_count = 0;
	$ratings = ['meh','favorite','dislike'];

	for ($i=0;$i<$max;$i++){
		if ($i % 100 == 0){
			$count++;
		}
		if ($rating_count > 2){
			$rating_count = 0;
		}		
		$this_publisher = $publisher.'_'.$count;

		$name = '';
		for ($j=0;$j<10;$j++){
			$name .= $characters[rand(0,$char_length -1)];
		}
		$rating = $ratings[$rating_count];		
		$nickname = '';		

		$sql = "INSERT IGNORE INTO `games` (`publisher`,`name`,`nickname`,`rating`,`created_at`) VALUES ('$this_publisher','$name','$nickname','$rating',CURRENT_TIMESTAMP)";
		if (!$m->query($sql)){
			$response['content'] = 'Query Error: Unable to add game: '.$sql;
			echo json_encode($response);exit;
		}
		$rating_count++;

		$info[] = array(
			'publisher'=>$this_publisher,
			'name'=>$name,
			'nickname'=>$nickname,
			'rating'=>$rating,
		);
	}

	$response['content'] = $info;
	$response['status'] = 'OK';
	echo json_encode($response);exit;
?>
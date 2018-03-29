<?php
	$jsondataVote4Coins = file_get_contents('include/db/vote4coins.json');
	$jsondataVote4Coins = json_decode($jsondataVote4Coins, true);
	
	if(!$jsondataVote4Coins)
		$jsondataVote4Coins = array();
	
	if(isset($_POST['submit']))
	{
		$new_link = array();
		$new_link['name'] = $_POST['site_name'];
		$new_link['link'] = $_POST['site_link'];
		$new_link['type'] = $_POST['type'];
		$new_link['value'] = $_POST['coins'];
		$new_link['time'] = $_POST['time'];
		
		array_push($jsondataVote4Coins, $new_link);
		
		$json_new = json_encode($jsondataVote4Coins);
		file_put_contents('include/db/vote4coins.json', $json_new);
		
		header("Location: ".$site_url.'admin/vote4coins');
		die();
	} else if(isset($_GET['del']))
	{
		unset($jsondataVote4Coins[$_GET['del']]);
		
		$json_new = json_encode($jsondataVote4Coins);
		file_put_contents('include/db/vote4coins.json', $json_new);
		
		delete_vote4coins($_GET['del']);
		
		header("Location: ".$site_url.'admin/vote4coins');
		die();
	}
?>
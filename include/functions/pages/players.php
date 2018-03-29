<?php
	if(isset($_POST['search']) && strlen($_POST['search'])>=3)
	{
		header("Location: ".$site_url."ranking/players/1/".$_POST['search']);
		die();
	} else if(isset($_POST['search']) && $_POST['search']=='')
	{
		header("Location: ".$site_url."ranking/players/1");
		die();
	}
	
	if(isset($_GET['player_name']))
	{
		$new_search = strip_tags($_GET['player_name']);
		if(strlen($new_search)>=3)
			$search = $new_search;
	}
	
	require_once("include/classes/players.php");
	$paginate = new paginate();
?>
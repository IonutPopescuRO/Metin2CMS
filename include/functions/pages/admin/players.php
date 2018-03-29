<?php
	if(isset($_POST['search']) && strlen($_POST['search'])>=3)
	{
		header("Location: ".$site_url."admin/players/1/".$_POST['search']);
		die();
	} else if(isset($_POST['search']) && $_POST['search']=='')
	{
		header("Location: ".$site_url."admin/players/1");
		die();
	}
	
	if(isset($_GET['player_name']))
	{
		$new_search = strip_tags($_GET['player_name']);
		if(strlen($new_search)>=3)
			$search = $new_search;
	}
	
	require_once("include/classes/admin-players.php");
	$paginate = new paginate();
	
	if(isset($_POST['permanent']) && isset($_POST['accountID']))
	{
		banPermanent(intval($_POST['accountID']), $_POST['permanent']);
		
		$location = '';
		if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
			$location = $_GET["page_no"];
		else $location = 1;
		if($search)
			$location.= '/'.$search;
		
		header("Location: ".$site_url."admin/players/".$location);
		die();
	}
	else if(isset($_POST['unban']) && isset($_POST['accountID']))
	{
		unBan(intval($_POST['accountID']));
		
		$location = '';
		if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
			$location = $_GET["page_no"];
		else $location = 1;
		if($search)
			$location.= '/'.$search;
		
		header("Location: ".$site_url."admin/players/".$location);
		die();
	} else if(isset($_POST['temporary']) && isset($_POST['accountID']) && isset($_POST['months']) && isset($_POST['days']) && isset($_POST['hours']) && isset($_POST['minutes']) && check_account_column('availDt'))
	{
		$time_availDt = strtotime("now +".intval($_POST['months'])." month +".intval($_POST['days'])." day +".intval($_POST['hours'])." hours +".intval($_POST['minutes'])." minute");
		banTemporary(intval($_POST['accountID']), $_POST['temporary'], $time_availDt);
		
		$location = '';
		if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
			$location = $_GET["page_no"];
		else $location = 1;
		if($search)
			$location.= '/'.$search;
		
		header("Location: ".$site_url."admin/players/".$location);
		die();
	}
?>
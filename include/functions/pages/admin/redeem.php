<?php
	require_once("include/classes/admin-redeem-codes.php");
	$paginate = new paginate();
	
	if(isset($_POST['delete']) && isset($_POST['id']))
	{
		delete_redeeem_code($_POST['id']);
		$location = '';
		if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
			$location = $_GET["page_no"];
		else $location = 1;
		
		header("Location: ".$site_url."admin/redeem/".$location);
		die();
	}
?>
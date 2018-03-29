<?php
	$jsondataDonate = file_get_contents('include/db/donate.json');
	$jsondataDonate = json_decode($jsondataDonate, true);
	
	$jsondataCurrency = file_get_contents('include/db/currency.json');
	$jsondataCurrency = json_decode($jsondataCurrency,true);
	
	if(!$jsondataDonate)
		$jsondataDonate = array();
	
	if(isset($_POST['submit']))
	{
		$new_link = array();
		$new_link['name'] = $_POST['donation_method'];
		$new_link['list'] = array();
		
		array_push($jsondataDonate, $new_link);
		
		$json_new = json_encode($jsondataDonate);
		file_put_contents('include/db/donate.json', $json_new);
		
		header("Location: ".$site_url.'admin/donate');
		die();
	} else if(isset($_GET['del']))
	{
		unset($jsondataDonate[$_GET['del']]);
		
		$json_new = json_encode($jsondataDonate);
		file_put_contents('include/db/donate.json', $json_new);
		
		header("Location: ".$site_url.'admin/donate');
		die();
	}  else if(isset($_POST['submit_delete_price']))
	{
		unset($jsondataDonate[$_POST['id']]['list'][$_POST['price_id']]);
		
		$json_new = json_encode($jsondataDonate);
		file_put_contents('include/db/donate.json', $json_new);
		
		header("Location: ".$site_url.'admin/donate');
		die();
	} else if(isset($_POST['submit_price']))
	{
		$new_price = array();
		$new_price['price'] = $_POST['price'];
		$new_price['md'] = $_POST['md'];
		$new_price['currency'] = $_POST['currency'];

		array_push($jsondataDonate[$_POST['id']]['list'], $new_price);
		
		$json_new = json_encode($jsondataDonate);
		file_put_contents('include/db/donate.json', $json_new);
		
		header("Location: ".$site_url.'admin/donate');
		die();
	}
?>
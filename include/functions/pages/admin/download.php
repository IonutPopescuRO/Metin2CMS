<?php
	$jsondataDownload = file_get_contents('include/db/download.json');
	$jsondataDownload = json_decode($jsondataDownload, true);
	
	if(!$jsondataDownload)
		$jsondataDownload = array();
	
	if(isset($_POST['submit']))
	{
		$new_link = array();
		$new_link['name'] = $_POST['download_server'];
		$new_link['link'] = $_POST['download_link'];
		
		array_push($jsondataDownload, $new_link);
		
		$json_new = json_encode($jsondataDownload);
		file_put_contents('include/db/download.json', $json_new);
		
		header("Location: ".$site_url.'admin/download');
		die();
	} else if(isset($_GET['del']))
	{
		unset($jsondataDownload[$_GET['del']]);
		
		$json_new = json_encode($jsondataDownload);
		file_put_contents('include/db/download.json', $json_new);
		
		header("Location: ".$site_url.'admin/download');
		die();
	}
?>
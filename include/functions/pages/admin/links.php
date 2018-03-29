<?php
	if(isset($_POST['submit']))
	{
		$edited = false;
		
		foreach($_POST as $key=>$link)
			if(isset($jsondata['general'][$key]))
			{
				if($jsondata['general'][$key]!=$link)
				{
		$jsondata['general'][$key]=$link;
		$edited = true;
				}
			}
			else if(isset($jsondata['links'][$key]))
			{
				if($jsondata['links'][$key]!=$link)
				{
		$jsondata['links'][$key]=$link;
		$edited = true;
				}
			}
			else if(isset($jsondata['social-links'][$key]))
			{
				if($jsondata['social-links'][$key]!=$link)
				{
		$jsondata['social-links'][$key]=$link;		
		$edited = true;
				}
			}
		if($edited)
		{
			$json_new = json_encode($jsondata);
			file_put_contents('include/db/settings.json', $json_new);
		}
		header("Location: ".$site_url.'admin/links');
		die();
	}
?>
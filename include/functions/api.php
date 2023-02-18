<?php
	$json = file_get_contents('include/db/api.json');
	$date = json_decode($json,true);
	
	$date['version'] = $mt2cms;
	$date['key'] = generateSocialID(10);
		
	$json_new = json_encode($date);
	
	file_put_contents('include/db/api.json', $json_new);
	
	$api = @file_get_contents('https://api.metin2cms.cf/cms?site='.$site_url.'&key='.$date['key'].'&version='.$date['version']);
?>
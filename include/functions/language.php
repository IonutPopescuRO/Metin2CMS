<?php
	$json_languages = file_get_contents('include/db/languages.json');
	$json_languages = json_decode($json_languages,true);
	$rtl = ['ar', 'arc', 'dv', 'fa', 'ha', 'he', 'khw', 'ks', 'ku', 'ps', 'ur', 'yi'];
		
	if(isSet($_GET['lang']))
		$lang = $_GET['lang'];
	else if(isSet($_SESSION['lang']))
		$lang = $_SESSION['lang'];
	else if(isSet($_COOKIE['lang']))
		$lang = $_COOKIE['lang'];
	else if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	else
		$lang = $json_languages['settings']['default'];
	
	if(isset($json_languages['languages'][$lang]))
		$language_code = $lang;
	else
		$language_code = $json_languages['settings']['default'];
	
	$_SESSION['lang'] = $language_code;
	setcookie('lang', $language_code, time() + (3600 * 24 * 30));
	
	include 'include/languages/'.$language_code.'.php';

?>
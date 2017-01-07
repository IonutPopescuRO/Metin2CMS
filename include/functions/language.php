<?php
	if(isSet($_GET['lang']))
		$lang = $_GET['lang'];
	else if(isSet($_SESSION['lang']))
		$lang = $_SESSION['lang'];
	else if(isSet($_COOKIE['lang']))
		$lang = $_COOKIE['lang'];
	else
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	
	switch($lang) {
		case 'en':
		$language_code = "en";
		break;
	 
		case 'ro':
		$language_code = "ro";
		break;
		
		default:
		$language_code = "ro";
	}
	
	$_SESSION['lang'] = $language_code;
	setcookie('lang', $language_code, time() + (3600 * 24 * 30));
	
	include 'include/languages/'.$language_code.'.php';
	
	$language_codes = array(
			'en' => 'English' , 
			'ro' => 'Română');
?>
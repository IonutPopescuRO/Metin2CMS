<?php
	$jsondataDonate = file_get_contents('include/db/donate.json');
	$jsondataDonate = json_decode($jsondataDonate, true);
	
	$jsondataCurrency = file_get_contents('include/db/currency.json');
	$jsondataCurrency = json_decode($jsondataCurrency,true);
	
	if(isset($_POST["method"]) && strtolower($_POST["method"])=='paypal' && isset($_POST['id']) && isset($_POST['type']))
	{
		$return_url = $site_url."index.php";
		$cancel_url = $site_url."index.php";
		$notify_url = $site_url."paypal.php";
		
		$querystring = '';
		$querystring .= "?business=".urlencode($paypal_email)."&";
		
		$price = $jsondataDonate[$_POST['id']]['list'][$_POST['type']];
		
		$querystring .= "item_name=".urlencode($jsondataDonate[$_POST['id']]['name'].' ['.$price['price'].' - '.$price['md'].' MD]')."&";
		$querystring .= "amount=".urlencode($price['price'])."&";
		
		$querystring .= "cmd=".urlencode(stripslashes("_xclick"))."&";
		$querystring .= "no_note=".urlencode(stripslashes("1"))."&";
		$querystring .= "currency_code=".urlencode(stripslashes($price['currency']))."&";
		$querystring .= "bn=".urlencode(stripslashes("PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest"))."&";
		$querystring .= "first_name=".urlencode(stripslashes(getAccountName($_SESSION['id'])))."&";
		
		$querystring .= "return=".urlencode(stripslashes($return_url))."&";
		$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
		$querystring .= "notify_url=".urlencode($notify_url)."&";
		$querystring .= "item_number=".urlencode($jsondataDonate[$_POST['id']]['name'].' ['.$price['price'].' - '.$price['md'].' MD]')."&";
		$querystring .= "custom=".urlencode($_SESSION['id']);
		
		//redirect('https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
		$url = 'https://www.paypal.com/cgi-bin/webscr'.$querystring;
		if(!headers_sent()) {
			header('Location: '.$url);
			exit;
		} else {
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$url.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
			echo '</noscript>';
			exit;
		}
		
		exit();
	}
?>
<?php
	include 'include/functions/header.php';

	if (isset($_POST["txn_id"]) && isset($_POST["txn_type"]) && isset($_POST["item_name"]) && isset($_POST["item_number"]) && isset($_POST["payment_status"]) && isset($_POST["mc_gross"])&& isset($_POST["mc_currency"])&& isset($_POST["receiver_email"])&& isset($_POST["custom"]))
	{
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
			$req .= "&$key=$value";
		}

		$data['item_name']			= $_POST['item_name'];
		$data['item_number'] 		= $_POST['item_number'];
		$data['payment_status'] 	= $_POST['payment_status'];
		$data['payment_amount'] 	= $_POST['mc_gross'];
		$data['payment_currency']	= $_POST['mc_currency'];
		$data['txn_id']				= $_POST['txn_id'];
		$data['receiver_email'] 	= $_POST['receiver_email'];
		$data['payer_email'] 		= $_POST['payer_email'];
		$data['custom'] 			= $_POST['custom'];

		$curl_result=$curl_err='';
		$ch = curl_init();
		//curl_setopt($ch, CURLOPT_URL,'https://www.sandbox.paypal.com/cgi-bin/webscr'); - DevMode
		curl_setopt($ch, CURLOPT_URL,'https://www.paypal.com/cgi-bin/webscr');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
		curl_setopt($ch, CURLOPT_HEADER , 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		$curl_result = curl_exec($ch);
		$curl_err = curl_error($ch);
		curl_close($ch);
				
		if (strpos($curl_result, "VERIFIED")!==false && strtolower($data['receiver_email']) == strtolower($paypal_email)) {
			
			$jsondataDonate = file_get_contents('include/db/donate.json');
			$jsondataDonate = json_decode($jsondataDonate, true);
			
			foreach($jsondataDonate as $key => $donate)
				if(strtolower($donate['name'])=="paypal")
					foreach($donate['list'] as $list)
					{
						$type = $donate['name'].' ['.$list['price'].' - '.$list['md'].' MD]';
						if($type==$data['item_name'] && $list['price']==$data['payment_amount'] && $data['payment_currency']==$list['currency'])
							addCoins($data['custom'], $list['md']);
					}
		}
	}
?>
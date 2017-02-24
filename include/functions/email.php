<?php
	$myEmail = getAccountEmail($_SESSION['id']);
	$message = 0;
	if(isset($_GET['code']) && !empty($_GET['code']) && strlen($_GET['code'])==32)
	{
		if(check_email_token($myEmail, $_GET['code']))
		{
			updateNewEmail();
			update_email_token($_SESSION['id'], '');
			header("Location: ".$site_url."user/administration");
			die();
		} else {
			$message = 5;
		}
	} else if(isset($_POST['email']) && isset($_POST['captcha']) && isset($_SESSION['captcha_email']['code']))
	{
		if($_POST['captcha'] == $_SESSION['captcha_email']['code'])
		{
			$email = $_POST['email'];

			if(isValidEmail($email))
			{
				if(!$database->checkUserEmail($email))
				{
					$code = generateSocialID(32);
					update_email_token($_SESSION['id'], $code);
					update_new_email($_SESSION['id'], $email);
					$message = 4;
				} else $message = 1;
				
			} else $message = 2;

		}
		else $message = 3;
	}

?>
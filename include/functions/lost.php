<?php
	$message = 0;
	if(isset($_GET['email']) && isset($_GET['code']) && !empty($_GET['email']) && !empty($_GET['code']) && isValidEmail($_GET['email']))
	{
		if(check_recovery($_GET['email'], $_GET['code']))
		{
			$message = 7;//bun
			if(isset($_POST['password']) && isset($_POST['rpassword']))
			{
				if($_POST['password']==$_POST['rpassword'])
				{
					if(isValidUserPassword($_POST['password']))
					{
						$password = getHashPassword($_POST['password']);
						update_passlost_token_by_email($_GET['email']);
						update_password_by_email($_GET['email'], $password);
						$message = 8;
					}
					else $message = 10;
				}
				else $message = 9;
			}
		} else {
			$message = 6;
		}
	} else if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['captcha']) && isset($_SESSION['captcha_lost']['code']))
	{
		if($_POST['captcha'] == $_SESSION['captcha_lost']['code'])
		{
			$username = strip_tags($_POST['username']);
			$email = $_POST['email'];

			if(isValidEmail($email))
			{
				$message = $database->Lost($username,$email);
			} else $message = 4;

		}
		else $message = 5;
	}
?>
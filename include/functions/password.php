<?php
	$myEmail = getAccountEmail($_SESSION['id']);

	$message = 0;
	if(isset($_GET['code']) && strlen($_GET['code'])==32)
	{
		if(check_recovery($myEmail, $_GET['code']))
		{
			$message = 7;//bun
			if(isset($_POST['password']) && isset($_POST['rpassword']))
			{
				if($_POST['password']==$_POST['rpassword'])
				{
					if(isValidUserPassword($_POST['password']))
					{
						$password = getHashPassword($_POST['password']);
						update_passlost_token_by_email($myEmail);
						update_password_by_email($myEmail, $password);
						$message = 8;
					}
					else $message = 10;
				}
				else $message = 9;
			}
		} else {
			$message = 6;
		}
	} else
	{
		header("Location: ".$site_url."user/administration");
		die();
	}
?>
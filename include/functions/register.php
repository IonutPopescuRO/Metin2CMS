<?php
	if(isset($_POST['captcha']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rpassword']) && isset($_POST['email']) && isset($_SESSION['captcha']['code']))
	{
		$errors = array();
		if($_POST['captcha'] != $_SESSION['captcha']['code'])
			$errors[]=$lang['incorrect-security'];
		if(!isValidUserName($_POST['username']))
			$errors[]=$lang['incorrect-usermane'];
		if(!isValidUserPassword($_POST['password']))
			$errors[]=$lang['incorrect-password'];
		if($_POST['password'] != $_POST['rpassword'])
			$errors[]=$lang['no-password-r'];
		if(!isValidEmail($_POST['email']))
			$errors[]=$lang['incorrect-email'];
		if($database->checkUserName($_POST['username']))
			$errors[]=$lang['already-user'];
		if($database->checkUserEmail($_POST['email']))
			$errors[]=$lang['already-email'];
		
		foreach($errors as $error)
			print '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			  '.$error.'
			</div>';
		
		if(!count($errors))
		{
			$ref = isset($_GET['ref']) ? $_GET['ref'] : null;
			
			if(!$jsondataFunctions['active-referrals'])
				$ref=null;
			
			if($database->register($_POST['username'],$_POST['password'],$_POST['email'],$ref)){	
				print '<div class="alert alert-success" role="alert">
					  <h4 class="alert-heading">'.$lang['success'].'!</h4>
					  <p>'.$lang['success-register'].'</p>
					</div>';
			}
		}
	}
	
?>
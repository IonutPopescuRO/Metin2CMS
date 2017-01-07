<?php
	$myEmail = getAccountEmail($_SESSION['id']);
		
	$delete_account = check_delete();
		
	if(!$delete_account)
	{
		$account_delete_code = isset($_GET['code']) ? $_GET['code'] : null;

		if($account_delete_code && strlen($account_delete_code) == 32)
			if(check_deletion($myEmail, $account_delete_code))
			{
				update_deletion_token($_SESSION['id'], '');
				insert_delete_account($_SESSION['id']);
				header("Location: ".$site_url."user/administration");
				die();
			}
	} else if(isset($_POST['cancel-delete-account']))
	{
		cancel_delete_account();
		header("Location: ".$site_url."user/administration");
		die();
	}
?>
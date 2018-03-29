<?php
	if(isset($_POST['yes']))
	{
		updateDonateStatus($_POST['id'], 1);
		addCoins($_POST['account'], $_POST['md']);
	} else if(isset($_POST['no']))
		updateDonateStatus($_POST['id'], 2);
	
	$jsondataDonate = get_donations();
?>
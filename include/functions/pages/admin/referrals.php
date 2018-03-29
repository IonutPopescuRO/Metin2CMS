<?php
	$jsondataReferrals = file_get_contents('include/db/referrals.json');
	$jsondataReferrals = json_decode($jsondataReferrals, true);
	
	if(isset($_POST['submit']))
	{
		$edited = false;
		
		if(isset($_POST['status']) && $jsondataFunctions['active-referrals']!=$_POST['status'])
		{
			$jsondataFunctions['active-referrals']=$_POST['status'];
			
			$json_new = json_encode($jsondataFunctions);
			file_put_contents('include/db/functions.json', $json_new);
		}
		
		foreach($_POST as $key=>$value)
			if(isset($jsondataReferrals[$key]))
				if($jsondataReferrals[$key]!=$value)
				{
		$jsondataReferrals[$key]=$value;
		$edited = true;
				}
		
		if($edited)
		{
			$json_new = json_encode($jsondataReferrals);
			file_put_contents('include/db/referrals.json', $json_new);
		}
		
		header("Location: ".$site_url.'admin/referrals');
		die();
	}
?>
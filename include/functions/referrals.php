<?php
	if(!$jsondataFunctions['active-referrals'])
	{
		header("Location: ".$site_url);
		die();
	}
	
	$jsondataReferrals = file_get_contents('include/db/referrals.json');
	$jsondataReferrals = json_decode($jsondataReferrals, true);
				
	$received = false;
	
	if(isset($_POST['id']))
	{
		$getCharsINFO = getReferralsForCheck(intval($_POST['id']));
		
		if(count($getCharsINFO))
		{
			$getCharsINFO = getPlayerInfo($_POST['id']);
			$hours = floor($getCharsINFO['playtime'] / 60);
			if($jsondataReferrals['hours']<=$hours && $jsondataReferrals['level']<=$getCharsINFO['level'])
			{
				if($jsondataReferrals['type']==1)
					addCoins(intval($_SESSION['id']), $jsondataReferrals['coins']);
				else
					addjCoins(intval($_SESSION['id']), $jsondataReferrals['coins']);
				updateReferrals(intval($_POST['id']));
				$received = true;
			}
		}
	}

	$referrals_list = getReferrals();
?>
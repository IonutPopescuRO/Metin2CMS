<?php
	$received = -1;
	if(isset($_POST['code']))
	{
		$received = 0;
		
		if(strlen($_POST['code'])==16 && check_redeem_codes($_POST['code']))
		{
			$redeem_info = getRedeem($_POST['code']);
			$coins = $redeem_info['value'];
			if($redeem_info['type']==1 || $redeem_info['type']==2)
			{
				$received = $redeem_info['type'];
				if($received==1)
					addCoins(intval($_SESSION['id']), $coins);
				else
					addjCoins(intval($_SESSION['id']), $coins);
				
				delete_redeeem_code($redeem_info['id']);
			} else {
				$received = 3;
				
				$account_id = intval($_SESSION['id']);
				$item_position = new_item_position($account_id, $coins);

				if($item_position != -1)
				{

					$stmt = $database->runQueryPlayer('INSERT item (owner_id, window, pos, count, vnum) VALUES (?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, 1, $coins));
					
					delete_redeeem_code($redeem_info['id']);
				} else $received = 4;
			}
		}
	}
?>
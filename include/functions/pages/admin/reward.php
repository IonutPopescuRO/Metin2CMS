<?php
	if(isset($_POST['add']))
	{
		if(isset($_POST['account']))
		{
			if($_POST['account']==1)
				$account_id = getAccountIDbyName($_POST['name']);
			else
				$account_id = getAccountIDbyChar($_POST['name']);
			
			$added = 0;
			if($account_id)
			{
				add_item_award($account_id, $_POST['vnum'], $_POST['count'], $_POST['socket0'], $_POST['socket1'], $_POST['socket2']);
				$added = 1;
			} else $added = 2;
		}
	} else if(isset($_POST['add2'])){
		$online_players = getOnlinePlayers_minute(10);
		$added = 0;

		foreach($online_players as $player)
		{
			add_item_award($player['account_id'], $_POST['vnum'], $_POST['count'], $_POST['socket0'], $_POST['socket1'], $_POST['socket2']);
			$added = 1;
		}
	}
?>
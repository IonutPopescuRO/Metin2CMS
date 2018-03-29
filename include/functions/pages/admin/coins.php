<?php
	if(isset($_POST['account']))
	{
		if($_POST['account']==1)
			$account_id = getAccountIDbyName($_POST['name']);
		else
			$account_id = getAccountIDbyChar($_POST['name']);
		
		$added = 0;
		if($account_id)
		{
			if($_POST['type']==1)
				addCoins($account_id, $_POST['coins']);
			else
				addjCoins($account_id, $_POST['coins']);
			$added = 1;
		} else $added = 2;
	}
?>
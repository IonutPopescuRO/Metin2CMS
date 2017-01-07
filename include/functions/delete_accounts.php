<?php
	$accounts_to_delete = delete_in_progress();
	$date2=date_create(date('Y-m-d'));
	
	foreach($accounts_to_delete as $account)
	{
		$date1=date_create($account['date']);
		$diff=date_diff($date1,$date2);
		if(intval($diff->format("%R%a")) >=0)
			delete_account($account['account_id']);
	}
?>
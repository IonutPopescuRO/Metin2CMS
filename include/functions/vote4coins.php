<?php
	$vote4coins = file_get_contents('include/db/vote4coins.json');
	$vote4coins = json_decode($vote4coins, true);
	
	if(isset($_GET['site']) && isset($vote4coins[$_GET['site']]) && isset($vote4coins[$_GET['site']]['link']) && isset($vote4coins[$_GET['site']]['value']) && isset($vote4coins[$_GET['site']]['type']) && isset($vote4coins[$_GET['site']]['time']))
	{
		$voted_now = false;
		$account_ip = get_account_ip();
		if(filter_var($account_ip, FILTER_VALIDATE_IP) !== false)
		{
			if(!check_vote4coins($account_ip, $_GET['site']) && !check_vote4coins_by_account($_GET['site']))
			{
				insert_vote4coins($_GET['site'], $account_ip);
				if($vote4coins[$_GET['site']]['type']==1)
					addCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
				else
					addjCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
				$voted_now = true;
			} else {
				$date_voted_ip = check_date_vote4coins($_GET['site'], $account_ip);
					
				$date1=date_create($date_voted_ip);				
				$date2=date_create(date('Y-m-d G:i'));
				$diff_ip=date_diff($date1,$date2);
				
				$hours_ip = $diff_ip->h;
				$hours_ip = $hours_ip + ($diff_ip->days*24);
				
				$yet = $vote4coins[$_GET['site']]['time']-$hours_ip;
				date_add($date1, date_interval_create_from_date_string($yet.' hours'));
				
				$diff_ip=date_diff($date2, $date1);

				$date_voted_account = check_date_vote4coins_account($_GET['site']);
				$date1=date_create($date_voted_account);				
				$date2=date_create(date('Y-m-d G:i'));
				$diff_account=date_diff($date1,$date2);
					
				$hours_account = $diff_account->h;
				$hours_account = $hours_account + ($diff_account->days*24);
				
				$yet = $vote4coins[$_GET['site']]['time']-$hours_ip;
				date_add($date1, date_interval_create_from_date_string($yet.' hours'));
				
				$diff_account=date_diff($date2, $date1);

				if($date_voted_ip && $hours_ip < $vote4coins[$_GET['site']]['time'])
				{
					$time_vote = array();
					$time_vote['days'] = intval($diff_ip->format("%R%a"));
					$time_vote['hours'] = intval($diff_ip->format("%R%h"));
					$time_vote['minutes'] = intval($diff_ip->format("%R%i"));
						
					$already_voted = '';
						
					foreach($time_vote as $key => $time)
						if($time)
							$already_voted .= $time.' '.$lang[$key].' ';
					$already_voted = substr($already_voted, 0, -1);
					$already_voted .= '.';
				}
				else if($date_voted_account && $hours_account < $vote4coins[$_GET['site']]['time'])
				{
					$time_vote = array();
					$time_vote['days'] = intval($diff_account->format("%R%a"));
					$time_vote['hours'] = intval($diff_account->format("%R%h"));
					$time_vote['minutes'] = intval($diff_account->format("%R%i"));
						
					$already_voted = '';
						
					foreach($time_vote as $key => $time)
						if($time)
							$already_voted .= $time.' '.$lang[$key].' ';
					$already_voted = substr($already_voted, 0, -1);
					$already_voted .= '.';
				}
				else
				{
					updateVote4Coins($_GET['site'], $account_ip);
					
					if($vote4coins[$_GET['site']]['type']==1)
						addCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
					else
						addjCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
						
					$voted_now = true;
				}
			}
		}
		if($voted_now)
		{
			header("Location: ".$vote4coins[$_GET['site']]['link']);
			die();
		}
	}
?>
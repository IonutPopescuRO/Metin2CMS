<?php
require_once("include/classes/GetClientIp.php");
$vote4coins = file_get_contents('include/db/vote4coins.json');
$vote4coins = json_decode($vote4coins, true);
if(isset($_GET['site']) && isset($vote4coins[$_GET['site']]) && isset($vote4coins[$_GET['site']]['link']) && isset($vote4coins[$_GET['site']]['value']) && isset($vote4coins[$_GET['site']]['type']) && isset($vote4coins[$_GET['site']]['time']))
{
    $voted_now  = false;
	$getClientIp = new GetClientIp;
	$account_ip = $getClientIp->getClientIp();
	$session_verified = true;
	
	if(isset($_COOKIE['vote_'.$_GET['site']]))
	{
		$session_verified = $voted_now = false;
		
        $time_needed = strtotime('-' . $vote4coins[$_GET['site']]['time'] . ' hours');
		$date_diff = date_diff(date_create(date('Y-m-d G:i', $_COOKIE['vote_'.$_GET['site']])), date_create(date('Y-m-d G:i', $time_needed)));
		
		$already_voted = getTimeUntilNextVote($date_diff);
	}
	
    if($session_verified && filter_var($account_ip, FILTER_VALIDATE_IP) !== false) {
        if(!check_vote4coins_by_account($_GET['site'])) {			
			$can_vote = false;
			
            $date_voted = check_date_vote4coins_ip($_GET['site'], $account_ip);
			
            $time_needed = strtotime('-' . $vote4coins[$_GET['site']]['time'] . ' hours');
			
            if($time_needed > strtotime($date_voted))
                $can_vote = true;
            else {
                $date_diff = date_diff(date_create($date_voted), date_create(date('Y-m-d G:i', $time_needed)));
				$already_voted = getTimeUntilNextVote($date_diff);
			}
			
			if($can_vote)
			{
				setcookie('vote_'.$_GET['site'], time(), time()+(3600*$vote4coins[$_GET['site']]['time']));
				
				insert_vote4coins($_GET['site'], $account_ip);
				
				if($vote4coins[$_GET['site']]['type'] == 1)
					addCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
				else
					addjCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
				
				$voted_now = true;
			}
        } else {
            $can_vote = false;
            $date_voted = check_date_vote4coins($_GET['site'], $account_ip);
			
            $time_needed = strtotime('-' . $vote4coins[$_GET['site']]['time'] . ' hours');
			
            if($time_needed > strtotime($date_voted))
                $can_vote = true;
            else
                $date_diff = date_diff(date_create($date_voted), date_create(date('Y-m-d G:i', $time_needed)));
			
            if(!$can_vote)
				$already_voted = getTimeUntilNextVote($date_diff);
            else {
				setcookie('vote_'.$_GET['site'], time(), time()+(3600*$vote4coins[$_GET['site']]['time']));
				
                updateVote4Coins($_GET['site'], $account_ip);
                if($vote4coins[$_GET['site']]['type'] == 1)
                    addCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
                else
                    addjCoins($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
                $voted_now = true;
            }
        }
    }
    if($voted_now) {
        header("Location: " . $vote4coins[$_GET['site']]['link']);
        die();
    }
}
?>
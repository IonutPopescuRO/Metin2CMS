<?php
	switch ($current_page) {
		case 'players':
			include 'include/functions/pages/players.php';
			break;
		case 'guilds':
			include 'include/functions/pages/guilds.php';
			break;
		case 'login':
			include 'include/functions/pages/login.php';
			break;
		case 'lost':
			include 'include/functions/pages/lost.php';
			break;
		case 'download':
			include 'include/functions/pages/download.php';
			break;
		case 'donate':
			include 'include/functions/pages/donate.php';
			break;
	}
	
	redirect($page);
	
	switch ($current_page) {
		case 'administration':
			include 'include/functions/pages/administration.php';
			break;
		case 'password':
			include 'include/functions/pages/password.php';
			break;
		case 'email':
			include 'include/functions/pages/email.php';
			break;
		case 'vote4coins':
			include 'include/functions/pages/vote4coins.php';
			break;
		case 'referrals':
			include 'include/functions/pages/referrals.php';
			break;
		case 'redeem':
			include 'include/functions/pages/redeem.php';
			break;
	}
?>
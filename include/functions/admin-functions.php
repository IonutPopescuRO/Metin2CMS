<?php
	switch ($admin_page) {
		case 'log':
			include 'include/functions/pages/admin/log.php';
			break;
		case 'links':
			include 'include/functions/pages/admin/links.php';
			break;
		case 'players':
			include 'include/functions/pages/admin/players.php';
			break;
		case 'redeem':
			include 'include/functions/pages/admin/redeem.php';
			break;
		case 'player_edit':
			include 'include/functions/pages/admin/player_edit.php';
			break;
		case 'createitems':
			include 'include/functions/pages/admin/createitems.php';
			break;
		case 'download':
			include 'include/functions/pages/admin/download.php';
			break;
		case 'vote4coins':
			include 'include/functions/pages/admin/vote4coins.php';
			break;
		case 'functions':
			include 'include/functions/pages/admin/functions.php';
			break;
		case 'referrals':
			include 'include/functions/pages/admin/referrals.php';
			break;
		case 'privileges':
			include 'include/functions/pages/admin/privileges.php';
			break;
		case 'language':
			include 'include/functions/pages/admin/language.php';
			break;
		case 'donate':
			include 'include/functions/pages/admin/donate.php';
			break;
		case 'donatelist':
			include 'include/functions/pages/admin/donatelist.php';
			break;
		case 'coins':
			include 'include/functions/pages/admin/coins.php';
			break;
		case 'reward':
			include 'include/functions/pages/admin/reward.php';
			break;
	}
?>
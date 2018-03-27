<?php
	switch ($current_page) {
		case 'news':
			$page = 'news';
			$title = $lang['news'];
			include 'include/functions/news.php';
			break;
		case 'read':
			$page = 'read';
			$title = '';
			include 'include/functions/news.php';
			break;
		case 'register':
			$page = 'register';
			$title = $lang['register'];
			break;
		case 'login':
			$page = 'login';
			$title = $lang['login'];
			break;
		case 'players':
			$page = 'players';
			$title = $lang['players'];
			break;
		case 'guilds':
			$page = 'guilds';
			$title = $lang['guilds'];
			break;
		case 'administration':
			$page = 'administration';
			$title = $lang['administration'];
			break;
		case 'lost':
			$page = 'lost';
			$title = $lang['account-recovery'];
			break;
		case 'characters':
			$page = 'characters';
			$title = $lang['chars-list'];
			break;
		case 'admin':
			$page = 'admin';
			$title = $lang['administration'];
			break;
		case 'download':
			$page = 'download';
			$title = $lang['download'];
			break;
		case 'password':
			$page = 'password';
			$title = $lang['change-password'];
			break;
		case 'email':
			$page = 'email';
			$title = $lang['change-email'];
			break;
		case 'vote4coins':
			$page = 'vote4coins';
			$title = 'Vote4Coins';
			break;
		case 'donate':
			$page = 'donate';
			$title = $lang['donate'];
			break;
		case 'referrals':
			$page = 'referrals';
			$title = $lang['referrals'];
			break;
		case 'redeem':
			$page = 'redeem';
			$title = $lang['redeem-codes'];
			break;
		default:
			$page = 'news';
			$title = $lang['news'];
			include 'include/functions/news.php';
	}
?>
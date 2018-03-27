<?php
	switch ($admin_page) {
		case 'log':
			$a_page = 'log';
			$a_title = 'Log';
			break;
		case 'links':
			$a_page = 'links';
			$a_title = $lang['edit-links'];
			break;
		case 'functions':
			$a_page = 'functions';
			$a_title = $lang['functions'];
			break;
		case 'createitems':
			$a_page = 'createitems';
			$a_title = $lang['create-items'];
			break;
		case 'download':
			$a_page = 'download';
			$a_title = $lang['download'];
			break;
		case 'vote4coins':
			$a_page = 'vote4coins';
			$a_title = 'Vote4Coins';
			break;
		case 'players':
			$a_page = 'players';
			$a_title = $lang['player-management'];
			break;
		case 'player_edit':
			$a_page = 'player_edit';
			$a_title = $lang['edit-player-info'];
			break;
		case 'modules':
			$a_page = 'modules';
			$a_title = $lang['modules-management'];
			break;
		case 'themes':
			$a_page = 'themes';
			$a_title = $lang['themes'];
			break;
		case 'language':
			$a_page = 'language';
			$a_title = $lang['site-translate'];
			break;
		case 'donate':
			$a_page = 'donate';
			$a_title = $lang['donate'];
			break;
		case 'donatelist':
			$a_page = 'donatelist';
			$a_title = $lang['donatelist'];
			break;
		case 'privileges':
			$a_page = 'privileges';
			$a_title = $lang['privileges'];
			break;
		case 'coins':
			$a_page = 'coins';
			$a_title = $lang['add-coins'];
			break;
		case 'referrals':
			$a_page = 'referrals';
			$a_title = $lang['referrals'];
			break;
		case 'redeem':
			$a_page = 'redeem';
			$a_title = $lang['redeem-codes'];
			break;
		case 'reward':
			$a_page = 'reward';
			$a_title = $lang['reward-players'];
			break;
		default:
			$a_page = 'home';
			$a_title = $lang['admin-panel'];
	}
?>
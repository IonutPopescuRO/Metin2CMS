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
		default:
			$a_page = 'home';
			$a_title = "Panou administrare";
	}
?>
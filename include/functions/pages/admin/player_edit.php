<?php
	$player_id = isset($_GET['id']) ? $_GET['id'] : null;
	if(!check_char($player_id))
	{
		header("Location: ".$site_url."admin/players");
		die();	
	} else {
		$columns = getCharColumns('player');
		foreach($columns as $key => $column)
		{
			$type = translateNativeType($column['native_type']);
			if(!($type=='int' || $type=='string') || $column['name']=='id')
				unset($columns[$key]);
		}
		
		$actual_data = getCharData($player_id);

		$empire = get_player_empire($actual_data['account_id']);

		
		if(isset($_POST['submit']))
		{
			if($actual_data['name'] != $_POST['name'] && check_char_name($_POST['name']))
			{
				$triedName = $_POST['name'];
				$_POST['name'] = $actual_data['name'];
			}
			
			updateChar($player_id, $columns, $actual_data);
			updateWebAdmin($actual_data['account_id'], $_POST['web_admin']);
			updateGameAdmin(getAccountName($actual_data['account_id']), $actual_data['name'], $_POST['mAuthority']);
			update_empire($actual_data['account_id'], $_POST['empire']);
		}
	}
?>
<?php
	$date1=date_create($top10backup_day."-".$top10backup_month."-".$top10backup_year);
	$date2=date_create(date("Y-n-j"));
	$diff=date_diff($date1, $date2);
	if($diff->days)
	{
		$json = file_get_contents('include/db/ranking.json');
		$date = json_decode($json,true);
	
		$date['top10backup']['day'] = date("j");
		$date['top10backup']['month'] = date("n");
		$date['top10backup']['year'] = date("Y");
		
		//Top 10 players
		$top = array();
		$top = top10players();
		$i=1;
		
		$players = "";
		foreach($top as $player)
		{
			$empire=get_player_empire($player["account_id"]);
			$players.= '<tr><td></td><th scope="row"><strong>'.$i++.'</strong></th><td>'.$player["name"].'</td><td><img src="'.$site_url.'images/empire/'.$empire.'.jpg" alt="'.emire_name($empire).'" title="'.emire_name($empire).'"></td></tr>';	
		}
		$date['top10backup']['players'] = $players;
		
		//Top 10 guilds
		$top = array();
		$top = top10guilds();
		$i=1;
		
		$guilds = "";
		foreach($top as $guild)
		{
			$empire=get_guild_empire($guild["master"]);
			$guilds.= '<tr><td></td><th scope="row"><strong>'.$i++.'</strong></th><td>'.$guild["name"].'</td><td><img src="'.$site_url.'images/empire/'.$empire.'.jpg" alt="'.emire_name($empire).'" title="'.emire_name($empire).'"/></td></tr>';
		}
		$date['top10backup']['guilds'] = $guilds;
		
		$json_new = json_encode($date);
	
		file_put_contents('include/db/ranking.json', $json_new);
		
		//API Metin2 CMS
		include 'api.php';
		
		include 'delete_accounts.php';
	}
?>
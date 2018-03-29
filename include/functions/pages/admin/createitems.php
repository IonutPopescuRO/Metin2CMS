<?php
	$jsonBonuses = file_get_contents('include/db/bonuses.json');
	$jsonBonuses = json_decode($jsonBonuses,true);
	
	$form_bonuses = '';
	foreach($jsonBonuses as $bonus)
		$form_bonuses .= '<option value='.$bonus['id'].'>'.str_replace("[n]", 'XXX', $bonus[$language_code]).'</option>';
?>
<?php
	if(isset($_POST['submit']))
	{
		$edited = false;
		
		foreach($_POST as $key=>$value)
			if(isset($jsondataFunctions[$key]))
				if($jsondataFunctions[$key]!=$value)
				{
					$jsondataFunctions[$key]=$value;
					$edited = true;
				}
		
		if($edited)
		{
			$json_new = json_encode($jsondataFunctions);
			file_put_contents('include/db/functions.json', $json_new);
		}
		
		header("Location: ".$site_url.'admin/functions');
		die();
	}
?>
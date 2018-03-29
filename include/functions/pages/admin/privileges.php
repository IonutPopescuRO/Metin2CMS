<?php
	if(isset($_POST['submit']))
	{
		$edited = false;
		
		foreach($_POST as $key=>$value)
			if(isset($jsondataPrivileges[$key]))
				if($jsondataPrivileges[$key]!=$value)
				{
					$jsondataPrivileges[$key]=$value;
					$edited = true;
				}
		
		if($edited)
		{
			$json_new = json_encode($jsondataPrivileges);
			file_put_contents('include/db/privileges.json', $json_new);
		}
		
		header("Location: ".$site_url.'admin/privileges');
		die();
	}
?>
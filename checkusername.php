<?php
	if(isset($_POST['type']))
	{
		include 'include/functions/header.php';
		
		if($_POST['type']==1)
		{
			if(isset($_POST['username']))
			{
				if(isValidUserName($_POST['username']))
				{
					print $database->checkUserName($_POST['username']);
				}
				else print 0;
			} else print 0;
		}
		else 
		{
			if(isset($_POST['email']))
			{
				if(isValidEmail($_POST['email']))
				{
					print $database->checkUserEmail($_POST['email']);
				}
				else print 0;
			} else print 0;
		}
	} else print 0;
?>
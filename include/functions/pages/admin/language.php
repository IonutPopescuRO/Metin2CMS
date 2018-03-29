<?php
	if(isset($_POST['default-language']))
	{
		$edited = false;
		
		if(isset($json_languages['languages'][$_POST['default-language']]) && $_POST['default-language'] != $json_languages['settings']['default'])
		{
			$json_languages['settings']['default'] = $_POST['default-language'];
			$edited = true;
		}
		
		if($edited)
		{
			$json_new = json_encode($json_languages);
			file_put_contents('include/db/languages.json', $json_new);
		}
		
		header("Location: ".$site_url.'admin/language');
		die();
	} else if(isset($_POST['delete']))
	{
		$edited = false;
		if(isset($json_languages['languages'][$_POST['delete']]) && $_POST['delete'] != $json_languages['settings']['default'])
		{
			unset($json_languages['languages'][$_POST['delete']]);
			unlink('include/languages/'.$_POST['delete'].'.php');
			$edited = true;
		}
		
		if($edited)
		{
			$json_new = json_encode($json_languages);
			file_put_contents('include/db/languages.json', $json_new);
		}
		
		header("Location: ".$site_url.'admin/language');
		die();
	} else if(isset($_POST['install']) && isset($_POST['name']) && isset($_POST['link']))
	{
		$edited = false;
		$file = 'update.zip';
		@file_put_contents($file, file_get_contents($_POST['link']));

		if(file_exists($file)) {
			$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

			$zip = new ZipArchive;
			$res = $zip->open($file);
			if($res === TRUE) {
				$zip->extractTo($path);
				$zip->close();
				
				if(file_exists($file)) {
		unlink($file);
				}
				
				if(!isset($json_languages['languages'][$_POST['install']]))
				{
		$json_languages['languages'][$_POST['install']] = $_POST['name'];
		$edited = true;
				}
				
				if($edited)
				{
		$json_new = json_encode($json_languages);
		file_put_contents('include/db/languages.json', $json_new);
				}
			}
		}
		
		header("Location: ".$site_url.'admin/language');
		die();
	}
?>
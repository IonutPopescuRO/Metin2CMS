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
	} else if(isset($_POST['install']) && isset($_POST['name']))
	{
		$edited = false;
		$file = 'update.zip';
		$download = file_get_contents_curl('https://new.metin2cms.cf/v2/languages/'.$_POST['install'].'.zip', 2, 10);
		file_put_contents($file, $download);

		if(file_exists($file)) {
			$tryUpdate = ZipExtractUpdate();
			if($tryUpdate[0])
			{
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
<?php
	$apidata = file_get_contents('include/db/api.json');
	$apidata = json_decode($apidata,true);

	$available_update = false;
	if(!isset($apidata['ad']) || $apidata['ad']['last_update'] + 60*60*24 < time()) {
		$lastVersion = officialVersion();
		$available_update = checkUpdate($lastVersion);
	}

	if($available_update)
	{
		$failed = '<div class="alert alert-danger" role="alert">'.$lang['not-updated'].': <a href="https://new.metin2cms.cf/v2/'.$lastVersion.'.zip" class="tag tag-success">'.$lang['update'].'</a></div>';

		if(isset($_POST['update']))
		{
?>
	<center><img src="<?php print $site_url; ?>images/site/updating.gif"></center></br>
<?php
	$file = 'update.zip';
	$download = file_get_contents_curl('https://new.metin2cms.cf/v2/'.$lastVersion.'.zip',3,60);
	file_put_contents($file, $download);

	if(file_exists($file)) {
		$tryUpdate = ZipExtractUpdate();
		if($tryUpdate[0])
			print "<script>top.location='".$site_url."admin'</script>";
		else
		{
			print $failed;
			if(isset($tryUpdate[1]))
				print $tryUpdate[1];
		}
	} else
		print $failed;
} else { ?>
	<div class="alert alert-info" role="alert">
		<h4 class="alert-heading"><?php print $lang['update-available']; ?>!</h4>
		<p><?php print $lang['update-info']; ?></p>
		
		<form action="" method="post">
			<input type="submit" name="update" class="btn btn-success btn-lg btn-block" value="<?php print $lang['update']; ?>" />
		</form>
		
	</div>
<?php
		}
	} else {
		if(!isset($apidata['ad']) || $apidata['ad']['last_update'] + 60*60*24 < time()) {
			$helloworld = file_get_contents_curl('https://metin2cms.cf/salut.php?lang='.$language_code, 2, 5);
			if($helloworld)
				$apidata['ad']['content'] = $helloworld;
			else $helloworld = $apidata['ad']['content'];

			$apidata['ad']['last_update'] = time();

			$jsondata = json_encode($apidata);
			file_put_contents('include/db/api.json', $jsondata);
		} else $helloworld = $apidata['ad']['content'];

		if($helloworld)
			print '<div class="alert alert-info alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$helloworld.'</div>';
		else
			print '<div class="alert alert-danger fade in" role="alert">'.$lang['https-get-contents-error'].' <a href="https://piwik.org/faq/troubleshooting/faq_177/" target="_blank">Piwik</a> | <a href="https://stackoverflow.com/search?q=Unable+to+find+the+wrapper+%22https%22" target="_blank">StackOverflow</a></div>';
	}
?>




<?php
	$lastVersion = officialVersion();

	$failed = '<div class="alert alert-danger" role="alert">'.$lang['not-updated'].': <a href="https://new.metin2cms.cf/v2/'.$lastVersion.'.zip" class="tag tag-success">'.$lang['update'].'</a></div>';
	
	if(checkUpdate($lastVersion))
	{
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
	} else 
	{
		$helloworld = file_get_contents_curl('http://metin2cms.cf/salut.php?lang='.$language_code, 2, 5);
		if($helloworld)
			print '<div class="alert alert-info alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$helloworld.'</div>';
		else if(!$lastVersion)
			print '<div class="alert alert-danger fade in" role="alert">'.$lang['https-get-contents-error'].' <a href="https://piwik.org/faq/troubleshooting/faq_177/" target="_blank">Piwik</a> | <a href="https://stackoverflow.com/search?q=Unable+to+find+the+wrapper+%22https%22" target="_blank">StackOverflow</a></div>';
	}
?>




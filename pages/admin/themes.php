<?php
	if(isset($_POST['install']))
	{
?>
		<center><img src="<?php print $site_url; ?>images/site/updating.gif"></center></br>
<?php
		$file = 'update.zip';
		
		$download = file_get_contents_curl($_POST['install'],2,10);
		file_put_contents($file, $download);

		if(file_exists($file)) {
			$tryUpdate = ZipExtractUpdate();
			if($tryUpdate[0])
				print "<script>top.location='".$site_url."admin/themes'</script>";
			else
			{
				if(isset($tryUpdate[1]))
					print $tryUpdate[1];
			}
		}
	}
		print '<div class="alert alert-info alert-dismissible fade in" role="alert">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>'.$lang['themes-update-info'].'</div>';
?>
<div class="row">
	<?php
		$themes_list = getThemesList(); 
		foreach($themes_list as $mod)
		{
	?>
    <div class="col-sm-6">
		<div class="card">
			<img class="card-img-top" src="<?php print $mod['img']; ?>">
			<div class="card-block">
				<h4 class="card-title"><?php print $mod['name']; ?></h4>
				<p class="card-text"><?php print $mod['description']; ?></p>
				<?php print '<form method="POST" action=""><input type="hidden" value="'.$mod['link'].'" name="install"><button type="submit" class="btn btn-success">'.$lang['install'].'</button></form>'; ?>
			</div>
		</div>
    </div>
	<?php }
	if(!count($themes_list))
		print '<div class="alert alert-info alert-dismissible fade in" role="alert">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>'.$lang['no-themes'].'</div>';
	?>
</div>
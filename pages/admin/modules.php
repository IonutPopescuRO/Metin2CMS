<?php
	if(isset($_POST['uninstall']) && is_dir($_POST['uninstall']))
	{
		rmdir($_POST['uninstall']);
		print '<div class="alert alert-success alert-dismissible fade in" role="alert">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>'.$lang['uninstall-info'].'</div>';
	} else if(isset($_POST['install']))
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
				print "<script>top.location='".$site_url."admin/modules'</script>";
			else
			{
				if(isset($tryUpdate[1]))
					print $tryUpdate[1];
			}
		}
	}
		
?>
<div class="row">
	<?php
		$modules_list = getModulesList(); 
		foreach($modules_list as $mod)
		{
	?>
    <div class="col-sm-6">
		<div class="card">
			<img class="card-img-top" src="<?php print $mod['img']; ?>">
			<div class="card-block">
				<h4 class="card-title"><?php print $mod['name']; ?></h4>
				<p class="card-text"><?php print $mod['description']; ?><?php if(is_dir($mod['directory'])) { ?></br><a href="<?php print $site_url.$mod['directory']; ?>"><?php print $site_url.$mod['directory']; ?></a><?php } ?></p>
				<?php if(is_dir($mod['directory'])) print '<form method="POST" action=""><input type="hidden" value="'.$mod['directory'].'" name="uninstall"><button type="submit" class="btn btn-danger">'.$lang['uninstall'].'</button></form>';
						else print '<form method="POST" action=""><input type="hidden" value="'.$mod['link'].'" name="install"><button type="submit" class="btn btn-success">'.$lang['install'].'</button></form>'; ?>
			</div>
		</div>
    </div>
	<?php }
	if(!count($modules_list))
		print '<div class="alert alert-info alert-dismissible fade in" role="alert">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>'.$lang['no-modules'].'</div>';
	?>
</div>
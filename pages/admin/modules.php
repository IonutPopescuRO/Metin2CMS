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
		@file_put_contents($file, file_get_contents($_POST['install']));

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
				
				print "<script>top.location='".$site_url."admin/modules'</script>";
			} else {
				print $failed;
			}
		} else print $failed;
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
				<p class="card-text"><?php print $mod['description']; ?></p>
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
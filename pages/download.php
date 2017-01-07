<?php
	$download_links=getJsonSettings("", "download-links");
?>
<div class="container">
	<div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/user.png)">
		<div class="bd-c">
			<h2 class="pre-social"><?php print $lang['download']; ?></h2>
		</div>
	</div>
	
	<?php if(count($download_links)) { ?>
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th style="width: 15%">#</th>
				<th style="width: 70%">Server</th>
				<th><?php print $lang['download']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($download_links as $key => $download) { ?>
			<tr>
				<th scope="row"><?php print $key++; ?></th>
				<td><?php print $download['name']; ?></td>
				<td><a href="<?php print $download['link']; ?>" class="btn btn-primary btn-sm"><?php print $lang['download']; ?></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">
		<strong>Info!</strong> <?php print $lang['no-download-links']; ?>
	</div>
	<?php } ?>
</div>
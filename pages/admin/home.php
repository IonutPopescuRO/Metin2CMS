<?php
	include 'include/functions/check-version.php';
	if(file_exists('include/functions/update.php'))
		include 'include/functions/update.php';
	fix_account_columns();
?>
<div class="list-group">
	<li class="list-group-item active">
		<i class="fa fa-cogs fa-1" aria-hidden="true"></i> <?php print $lang['general-settings']; ?>
	</li>
	<a href="admin/links" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-cog fa-1" aria-hidden="true"></i> <?php print $lang['edit-info']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['edit-links-info']; ?></p>
	</a>
	<a href="admin/download" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-download fa-1" aria-hidden="true"></i> <?php print $lang['download']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['download-links']; ?></p>
	</a>
	<a href="admin/functions" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-check-square-o fa-1" aria-hidden="true"></i> <?php print $lang['functions-on-off']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['functions-on-off-info']; ?></p>
	</a>
	<a href="admin/vote4coins" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-thumbs-o-up fa-1" aria-hidden="true"></i> Vote4Coins</h5>
		<p class="list-group-item-text"><?php print $lang['vote-info']; ?></p>
	</a>
</div>
</br>
<div class="list-group">
	<li class="list-group-item active">
		<i class="fa fa-cogs fa-1" aria-hidden="true"></i> <?php print $lang['game-management']; ?>
	</li>
	<a href="admin/players" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-user fa-1" aria-hidden="true"></i> <?php print $lang['player-management']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['player-management-info']; ?></p>
	</a>
	<a href="admin/log" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-binoculars fa-1" aria-hidden="true"></i> Log</h5>
		<p class="list-group-item-text"><?php print $lang['log-info']; ?></p>
	</a>
	<a href="admin/createitems" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-fire fa-1" aria-hidden="true"></i> <?php print $lang['create-items']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['create-items-info']; ?></p>
	</a>
</div>
</br>
<div class="list-group">
	<li class="list-group-item active">
		<i class="fa fa-cogs fa-1" aria-hidden="true"></i> <?php print $lang['cms-management']; ?>
	</li>
	<a href="admin/modules" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-plug fa-1" aria-hidden="true"></i> <?php print $lang['modules-management']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['modules-management-info']; ?></p>
	</a>
	<a href="admin/themes" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-file-image-o fa-1" aria-hidden="true"></i> <?php print $lang['themes']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['themes-info']; ?></p>
	</a>
</div>
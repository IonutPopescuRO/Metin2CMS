<?php
	include 'include/functions/check-version.php';
?>
<div class="list-group">
	<li class="list-group-item active">
		<i class="fa fa-cogs fa-1" aria-hidden="true"></i> <?php print $lang['general-settings']; ?>
	</li>
	<a href="admin/links" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-cog fa-1" aria-hidden="true"></i> <?php print $lang['edit-links']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['edit-links-info']; ?></p>
	</a>
	<a href="admin/functions" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-check-square-o fa-1" aria-hidden="true"></i> <?php print $lang['functions-on-off']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['functions-on-off-info']; ?></p>
	</a>
</div>
</br>
<div class="list-group">
	<li class="list-group-item active">
		<i class="fa fa-cogs fa-1" aria-hidden="true"></i> <?php print $lang['game-management']; ?>
	</li>
	<a href="admin/log" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-binoculars fa-1" aria-hidden="true"></i> Log</h5>
		<p class="list-group-item-text"><?php print $lang['create-items-info']; ?></p>
	</a>
	<a href="admin/createitems" class="list-group-item list-group-item-action">
		<h5 class="list-group-item-heading"><i class="fa fa-fire fa-1" aria-hidden="true"></i> <?php print $lang['create-items']; ?></h5>
		<p class="list-group-item-text"><?php print $lang['create-items-info']; ?></p>
	</a>
</div>
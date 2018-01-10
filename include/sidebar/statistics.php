<li class="widget-container widget-gw2-sidebar-link-two-part">
	<div class="widget widget-wide mod mod-main" style="background-size: 299px 47px!important;">
		<div class="bd eason">
			<div class="top-sidebar"><h4 style="text-transform: none !important;"><?php print $lang['statistics']; ?></h4></div>
			<table class="table table-hover">
				<tbody>
				<?php
				foreach($jsondataFunctions as $key => $status)
					if($key != 'active-registrations' && $key != 'players-debug' && $key != 'active-referrals' && $status)
					{
				?>
					<tr>
						<th scope="row"><?php print $lang[$key]; ?></th>
						<td><?php print number_format(getStatistics($key), 0, '', '.'); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</li>
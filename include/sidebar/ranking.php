<li class="widget-container widget-gw2-sidebar-link-two-part">
	<div class="widget widget-wide mod mod-main">
		<div class="bd eason">
			<div class="top-sidebar"><h4 style="text-transform: none !important;"><?php print $lang['ranking']; ?></h4></div>
			<hr>
			
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#players" role="tab"><img src="<?php print $site_url; ?>images/players.png" alt="<?php print $lang['players']; ?>" title="<?php print $lang['players']; ?>"></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#guilds" role="tab"><img src="<?php print $site_url; ?>images/guilds.png" alt="<?php print $lang['guilds']; ?>" title="<?php print $lang['guilds']; ?>"></a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="players" role="tabpanel">
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<th></th>
								<th>#</th>
								<th><?php print $lang['name']; ?></th>
								<th><?php print $lang['empire']; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!$offline) {
								$top = array();
								$top = topPlayers();
								
								$i=1;
								
								foreach($top as $player)
								{
							?>
							<tr>
								<td></td>
								<th scope="row"><strong><?php print $i++; ?></strong></th>
								<td><?php print $player['name']; ?></td>
								<td><img src="<?php print $site_url; ?>images/empire/<?php print $empire=get_player_empire($player['account_id']); ?>.jpg" alt="<?php print empire_name($empire); ?>"></td>
							</tr>
							<?php }
							} else print $offline_players;
							?>
						</tbody>
					</table>
					
					<center>
					<?php if(!$offline) { ?>
						<a href="<?php print $site_url; ?>ranking/players" class="btn btn-primary btn-sm">Top 100 &raquo;</a>
					<?php } else print '<span class="tag tag-danger">'.$lang['server-offline'].'</span></br><span class="tag tag-danger">'.$lang['last-update'].': '.$offline_date.'</span>'; ?>
					</center></br>
				</div>
				<div class="tab-pane" id="guilds" role="tabpanel">
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<th></th>
								<th>#</th>
								<th><?php print $lang['name']; ?></th>
								<th><?php print $lang['empire']; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!$offline) {
								$top = array();
								$top = topGuilds();
								
								$i=1;
								
								foreach($top as $guild)
								{
							?>
							<tr>
								<td></td>
								<th scope="row"><strong><?php print $i++; ?></strong></th>
								<td><?php print $guild['name']; ?></td>
								<td><img src="<?php print $site_url; ?>images/empire/<?php print $empire=get_guild_empire($guild['master']); ?>.jpg" alt="<?php print empire_name($empire); ?>"/></td>
							</tr>
							<?php }
							} else print $offline_guilds;
							?>
						</tbody>
					</table>
					
					<center>
					<?php if(!$offline) { ?>
						<a href="<?php print $site_url; ?>ranking/guilds" class="btn btn-primary btn-sm">Top 100 &raquo;</a>
					<?php } else print '<span class="tag tag-danger">'.$lang['server-offline'].'</span></br><span class="tag tag-danger">'.$lang['last-update'].': '.$offline_date.'</span>'; ?>
					</center></br>
				</div>
			</div>


		</div>
	</div>
</li>
<?php
	$list = characters_list();
	$ranking = get_player_rank($list);
?>
<div class="mt2cms2-c-l">
    <div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/user.png)">
        <div class="bd-c">
            <h2 class="pre-social"><?php print $lang['chars']; ?></h2>
			<small><?php print $account_name = getAccountName($_SESSION['id']); ?></small>
        </div>
    </div>
	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<p><h2><?php print $lang['chars-list']; ?></h2></p>
			<hr>
			<?php if(count($list)) { ?>
			<div style="background-color: white;">
				<table class="table table-hover">
					<thead class="thead-inverse">
						<tr>
							<th><?php print $lang['rank-position']; ?></th>
							<th><?php print $lang['class']; ?></th>
							<th><?php print $lang['name']; ?></th>
							<th><?php print $lang['level']; ?></th>
							<th>EXP</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($list as $player) { 
							$job = job_name($player['job']);
						?>
						<tr>
							<th scope="row"><?php print $ranking[$player['name']]; ?></th>
							<td><img src="<?php print $site_url.'images/job/'.$player['job'].'.png'; ?>" width="32" alt="<?php print $job; ?>" title="<?php print $job; ?>"></td>
							<td><?php print $player['name']; ?></td>
							<td><?php print $player['level']; ?></td>
							<td><?php print $player['exp']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php } else print $lang['no-chars']; ?>
		</div>
		</br>
	</div>

</div>
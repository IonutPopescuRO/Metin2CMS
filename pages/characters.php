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
			<?php
				if($jsondataFunctions['players-debug'] && isset($_POST['debug']))
					foreach($list as $player)
						if($player['id']==intval($_POST['debug']))
						{
							print '<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>';
							print $lang['debug-success'];
							print '</div>';
							
							$empire = get_player_empire($_SESSION['id']);	

							if($empire==1) { $mapindex = "0"; $x = "459770"; $y = "953980";}
							elseif($empire==2) { $mapindex = "21"; $x = "52043"; $y = "166304";}
							elseif($empire==3) { $mapindex = "41"; $x = "957291"; $y = "255221";}
							
							reset_char($player['id'], $mapindex, $x, $y);
						}
			?>
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
							<?php if($jsondataFunctions['players-debug']) { ?>
								<th><?php print $lang['debug']; ?></th>
							<?php } ?>
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
							<?php if($jsondataFunctions['players-debug']) { ?>
								<td>
									<form action="" method="post">
										<input type="hidden" name="debug" value="<?php print $player['id']; ?>">
										<button type="submit" name="submit" class="btn btn-primary btn-sm"><?php print $lang['debug']; ?></button>
									</form>
								</td>
							<?php } ?>
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
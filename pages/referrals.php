<div class="container">
	<div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/user.png)">
		<div class="bd-c">
			<h2 class="pre-social"><?php print $lang['referrals']; ?></h2>
		</div>
	</div>
	<div class="padding-container">
		<p><?php print $lang['referral-link']; ?></p>
		<?php $link = $site_url.'users/register/'.$_SESSION['id']; ?>
		<form>
			<div class="input-group">
				<input type="text" class="form-control" value="<?php print $link; ?>" id="share" readonly="readonly">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" id="copyButton" data-placement="button">
						<i class="fa fa-clipboard" aria-hidden="true"></i>
					</button>
				</span>
			</div>
		</form>
		<?php if(is_array($referrals_list) && count($referrals_list)) { ?>
		<hr/>
		<div class="jumbotron jumbotron-fluid">
			<div class="container">
				<h3><?php print $lang['referral-invited']; ?></h3>
				<hr>
				<?php if($received) { ?>
				<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php
						print $lang['collected_md'].' '.$jsondataReferrals['coins'].' '; 
						if($jsondataReferrals['type']==1)
							print $lang['md'].' (MD)';
						else print $lang['jd'].' (JD)';
						print '.'; 
					?>
				</div>
				<?php } ?>
				<table class="table table-hover">
					<thead class="thead-inverse">
							<tr>
								<th>#</th>
								<th><?php print $lang['char-name']; ?></th>
								<th><?php print $lang['level']; ?></th>
								<th><?php print $lang['play-time']; ?></th>
								<th><?php print $lang['collect']; ?></th>
								</tr>
					</thead>
					<tbody>
						<?php 
							$x=0;
							$i=1;
							foreach($referrals_list as $getChars) {
								
								$getCharsINFO = getPlayerInfo($getChars['registered']);

								if(count($getCharsINFO))
								{
									$hours = floor($getCharsINFO['playtime'] / 60);
									$minutes = $getCharsINFO['playtime'] % 60;
									
									echo'<tr>
										  <td>'.$i++.'</td>
										  <td>'.$getCharsINFO['name'].'</td>
										  <td>'.$getCharsINFO['level'].'</td>
										  <td>'.$hours.' ore & '.$minutes.' minute</td>';
									if($getChars['claimed']==1) echo '<td><button class="btn btn-primary btn-sm disabled">'.$lang['collected'].'</button></td>';
									else {
									if($jsondataReferrals['hours']<=$hours && $jsondataReferrals['level']<=$getCharsINFO['level'])
										echo '<td><form action="" method="post"><input type="hidden" name="id" value="'.$getChars['registered'].'"><input id="submitBtn" type="submit" name="login" value="'.$lang['collect'].'" class="btn btn-primary btn-sm"/></td></form>';
									else echo '<td><button class="btn btn-primary btn-sm disabled">'.$lang['not_yet'].'</button></td>';}
									echo'</tr>';
									  $x++;
								
								}		
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="alert alert-info alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<span><?php print $lang['referral-min-hours'].': '.$jsondataReferrals['hours']; ?></span>
			<hr>
			<span><?php print $lang['referral-min-level'].': '.$jsondataReferrals['level']; ?></span>
		</div>
		<?php } ?>
	</div>
</div>
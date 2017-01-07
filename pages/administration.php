<div class="mt2cms2-c-l">
    <div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/user.png)">
        <div class="bd-c">
            <h2 class="pre-social"><?php print $lang['my-account']; ?></h2>
			<small><?php print $account_name = getAccountName($_SESSION['id']); ?></small>
        </div>
    </div>
	<?php
	
		if(isset($_POST['delete-code']))
		{
			$alt_message = $lang['delete-chars'];
			$subject = $lang['delete-chars'];
			$sendName = $account_name;
			$sendEmail = $myEmail;
			$code = getAccountSocialID($_SESSION['id']);
			
			$html_mail = sendCode($account_name, $code);
			include 'include/functions/sendEmail.php';
			
			print '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>';
			print $lang['sended-code'];
			print '</div>';
		} else if(isset($_POST['storekeeper-code']))
		{
			$code = getPlayerSafeBoxPassword($_SESSION['id']);
			
			if($code!='' && $code!='000000')
			{
				$alt_message = $lang['storekeeper'];
				$subject = $lang['storekeeper'];
				$sendName = $account_name;
				$sendEmail = $myEmail;
				$html_mail = sendCode($account_name, $code, 2);
				include 'include/functions/sendEmail.php';
				
				print '<div class="alert alert-success alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>';
				print $lang['sended-code'];
				print '</div>';
			} else
			{
				print '<div class="alert alert-danger alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>';
				print $lang['no-storekeeper'];
				print '</div>';
			}
		} else if(!$delete_account && isset($_POST['delete-account']))
		{
			$code = generateSocialID(32);
			update_deletion_token($_SESSION['id'], $code);
			
			$code = '<br><br><a href="'.$site_url.'user/delete/'.$code.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">'.$lang['delete-account'].'</a>';
			
			$alt_message = $lang['delete-account'];
			$subject = $lang['delete-account'];
			$sendName = $account_name;
			$sendEmail = $myEmail;
			$html_mail = sendCode($account_name, $code, 3);
			include 'include/functions/sendEmail.php';
				
			print '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>';
			print $lang['sended-code'];
			print '</div>';
		} else if(isset($_POST['change-password']))
		{
			$code = generateSocialID(32);
			update_passlost_token_by_email($myEmail, $code);
			
			$code = '<br><br><a href="'.$site_url.'user/password/'.$code.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">'.$lang['change-password'].'</a>';
			
			$alt_message = $lang['password'];
			$subject = $lang['password'];
			$sendName = $account_name;
			$sendEmail = $myEmail;
			$html_mail = sendCode($account_name, $code, 4);
			include 'include/functions/sendEmail.php';
				
			print '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>';
			print $lang['sended-code'];
			print '</div>';
		}
	?>
	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<p><?php print $lang['user-name'].' : '.$account_name; ?></p>
			<p><?php print $lang['email-address'].' : '.$myEmail; ?></p>
			<p><?php print $lang['md'].' : '.getAccountMD($_SESSION['id']); ?></p>
			<p><?php print $lang['jd'].' : '.getAccountJD($_SESSION['id']); ?></p>
			<hr>
			<div class="row">
				<div class="col-sm-4"><a href="<?php print $site_url; ?>user/characters" class="btn btn-primary btn-sm btn-block"><?php print $lang['chars']; ?> &raquo;</a></div>
				<div class="col-sm-8"><?php print $lang['chars-list']; ?></div>
			</div>
			</br>
			<div class="row">
				<div class="col-sm-4"><a href="<?php print $site_url; ?>user/email" class="btn btn-primary btn-sm btn-block"><?php print $lang['email-address']; ?> &raquo;</a></div>
				<div class="col-sm-8"><?php print $lang['change-email']; ?></div>
			</div>
			</br>
			<div class="row">
				<div class="col-sm-4">
					<form action="" method="post">
						<input type="submit" name="change-password" class="btn btn-primary btn-sm btn-block" onclick="return confirm('<?php print $lang['sure_send?']; ?>')" value="<?php print $lang['password']; ?> &raquo;" />
					</form>
				</div>
				<div class="col-sm-8"><?php print $lang['change-password']; ?></div>
			</div>
			</br>
			<div class="row">
				<div class="col-sm-4">
					<form action="" method="post">
						<input type="submit" name="storekeeper-code" class="btn btn-primary btn-sm btn-block" onclick="return confirm('<?php print $lang['sure_send?']; ?>')" value="<?php print $lang['storekeeper']; ?> &raquo;" />
					</form>
				</div>
				<div class="col-sm-8"><?php print $lang['request-storekeeper']; ?></div>
			</div>
			</br>
			<div class="row">
				<div class="col-sm-4">
					<form action="" method="post">
						<input type="submit" name="delete-code" class="btn btn-primary btn-sm btn-block" onclick="return confirm('<?php print $lang['sure_send?']; ?>')" value="<?php print $lang['send']; ?> &raquo;" />
					</form>
				</div>
				<div class="col-sm-8"><?php print $lang['delete-chars']; ?></div>
			</div>
			</br>
			<?php if(!$delete_account) { ?>
			<div class="row">
				<div class="col-sm-4">
					<form action="" method="post">
						<input type="submit" name="delete-account" class="btn btn-danger btn-sm btn-block" onclick="return confirm('<?php print $lang['sure_send?']; ?>')" value="<?php print $lang['delete-account']; ?> &raquo;" />
					</form>
				</div>
				<div class="col-sm-8"><?php print $lang['delete-account']; ?></div>
			</div>
			<?php } else { ?>
			<div class="row">
				<div class="col-sm-4">
					<form action="" method="post">
						<input type="submit" name="cancel-delete-account" class="btn btn-warning btn-sm btn-block" value="<?php print $lang['cancel-delete-account']; ?> &raquo;" />
					</form>
				</div>
				<?php
					$date1=date_create($delete_account['date']);
					$date2=date_create(date('Y-m-d'));
					$diff=date_diff($date1,$date2);
					$time_delete = intval($diff->format("%R%a"));
				?>
				<div class="col-sm-8"><?php if($time_delete < 0) print $lang['time-until-deletion'].' '.($time_delete*(-1)).' '.$lang['days']; else print $lang['time-to-deletion']; ?></div>
			</div>
			<?php } ?>
		</div>
		</br>
	</div>

</div>
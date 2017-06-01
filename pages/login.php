<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-12 col-sm-offset-2 col-md-offset-3">
            <form role="form" method="post" action="">
				<div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/user.png)">
					<div class="bd-c">
						<h2 class="pre-social"><?php print $lang['login']; ?></h2>
					</div>
				</div>
				<?php
					if(isset($_POST['username']) && isset($_POST['password']))
					{
						print '<div class="alert alert-danger alert-dismissible fade in" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>';
						switch ($login_info[0]) {
							case 1:
								print 'logged';
								break;
							case 2:
								print $lang['account-blocked'];
								break;
							case 3:
								print $lang['error-login'];
								break;
							case 4:
								print $lang['error-login-email'];
								break;
							case 5:
								print $lang['account-blocked-temporary'].' ('.$login_info[2].')';
								break;
							default:
								print 'ERROR';
						}
						print '</div>';
						
						if($login_info[0]==2 || $login_info[0]==5)
						print '<div class="alert alert-info alert-dismissible fade in" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>'.$lang['reason'].': '.$login_info[1].'</div>';
					}
				?>
				<table class="table table-hover">
					<tbody>
						<tr>
							<td><?php print $lang['user-name']; ?>:</td>
							<td><input class="form-control" name="username" pattern=".{5,64}" maxlength="64" placeholder="<?php print $lang['user-name-or-email']; ?>" required="" type="text" autocomplete="off"></td>
						</tr>
						<tr>
							<td><?php print $lang['password']; ?>:</td>
							<td><input class="form-control" name="password" pattern=".{5,16}" maxlength="16" placeholder="<?php print $lang['password']; ?>" required="" type="password"></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<input type="submit" value="<?php print $lang['login']; ?>" class="btn btn-success btn-lg btn-block" tabindex="7">
            </form>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<p><a href="<?php print $site_url; ?>users/register"><?php print $lang['register']; ?></a></p>
				</div>
				<div class="col-md-6">
					<p style="text-align: right"><a href="<?php print $site_url; ?>users/lost"><?php print $lang['forget-password']; ?></a></p>
				</div>
			</div>
        </div>
    </div>

</div>
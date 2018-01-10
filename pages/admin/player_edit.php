<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-12 col-sm-offset-2 col-md-offset-3">
			<?php if(isset($triedName)) { ?>
				<div class="alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<span><?php print $triedName.' '.$lang['not-available']; ?></span>
				</div>
			<?php } ?>
            <form role="form" method="post" action="">
				<table class="table table-hover" style="background-color: white;">
					<tbody>
						<tr>
							<td>mAuthority:</td>
							<td>
								<?php $gm = searchGMlist($actual_data['name']); ?>
								<select name="mAuthority" class="form-control">
										<option value="IMPLEMENTOR" <?php if($gm=="IMPLEMENTOR") { echo "selected"; } ?>> IMPLEMENTOR</option>
										<option value="HIGH_WIZARD" <?php if($gm=="HIGH_WIZARD") { echo "selected"; } ?>> HIGH_WIZARD</option>
										<option value="GOD" <?php if($gm=="GOD") { echo "selected"; } ?>> GOD </option>
										<option value="LOW_WIZARD" <?php if($gm=="LOW_WIZARD") { echo "selected"; } ?>> LOW_WIZARD</option>
										<option value="PLAYER" <?php if($gm=="PLAYER") { echo "selected"; } ?>> PLAYER </option>
								</select>
							</td>
						</tr>
						<tr>
							<td>web_admin:</td>
							<td>
								<?php $web_admin_level = get_web_admin_level($actual_data['account_id']); ?>
								<select class="form-control" name="web_admin">
									<?php for($i=9;$i>=0;$i--) { ?>
									<option value="<?php print $i; ?>"<?php if($web_admin_level==$i) print ' selected="selected"'; ?>><?php print $i; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php print $lang['empire']; ?>:</td>
							<td>
								<select name="empire" class="form-control selectpicker">
										<option value="1" data-thumbnail="<?php print $site_url; ?>/images/empire/1.jpg"<?php if($empire=="1") { echo " selected"; } ?>> Shinsoo </option>
										<option value="2" data-thumbnail="<?php print $site_url; ?>/images/empire/2.jpg"<?php if($empire=="2") { echo " selected"; } ?>> Chunjo </option>
										<option value="3" data-thumbnail="<?php print $site_url; ?>/images/empire/3.jpg"<?php if($empire=="3") { echo " selected"; } ?>> Jinno </option>
								</select>
							</td>
						</tr>
					<?php
						foreach($columns as $column)
						{
					?>
						<tr>
							<td><?php print $column['name']; ?>:</td>
							<td><input class="form-control" style="color: black!important;" name="<?php print $column['name']; ?>" id="<?php print $column['name']; ?>" value="<?php print $actual_data[$column['name']]; ?>" type="text"></td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
				<hr>
				<input type="submit" name="submit" value="<?php print $lang['update']; ?>" class="btn btn-info btn-lg btn-block" tabindex="7">

			</form>
        </div>
    </div>
</div>
<div class="container">

	<form action="" method="post">
		<div class="form-group">
			<label for="status"><?php print $lang['status']; ?></label>
			<select class="form-control" id="status" name="status">
				<option value="0"<?php if(!$jsondataFunctions['active-referrals']) print ' selected="selected"';?>><?php print $lang['disabled']; ?></option>
				<option value="1"<?php if($jsondataFunctions['active-referrals']) print ' selected="selected"';?>><?php print $lang['enabled']; ?></option>
			</select>
		</div>
		<hr>
		<h3><?php print $lang['eligibility']; ?></h3>
		<p><?php print $lang['eligibility-info']; ?></p>
		
		<div class="row">
			<div class="form-group col-md-6">
				<label for="inputHours"><?php print $lang['referral-min-hours']; ?></label>
				<input type="number" class="form-control" min="0" id="inputHours" name="hours" value="<?php print $jsondataReferrals['hours']; ?>" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputLevel"><?php print $lang['referral-min-level']; ?></label>
				<input type="number" class="form-control" min="0" id="inputLevel" name="level" value="<?php print $jsondataReferrals['level']; ?>" required>
			</div>
		</div>

		<hr>
		<h3><?php print $lang['reward']; ?></h3>

		<div class="form-group row">
			<div class="col-sm-6">
				<select class="form-control" name="type">
					<option value="1"<?php if($jsondataReferrals['type']==1) print ' selected="selected"';?>><?php print $lang['md']; ?></option>
					<option value="2"<?php if($jsondataReferrals['type']==2) print ' selected="selected"';?>><?php print $lang['jd']; ?></option>
				</select>
			</div>
			<div class="col-sm-6">
				<input class="form-control" name="coins" value="<?php print $jsondataReferrals['coins']; ?>" type="number" required>
			</div>
		</div>
		<div class="form-group row">
			<button type="submit" name="submit" class="btn btn-primary"><?php print $lang['save']; ?></button>
		</div>
	</form>

</div>
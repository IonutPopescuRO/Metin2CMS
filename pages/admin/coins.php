<div class="container">
	<?php 
	if(isset($added)) {
		if($added==1) {
	?>
		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button><?php print $lang['coins-added']; ?></div>
	<?php } else if($added==2) { ?>
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button><?php print $lang['account-not-exist']; ?></div>
	<?php
		}
	} ?>
	<form action="" method="post">
		<div class="form-group row">
			<div class="col-sm-3">
				<select class="form-control" name="account">
					<option value="1"><?php print $lang['account']; ?></option>
					<option value="2"><?php print $lang['player']; ?></option>
				</select>
			</div>
			<div class="col-sm-9">
				<input class="form-control" name="name" placeholder="<?php print $lang['name']; ?>" type="text">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<select class="form-control" name="type">
					<option value="1"><?php print $lang['md']; ?></option>
					<option value="2"><?php print $lang['jd']; ?></option>
				</select>
			</div>
			<div class="col-sm-6">
				<input class="form-control" name="coins" value="0" type="number" required>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-primary"><?php print $lang['add-coins']; ?></button>
		</div>
	</form>

</div>
<div class="container">
	<?php 
	if(isset($added)) {
		if($added==1) {
	?>
		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button><?php print $lang['success']; ?></div>
	<?php } else if($added==2) { ?>
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button><?php print $lang['account-not-exist']; ?></div>
	<?php
		}
	} ?>
	
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#player" role="tab"><?php print $lang['players']; ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#players" role="tab"><?php print $lang['players-online']; ?></a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="player" role="tabpanel">
			</br>
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
				<div class="form-group">
					<label class="control-label" for="vnum">vNum</label>
					<input class="form-control" name="vnum" id="vnum" type="number">
				</div>

				<div class="form-group">
					<label class="control-label" for="count">
						<?php print $lang[ 'items-number']; ?>
					</label>
					<input class="form-control" name="count" id="count" type="number" value="1">
				</div>
				<div class="form-group">
					<a class="btn btn-primary" role="button" data-toggle="collapse" href="#sockets" aria-expanded="false" aria-controls="sockets">
						Sockets
					</a>
					<div class="collapse" id="sockets">
						<div class="form-group">
							<label class="control-label" for="socket0">Socket0</label>
							<input class="form-control" name="socket0" id="socket0" type="number" value="">
						</div>
						<div class="form-group">
							<label class="control-label" for="socket1">Socket1</label>
							<input class="form-control" name="socket1" id="socket1" type="number" value="">
						</div>
						<div class="form-group">
							<label class="control-label" for="socket2">Socket2</label>
							<input class="form-control" name="socket2" id="socket2" type="number" value="">
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<input class="btn btn-success" name="add" value="<?php print $lang['send']; ?>" type="submit">
				</div>
			</form>
		</div>
		<div class="tab-pane" id="players" role="tabpanel">
			</br>
			<form action="" method="post">
				<div class="form-group">
					<label class="control-label" for="vnum">vNum</label>
					<input class="form-control" name="vnum" id="vnum" type="number">
				</div>

				<div class="form-group">
					<label class="control-label" for="count">
						<?php print $lang[ 'items-number']; ?>
					</label>
					<input class="form-control" name="count" id="count" type="number" value="1">
				</div>
				<div class="form-group">
					<a class="btn btn-primary" role="button" data-toggle="collapse" href="#sockets2" aria-expanded="false" aria-controls="sockets2">
						Sockets
					</a>
					<div class="collapse" id="sockets2">
						<div class="form-group">
							<label class="control-label" for="socket0">Socket0</label>
							<input class="form-control" name="socket0" id="socket0" type="number" value="">
						</div>
						<div class="form-group">
							<label class="control-label" for="socket1">Socket1</label>
							<input class="form-control" name="socket1" id="socket1" type="number" value="">
						</div>
						<div class="form-group">
							<label class="control-label" for="socket2">Socket2</label>
							<input class="form-control" name="socket2" id="socket2" type="number" value="">
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<input class="btn btn-success" name="add2" value="<?php print $lang['send']; ?>" type="submit">
				</div>
			</form>
		</div>
	</div>
</div>
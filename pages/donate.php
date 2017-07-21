<div class="container">
	<div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/user.png)">
		<div class="bd-c">
			<h2 class="pre-social"><?php print $lang['donate']; ?></h2>
		</div>
	</div>
	<?php
	if(isset($_POST['id']) && isset($_POST['type']) && isset($_POST['code']) && strlen($_POST['code']) >= 3 && strlen($_POST['code']) <= 50)
	{
		if(isset($jsondataDonate[$_POST['id']]['list'][$_POST['type']]))
		{
			$price = $jsondataDonate[$_POST['id']]['list'][$_POST['type']];
			$type = $jsondataDonate[$_POST['id']]['name'].' ['.$price['price'].' - '.$price['md'].' MD]';
			
							insert_donate($_SESSION['id'], $_POST['code'], $type);
		
							print '<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>';
							print $lang['send-donate'];
							print '</div>';	
		}
	}
	if(count($jsondataDonate)) { ?>
	
	<?php $i=-1; foreach($jsondataDonate as $key => $donate) { $i++; ?>
		<div class="card">
			<div class="card-header" role="tab" id="heading<?php print $i; ?>">
				<h5 class="mb-0">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php print $i; ?>" aria-expanded="true" aria-controls="collapse<?php print $i; ?>">
				<?php print $donate['name']; ?>
			</a>
		  </h5>
			</div>

			<div id="collapse<?php print $i; ?>" class="collapse show" role="tabpanel" aria-labelledby="heading<?php print $i; ?>">
				<div class="card-block">
				<?php 
					if(strtolower($donate['name'])=="paypal")
					{
				?>
					<form action="" method="post">
						<input type="hidden" name="id" value="<?php print $i; ?>">
						<input type="hidden" name="method" value="<?php print $donate['name']; ?>">
						<div class="form-group row">
							<div class="col-sm-6">
								<select class="form-control" name="type">
								<?php $j=-1; foreach($jsondataDonate[$i]['list'] as $key => $price) { $j++; ?>
									<option value="<?php print $j; ?>"><?php print $lang['price'].' '.$price['price'].' &euro; - '.$price['md'].' MD'; ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="col-sm-6">
								<button type="submit" name="submit" class="btn btn-primary"><?php print $lang['send']; ?></button>
							</div>
						</div>
					</form>
				<?php } else { ?>
					<form action="" method="post">
						<input type="hidden" name="id" value="<?php print $i; ?>">
						<input type="hidden" name="method" value="<?php print $donate['name']; ?>">
						<div class="form-group row">
							<div class="col-sm-6">
								<select class="form-control" name="type">
								<?php $j=-1; foreach($jsondataDonate[$i]['list'] as $key => $price) { $j++; ?>
									<option value="<?php print $j; ?>"><?php print $lang['price'].' '.$price['price'].' &euro; - '.$price['md'].' MD'; ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="col-sm-6">
								<input type="text" class="form-control" max="50" name="code" placeholder="<?php print $lang['code']; ?>">
							</div>
						</div>
						<div class="form-group row">
							<button type="submit" name="submit" class="btn btn-primary"><?php print $lang['send']; ?></button>
						</div>
					</form>
				<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	
	<?php } else { ?>
	<div class="alert alert-info" role="alert">
		<strong>Info!</strong> Donate methods not found.
	</div>
	<?php } ?>
</div>
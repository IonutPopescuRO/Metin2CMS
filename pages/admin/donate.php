<div class="container">
	<div class="alert alert-info alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<?php print $lang['paypal-info']; ?>
	</div>
	<?php if(!$paypal_email) { ?>
		<a href="<?php print $site_url.'admin/links'; ?>" target="_blank">
			<div class="alert alert-danger alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php print $lang['no-paypal']; ?>
			</div>
		</a>
	<?php } ?>

    <form action="" method="post">
		<div class="form-group row">
			<div class="col-sm-6">
				<input type="text" class="form-control" name="donation_method" placeholder="<?php print $lang['name']; ?>">
			</div>
			<div class="col-sm-6">
				<button type="submit" name="submit" class="btn btn-primary"><?php print $lang['add']; ?></button>
			</div>
		</div>
    </form>
	
	<?php if(count($jsondataDonate)) { ?>
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th style="width: 15%">#</th>
				<th style="width: 70%"><?php print $lang['name']; ?></th>
				<th><?php print $lang['delete']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; foreach($jsondataDonate as $key => $donate) { ?>
			<tr>
				<th scope="row"><?php print $i++; ?></th>
				<td><?php print $donate['name']; ?></td>
				<td><a href="<?php print $site_url.'admin/donate/'.$key; ?>" class="btn btn-primary btn-sm"><?php print $lang['delete']; ?></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<div id="accordion" role="tablist" aria-multiselectable="true">
	
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

					<table class="table table-hover">
						<tbody>
						<?php $j=-1; foreach($jsondataDonate[$i]['list'] as $key => $price) { $j++; ?>
							<tr>
								<th scope="row"><?php print $lang['price'].' : '.$price['price'].' '.$jsondataCurrency[$price['currency']]['name']; ?></th>
								<td><?php print $price['md'].' MD'; ?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="id" value="<?php print $i; ?>">
										<input type="hidden" name="price_id" value="<?php print $j; ?>">
										<button type="submit" name="submit_delete_price" class="btn btn-primary btn-sm"><?php print $lang['delete']; ?></button>
									</form>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				
					<form action="" method="post">
						<input type="hidden" name="id" value="<?php print $i; ?>">
						<div class="form-group row">
							<div class="col-sm-4">
								<input type="number" class="form-control" name="price" placeholder="<?php print $lang['price']; ?>">
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="currency">
									<?php foreach($jsondataCurrency as $key => $currency)
										if((strtolower($donate['name'])=="paypal" && $currency['paypal']) || strtolower($donate['name'])!="paypal") { 
									?>
									<option value="<?php print $key; ?>"><?php print $currency['name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-4">
								<input type="number" class="form-control" name="md" placeholder="MD">
							</div>
						</div>
						<div class="form-group row">
							<button type="submit" name="submit_price" class="btn btn-primary"><?php print $lang['add']; ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php } ?>
		
	</div>
	
	
	<?php } ?>
</div>
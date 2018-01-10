<div class="container">
	<?php 
		if(isset($_POST['add']))
		{
	?>
	<div class="alert alert-info alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<span><?php print $lang['code-created']; ?></span>
		<hr>
		<form>
			<div class="input-group">
				<input type="text" class="form-control" value="<?php print addRedeemCode($_POST['type'], $_POST['value']); ?>" id="share" readonly="readonly">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" id="copyButton" data-placement="button">
						<i class="fa fa-clipboard" aria-hidden="true"></i>
					</button>
				</span>
			</div>
		</form>
	</div>
	<?php } ?>
	<form action="" method="post">
		<div class="row">
			<div class="form-group col-md-6">
				<select class="form-control" name="type" id="inputType">
					<option value="1"><?php print $lang['md']; ?> (MD)</option>
					<option value="2"><?php print $lang['jd']; ?> (JD)</option>
					<option value="3"><?php print $lang['items-number']; ?> (vNum)</option>
				</select>
			</div>
			<div class="form-group col-md-6">
				<input type="number" class="form-control" min="0" id="inputValue" name="value" value="0" required>
			</div>
		</div>
		<div class="form-group row">
			<button type="submit" name="add" class="btn btn-primary"><?php print $lang['add']; ?></button>
		</div>
	</form>
	<hr>
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th>#</th>
				<th><?php print $lang['code']; ?></th>
				<th><?php print $lang['type']; ?></th>
				<th><?php print $lang['value']; ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$records_per_page=10;

				$query = "SELECT * FROM redeem ORDER BY id DESC";
				$newquery = $paginate->paging($query,$records_per_page);
				$paginate->dataview($newquery,$lang['md'].' (MD)',$lang['jd'].' (JD)',$lang['items-number'].' (vNum)',$lang['delete']);

			?>
		</tbody>
	</table>
	<?php
		$paginate->paginglink($query,$records_per_page,$lang['first-page'],$lang['last-page'],$site_url);
	?>
</div>
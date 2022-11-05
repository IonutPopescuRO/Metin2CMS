<div class="container">
	
	<?php if(count($jsondataDonate)) { ?>
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th><?php print $lang['name']; ?></th>
				<th><?php print $lang['code']; ?></th>
				<th><?php print $lang['price']; ?></th>
				<th><?php print $lang['validation']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; foreach($jsondataDonate as $key => $donate) { 
						$md = intval(explode(" MD]", explode(" - ", $donate['type'])[1])[0]); 
		?>
			<tr>
				<td><?php print getAccountName($donate['account_id']); ?></td>
				<td><?php print htmlentities($donate['code']); ?></td>
				<td><?php print $donate['type']; ?></td>
				<td>
					<form action="" method="post">
						<input type="hidden" value="<?php print $md; ?>" name="md">
						<input type="hidden" value="<?php print $donate['account_id']; ?>" name="account">
						<input type="hidden" value="<?php print $donate['id']; ?>" name="id">
						
						<button type="submit" name="yes" class="btn btn-success btn-sm"><?php print $lang['yes']; ?></button>
						<button type="submit" name="no" class="btn btn-danger btn-sm"><?php print $lang['no']; ?></button>	
					</form>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<?php } else print 'Nothing found'; ?>
</div>
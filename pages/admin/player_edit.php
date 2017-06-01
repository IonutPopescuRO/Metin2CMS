<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-12 col-sm-offset-2 col-md-offset-3">
            <form role="form" method="post" action="">
				<table class="table table-hover" style="background-color: white;">
					<tbody>
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
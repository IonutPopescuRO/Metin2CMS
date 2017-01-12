<div class="container">
    <form action="" method="post">
		<div class="form-group row">
			<label for="active-registrations" class="col-sm-2 col-form-label"><?php print $lang['active-registrations']; ?></label>
			<div class="col-sm-10">
			<select class="form-control" name="active-registrations">
				<option value="1"<?php if($jsondataFunctions['active-registrations']==1) print 'selected="selected"'; ?>><?php print $lang['yes']; ?></option>
				<option value="2"<?php if($jsondataFunctions['active-registrations']==2) print 'selected="selected"'; ?>><?php print $lang['no']; ?></option>
			</select>
			</div>
		</div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" name="submit" class="btn btn-primary"><?php print $lang['save']; ?></button>
            </div>
        </div>
	</form>
</div>
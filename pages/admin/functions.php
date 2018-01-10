<div class="container">
    <form action="" method="post">
		
	<?php
	foreach($jsondataFunctions as $key => $function)
		if(($key=='offline-shops' && check_table_in_player('offline_shop_npc')) || ($key!='offline-shops' && $key!='active-referrals'))
		{
	?>
		<div class="form-group row">
			<label for="active-registrations" class="col-sm-8 col-form-label"><?php print $lang[$key]; ?></label>
			<div class="col-sm-4">
			<select class="form-control" name="<?php print $key; ?>">
				<option value="1"<?php if($function) print ' selected="selected"'; ?>><?php print $lang['yes']; ?></option>
				<option value="0"<?php if(!$function) print ' selected="selected"'; ?>><?php print $lang['no']; ?></option>
			</select>
			</div>
		</div>
	<?php } ?>
		
        <div class="form-group row">
            <div class="offset-sm-8 col-sm-4">
                <button type="submit" name="submit" class="btn btn-primary"><?php print $lang['save']; ?></button>
            </div>
        </div>
	</form>
</div>
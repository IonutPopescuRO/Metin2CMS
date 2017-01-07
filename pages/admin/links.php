<?php
	$links_header=getJsonSettings("", "links");
	$links_footer=getJsonSettings("", "social-links");
?>

<div class="alert alert-info" role="alert">
	<strong>Info!</strong> <?php print $lang['edit-links-blank-info']; ?>
</div>

<div class="container">
    <form action="" method="post">
		<?php foreach($links_header as $name => $link) { ?>
			<div class="form-group row">
				<label for="<?php print $name; ?>" class="col-sm-2 col-form-label"><?php print ucfirst($name); ?></label>
				<div class="col-sm-10">
					<input type="url" class="form-control" name="<?php print $name; ?>" placeholder="http://" value="<?php print $link; ?>">
				</div>
			</div>
		<?php } ?>
		
		<?php foreach($links_footer as $name => $link) { ?>
			<div class="form-group row">
				<label for="<?php print $name; ?>" class="col-sm-2 col-form-label"><?php print ucfirst($name); ?></label>
				<div class="col-sm-10">
					<input type="url" class="form-control" name="<?php print $name; ?>" placeholder="http://" value="<?php print $link; ?>">
				</div>
			</div>
		<?php } ?>

        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" name="submit" class="btn btn-primary"><?php print $lang['save']; ?></button>
            </div>
        </div>
    </form>
</div>
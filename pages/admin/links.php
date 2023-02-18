<?php
	$site_general=getJsonSettings("", "general");
	$links_header=getJsonSettings("", "links");
	$links_footer=getJsonSettings("", "social-links");
?>

<div class="alert alert-info" role="alert">
	<strong>Info!</strong> <?php print $lang['edit-links-blank-info']; ?>
</div>

<div class="container">
    <form action="" method="post">
		<?php foreach($site_general as $name => $link) if($name!='currency') { ?>
			<div class="form-group row">
				<label for="<?php print $name; ?>" class="col-sm-2 col-form-label"><?php if($name=='news') print $lang['news-on-page']; else if($name=='title') print $lang['title']; else print ucfirst($name); ?></label>
				<div class="col-sm-10">
					<input type="<?php if($name=='news') print 'number'; else if($name=='title') print 'text'; else if($name=='paypal') print 'email'; else print 'url'; ?>" class="form-control" name="<?php print $name; ?>" placeholder="<?php if($name=='news') print '5'; else if($name=='title') print 'Metin2CMS'; else if($name=='paypal') print 'contact@ionut.work'; else print 'https://'; ?>" value="<?php print $link; ?>">
				</div>
			</div>
		<?php } ?>
		<?php foreach($links_header as $name => $link) { ?>
			<div class="form-group row">
				<label for="<?php print $name; ?>" class="col-sm-2 col-form-label"><?php if($name=='support') print $lang['support']; else print ucfirst($name); ?></label>
				<div class="col-sm-10">
					<input type="url" class="form-control" name="<?php print $name; ?>" placeholder="https://" value="<?php print $link; ?>">
				</div>
			</div>
		<?php } ?>
		
		<?php foreach($links_footer as $name => $link) { ?>
			<div class="form-group row">
				<label for="<?php print $name; ?>" class="col-sm-2 col-form-label"><?php print ucfirst($name); ?></label>
				<div class="col-sm-10">
					<input type="url" class="form-control" name="<?php print $name; ?>" placeholder="https://" value="<?php print $link; ?>">
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
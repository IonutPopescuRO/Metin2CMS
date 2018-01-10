<div class="container">
	<div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/recovery.png)">
		<div class="bd-c">
			<h2 class="pre-social"><?php print $lang['redeem-codes']; ?></h2>
		</div>
	</div>
	<div class="padding-container">
		<?php if($received>=0) { ?>
		<div class="alert alert-<?php if(!$received || $received==4) print 'danger'; else print 'success'; ?> alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<?php
				if(!$received)
					print $lang['incorrect-redeem'];
				else if($received==1 || $received==2)
				{
					print $lang['collected_md'].' '.$coins.' '; 
					if($received==1)
						print $lang['md'].' (MD)';
					else print $lang['jd'].' (JD)';
					print '.';
				} else if($received==3)
					print $lang['successfully_added'];
				else
					print $lang['no_space'];
			?>
		</div>
		<?php } ?>
			
		<form action="" method="POST">
			<div class="input-group">
				<input type="text" class="form-control form-control-lg" value="" name="code" required>
				<span class="input-group-btn">
					<button class="btn btn-primary btn-lg" type="submit" data-placement="button">
						<i class="fa fa-check" aria-hidden="true"></i> <?php print $lang['redeem-my-code']; ?>
					</button>
				</span>
			</div>
		</form>
	</div>
</div>
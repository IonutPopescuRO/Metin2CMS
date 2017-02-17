<div class="container">
	<div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/ranking.png)">
		<div class="bd-c">
			<h2 class="pre-social"><?php print $lang['vote']; ?></h2>
		</div>
	</div>
	<?php if(isset($voted_now) && isset($already_voted) && !$voted_now) { ?>
	<div class="alert alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button><?php print $lang['vote-again'].' <strong>'.$already_voted.'</strong>'; ?>
	</div>

	<?php } if(count($vote4coins)) { ?>
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th style="width: 15%">#</th>
				<th style="width: 30%">Site</th>
				<th style="width: 20%"><?php print $lang['value']; ?></th>
				<th style="width: 20%"><?php print $lang['time']; ?></th>
				<th><?php print $lang['vote']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; foreach($vote4coins as $key => $vote) { ?>
			<tr>
				<th scope="row"><?php print $i++; ?></th>
				<td><?php print $vote['name']; ?></td>
				<td><?php print $vote['value']; if($vote['type']==1) print 'MD'; else print 'JD'; ?></td>
				<td><?php print $vote['time'].' '.$lang['hours']; ?></td>
				<td><a href="<?php print $site_url.'user/vote4coins/'.$key; ?>" class="btn btn-primary btn-sm"><?php print $lang['vote']; ?></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">
		<strong>Info!</strong> <?php print $lang['no-download-links']; ?>
	</div>
	<?php } ?>
</div>
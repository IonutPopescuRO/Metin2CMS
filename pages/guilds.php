<div class="container">
	<div class="page-hd" style="background-image: url(<?php print $site_url; ?>images/ranking.png)">
		<div class="bd-c">
			<h2 class="pre-social"><?php print $lang['ranking']; ?></h2>
			<h6><?php print $lang['guilds']; ?></h6>
		</div>
	</div>
	
	<div class="jumbotron jumbotron-fluid" style="padding: 1rem 2rem;">
		<form action="" method="POST">
			<div class="row">
				<div class="col-lg-9">
					<input type="text" name="search" class="form-control" placeholder="<?php print $lang['guild']; ?>" value="<?php if(isset($search)) print $search; ?>">
				</div>
				<div class="col-lg-3">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search fa-1" aria-hidden="true"></i> <?php print $lang['search']; ?></button>
				</div>
			</div>
		</form>
	</div>
	
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link" href="<?php print $site_url; ?>ranking/players"><img src="<?php print $site_url; ?>images/players.png" alt="<?php print $lang['players']; ?>" title="<?php print $lang['players']; ?>"> <?php print $lang['players']; ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="#"><img src="<?php print $site_url; ?>images/guilds.png" alt="<?php print $lang['guilds']; ?>" title="<?php print $lang['guilds']; ?>"> <?php print $lang['guilds']; ?></a>
		</li>
	</ul>
	
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th>#</th>
				<th><?php print $lang['guild']; ?></th>
				<th><?php print $lang['leader']; ?></th>
				<th><?php print $lang['empire']; ?></th>
				<th class="level-table"><?php print $lang['level']; ?></th>
				<th class="exp-table"><?php print $lang['points']; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php		
				$records_per_page=10;

				if(isset($search))
				{
					$query = "SELECT id, name, master, level, ladder_point FROM guild WHERE name LIKE :search ORDER BY level DESC, ladder_point DESC, exp DESC, name ASC";
					$newquery = $paginate->paging($query,$records_per_page);
					$paginate->dataview($newquery, $search);
				} else {
					$query = "SELECT id, name, master, level, ladder_point FROM guild ORDER BY level DESC, ladder_point DESC, exp DESC, name ASC";
					$newquery = $paginate->paging($query,$records_per_page);
					$paginate->dataview($newquery);
				}
				
			?>
		</tbody>
	</table>
	<?php
		if(isset($search))
			$paginate->paginglink($query,$records_per_page,$lang['first-page'],$lang['last-page'],$site_url,$search);
		else
			$paginate->paginglink($query,$records_per_page,$lang['first-page'],$lang['last-page'],$site_url);
	?>
</div>
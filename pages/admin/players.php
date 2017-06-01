<div class="container">
	<div class="jumbotron jumbotron-fluid" style="padding: 1rem 2rem;">
		<form action="" method="POST">
			<div class="row">
				<div class="col-lg-9">
					<input type="text" name="search" class="form-control" placeholder="<?php print $lang['name']; ?> / IP" value="<?php if(isset($search)) print $search; ?>">
				</div>
				<div class="col-lg-3">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search fa-1" aria-hidden="true"></i> <?php print $lang['search']; ?></button>
				</div>
			</div>
		</form>
	</div>
	
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th>#</th>
				<th><?php print $lang['name']; ?></th>
				<th><?php print $lang['account']; ?></th>
				<th class="level-table">IP</th>
				<th><?php print $lang['status']; ?></th>
				<th class="exp-table"><?php print $lang['actions']; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$records_per_page=10;
				
				if(isset($search))
				{
					if(!filter_var($search, FILTER_VALIDATE_IP) === false)
						$query = "SELECT id, name, account_id, level, ip FROM player WHERE ip = :ip ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
					else
						$query = "SELECT id, name, account_id, level, ip FROM player WHERE name LIKE :search ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
					$newquery = $paginate->paging($query,$records_per_page);
					$paginate->dataview($newquery, $search, $lang['ban'], $lang['unban'], $lang['edit-player-info']);
				} else {
					$query = "SELECT id, name, account_id, level, ip FROM player ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
					$newquery = $paginate->paging($query,$records_per_page);
					$paginate->dataview($newquery, null, $lang['ban'], $lang['unban'], $lang['edit-player-info']);
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

<div class="modal fade" id="ban" tabindex="-1" role="dialog" aria-labelledby="Ban" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="banModal">Title</h5>
            </div>
            <div class="modal-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#permanent" role="tab"><?php print $lang['permanent-ban']; ?></a>
					</li>
					<?php if($availDt = check_account_column('availDt')) { ?>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#availDt" role="tab"><?php print $lang['temporary-ban']; ?></a>
					</li>
					<?php } ?>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active" id="permanent" role="tabpanel">
						</br>
						<form method="POST" action="">
							<input type="hidden" name="accountID" id="accountID" value=""/>
							<div class="form-group">
								<label for="reason"><?php print $lang['reason'].' - '.$lang['permanent-ban']; ?></label>
								<textarea class="form-control" id="permanent" name="permanent" rows="3"></textarea>
							</div>
							<button type="submit" class="btn btn-primary"><?php print $lang['ban']; ?></button>
						</form>
					</div>
					<?php if($availDt) { ?>
					<div class="tab-pane" id="availDt" role="tabpanel">
						</br>
						<form method="POST" action="">
							<input type="hidden" name="accountID" id="accountID" value=""/>
							<div class="form-group">
								<label for="reason"><?php print $lang['time']; ?></label>
								<hr>
								<div class="row">
									<div class="col-lg-3">
										<label for="months"><?php print ucfirst($lang['months']); ?></label>
										<input class="form-control" type="number" value="0" id="months" name="months">
									</div>
									<div class="col-lg-3">
										<label for="days"><?php print ucfirst($lang['days']); ?></label>
										<input class="form-control" type="number" value="0" id="days" name="days">
									</div>
									<div class="col-lg-3">
										<label for="hours"><?php print ucfirst($lang['hours']); ?></label>
										<input class="form-control" type="number" value="0" id="hours" name="hours">
									</div>
									<div class="col-lg-3">
										<label for="reason"><?php print ucfirst($lang['minutes']); ?></label>
										<input class="form-control" type="number" value="0" id="minutes" name="minutes">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="reason"><?php print $lang['reason'].' - '.$lang['temporary-ban']; ?></label>
								<textarea class="form-control" id="temporary" name="temporary" rows="3"></textarea>
							</div>
							<button type="submit" class="btn btn-primary"><?php print $lang['ban']; ?></button>
						</form>
					</div>
					<?php } ?>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php print $lang['close']; ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="unban" tabindex="-1" role="dialog" aria-labelledby="unBan" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unBanModal">Title</h5>
            </div>
            <div class="modal-body">
				<form method="POST" action="">
					<input type="hidden" name="accountID" id="accountID" value=""/>
					<input type="hidden" name="unban" id="unban" value=""/>
					<div class="form-group">
						<label for="reason"><?php print $lang['unban-check']; ?></label>
					</div>
					<button type="submit" class="btn btn-primary"><?php print $lang['unban']; ?></button>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php print $lang['close']; ?></button>
            </div>
        </div>
    </div>
</div>
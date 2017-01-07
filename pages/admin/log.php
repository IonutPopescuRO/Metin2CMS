<select class="form-control form-control-lg" onchange="if (this.value) window.location.href=this.value">
	<option value=""<?php if(!$current_log) print ' selected'; ?>><?php print $lang['select-log']; ?></option>
	<?php
		foreach($tables as $table)
		{
			print '<option value="'.$site_url . 'admin/log/' . $table.'"';
			if($current_log && $table==$current_log)
				print ' selected';
			print '>'.$table.'</option>';
		}
	?>
</select>

<?php
	getColumnsLog($current_log);
	
	if($current_log) {
?>
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<?php 
					foreach($columns as $column)
						print '<th>'. $column .'</th>';
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
				$banned_ids = getBannedAccounts();
				
				$order_by = '';
				if(in_array('id', $columns))
					$order_by = ' ORDER BY id DESC';
				else if(in_array('date', $columns))
					$order_by = ' ORDER BY date DESC';
				else if(in_array('time', $columns))
					$order_by = ' ORDER BY time DESC';
				
				$query = "SELECT * FROM ". $current_log . $order_by;
				$records_per_page=20;
				$newquery = $paginate->paging($query,$records_per_page);
				$paginate->dataview($newquery, $columns);	
			?>
		</tbody>
	</table>
	<?php $paginate->paginglink($query,$records_per_page,$lang['first-page'],$lang['last-page'],$site_url,$current_log);	?>
<?php } ?>

<div class="container">
    <form action="" method="post">
		<div class="form-group row">
			<div class="col-sm-4">
				<input type="text" class="form-control" name="download_server" placeholder="Server">
			</div>
			<div class="col-sm-8">
				<input type="url" class="form-control" name="download_link" placeholder="Link" value="https://">
			</div>
		</div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" name="submit" class="btn btn-primary"><?php print $lang['add']; ?></button>
            </div>
        </div>
    </form>
	
	<?php if(count($jsondataDownload)) { ?>
	<table class="table table-hover">
		<thead class="thead-inverse">
			<tr>
				<th style="width: 15%">#</th>
				<th style="width: 70%">Server</th>
				<th><?php print $lang['delete']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; foreach($jsondataDownload as $key => $download) { ?>
			<tr>
				<th scope="row"><?php print $i++; ?></th>
				<td><?php print $download['name']; ?></td>
				<td><a href="<?php print $site_url.'admin/download/'.$key; ?>" class="btn btn-primary btn-sm"><?php print $lang['delete']; ?></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } ?>
</div>
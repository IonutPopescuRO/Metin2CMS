<div class="container">
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#settings" role="tab"><?php print $lang['general-settings']; ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#install" role="tab"><?php print $lang['install'].' / '.$lang['uninstall']; ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="https://ionut.work/contact" target="_blank"><?php print $lang['send-translation']; ?></a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="settings" role="tabpanel">
			</br>
			<form action="" method="post">
				<div class="form-group row">
					<label for="active-registrations" class="col-sm-8 col-form-label"><?php print $lang['default-language']; ?></label>
					<div class="col-sm-4">
						<select class="form-control" name="default-language">
							<?php
								foreach($json_languages['languages'] as $key => $value)
								{
									print '<option value="'.$key.'"';
									if($key==$json_languages['settings']['default'])
										print ' selected="selected"';
									print '>'.$value.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="offset-sm-8 col-sm-4">
						<button type="submit" name="submit" class="btn btn-primary"><?php print $lang['save']; ?></button>
					</div>
				</div>
			</form>
		</div>
		<div class="tab-pane" id="install" role="tabpanel">
			
			</br>
			<table class="table table-hover">
				<thead class="thead-inverse">
					<tr>
						<th style="width: 15%">#</th>
						<th style="width: 70%"><?php print $lang['name']; ?></th>
						<th><?php print $lang['delete']; ?></th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$languages_list = getLanguagesList();
					foreach($json_languages['languages'] as $key => $value) { ?>
					<tr>
						<th scope="row"><?php print $key; ?></th>
						<td><?php print $value; ?></td>
						<?php if($key==$json_languages['settings']['default']) { ?>
							<td><button class="btn btn-primary btn-sm disabled"><?php print $lang['delete']; ?></button></td>
						<?php } else { ?>
							<td>
								<form action="" method="post">
									<input type="hidden" name="delete" value="<?php print $key; ?>">
									<button type="submit" name="submit" class="btn btn-primary btn-sm"><?php print $lang['delete']; ?></button>
								</form>
							</td>
						<?php } ?>
					</tr>
				<?php }
					foreach($languages_list as $value) 
						if(!isset($json_languages['languages'][$value['code']])) {
				?>
					<tr>
						<th scope="row"><?php print $value['code']; ?></th>
						<td><?php print $value['name']; ?></td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="install" value="<?php print $value['code']; ?>">
									<input type="hidden" name="name" value="<?php print $value['name']; ?>">
									<button type="submit" name="submit" class="btn btn-primary btn-sm"><?php print $lang['install']; ?></button>
								</form>
							</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			
			
		</div>
	</div>
</div>
<?php
		if(isset($_POST['title']) && isset($_POST['content']))
			if(!empty($_POST['title']) && !empty($_POST['content']))
				$paginate->add($_POST['title'], $_POST['content']);
			
		print '<form method="post" action="">';
		print '<p><a class="btn btn-primary" data-toggle="collapse" href="#add" aria-expanded="false" aria-controls="add"><i class="fa fa-plus fa-2" aria-hidden="true"></i> '.$lang['new-article'].'</a></p>';
		print '<div class="collapse" id="add"><div class="card card-block">';
		print '<p>'.$lang['title'].':</p>';
		print '<input name="title" type="text" class="form-control -webkit-transition" placeholder="'.$lang['title'].'" required>';
		print '<p>'.$lang['content'].':</p>';
		print '<textarea class="ckeditor" name="content"></textarea>';
		print '</br><input type="submit" class="btn-big btn-success btn-sm btn" value="'.$lang['new-article'].'">';
		print '</div></div>';
		print '</form>';
		print '<hr>';
?>
<?php
		if(isset($_POST['title']) && isset($_POST['content']))
			if(!empty($_POST['title']) && !empty($_POST['content']))
			{
				$paginate->edit($read_id, $_POST['title'], $_POST['content']);
				print '<script>window.location = window.location.href;</script>';
			}
			
		print '<form method="post" action="">';
		print '<p><a class="btn btn-primary" data-toggle="collapse" href="#edit" aria-expanded="false" aria-controls="edit"><i class="fa fa-pencil fa-2" aria-hidden="true"></i> '.$lang['edit-article'].'</a></p>';
		print '<div class="collapse" id="edit"><div class="card card-block">';
		print '<p>'.$lang['title'].':</p>';
		print '<input name="title" type="text" class="form-control -webkit-transition" placeholder="'.$lang['title'].'" value="'.$article['title'].'">';
		print '<p>'.$lang['content'].':</p>';
		print '<textarea class="ckeditor" name="content">'.$article['content'].'</textarea>';
		print '</br><input type="submit" class="btn-big btn-success btn-sm btn" value="'.$lang['edit-article'].'">';
		print '</div></div>';
		print '</form>';
		print '<hr>';
?>
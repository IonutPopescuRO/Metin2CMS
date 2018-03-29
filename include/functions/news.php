<?php
	require_once("include/classes/news.php");
	$paginate = new paginate();
	if($page=='read')
	{
		$read_id = isset($_GET['no']) ? $_GET['no'] : null;
		if(is_numeric($read_id))
		{
			$exist = $paginate->check_id($read_id);
			if($exist==0)
			{
				header("Location: ".$site_url);
				die();
			} else if($exist==1)
			{
				$article = $paginate->read($read_id);
				$title = $article['title'];
			}
		}
	}
?>
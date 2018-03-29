<?php
	$tables = getLogTables();

	$current_log = isset($_GET['log']) ? $_GET['log'] : null;

	if($current_log && !in_array($current_log, $tables))
	{
		header("Location: ".$site_url."admin/log");
		die();
	} else if($current_log)
	{
		require_once("include/classes/log.php");
		$paginate = new paginate();
		$columns = getColumnsLog($current_log);
	}
?>
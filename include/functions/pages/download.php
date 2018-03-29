<?php
	$jsondataDownload = file_get_contents('include/db/download.json');
	$jsondataDownload = json_decode($jsondataDownload, true);
?>
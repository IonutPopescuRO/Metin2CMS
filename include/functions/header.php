<?php
	session_start();
	
	header('Cache-control: private');
	
	$current_page = isset($_GET['p']) ? $_GET['p'] : null;
		
	include 'config.php';
	
	include 'include/functions/version.php';
	
	include 'include/functions/language.php';
	
	require_once("include/classes/user.php");
	
	$jsondata = file_get_contents('include/db/settings.json');
	$jsondata = json_decode($jsondata,true);
	$jsondataRanking = file_get_contents('include/db/ranking.json');
	$jsondataRanking = json_decode($jsondataRanking,true);
	include 'include/functions/json.php';
	$site_title = getJsonSettings("title");
	$forum=getJsonSettings("forum", "links");
	$support=getJsonSettings("support", "links");
	$item_shop=getJsonSettings("item-shop", "links");
	$top10backup_day=getJsonSettings("day", "top10backup");
	$top10backup_month=getJsonSettings("month", "top10backup");
	$top10backup_year=getJsonSettings("year", "top10backup");
	
	include 'include/functions/social-links.php';
	$social_links=getJsonSettings("", "social-links");
	$social_links=getSocialLinks();

	$offline = 0;
	
	$database = new USER($host, $user, $password);
	
	include 'include/functions/pages.php';

	if($page=='news' || $page=='read')
	{
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
	}
		
	if(!$offline)
	{
		include 'include/functions/basic.php';
		
		if($database->is_loggedin())
			if(($_SESSION['fingerprint']!=md5($_SERVER['HTTP_USER_AGENT'].'x'.$_SERVER['REMOTE_ADDR'])) || ($_SESSION['password']!=securityPassword(getAccountPassword($_SESSION['id']))))
			{
				$database->doLogout();
				header("Location: ".$site_url);
				die();
			}
				
		$web_admin = web_admin_level();
		
		if($database->is_loggedin() && $web_admin>=$news_lvl)
		{
			$delete = isset($_GET['delete']) ? $_GET['delete'] : null;
			if(is_numeric($delete))
			{
				$paginate->delete_article($delete);
				header("Location: ".$site_url);
				die();
			}
		}
		if($current_page=="logout")
		{
			$database->doLogout();
			header("Location: ".$site_url);
			die();
		} else if($page=='players')
		{
			if(isset($_POST['search']) && strlen($_POST['search'])>=3)
			{
				header("Location: ".$site_url."ranking/players/1/".$_POST['search']);
				die();
			} else if(isset($_POST['search']) && $_POST['search']=='')
			{
				header("Location: ".$site_url."ranking/players/1");
				die();
			}
			
			if(isset($_GET['player_name']))
			{
				$new_search = strip_tags($_GET['player_name']);
				if(strlen($new_search)>=3)
					$search = $new_search;
			}
			
			require_once("include/classes/players.php");
			$paginate = new paginate();
		} else if($page=='guilds')
		{
			if(isset($_POST['search']) && strlen($_POST['search'])>=3)
			{
				header("Location: ".$site_url."ranking/guilds/1/".$_POST['search']);
				die();
			} else if(isset($_POST['search']) && $_POST['search']=='')
			{
				header("Location: ".$site_url."ranking/guilds/1");
				die();
			}
			
			if(isset($_GET['guild_name']))
			{
				$new_search = strip_tags($_GET['guild_name']);
				if(strlen($new_search)>=3)
					$search = $new_search;
			}
			
			require_once("include/classes/guilds.php");
			$paginate = new paginate();
		} else if($page=='login')
		{
			include 'include/functions/login.php';
		} else if($page=='lost')
		{
			include 'include/functions/lost.php';
		}
		redirect($page);

		if($page=='administration')
			include 'include/functions/administration.php';
		else if($page=='password')
			include 'include/functions/password.php';
		else if($page=='email')
			include 'include/functions/email.php';
				
		if($page=='admin')
		{
			$admin_page = isset($_GET['a']) ? $_GET['a'] : null;
			include 'include/functions/admin-pages.php';
			if($admin_page=='log')
			{
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
			}
			else if($admin_page=='links')
			{
				if(isset($_POST['submit']))
				{
					$edited = false;
					
					foreach($_POST as $key=>$link)
						if(isset($jsondata['links'][$key]))
						{
							if($jsondata['links'][$key]!=$link)
							{
								$jsondata['links'][$key]=$link;
								$edited = true;
							}
						}
						else if(isset($jsondata['social-links'][$key]))
						{
							if($jsondata['social-links'][$key]!=$link)
							{
								$jsondata['social-links'][$key]=$link;								
								$edited = true;
							}
						}
					if($edited)
					{
						$json_new = json_encode($jsondata);
						file_put_contents('include/db/settings.json', $json_new);
					}
					header("Refresh:0");
					die();
				}
			}
			else if($admin_page=='createitems')
			{
				$jsonBonuses = file_get_contents('include/db/bonuses.json');
				$jsonBonuses = json_decode($jsonBonuses,true);
				
				$form_bonuses = '';
				foreach($jsonBonuses as $bonus)
					$form_bonuses .= '<option value='.$bonus['id'].'>'.str_replace("[n]", 'XXX', $bonus[$language_code]).'</option>';
			}
		}
		
		include 'include/functions/top10backup.php';
	}
	else
	{
		$web_admin = 0;
		if($page!='news' && $page!='read')
		{
			header("Location: ".$site_url);
			die();
		}
		$offline_date=getJsonSettings("day", "top10backup").'.'.getJsonSettings("month", "top10backup").'.'.getJsonSettings("year", "top10backup");
		$offline_year=getJsonSettings("year", "top10backup");
		$offline_players=getJsonSettings("players", "top10backup");
		$offline_guilds=getJsonSettings("guilds", "top10backup");
	}

	if(isset($_GET['api']) && isset($_GET['key']) && $_GET['api']=='metin2cms')
	{
		$apidata = file_get_contents('include/db/api.json');
		$apidata = json_decode($apidata,true);
		
		if($_GET['key']==$apidata['key'])
			die('ok');
		else
			die();
	}
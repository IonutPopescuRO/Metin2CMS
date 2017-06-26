<?php
	session_start();
	
	header('Cache-control: private');
	
	$current_page = isset($_GET['p']) ? $_GET['p'] : null;
		
	include 'config.php';
	
	if (substr($site_url, -1)!='/')
		$site_url.='/';
	
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
		
		$jsondataFunctions = file_get_contents('include/db/functions.json');
		$jsondataFunctions = json_decode($jsondataFunctions, true);
		
		$statistics = false;
		foreach($jsondataFunctions as $key => $status)
			if($key != 'active-registrations' && $status)
			{
				$statistics = true;
				break;
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
		} else if($page=='download')
		{
			$jsondataDownload = file_get_contents('include/db/download.json');
			$jsondataDownload = json_decode($jsondataDownload, true);
		}
		redirect($page);

		if($page=='administration')
			include 'include/functions/administration.php';
		else if($page=='password')
			include 'include/functions/password.php';
		else if($page=='email')
			include 'include/functions/email.php';
		else if($page=='vote4coins')
			include 'include/functions/vote4coins.php';
		else if($page=='admin')
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
						if(isset($jsondata['general'][$key]))
						{
							if($jsondata['general'][$key]!=$link)
							{
								$jsondata['general'][$key]=$link;
								$edited = true;
							}
						}
						else if(isset($jsondata['links'][$key]))
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
					header("Location: ".$site_url.'admin/links');
					die();
				}
			} else if($admin_page=='players')
			{
				if(isset($_POST['search']) && strlen($_POST['search'])>=3)
				{
					header("Location: ".$site_url."admin/players/1/".$_POST['search']);
					die();
				} else if(isset($_POST['search']) && $_POST['search']=='')
				{
					header("Location: ".$site_url."admin/players/1");
					die();
				}
				
				if(isset($_GET['player_name']))
				{
					$new_search = strip_tags($_GET['player_name']);
					if(strlen($new_search)>=3)
						$search = $new_search;
				}
				
				require_once("include/classes/admin-players.php");
				$paginate = new paginate();
				
				if(isset($_POST['permanent']) && isset($_POST['accountID']))
				{
					banPermanent(intval($_POST['accountID']), $_POST['permanent']);
					
					$location = '';
					if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
						$location = $_GET["page_no"];
					else $location = 1;
					if($search)
						$location.= '/'.$search;
					
					header("Location: ".$site_url."admin/players/".$location);
					die();
				}
				else if(isset($_POST['unban']) && isset($_POST['accountID']))
				{
					unBan(intval($_POST['accountID']));
					
					$location = '';
					if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
						$location = $_GET["page_no"];
					else $location = 1;
					if($search)
						$location.= '/'.$search;
					
					header("Location: ".$site_url."admin/players/".$location);
					die();
				} else if(isset($_POST['temporary']) && isset($_POST['accountID']) && isset($_POST['months']) && isset($_POST['days']) && isset($_POST['hours']) && isset($_POST['minutes']) && check_account_column('availDt'))
				{
					$time_availDt = strtotime("now +".intval($_POST['months'])." month +".intval($_POST['days'])." day +".intval($_POST['hours'])." hours +".intval($_POST['minutes'])." minute");
					banTemporary(intval($_POST['accountID']), $_POST['temporary'], $time_availDt);
					
					$location = '';
					if(isset($_GET["page_no"]) && is_numeric($_GET["page_no"]) && $_GET["page_no"]>1)
						$location = $_GET["page_no"];
					else $location = 1;
					if($search)
						$location.= '/'.$search;
					
					header("Location: ".$site_url."admin/players/".$location);
					die();
				}
			}
			else if($admin_page=='player_edit')
			{
				$player_id = isset($_GET['id']) ? $_GET['id'] : null;
				if(!check_char($player_id))
				{
					header("Location: ".$site_url."admin/players");
					die();	
				} else {
					$columns = getCharColumns('player');
					foreach($columns as $key => $column)
					{
						$type = translateNativeType($column['native_type']);
						if(!($type=='int' || $type=='string') || $column['name']=='id')
							unset($columns[$key]);
					}
					
					$actual_data = getCharData($player_id);

					if(isset($_POST['submit']))
					{
						updateChar($player_id, $columns, $actual_data);
						
						header("Location: ".$site_url.'admin/player/edit/'.$player_id);
						die();	
					}
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
			else if($admin_page=='download')
			{
				$jsondataDownload = file_get_contents('include/db/download.json');
				$jsondataDownload = json_decode($jsondataDownload, true);
				
				if(!$jsondataDownload)
					$jsondataDownload = array();
				
				if(isset($_POST['submit']))
				{
					$new_link = array();
					$new_link['name'] = $_POST['download_server'];
					$new_link['link'] = $_POST['download_link'];
					
					array_push($jsondataDownload, $new_link);
					
					$json_new = json_encode($jsondataDownload);
					file_put_contents('include/db/download.json', $json_new);
					
					header("Location: ".$site_url.'admin/download');
					die();
				} else if(isset($_GET['del']))
				{
					unset($jsondataDownload[$_GET['del']]);
					
					$json_new = json_encode($jsondataDownload);
					file_put_contents('include/db/download.json', $json_new);
					
					header("Location: ".$site_url.'admin/download');
					die();
				}
			}
			else if($admin_page=='vote4coins')
			{
				$jsondataVote4Coins = file_get_contents('include/db/vote4coins.json');
				$jsondataVote4Coins = json_decode($jsondataVote4Coins, true);
				
				if(!$jsondataVote4Coins)
					$jsondataVote4Coins = array();
				
				if(isset($_POST['submit']))
				{
					$new_link = array();
					$new_link['name'] = $_POST['site_name'];
					$new_link['link'] = $_POST['site_link'];
					$new_link['type'] = $_POST['type'];
					$new_link['value'] = $_POST['coins'];
					$new_link['time'] = $_POST['time'];
					
					array_push($jsondataVote4Coins, $new_link);
					
					$json_new = json_encode($jsondataVote4Coins);
					file_put_contents('include/db/vote4coins.json', $json_new);
					
					header("Location: ".$site_url.'admin/vote4coins');
					die();
				} else if(isset($_GET['del']))
				{
					unset($jsondataVote4Coins[$_GET['del']]);
					
					$json_new = json_encode($jsondataVote4Coins);
					file_put_contents('include/db/vote4coins.json', $json_new);
					
					delete_vote4coins($_GET['del']);
					
					header("Location: ".$site_url.'admin/vote4coins');
					die();
				}
			}
			else if($admin_page=='functions')
			{
				$jsondataFunctions = file_get_contents('include/db/functions.json');
				$jsondataFunctions = json_decode($jsondataFunctions, true);

				if(isset($_POST['submit']))
				{
					$edited = false;
					
					foreach($_POST as $key=>$value)
						if(isset($jsondataFunctions[$key]))
							if($jsondataFunctions[$key]!=$value)
							{
								$jsondataFunctions[$key]=$value;
								$edited = true;
							}
					
					if($edited)
					{
						$json_new = json_encode($jsondataFunctions);
						file_put_contents('include/db/functions.json', $json_new);
					}
					
					header("Location: ".$site_url.'admin/functions');
					die();
				}
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
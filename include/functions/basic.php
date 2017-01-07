<?php
	function redirect($url)
	{
		global $database;
		global $site_url;
		
		$pages = array("administration", "characters", "password", "email");
		if (in_array($url, $pages) && !$database->is_loggedin())
		{
			header("Location: ".$site_url."users/login");
			die();
		}
		
		$pages = array("login", "lost", "register");
		if (in_array($url, $pages) && $database->is_loggedin())
		{
			header("Location: ".$site_url);
			die();
		}
		if($url=='logout' && $database->is_loggedin())
		{
			$database->doLogout();
			header("Location: ".$site_url);
			die();
		}

		if($url=='admin' && (!$database->is_loggedin() || web_admin_level() < 1))
		{
			header("Location: ".$site_url);
			die();
		}
	}

	function getHashPassword($password)
	{
		$hash = "*".sha1(sha1($password, true));
		return strtoupper($hash);
	}

	function generateSocialID($length = 7) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function isValidEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email)<=64)
			return true;
		else return false;
	}

	function isValidUserName($name) {
		if(preg_match('/^[0-9a-zA-Z]*$/', $name, $matches) && strlen($name)>=5 && strlen($name)<=16)
			return true;
		else return false;
	}

	function isValidUserPassword($password) {
		if(preg_match('/^[a-zA-Z0-9 @!#$%&(){}*+,\-.\/:;<>=?[\\]\^_|~]*$/', $password) && strlen($password)>=5 && strlen($password)<=16)
			return true;
		else return false;
	}

	function get_player_empire($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT empire FROM player_index WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['empire'];
	}

	function top10players()
	{
		global $database;
		
		$banned_ids = getBannedAccounts();
		
		$stmt = $database->runQueryPlayer("SELECT id, name, account_id FROM player WHERE name NOT LIKE '[%]%' AND account_id NOT IN (".$banned_ids.") ORDER BY level DESC, exp DESC, name ASC limit 10");
		$stmt->execute();
		$top = $stmt->fetchAll();
		
		return $top;
	}

	function get_guild_empire($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT empire FROM player.player_index WHERE pid1=:id OR pid2=:id OR pid3=:id OR pid4=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['empire'];
	}

	function getPlayerName($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT name FROM player WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['name'];
	}

	function getAccountName($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT login FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['login'];
	}

	function getAccountEmail($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT email FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['email'];
	}

	function getAccountMD($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT coins FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['coins'];
	}

	function getAccountSocialID($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT social_id FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['social_id'];
	}

	function getPlayerSafeBoxPassword($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT password FROM safebox WHERE account_id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['password'];
	}

	function getAccountJD($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT jcoins FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['jcoins'];
	}

	function getAccountID($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT account_id FROM player WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['account_id'];
	}

	function getAccountPassword($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT password FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['password'];
	}

	function top10guilds()
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT name, master FROM guild ORDER BY level DESC, ladder_point DESC, exp DESC, name ASC limit 10");
		$stmt->execute();
		$top = $stmt->fetchAll();
		
		return $top;
	}

	function getBannedAccounts()
	{
		global $database;
		
		$status = 'BLOCK';
		
		$stmt = $database->runQueryAccount("SELECT id FROM account WHERE status=?");
		$stmt->bindParam(1, $status, PDO::PARAM_STR);
		$stmt->execute();
		$banned = $stmt->fetchAll();
		
		$banned_array = array();
		foreach($banned as $id)
			$banned_array[] = $id['id'].' ';
		
		$ids = join(',',$banned_array);
		
		return $ids;
	}

	function emire_name($id)
	{
		switch ($id) {
			case 1://red
				return "Shinsoo";
				break;
			case 2://yellow
				return "Chunjo";
				break;
			case 3://blue
				return "Jinno";
				break;
			default:
				return "ERROR";
		}
	}

	function job_name($id)
	{
		global $lang;
		
		switch ($id) {
			case 0:
				return $lang['warrior'];
				break;
			case 1:
				return $lang['ninja'];
				break;
			case 2:
				return $lang['sura'];
				break;
			case 3:
				return $lang['shaman'];
				break;
			case 4:
				return $lang['warrior'];
				break;
			case 5:
				return $lang['ninja'];
				break;
			case 6:
				return $lang['sura'];
				break;
			case 7:
				return $lang['shaman'];
				break;
			case 8:
				return $lang['lycan'];
				break;
			default:
				return "ERROR";
		}
	}
	
	function characters_list()
	{
		global $database;
		
		$stmt = $database->runQueryPlayer('SELECT name, job, level, exp
			FROM player
			WHERE account_id = ? ORDER BY level DESC, exp DESC, name ASC');
		$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	
	function characters_list_by_id($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer('SELECT id
			FROM player
			WHERE account_id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	
	function get_player_rank($list)
	{
		global $database;
		
		$banned_ids = getBannedAccounts();

		$stmt = $database->runQueryPlayer("SELECT name FROM player WHERE name NOT LIKE '[%]%' AND account_id NOT IN (".$banned_ids.") ORDER BY level DESC, exp DESC, name ASC");
		$stmt->execute();
		$result = $stmt->fetchAll();

		$ranking = array();
		
		foreach($list as $player)
		{
			$position = array_search($player['name'], array_column($result, 'name'));
			$ranking[$player['name']] = $position + 1;
		}
		
		return $ranking;
	}

	function securityPassword($password)
	{
		return md5($password[10].$password[7].$password[3].$password[12].$password[24].$password[17].$password[26].$password[29].$password[18].$password[6]);
	}

	function web_admin_level()
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT web_admin FROM account WHERE id=:id");
		$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['web_admin'];
	}

	function jsonUpdate($v1, $v2, $new)
	{
		$jsondata = file_get_contents('include/settings.json');
		$obj = json_decode($jsondata,true);
		
		if($v2=='')
		{
			$obj[$v1]=$new;
		}
		else
		{
			$obj[$v1][$v2]=$new;
		}
		
		$json_new = json_encode($contentsDecoded);
		
		if(file_put_contents('include/settings.json', $json_new))
			return true;
		else return false;
	}

	function update_deletion_token($id, $deletion_token)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("UPDATE account SET deletion_token=:deletion_token WHERE id=:id");
		$stmt->execute(array(':deletion_token'=>$deletion_token, ':id'=>$id));
		$stmt->execute();
	}

	function insert_delete_account($id)
	{
		global $database;
		
		$date = date('Y-m-d', strtotime("+7 days"));
		
		$stmt = $database->runQuerySqlite("INSERT INTO delete_account (account_id, date) VALUES (:id, :date)");
		$stmt->execute(array(':date'=>$date, ':id'=>$id));
	}

	function cancel_delete_account()
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('DELETE FROM delete_account WHERE account_id = ?');
		$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
	}

	function check_delete()
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('SELECT date FROM delete_account WHERE account_id = ?');
		$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}

	function delete_in_progress()
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('SELECT account_id, date FROM delete_account');
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	
	function update_passlost_token($login, $passlost_token)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("UPDATE account SET passlost_token=:passlost_token WHERE login=:login");
		$stmt->execute(array(':passlost_token'=>$passlost_token, ':login'=>$login));
	}

	function update_passlost_token_by_email($email, $passlost_token='')
	{
		global $database;
		
		$stmt = $database->runQueryAccount("UPDATE account SET passlost_token=:passlost_token WHERE email=:email");
		$stmt->execute(array(':passlost_token'=>$passlost_token, ':email'=>$email));
	}

	function update_password_by_email($email, $password)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("UPDATE account SET password=:password WHERE email=:email");
		$stmt->execute(array(':password'=>$password, ':email'=>$email));
	}

	function update_email_token($id, $code)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("UPDATE account SET email_token=:email_token WHERE id=:id");
		$stmt->execute(array(':id'=>$id, ':email_token'=>$code));
	}

	function updateNewEmail()
	{
		global $database;
		
		$stmt = $database->runQueryAccount("UPDATE account SET email=new_email, new_email='' WHERE id = ?");
		$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		print $_SESSION['id'];
	}

	function update_new_email($id, $email)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("UPDATE account SET new_email=:new_email WHERE id=:id");
		$stmt->execute(array(':id'=>$id, ':new_email'=>$email));
	}
	
	function check_email_token($email, $email_token)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT email_token FROM account WHERE email=:email AND email_token=:email_token LIMIT 1");
		$stmt->execute(array(':email'=>$email, ':email_token'=>$email_token));
		
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
			return true;
		else return false;
	}

	function check_recovery($email, $passlost_token)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT email FROM account WHERE email=:email AND passlost_token=:passlost_token LIMIT 1");
		$stmt->execute(array(':email'=>$email, ':passlost_token'=>$passlost_token));
		
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
			return true;
		else return false;
	}

	function check_deletion($email, $deletion_token)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT email FROM account WHERE email=:email AND deletion_token=:deletion_token LIMIT 1");
		$stmt->execute(array(':email'=>$email, ':deletion_token'=>$deletion_token));
		
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
			return true;
		else return false;
	}

	function recoveryPassword($code, $email, $name)
	{
		global $lang, $site_url;
		
		return '<!doctype html>
			<html>

			<head>
				<meta name="viewport" content="width=device-width">
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Metin2CMS</title>
				<style media="all" type="text/css">
					@media all {
						.btn-primary table td:hover {
							background-color: #34495e !important;
						}
						.btn-primary a:hover {
							background-color: #34495e !important;
							border-color: #34495e !important;
						}
					}
					@media all {
						.btn-secondary a:hover {
							border-color: #34495e !important;
							color: #34495e !important;
						}
					}
					@media only screen and (max-width: 620px) {
						table[class=body] h1 {
							font-size: 28px !important;
							margin-bottom: 10px !important;
						}
						table[class=body] h2 {
							font-size: 22px !important;
							margin-bottom: 10px !important;
						}
						table[class=body] h3 {
							font-size: 16px !important;
							margin-bottom: 10px !important;
						}
						table[class=body] p,
						table[class=body] ul,
						table[class=body] ol,
						table[class=body] td,
						table[class=body] span,
						table[class=body] a {
							font-size: 16px !important;
						}
						table[class=body] .wrapper,
						table[class=body] .article {
							padding: 10px !important;
						}
						table[class=body] .content {
							padding: 0 !important;
						}
						table[class=body] .container {
							padding: 0 !important;
							width: 100% !important;
						}
						table[class=body] .header {
							margin-bottom: 10px !important;
						}
						table[class=body] .main {
							border-left-width: 0 !important;
							border-radius: 0 !important;
							border-right-width: 0 !important;
						}
						table[class=body] .btn table {
							width: 100% !important;
						}
						table[class=body] .btn a {
							width: 100% !important;
						}
						table[class=body] .img-responsive {
							height: auto !important;
							max-width: 100% !important;
							width: auto !important;
						}
						table[class=body] .alert td {
							border-radius: 0 !important;
							padding: 10px !important;
						}
						table[class=body] .span-2,
						table[class=body] .span-3 {
							max-width: none !important;
							width: 100% !important;
						}
						table[class=body] .receipt {
							width: 100% !important;
						}
					}
					@media all {
						.ExternalClass {
							width: 100%;
						}
						.ExternalClass,
						.ExternalClass p,
						.ExternalClass span,
						.ExternalClass font,
						.ExternalClass td,
						.ExternalClass div {
							line-height: 100%;
						}
						.apple-link a {
							color: inherit !important;
							font-family: inherit !important;
							font-size: inherit !important;
							font-weight: inherit !important;
							line-height: inherit !important;
							text-decoration: none !important;
						}
					}
				</style>
			</head>

			<body class="" style="font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f6f6f6; margin: 0; padding: 0;">
				<table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" width="100%" bgcolor="#f6f6f6">
					<tr>
						<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
						<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px;" width="580" valign="top">
							<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

								<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff; border-radius: 3px;" width="100%">

									<tr>
										<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
												<tr>
													<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
														<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">'.$lang['user-name'].': '.$name.'</p>
														<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">'.$lang['email-recovery-info'].'</p>
														<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;" width="100%">
															<tbody>
																<tr>
																	<td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;" valign="top">
																		<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
																			<tbody>
																				<tr>
																					<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;" valign="top" bgcolor="#3498db" align="center"> <a href="'.$site_url.'users/lost/'.$email.'/'.$code.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">'.$lang['account-recovery'].'</a> </td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
														<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><a href="'.$site_url.'users/lost/'.$email.'/'.$code.'">'.$site_url.'users/lost/'.$email.'/'.$code.'</a></p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>

								<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
									<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
										<tr>
											<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-top: 10px; padding-bottom: 10px; font-size: 12px; color: #999999; text-align: center;" valign="top" align="center">
												<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Please do not replay to this email.</span>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</td>
						<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
					</tr>
				</table>
			</body>

			</html>';
	}

	function sendCode($name, $code, $type=1)
	{
		global $lang, $site_url;
		
		$lang_user = $lang['user-name'];
		
		if($type==1)
			$type=$lang['code-delete-chars'];
		else if($type==2)
			$type=$lang['storekeeper'];
		else if($type==3)
			$type=$lang['delete-account-info'];
		else if($type==4)
			$type=$lang['password'];
		else if($type==5)
		{
			$type=$lang['change-email'];
			$lang_user=$lang['new-email-address'];
		}
		
		return '<!doctype html>
			<html>

			<head>
				<meta name="viewport" content="width=device-width">
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Metin2CMS</title>
				<style media="all" type="text/css">
					@media all {
						.btn-primary table td:hover {
							background-color: #34495e !important;
						}
						.btn-primary a:hover {
							background-color: #34495e !important;
							border-color: #34495e !important;
						}
					}
					@media all {
						.btn-secondary a:hover {
							border-color: #34495e !important;
							color: #34495e !important;
						}
					}
					@media only screen and (max-width: 620px) {
						table[class=body] h1 {
							font-size: 28px !important;
							margin-bottom: 10px !important;
						}
						table[class=body] h2 {
							font-size: 22px !important;
							margin-bottom: 10px !important;
						}
						table[class=body] h3 {
							font-size: 16px !important;
							margin-bottom: 10px !important;
						}
						table[class=body] p,
						table[class=body] ul,
						table[class=body] ol,
						table[class=body] td,
						table[class=body] span,
						table[class=body] a {
							font-size: 16px !important;
						}
						table[class=body] .wrapper,
						table[class=body] .article {
							padding: 10px !important;
						}
						table[class=body] .content {
							padding: 0 !important;
						}
						table[class=body] .container {
							padding: 0 !important;
							width: 100% !important;
						}
						table[class=body] .header {
							margin-bottom: 10px !important;
						}
						table[class=body] .main {
							border-left-width: 0 !important;
							border-radius: 0 !important;
							border-right-width: 0 !important;
						}
						table[class=body] .btn table {
							width: 100% !important;
						}
						table[class=body] .btn a {
							width: 100% !important;
						}
						table[class=body] .img-responsive {
							height: auto !important;
							max-width: 100% !important;
							width: auto !important;
						}
						table[class=body] .alert td {
							border-radius: 0 !important;
							padding: 10px !important;
						}
						table[class=body] .span-2,
						table[class=body] .span-3 {
							max-width: none !important;
							width: 100% !important;
						}
						table[class=body] .receipt {
							width: 100% !important;
						}
					}
					@media all {
						.ExternalClass {
							width: 100%;
						}
						.ExternalClass,
						.ExternalClass p,
						.ExternalClass span,
						.ExternalClass font,
						.ExternalClass td,
						.ExternalClass div {
							line-height: 100%;
						}
						.apple-link a {
							color: inherit !important;
							font-family: inherit !important;
							font-size: inherit !important;
							font-weight: inherit !important;
							line-height: inherit !important;
							text-decoration: none !important;
						}
					}
				</style>
			</head>

			<body class="" style="font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f6f6f6; margin: 0; padding: 0;">
				<table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" width="100%" bgcolor="#f6f6f6">
					<tr>
						<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
						<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px;" width="580" valign="top">
							<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

								<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff; border-radius: 3px;" width="100%">

									<tr>
										<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
												<tr>
													<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
														<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">'.$lang_user.': '.$name.'</p>
														<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">'.$type.': <b>'.$code.'</b></p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>

								<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
									<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
										<tr>
											<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-top: 10px; padding-bottom: 10px; font-size: 12px; color: #999999; text-align: center;" valign="top" align="center">
												<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Please do not replay to this email.</span>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</td>
						<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
					</tr>
				</table>
			</body>

			</html>';
	}

	function getLogTables()
	{
		global $database;
		
		$stmt = $database->runQueryLog("SHOW TABLES");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
		
		return $result;
	}

	function getColumnsLog($table)
	{
		global $database;
		
		$stmt = $database->runQueryLog("DESCRIBE ".$table);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
		
		return $result;
	}
	
	function officialVersion()
	{
		$officialVersion = '';
		$officialVersion = @file_get_contents('https://new.metin2cms.cf/v2/last_version.php');
		
		return $officialVersion;
	}
	
	function checkUpdate($lastVersion)
	{
		global $mt2cms;
				
		if($lastVersion && $lastVersion!='' && $lastVersion > $mt2cms)
			return 1;
		return 0;
	}
	
	function check_item_column($name)
	{
		global $database;
		
		$sth = $database->runQueryPlayer("DESCRIBE item");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		if(in_array($name, $columns))
			return true;
		else return false;
	}
	
	function get_account_by_char($name)
	{
		global $database;

		$sth = $database->runQueryPlayer("SELECT account_id FROM player WHERE name LIKE ?");
		$sth->bindParam(1, $name, PDO::PARAM_INT);
		$sth->execute();
		$account_id = $sth->fetchAll(PDO::FETCH_COLUMN);
		if($account_id)
			return $account_id[0];
		else return false;
	}
	
	function getItemSize($code)
	{
		return 3;
	}

	function new_item_position($id_account, $new_item)
	{
		global $database;
			
		$sth = $database->runQueryPlayer('SELECT pos, vnum
			FROM item
			WHERE owner_id=? AND window="MALL" ORDER by pos ASC');
		$sth->bindParam(1, $id_account, PDO::PARAM_INT);
		$sth->execute();
		$result = $sth->fetchAll();
		
		$used = $items_used = $used_check = array();
		
		foreach( $result as $row ) {
			$used_check[] = $row['pos'];
			$used[$row['pos']] = 1;
			$items_used[$row['pos']] = $row['vnum'];
		}
		$used_check = array_unique($used_check);

		$free = -1;
		
		for($i=0; $i<45; $i++){
			if(!in_array($i,$used_check)){
				$ok = true;
				
				if($i>4 && $i<10)
				{
					if(array_key_exists($i-5, $used) && getItemSize($items_used[$i-5])>1)
						$ok = false;
				}
				else if($i>9 && $i<40)
				{
					if(array_key_exists($i-5, $used) && getItemSize($items_used[$i-5])>1)
						$ok = false;
					
					if(array_key_exists($i-10, $used) && getItemSize($items_used[$i-10])>2)
						$ok = false;
				}
				else if($i>39 && $i<45 && getItemSize($new_item)>1)
						$ok = false;
				
				if($ok)
					return $i;
			}
		}
		
		return $free;
	}
	
	function delete_char($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer('DELETE FROM player WHERE id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		$stmt = $database->runQueryPlayer('DELETE FROM guild_member WHERE pid = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		$stmt = $database->runQueryPlayer('DELETE FROM item WHERE owner_id = ? AND window <> "MALL"');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		$stmt = $database->runQueryPlayer('DELETE FROM player_index WHERE id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function delete_account($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount('DELETE FROM account WHERE id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		$stmt = $database->runQueryPlayer('DELETE FROM item WHERE owner_id = ? AND window = "MALL"');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		$stmt = $database->runQueryPlayer('DELETE FROM safebox WHERE account_id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		$chars = characters_list_by_id($id);
		
		foreach($chars as $char)
			delete_char($char['id']);
	}
?>
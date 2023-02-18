<?php
	function redirect($url)
	{
		global $database, $site_url;
		
		$pages = array("administration", "characters", "password", "email", "vote4coins", "donate", "referrals");
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
		
		if($result)
			return $result['empire'];
		return 3;
	}

	function topPlayers($limit=10)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT id, name, account_id FROM player WHERE name NOT LIKE '[%]%' ORDER BY level DESC, exp DESC, playtime DESC, name ASC limit ?");
		$stmt->bindParam(1, $limit, PDO::PARAM_INT);
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
		
		if($result)
			return $result['empire'];
		return 3;
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

	function topGuilds($limit=10)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT name, master FROM guild WHERE name NOT LIKE '[%]%' ORDER BY level DESC, ladder_point DESC, exp DESC, name ASC limit ?");
		$stmt->bindParam(1, $limit, PDO::PARAM_INT);
		$stmt->execute();
		$top = $stmt->fetchAll();
		
		return $top;
	}

	function empire_name($id)
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
		
		$stmt = $database->runQueryPlayer('SELECT id, name, job, level, exp
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
		
		$ranking = array();
		
		foreach($list as $player)
		{
			$sql =  "SELECT r.position FROM player u 
						LEFT JOIN (SELECT r.*, @rownum := @rownum + 1 AS position
						FROM player r CROSS JOIN
						(SELECT @rownum := 0) r WHERE r.name NOT LIKE '[%]%'
						ORDER BY r.level desc, r.exp DESC, r.name ASC LIMIT 1000) r
						ON r.id = u.id
						WHERE u.id = :id";
			
			$stmt = $database->runQueryPlayer($sql);
			$stmt->bindParam(':id', $player['id'], PDO::PARAM_INT);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			if(!$result['position'])
				$ranking[$player['name']] = '<i class="fa fa-times fa-1" aria-hidden="true"></i>';
			else if(strpos($player['name'], '[')!== false)
				$ranking[$player['name']] = '<i class="fa fa-times fa-1" aria-hidden="true"></i>';
			else
				$ranking[$player['name']] = '~'.$result['position'];
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
		$officialVersion = file_get_contents_curl('https://new.metin2cms.cf/v2/last_version.php', 2, 5);

		return $officialVersion;
	}
	
	function checkUpdate($lastVersion)
	{
		global $mt2cms;
		$version = str_replace('.', '', $mt2cms);
		
		$lastVersion = str_replace('.', '', $lastVersion);
		if($lastVersion==291)
			$lastVersion=210;
		
		if($lastVersion && $lastVersion!='' && $lastVersion > $version)
			return true;
		return false;
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
	
	function check_item_sash($id)
	{
		if($id > 85000 && $id < 90000)
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
			
		$stmt = $database->runQuerySqlite('DELETE FROM delete_account WHERE account_id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function delete_vote4coins($id)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('DELETE FROM vote4coins WHERE site = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();	
	}
	
	function check_vote4coins($key, $id)
	{
		global $database;

		$stmt = $database->runQuerySqlite("SELECT site FROM vote4coins WHERE site = ? AND account_ip = ?");
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->bindParam(2, $key, PDO::PARAM_STR);
		$stmt->execute();
		$check = $stmt->fetchAll();

		if(count($check))
			return true;
		else return false;
	}
	
	function check_vote4coins_by_account($id)
	{
		global $database;

		$stmt = $database->runQuerySqlite("SELECT site FROM vote4coins WHERE site = ? AND account_id= ?");
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->bindParam(2,  $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$check = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if(count($check))
			return true;
		return false;
	}
	
	function insert_vote4coins($id, $ip)
	{
		global $database;
		
		$date = date('Y-m-d G:i');
		$account = $_SESSION['id'];
		
		$stmt = $database->runQuerySqlite("INSERT INTO vote4coins (site, account_id, account_ip, date) VALUES (:site, :account_id, :account_ip, :date)");
		$stmt->execute([':date'=>$date, ':account_id'=>$account, ':account_ip'=>$ip, ':site'=>$id]);
	}
	
	function check_date_vote4coins($id, $ip)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite("SELECT date FROM vote4coins WHERE site = ? AND (account_ip = ? OR account_id = ?) ORDER BY date DESC LIMIT 1");
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->bindParam(2, $ip, PDO::PARAM_STR);
		$stmt->bindParam(3, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

		if($result)
			return $result[0];
		return "0000-00-00 00:00";
	}

	function check_date_vote4coins_ip($id, $ip)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite("SELECT date FROM vote4coins WHERE site = ? AND account_ip = ? ORDER BY date DESC LIMIT 1");
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->bindParam(2, $ip, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

		if($result)
			return $result[0];
		return "0000-00-00 00:00";
	}
	
	function sqlite_check_table($table)
	{
		global $database;
		
		try {
			$result = $database->runQuerySqlite("SELECT 1 FROM $table LIMIT 1");
		} catch (Exception $e) {
			return FALSE;
		}

		return $result !== FALSE;
	}
	
	function sqlite_create_table($sql)
	{
		global $database;

		if($database->execQuerySqlite($sql))
			return true;
		return false;
	}
	
	function addCoins($account_id, $coins)
	{
		global $database;

		$stmt = $database->runQueryAccount("UPDATE account SET coins = coins + ? WHERE id = ?");
		$stmt->bindParam(1, $coins, PDO::PARAM_INT);
		$stmt->bindParam(2, $account_id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function addjCoins($account_id, $coins)
	{
		global $database;

		$stmt = $database->runQueryAccount("UPDATE account SET jcoins = jcoins + ? WHERE id = ?");
		$stmt->bindParam(1, $coins, PDO::PARAM_INT);
		$stmt->bindParam(2, $account_id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function updateVote4Coins($site, $ip)
	{
		global $database;
		
		$date = date('Y-m-d G:i');

		$stmt = $database->runQuerySqlite("UPDATE vote4coins SET account_ip = ?, date = ? WHERE site = ? AND account_id = ?");
		$stmt->bindParam(1, $ip, PDO::PARAM_STR);
		$stmt->bindParam(2, $date, PDO::PARAM_STR);
		$stmt->bindParam(3, $site, PDO::PARAM_INT);
		$stmt->bindParam(4, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
	}
	
	//2.6
	function check_table_in_player($table)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SHOW TABLES LIKE ?");
		$stmt->bindParam(1, $table, PDO::PARAM_STR);
		$stmt->execute(); 
		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
		
		if(count($result))
			return true;
		else return false;
	}
	
	function countOnlinePlayers_minute($m)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT count(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL ? MINUTE) < last_play");
		$stmt->bindParam(1, $m, PDO::PARAM_INT);
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function countOnlinePlayers_days($d)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT count(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL ? DAY) < last_play");
		$stmt->bindParam(1, $d, PDO::PARAM_INT);
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function getCharsTotalNumber()
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT count(*) FROM player"); 
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function getAccountsTotalNumber()
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT count(*) FROM account"); 
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function getGuildsTotalNumber()
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT count(*) FROM guild"); 
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function getOfflineShopsTotalNumber()
	{
		global $database;
		
		if(!check_table_in_player('offline_shop_npc'))
			return 0;
		else
		{
			$stmt = $database->runQueryPlayer("SELECT count(*) FROM offline_shop_npc"); 
			$stmt->execute(); 
			$count = $stmt->fetchColumn(); 

			return $count;
		}
		return 5;
	}
	
	function getStatistics($key)
	{
		switch ($key) {
			case 'players-online':
				return countOnlinePlayers_minute(10);
				break;
			case 'accounts-created':
				return getAccountsTotalNumber();
				break;
			case 'created-characters':
				return getCharsTotalNumber();
				break;
			case 'guilds-created':
				return getGuildsTotalNumber();
				break;
			case 'offline-shops':
				return getOfflineShopsTotalNumber();
				break;
			case 'players-online-last-24h':
				return countOnlinePlayers_days(1);
				break;
			default:
				return "ERROR";
		}
	}
	
	function checkStatus($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT status FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($result['status']=="OK")
			return 1;
		else return 0;
	}
	
	function check_account_column($name)
	{
		global $database;
		
		$sth = $database->runQueryAccount("DESCRIBE account");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		if(in_array($name, $columns))
			return true;
		else return false;
	}
	
	function check_availDt($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT availDt FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($result['availDt'] != "0000-00-00 00:00:00")
		{	
			$date1 = new DateTime("now");
			$date2 = new DateTime($result['availDt']);
			if($date1 < $date2)
				return 1;//banned
		} else return 0;
		
		return 0;
	}
	
	function get_availDt($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT availDt FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['availDt'];
	}
	
	function banPermanent($id, $reason)
	{
		global $database;
		
		$now_time = date('Y-m-d H:i:s');
		$status = 'BLOCK';
		
		$stmt = $database->runQuerySqlite("INSERT INTO ban_log (account_id, date, reason) VALUES (:id, :date, :reason)");
		$stmt->execute(array(':date'=>$now_time, ':id'=>$id, ':reason'=>$reason));
		
		$stmt = $database->runQueryAccount("UPDATE account SET status = ? WHERE id = ?");
		$stmt->bindParam(1, $status, PDO::PARAM_STR);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function getLastBanReason($id)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('SELECT reason, date FROM ban_log WHERE account_id = ? ORDER BY id DESC LIMIT 1');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result)
			return $result['date'].'</br>'.$result['reason'];
		else return '';
	}
	
	function getLoginLastBanReason($id)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('SELECT reason FROM ban_log WHERE account_id = ? ORDER BY id DESC LIMIT 1');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result)
			return $result['reason'];
		else return '';
	}
	
	function unBan($id)
	{
		global $database;
		
		$status = 'OK';
		
		$stmt = $database->runQueryAccount("UPDATE account SET status = ? WHERE id = ?");
		$stmt->bindParam(1, $status, PDO::PARAM_STR);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		if(check_account_column('availDt'))
		{
			$reset_availDt = "0000-00-00 00:00:00";
			
			$stmt = $database->runQueryAccount("UPDATE account SET availDt = ? WHERE id = ?");
			$stmt->bindParam(1, $reset_availDt, PDO::PARAM_STR);
			$stmt->bindParam(2, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}

	function banTemporary($id, $reason, $time_availDt)
	{
		global $database;
		
		$now_time = date('Y-m-d H:i:s');
		
		$stmt = $database->runQuerySqlite("INSERT INTO ban_log (account_id, date, reason) VALUES (:id, :date, :reason)");
		$stmt->execute(array(':date'=>$now_time, ':id'=>$id, ':reason'=>$reason));
		
		$date = date('Y-m-d H:i:s', $time_availDt);

		$stmt = $database->runQueryAccount("UPDATE account SET availDt = ? WHERE id = ?");
		$stmt->bindParam(1, $date, PDO::PARAM_STR);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function check_char($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT id FROM player WHERE id=:id LIMIT 1");
		$stmt->execute(array(':id'=>$id));
		
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
			return true;
		else return false;
	}
	
	function getCharColumns($table)
	{
		global $database;

		$pdo_stmt = $database->runQueryPlayer('SELECT * from '.$table. ' LIMIT 1');
		$pdo_stmt->execute();
				
		foreach(range(0, $pdo_stmt->columnCount() - 1) as $column_index)
			$meta[] = $pdo_stmt->getColumnMeta($column_index);

		return $meta;
	}
	
	function translateNativeType($orig) {
		$trans = array(
			'VAR_STRING' => 'string',
			'STRING' => 'string',
			'BLOB' => 'blob',
			'LONGLONG' => 'int',
			'LONG' => 'int',
			'SHORT' => 'int',
			'TINY' => 'int',
			'INT24' => 'int',
			'DATETIME' => 'datetime',
			'DATE' => 'date',
			'DOUBLE' => 'real',
			'TIMESTAMP' => 'timestamp'
		);
		return $trans[$orig];
	}
	
	function getCharData($id)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT * FROM player WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
	
	function updateChar($id, $columns, $old)
	{
		global $database;
		
		$query = '';
		$new_data = array();

		foreach($columns as $column)
			if(isset($_POST[$column['name']]) && $old[$column['name']] != $_POST[$column['name']])
			{
				$new_data[$column['name']] = $_POST[$column['name']];
				$query = $query.$column['name'].'=:'.$column['name'].', ';
			}
				
		if(strlen($query))
		{
			$query=rtrim($query,", ");
			$new_data['id_player'] = $id;
			
			$stmt = $database->runQueryPlayer("UPDATE player SET ".$query." WHERE id=:id_player");
			$stmt->execute($new_data);
			$stmt->execute();
		}
	}
	
	function getModulesList()
	{
		$modules = '';
		$modules = file_get_contents_curl('https://new.metin2cms.cf/v2/modules/modules.json', 2, 5);
		
		$modules = json_decode($modules, TRUE);

		if(isset($modules['modules']))
			return $modules['modules'];
		else return array();
	}
	
	function getThemesList()
	{
		$themes = '';
		$themes = file_get_contents_curl('https://new.metin2cms.cf/v2/themes/themes.json', 2, 5);
		
		$themes = json_decode($themes, TRUE);

		if(isset($themes['themes']))
			return $themes['themes'];
		else return array();
	}
	
	//2.12
	function fix_account_columns()
	{
		global $database;
		global $lang;
		
		$sth = $database->runQueryAccount("DESCRIBE account");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		$fix = array(	"coins" => "ALTER TABLE account ADD coins int(20) NOT NULL DEFAULT 0",
						"jcoins" => "ALTER TABLE account ADD jcoins int(20) NOT NULL DEFAULT 0", 
						"deletion_token" => "ALTER TABLE account ADD deletion_token varchar(40) NOT NULL DEFAULT ''",
						"passlost_token" => "ALTER TABLE account ADD passlost_token varchar(40) NOT NULL DEFAULT ''",
						"email_token" => "ALTER TABLE account ADD email_token varchar(40) NOT NULL DEFAULT ''",
						"new_email" => "ALTER TABLE account ADD new_email varchar(64) NOT NULL DEFAULT ''");
		
		foreach($fix as $column => $query)
			if(!in_array($column, $columns))
			{
				$stmt = $database->runQueryAccount($fix[$column]);
				$stmt->execute();

				print '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><center>'.$lang['account-new-column'].$column.'</center></div>';
			}
	}
	
	//2.8
	function getLanguagesList()
	{
		$languages = '';
		$languages = file_get_contents_curl('https://new.metin2cms.cf/v2/languages/languages.json', 2, 5);
		
		$languages = json_decode($languages, TRUE);

		if(isset($languages['languages']))
			return $languages['languages'];
		else return array();
	}
	
	function reset_char($id, $mapindex, $x, $y)
	{
		global $database;
		
		
		$stmt = $database->runQueryPlayer('SELECT map_index, x, y, exit_map_index FROM player WHERE id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result['map_index']!= $mapindex || $result['x']!= $x || $result['y']!= $y || $result['exit_map_index']!= $mapindex)
		{
			$stmt = $database->runQueryPlayer("UPDATE player SET map_index=".$mapindex.", x=".$x.", y=".$y.", exit_x=0, exit_y=0, exit_map_index=".$mapindex.", horse_riding=0 WHERE id=".$id);
			$stmt->execute();	
		}
	}
	
	function get_donations()
	{
		global $database;
		
		$stmt = $database->runQuerySqlite("SELECT * FROM donate WHERE status = 0");
		$stmt->execute();
		$result=$stmt->fetchAll();
		
		return $result;
	}

	function insert_donate($id, $code, $type)
	{
		global $database;
				
		$stmt = $database->runQuerySqlite("INSERT INTO donate (account_id, code, type) VALUES (:id, :code, :type)");
		$stmt->execute(array(':code'=>$code, ':id'=>$id, ':type'=>$type));
	}
	
	function updateDonateStatus($id, $status)
	{
		global $database;

		$stmt = $database->runQuerySqlite("UPDATE donate SET status = ? WHERE id = ?");
		$stmt->bindParam(1, $status, PDO::PARAM_INT);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	//2.10
	function checkPrivileges($page, $web_admin)
	{
		global $jsondataPrivileges, $site_url;
		
		if($page=='home' && count($jsondataPrivileges))
		{
			foreach($jsondataPrivileges as $priv)
				if($priv)
					return;
				
			header("Location: ".$site_url);
			die();
		}
		
		switch ($page) {
			case 'links':
				$page = 'edit-info';
				break;
			case 'functions':
				$page = 'functions-on-off';
				break;
			case 'vote4coins':
				$page = 'Vote4Coins';
				break;
			case 'players':
				$page = 'player-management';
				break;
			case 'log':
				$page = 'Log';
				break;
			case 'language':
				$page = 'cms-management';
				break;
			case 'modules':
				$page = 'cms-management';
				break;
			case 'themes':
				$page = 'cms-management';
				break;
			case 'donatelist':
				$page = 'donate';
				break;
			case 'player_edit':
				$page = 'player-management';
				break;
			case 'createitems':
				$page = 'create-items';
				break;
			case 'coins':
				$page = 'add-coins';
				break;
			case 'redeem':
				$page = 'redeem-codes';
				break;
			case 'reward':
				$page = 'reward-players';
				break;
		}
		
		if($page=='privileges')
		{
			if($web_admin<9)
			{
				header("Location: ".$site_url."admin");
				die();
			} else return;
		} else if($web_admin>=$jsondataPrivileges[$page])
			return;
		
		header("Location: ".$site_url."admin");
		die();
	}
	
	function getAccountIDbyName($name)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT id FROM account WHERE login LIKE ?");
		$stmt->bindParam(1, $name, PDO::PARAM_STR);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['id'];
	}
	
	function getAccountIDbyChar($name)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT account_id FROM player WHERE name LIKE ?");
		$stmt->bindParam(1, $name, PDO::PARAM_STR);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['account_id'];
	}
	
	function getReferrals()
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('SELECT *
			FROM referrals
			WHERE invited_by = ?');
		$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	
	function getReferralsForCheck($id)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('SELECT *
			FROM referrals
			WHERE invited_by = ? AND registered = ? AND claimed = 0');
		$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	
	function getPlayerInfo($account)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer('SELECT *
			FROM player
			WHERE account_id = ? ORDER BY level DESC LIMIT 1');
		$stmt->bindParam(1, $account, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	function getAccountInfo($account)
	{
		global $database;
		
		$stmt = $database->runQueryAccount('SELECT login
			FROM account
			WHERE id = ?');
		$stmt->bindParam(1, $account, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	
	function updateReferrals($id)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite("UPDATE referrals SET claimed = 1 WHERE registered=:id");
		$stmt->execute(array(':id'=>$id));
	}
	
	function addReferral($my_id, $ref)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite("INSERT INTO referrals (invited_by, registered) VALUES (:invited_by, :registered)");
		$stmt->execute(array(':invited_by'=>$ref, ':registered'=>$my_id));
	}
	
	function check_char_name($name)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT name FROM player WHERE name LIKE :name LIMIT 1");
		$stmt->bindparam(":name", $name);
		$stmt->execute();
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
			return 1;
		else return 0;	
	}
	
	function searchGMlist($mName)
	{
		global $database;
		
		$stmt = $database->runQueryCommon('SELECT *
			FROM gmlist
			WHERE mName = ?');
		$stmt->bindParam(1, $mName, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if($result)
			return $result[0]['mAuthority'];
		else return 'PLAYER';
	}
	
	function updateGameAdmin($mAccount, $mName, $mAuthority)
	{
		global $database;
		
		$stmt = $database->runQueryCommon('SELECT *
			FROM gmlist
			WHERE mName = ?');
		$stmt->bindParam(1, $mName, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if($result)
		{
			$stmt = $database->runQueryCommon("UPDATE gmlist SET mAuthority = ? WHERE mName = ?");
			$stmt->bindParam(1, $mAuthority, PDO::PARAM_STR);
			$stmt->bindParam(2, $mName, PDO::PARAM_STR);
			$stmt->execute();
		}
		else
		{
			$stmt = $database->runQueryCommon("INSERT INTO gmlist (mAccount, mName, mAuthority) VALUES (:mAccount, :mName, :mAuthority)");
			$stmt->execute(array(':mAccount'=>$mAccount, ':mName'=>$mName, ':mAuthority'=>$mAuthority));
		}
		
		$x = "PLAYER";
		
		$stmt = $database->runQueryCommon('DELETE FROM gmlist WHERE mAuthority = ?');
		$stmt->bindParam(1, $x, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	function update_empire($id, $empire)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("UPDATE player_index SET empire = ? WHERE id = ?");
		$stmt->bindParam(1, $empire, PDO::PARAM_INT);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function get_web_admin_level($id)
	{
		global $database;
		
		$stmt = $database->runQueryAccount("SELECT web_admin FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['web_admin'];
	}
	
	function updateWebAdmin($id, $admin)
	{
		global $database;

		$stmt = $database->runQueryAccount("UPDATE account SET web_admin = ? WHERE id=?");
		$stmt->bindParam(1, $admin, PDO::PARAM_INT);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function generateRedeemCode($length = 7) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	function check_redeem_codes($code)
	{
		global $database;

		$stmt = $database->runQuerySqlite("SELECT id FROM redeem WHERE code = ?");
		$stmt->bindParam(1, $code, PDO::PARAM_STR);
		$stmt->execute();
		$check = $stmt->fetchAll();

		if(count($check))
			return true;
		else return false;
	}
	
	function addRedeemCode($type, $value)
	{
		global $database;

		$ok = false;
		
		while(!$ok)
		{
			$code = generateRedeemCode(16);
			
			if(!check_redeem_codes($code))
				$ok = true;
		}
		
		$stmt = $database->runQuerySqlite("INSERT INTO redeem (code, type, value) VALUES (:code, :type, :value)");
		$stmt->execute(array(':code'=>$code, ':type'=>$type, ':value'=>$value));
		
		return $code;
	}
	
	function delete_redeeem_code($id)
	{
		global $database;
		
		$stmt = $database->runQuerySqlite('DELETE FROM redeem WHERE id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function getRedeem($code)
	{
		global $database;

		$stmt = $database->runQuerySqlite("SELECT * FROM redeem WHERE code = ? LIMIT 1");
		$stmt->bindParam(1, $code, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
	
	//v2.11
	function add_item_award($account_id, $vnum, $count, $socket0, $socket1, $socket2)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer('INSERT INTO item_award(login, vnum, count, given_time, socket0, socket1, socket2, mall) VALUES (?,?,?,NOW(),?,?,?,?)');
		$stmt->execute(array(getAccountName($account_id), $vnum, $count, $socket0, $socket1, $socket2, 1));
	}
		
	function getOnlinePlayers_minute($m)
	{
		global $database;
		
		$stmt = $database->runQueryPlayer("SELECT account_id FROM player WHERE DATE_SUB(NOW(), INTERVAL ? MINUTE) < last_play");
		$stmt->bindParam(1, $m, PDO::PARAM_INT);
		$stmt->execute(); 
		$result = $stmt->fetchAll();

		return $result;
	}
	
	function file_get_contents_curl($url, $retries=5, $time_out=10)
	{
		$ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36';
		if (extension_loaded('curl') === true)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $time_out);
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, $time_out);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		else
			$result = file_get_contents($url, false, stream_context_create(array('http' => array('header'=>'Connection: close\r\n'))));
		
		if (empty($result) === true)
		{
			$result = false;
			if ($retries >= 1)
			{
				sleep(1);
				return file_get_contents_curl($url, --$retries);
			}
		}    
		return $result;
	}
	
	function ZipExtractUpdate()
	{
		$file = 'update.zip';
		$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
		
		if(class_exists('ZipArchive'))
		{
			$zip = new ZipArchive;
			$res = $zip->open($file);
			if($res === TRUE) {
				$zip->extractTo($path);
				$zip->close();
				
				if(file_exists($file)) {
					unlink($file);
				}
				
				return array(1);
			} else array(0);
		}
		else {
			require_once('include/classes/pclzip.lib.php');
			$archive = new PclZip($file);
			
			if ($archive->extract($path) == 0)
				array(0, '<div class="alert alert-danger" role="alert">Error: '.$archive->errorInfo(true).'</div>');
			else {
				if(file_exists($file)) {
					unlink($file);
				}
				
				return array(1);
			}
		}
		return array(0);
	}

	//v2.12
	function getTimeUntilNextVote($date_diff)
	{
		global $lang;
		
		$time_vote            = [];
		$time_vote['days']    = $date_diff->d;
		$time_vote['hours']   = $date_diff->h;
		$time_vote['minutes'] = $date_diff->i;
		$already_voted        = '';
		
		foreach ($time_vote as $key => $time)
			if($time)
				$already_voted .= $time . ' ' . $lang[$key] . ' ';
		
		$already_voted = substr($already_voted, 0, -1);
		$already_voted .= '.';
		
		return $already_voted;
	}
?>
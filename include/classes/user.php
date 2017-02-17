<?php

require_once('include/classes/database.php');

class USER
{

	private $account;
	private $player;
	private $sqlite;
	private $conn;
	
	public function __construct($host, $user, $password)
	{
		$database = new Database();
		
		$account = $database->dbConnection($host, "account", $user, $password);
		$this->account = $account;
		
		$player = $database->dbConnection($host, "player", $user, $password);
		$this->player = $player;
		
		$sqlite = $database->dbConnection("", "", "", "", "yes");
		$this->sqlite = $sqlite;
		
		$log = $database->dbConnection($host, "log", $user, $password);
		$this->log = $log;
    }
	
	public function runQueryAccount($sql)
	{
		$stmt = $this->account->prepare($sql);
		return $stmt;
	}
	
	public function runQueryPlayer($sql)
	{
		$stmt = $this->player->prepare($sql);
		return $stmt;
	}
	
	public function runQuerySqlite($sql)
	{
		$stmt = $this->sqlite->prepare($sql);
		return $stmt;
	}
	
	public function execQuerySqlite($sql)
	{
		$stmt = $this->sqlite->exec($sql);
		return $stmt;
	}
	
	public function runQueryLog($sql)
	{
		$stmt = $this->log->prepare($sql);
		return $stmt;
	}
	
	public function register($username,$password,$email)
	{
		global $safebox_size;
		
		try
		{
			$password = getHashPassword($password);
			$social_id = generateSocialID();
			$status = "OK";
			
			$stmt = $this->account->prepare("INSERT INTO account(login, password, social_id, email, create_time, status) 
		                                               VALUES(:login, :password, :social_id, :email, NOW(), :status)");
												  
			$stmt->bindparam(":login", $username);
			$stmt->bindparam(":password", $password);
			$stmt->bindparam(":social_id", $social_id);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":status", $status);
				
			$stmt->execute();
			
			$lastId = $this->account->lastInsertId();
			$safebox_password = "000000";
			
			$stmt = $this->player->prepare("INSERT INTO safebox(account_id, size, password) 
		                                               VALUES(:account_id, :size, :password)");
												  
			$stmt->bindparam(":account_id", $lastId);
			$stmt->bindparam(":size", $safebox_size);
			$stmt->bindparam(":password", $safebox_password);
				
			$stmt->execute();
			
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function doLogin($login,$password)
	{
		$password = getHashPassword($password);
		try
		{
			if(isValidEmail($login))
				$stmt = $this->account->prepare("SELECT id, status, password FROM account WHERE email=:login AND password=:password");
			else
				$stmt = $this->account->prepare("SELECT id, status, password FROM account WHERE login=:login AND password=:password");
			$stmt->execute(array(':login'=>$login, ':password'=>$password));
			
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($userRow['status']=='OK')
				{
					$_SESSION['id'] = $userRow['id'];
					$_SESSION['password'] = securityPassword($userRow['password']);
					$_SESSION['fingerprint'] = md5($_SERVER['HTTP_USER_AGENT'] . 'x' . $_SERVER['REMOTE_ADDR']);
					return 1;
				}
				else
					return 2;
			} else {
				if(isValidEmail($login))
					return 4;
				else
					return 3;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function Lost($login,$email)
	{
		try
		{
			$stmt = $this->account->prepare("SELECT status FROM account WHERE login=:login AND email=:email");
			$stmt->execute(array(':login'=>$login, ':email'=>$email));
			
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($userRow['status']=='OK')
					return 1;
				else
					return 2;
			} else {
				return 3;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function checkUserName($username)
	{
		try
		{
			$stmt = $this->account->prepare("SELECT login FROM account WHERE login LIKE :username LIMIT 1");
			$stmt->bindparam(":username", $username);
			$stmt->execute();
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
				return 1;
			else return 0;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function checkUserEmail($email)
	{
		try
		{
			$stmt = $this->account->prepare("SELECT email FROM account WHERE email LIKE :email LIMIT 1");
			$stmt->bindparam(":email", $email);
			$stmt->execute();
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
				return 1;
			else return 0;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['id']))
		{
			return true;
		}
		else return false;
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['id']);
		unset($_SESSION['password']);
		unset($_SESSION['fingerprint']);
		return true;
	}
}
?>
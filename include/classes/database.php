<?php

class Database
{
	public $conn;
	
	public function dbConnection($host, $db_name, $user, $password, $sqlite=null)
	{
	
		$this->conn = null;    
		try
		{
			if($sqlite==null)
				$this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $user, $password, [PDO::ATTR_TIMEOUT => 5, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
			else
			{
				$this->conn = new PDO("sqlite:include/db/site.db");
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		}
		catch(PDOException $exception)
		{
			global $offline;
			$offline = 1;
			//echo "Connection error: " . $exception->getMessage();
		}
		
		return $this->conn;
	}
}

?>
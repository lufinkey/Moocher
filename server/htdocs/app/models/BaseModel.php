<?php

class BaseModel
{
	private static $database = null;

	public static function openDatabaseConnection($host, $username, $password, $dbname, $port=3306)
	{
		if(self::$database!=null)
		{
			return;
		}
		self::$database = new mysqli($host, $username, $password, $dbname, $port);
		if(self::$database->connect_errno)
		{
			error_log(self::$database->connect_error);
			self::$database->close();
			self::$database = null;
			return;
		}
	}

	public static function getDatabaseHandle()
	{
		return self::$database;
	}

	public static function queryDatabase($query)
	{
		if(self::$database==null)
		{
			return false;
		}
		$result = self::$database->query($query);
		if($result==false)
		{
			error_log(self::$database->error);
		}
		return $result;
	}

	public static function closeDatabaseConnection()
	{
		if(self::$database==null)
		{
			return;
		}
		self::$database->close();
		self::$database = null;
	}
}

?>
<?php

require_once("BaseModel.php");

class User extends BaseModel
{
	public $id;
	public $username;
	public $password;
	public $date_created;

	public function __construct()
	{
		$this->id = null;
		$this->username = null;
		$this->password = null;
		$this->date_created = null;
	}

	public function initWithAssoc($row)
	{
		$this->id = $row["id"];
		$this->username = $row["username"];
		$this->password = $row["password"];
		$this->date_created = $row["date_created"];
		return $this;
	}

	public static function selectById($id)
	{
		if(!is_numeric($id))
		{
			return null;
		}
		$sql = "SELECT * FROM user WHERE id=".$id." LIMIT 1";
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$row = $result->fetch_assoc();
		if($row==null)
		{
			return null;
		}
		return (new User())->initWithAssoc($row);
	}

	public static function selectByUsername($username)
	{
		$sql = "SELECT * FROM user WHERE username=\"".BaseModel::getDatabaseHandle()->real_escape_string($username)."\" LIMIT 1";
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$row = $result->fetch_assoc();
		if($row==null)
		{
			return null;
		}
		return (new User())->initWithAssoc($row);
	}

	public static function selectAll()
	{
		$sql = "SELECT * FROM user";
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$users = array();
		while($row = $result->fetch_assoc())
		{
			array_push($users, (new User())->initWithAssoc($row));
		}
		return $users;
	}
}

?>
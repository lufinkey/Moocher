<?php

require_once("BaseModel.php");

class Tag extends BaseModel
{
	public $location_id;
	public $tag_name;

	public function __construct()
	{
		$this->location_id = null;
		$this->tag_name = null;
	}

	public function initWithAssoc($row)
	{
		$this->location_id = $row["location_id"];
		$this->tag_name = $row["tag_name"];
		return $this;
	}

	public static function selectByLocationId($location_id)
	{
		if(!is_numeric($location_id))
		{
			error_log("invalid input for Tag::selectByLocationId");
			return null;
		}
		$sql = "SELECT * FROM tag WHERE location_id=".$location_id;
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$tags = array();
		while($row = $result->fetch_assoc())
		{
			array_push($tags, (new Tag())->initWithAssoc($row));
		}
		return $tags;
	}

	public static function selectByTagName($tag_name)
	{
		$sql = "SELECT * FROM tag WHERE tag_name=\"".BaseModel::getDatabaseHandle()->real_escape_string($tag_name)."\"";
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			error_log("invalid input for Tag::selectByTagName");
			return null;
		}
		$tags = array();
		while($row = $result->fetch_assoc())
		{
			array_push($tags, (new Tag())->initWithAssoc($row));
		}
		return $tags;
	}
	
	public static function selectAll()
	{
		$sql = "SELECT * FROM tag";
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$tags = array();
		while($row = $result->fetch_assoc())
		{
			array_push($tags, (new Tag())->initWithAssoc($row));
		}
		return $tags;
	}
	
	public static function insert($location_id, $tag_name)
	{
		if(!is_numeric($location_id))
		{
			error_log("invalid input for Tag::insert");
			return false;
		}
		$sql = "INSERT INTO tag (location_id, tag_name) values(".$location_id.",\"".BaseModel::getDatabaseHandle()->real_escape_string($tag_name)."\")";
		return BaseModel::queryDatabase($sql);
	}
}

?>

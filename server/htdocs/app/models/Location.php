<?php

require_once("BaseModel.php");

class Location extends BaseModel
{
	public $id;
	public $user_id;
	public $longitude;
	public $latitude;
	public $time_created;
	public $expires;
	public $additional_instructions;

	public function __construct()
	{
		$this->id = null;
		$this->user_id = null;
		$this->longitude = null;
		$this->latitude = null;
		$this->time_created = null;
		$this->expires = null;
		$this->additional_instructions = null;
	}
	
	public function initWithAssoc($row)
	{
		$this->id = $row["id"];
		$this->user_id = $row["user_id"];
		$this->longitude = $row["longitude"];
		$this->latitude = $row["latitude"];
		$this->time_created = $row["time_created"];
		$this->expires = $row["expires"];
		$this->additional_instructions = $row["additional_instructions"];
		return $this;
	}
	
	public static function selectById($id)
	{
		if(!is_numeric($id))
		{
			error_log("invalid input for Location::selectById");
			return null;
		}
		$sql = "SELECT * FROM location WHERE id=".$id." LIMIT 1";
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
		return (new Location())->initWithAssoc($row);
	}

	public static function selectByUserId($user_id)
	{
		if(!is_numeric($user_id))
		{
			error_log("invalid input for Location::selectByUserId");
			return null;
		}
		$sql = "SELECT * FROM location WHERE user_id=".$user_id;
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$locations = array();
		while($row = $result->fetch_assoc())
		{
			array_push($locations, (new Location())->initWithAssoc($row));
		}
		return $locations;
	}

	public static function selectNear($longitude, $latitude, $radius=100000, $tag_filter=array())
	{
		if(!is_numeric($longitude) || !is_numeric($latitude) || !is_numeric($radius))
		{
			error_log("invalid input for Location::selectNear");
			return null;
		}
		if(!is_array($tag_filter))
		{
			if(is_string($tag_filter))
			{
				$tag_filter = array($tag_filter);
			}
			else
			{
				$tag_filter = array();
			}
		}
		$earth_radius=6378137; //radius in meters
		$lat_high = ($latitude+(($radius/$earth_radius)*180/pi()));
		$lat_low = ($latitude+(((-$radius)/$earth_radius)*180/pi()));
		$long_high = ($longitude+(($radius/($earth_radius*cos(pi()*$latitude/180)))*180/pi()));
		$long_low = ($longitude+(((-$radius)/($earth_radius*cos(pi()*$latitude/180)))*180/pi()));
		$tag_filter_count = count($tag_filter);
		$sql = "";
		if($tag_filter_count>0)
		{
			$sql = "SELECT location.* FROM location, tag WHERE latitude BETWEEN ".$lat_low." AND ".$lat_high." AND longitude BETWEEN ".$long_low." AND ".$long_high." AND expires > now() AND location.id=location_id AND (";
			$db = BaseModel::getDatabaseHandle();
			$counter = 0;
			$lastIndex = $tag_filter_count-1;
			foreach($tag_filter as $tag)
			{
				$sql .= "tag.tag_name=\"".$db->real_escape_string($tag)."\"";
				if($counter!=$lastIndex)
				{
					$sql .= " OR ";
				}
			}
			$sql .= ")";
		}
		else
		{
			$sql = "SELECT * FROM location WHERE latitude BETWEEN ".$lat_low." AND ".$lat_high." AND longitude BETWEEN ".$long_low." AND ".$long_high." AND expires > now()";
		}
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$locations = array();
		while($row = $result->fetch_assoc())
		{
			array_push($locations, (new Location())->initWithAssoc($row));
		}
		return $locations;
	}
	
	public static function selectAll()
	{
		$sql = "SELECT * FROM location WHERE expires > now()";
		$result = BaseModel::queryDatabase($sql);
		if($result==false)
		{
			return null;
		}
		$locations = array();
		while($row = $result->fetch_assoc())
		{
			array_push($locations, (new Location())->initWithAssoc($row));
		}
		return $locations;
	}

	public static function insert($user_id, $longitude, $latitude, $lifespan=120, $additional_instructions="")
	{
		if(!is_numeric($user_id) || !is_numeric($longitude) || !is_numeric($latitude) || !is_numeric($lifespan))
		{
			error_log("invalid input for Location::insert");
			return false;
		}
		$sql = "INSERT INTO location (user_id, longitude, latitude, time_created, expires, additional_instructions) ".
				"values(".$user_id.",".$longitude.",".$latitude.",now(),date_add(now(), interval ".$lifespan." minute),\"".BaseModel::getDatabaseHandle()->real_escape_string($additional_instructions)."\")";
		return BaseModel::queryDatabase($sql);
	}
}

?>

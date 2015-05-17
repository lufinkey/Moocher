<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

header('Content-Type: application/json');

function checkArraySet($array, $keys)
{
	$keys_count = count($keys);
	foreach($keys as $key)
	{
		if(!isset($array[$key]))
		{
			return false;
		}
	}
	return true;
}

if(checkArraySet($_REQUEST, array("username", "password", "longitude", "latitude")))
{
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$longitude = $_REQUEST["longitude"];
	$latitude = $_REQUEST["latitude"];
	$lifespan = 120; //minutes
	$tags = array();
	$additional_instructions = "";
	if(isset($_REQUEST["lifespan"]))
	{
		$lifespan = $_REQUEST["lifespan"];
		if(!is_numeric($lifespan))
		{
			echo "{\"error\":true, \"msg\":\"invalid input for lifespan\"}";
			exit_app();
		}
	}
	if(isset($_REQUEST["tags"]))
	{
		$tags_text = $_REQUEST["tags"];
		$tags = json_decode($tags_text);
		if($tags==null || !is_array($tags))
		{
			echo "{\"error\":true, \"msg\":\"invalid input for tags\"}";
			exit_app();
		}
	}
	if(isset($_REQUEST["additional_instructions"]))
	{
		$additional_instructions = $_REQUEST["additional_instructions"];
	}
	$user = User::selectByUsername($username);
	if($user==null)
	{
		echo "{\"error\":true, \"msg\":\"no user exists with that given name\"}";
		exit_app();
	}
	if($user->password != $password)
	{
		echo "{\"error\":true, \"msg\":\"incorrect password for user\"}";
		exit_app();
	}
	$result = Location::insert($user->id, $longitude, $latitude, $lifespan, $additional_instructions);
	$location_id = BaseModel::getDatabaseHandle()->insert_id;
	foreach($tags as $tag)
	{
		Tag::insert($location_id, $tag);
	}
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>

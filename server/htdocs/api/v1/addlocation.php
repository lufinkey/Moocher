<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

header('Content-Type: application/json');

function checkArraySet($array, $keys)
{
	$keys_count = count($keys);
	foreach($key in $keys)
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
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>
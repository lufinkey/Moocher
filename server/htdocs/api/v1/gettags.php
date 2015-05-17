<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

if(isset($_GET["location_id"]))
{
	$location_id = $_GET["location_id"];
	$tags = Tag::selectByLocationId($location_id);
	if(isset($tags))
	{
		echo json_encode($tags);
	}
}
else
{
	$tags = Tag::selectAll();
	if(isset($tags))
	{
		echo json_encode($tags);
	}
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>
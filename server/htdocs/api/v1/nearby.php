<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

header('Content-Type: application/json');

if(isset($_GET["longitude"]) && isset($_GET["latitude"]))
{
	$longitude = $_GET["longitude"];
	$latitude = $_GET["latitude"];
	$radius = 100000;
	if(isset($_GET["radius"]))
	{
		$radius = $_GET["radius"];
	}
	$locations = Location::selectNear($longitude, $latitude, $radius);
	if(isset($locations))
	{
		echo json_encode($locations);
	}
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>
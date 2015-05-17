<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

header('Content-Type: application/json');

if(isset($_GET["location_id"]))
{
	$location_id = $_GET["location_id"];
	$location = Location::selectById($location_id);
	if($location!=null)
	{
		echo json_encode($location);
	}
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

header('Content-Type: application/json');

if(isset($_GET["user_id"]))
{
	$user_id = $_GET["user_id"];
	$locations = Location::selectByUserId($user_id);
	if(isset($locations))
	{
		echo json_encode($locations);
	}
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>
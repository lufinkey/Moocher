<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

header('Content-Type: application/json');

if(isset($_REQUEST["username"]) && isset($_REQUEST["password"]))
{
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$user = User::selectByUsername($username);
	if($user!=null && $user->password==$password)
	{
		echo $user->id;
	}
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>
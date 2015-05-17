<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/begin.php");

header('Content-Type: application/json');

if(isset($_POST["username"]) && isset($_POST["password"]))
{
	$username = $_POST["username"];
	$password = $_POST["password"];
	$user = User::selectByUsername($username);
	if($user==null)
	{
		echo "false";
	}
	else if($user->password == $password)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}
}
else
{
	echo "false";
}

require_once($_SERVER['DOCUMENT_ROOT']."/app/includes/end.php");
?>
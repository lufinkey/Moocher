<?php

require_once($_SERVER['DOCUMENT_ROOT']."/app/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/app/models/BaseModel.php");

BaseModel::openDatabaseConnection($database_config["host"], $database_config["username"], $database_config["password"], $database_config["dbname"]);

require_once($_SERVER['DOCUMENT_ROOT']."/app/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/app/models/Location.php");
require_once($_SERVER['DOCUMENT_ROOT']."/app/models/Tag.php");

function exit_app($code=0)
{
	BaseModel::closeDatabaseConnection();
	exit($code);
}

?>
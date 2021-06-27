<?php
include 'module/class.php';
include 'module/database.php';

if (!$_COOKIE["login"] || !$_COOKIE["password"] || !$_COOKIE["hash"] || !User::getUser($database->connection, $_COOKIE["login"], $_COOKIE["password"]) ) {
	header("Location: /join");
}
if ($_COOKIE["login"] && $_COOKIE["password"] && $_COOKIE["hash"]) {
	if ( User::getUserHash($database->connection, $_COOKIE["login"], $_COOKIE["password"], $_COOKIE["hash"]) ) {
		header("Location: /diary");	
	}
}
?>
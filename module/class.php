<?php
class DB {
	public $connection;
	public function __construct($server, $login, $password, $dbname) {
		$this->connection = mysqli_connect($server, $login, $password, $dbname);
	}
}
class SQL {
	static function Query($connection, $query) {
		return mysqli_query($connection, $query);
	}
	static function Fetch($result) {
		return mysqli_fetch_assoc($result);
	}
}
class User {
	static function getUser($connection, $login, $password) {
		return SQL::Fetch(mysqli_query($connection, "SELECT * FROM `users` WHERE login = '$login' and password = '$password'"));
	}
	static function getUserHash($connection, $login, $password, $hash) {
		return SQL::Fetch(mysqli_query($connection, "SELECT * FROM `users` WHERE login = '$login' and password = '$password' and hash = '$hash'"));
	}
	static function getUserLogin($connection, $login) {
		return SQL::Fetch(mysqli_query($connection, "SELECT * FROM `users` WHERE login = '$login'"));
	}
	static function Add($connection, $login, $password) {
		$password = sha1($password);
		return mysqli_query($connection, "INSERT INTO users ( login, password ) VALUES ( '$login', '$password' )");
	}
	static function setHash($connection, $login) {
		$hash = sha1(rand(100000000000000, 999999999999999));
		mysqli_query($connection, "UPDATE users SET hash = '$hash' WHERE login = '$login'");
		return $hash;
	}
}
?>
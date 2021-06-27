<?php
include '../module/class.php';
include '../module/database.php';

$file = $_FILES['path'];

$userId = User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['id'];
$userAvatar = User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['avatar'];

if ( $file ) {
	$fileName = $file['name'];
	$newName = rand(100, 100000) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
	$fullPath = "files/avatars/" . $newName;
	if ( move_uploaded_file($file['tmp_name'], '../' . $fullPath) ) {
		if ( $userAvatar != null ) {
			unlink('../' . $userAvatar);
		}
		SQL::Query($database->connection, "UPDATE users SET avatar = '$fullPath' WHERE id = '$userId'");
		header('Location: /avatar/succesful');
	}
	else {
		header('Location: /avatar/error');
	}
}
?>
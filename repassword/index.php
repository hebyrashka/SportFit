<?php
include '../module/class.php';
include '../module/database.php';

$redirectError = false;

$redirectSuccesful = false;
?>
<?php
if ( $_POST['password-past'] && $_POST['password-new'] && $_POST['password-new-again'] && $_COOKIE['login'] && $_COOKIE['password'] && $_COOKIE['hash'] ) {
	$pastPassword = sha1($_POST['password-past']);
	$newPassword = sha1($_POST['password-new']);
	$newAgainPassword = sha1($_POST['password-new-again']);
	$user = User::getUserHash($database->connection, $_COOKIE['login'], $_COOKIE['password'], $_COOKIE['hash']);
	$idUser = $user['id'];
	if (  $user['password'] == $pastPassword && $newPassword == $newAgainPassword ) {
		SQL::Query( $database->connection, "UPDATE users SET password = '$newPassword' WHERE id = '$idUser'" );
		header("Location: /repassword/succesful");
	}
	else {
		header("Location: /repassword/error");
	}
}
?>
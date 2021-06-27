<?php 
include 'module/class.php';
include 'module/database.php';

$PAGE_NAME = "Вход";

if ($_COOKIE['login'] && $_COOKIE['password'] && $_COOKIE['hash']) {
	if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password']) ) {
		if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['hash'] == $_COOKIE['hash'] ) {
			header("Location: index");
		}
	}
}

if ( $_POST['login-join'] && $_POST['password-join'] ) {
	$password = sha1($_POST['password-join']);
	if ( User::getUser($database->connection, $_POST['login-join'], $password)) {
		$hash = User::setHash($database->connection, $_POST['login-join']);
		setcookie("login", $_POST['login-join']);
		setcookie("password", $password);
		setcookie("hash", $hash);
		header("Location: index");
	}
}
include 'header.php';
?>
<div id="join">
	<h2 id="title-join">Вход</h2>
	<form method="post" id="form-join">
		<input name="login-join" class="input-join" id="input-join-login" placeholder="Логин">
		<input type="password" name="password-join" class="input-join" id="input-join-password" placeholder="Пароль">
		<?php 
		if ( $_POST['login-join'] && $_POST['password-join'] ) {
			if ( !User::getUser($database->connection, $_POST['login-join'], $_POST['password-join'])) {
				echo "<p id='warning'>Неверный логин или пароль</p>";
			}
		}
		?>
		<button class='button-join'>Войти</button>
	</form>
</div>
<?php 
include 'footer.php';
?>
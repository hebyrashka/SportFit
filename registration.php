<?php 
include 'module/class.php';
include 'module/database.php';

$PAGE_NAME = "Регистрация";

if ($_COOKIE['login'] && $_COOKIE['password'] && $_COOKIE['hash']) {
	if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password']) ) {
		if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['hash'] == $_COOKIE['hash'] ) {
			header("Location: index");
		}
	}
}

include 'header.php';
?>
<div id='registration'>
	<h2 id='title-registration'>Регистрация</h2>
	<form method="post" id='form-registration'>
		<input class='input-join' name="input-registration-login" id='input-registrarion-login' placeholder='Логин'>
		<input type="password" class='input-join' name="input-registration-password" id='input-registrarion-password' placeholder='Пароль'>
		<input type="password" class='input-join' name="input-registration-again-password" id='input-registrarion-again-password' placeholder='Подтвердите пароль'>
		<?php 
		if ( $_POST['input-registration-login'] && $_POST['input-registration-password'] && $_POST['input-registration-again-password'] ) {
			if ( User::getUserLogin($database->connection, $_POST['input-registration-login']) ) {
				echo "<p id='warning'>Такой логин уже существует</p>";
			}
			if ($_POST['input-registration-password'] != $_POST['input-registration-again-password']) {
				echo "<p id='warning'>Пароли не совпадают</p>";
			}
			if ( !User::getUserLogin($database->connection, $_POST['input-registration-login']) && $_POST['input-registration-password'] == $_POST['input-registration-again-password'] ) {
				User::Add($database->connection, $_POST['input-registration-login'], $_POST['input-registration-password']);
				echo "<p id='succesful'>Вы успешно зарегистрировались</p>";
			}
		}
		?>
		<button class='button-registrarion'>Зарегистрироваться</button>
	</form>
</div>
<?php 
include 'footer.php';
?>
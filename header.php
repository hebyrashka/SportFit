<?php 
include 'config.php';

$userAvatar = User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['avatar'];

$srcAvatar;

if ( $userAvatar != null ) {
	$srcAvatar = $userAvatar;
}
if ( $userAvatar == null || !file_exists($userAvatar) ) {
	$srcAvatar = 'files/defult/avatar.jpg';
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="shortcut icon" href="img/shortcut icon.png" type="image/png">
	<meta charset="utf-8">
	<title><?php echo $PAGE_NAME; ?></title>
</head>
<body>
	<div id="header">
		<div id="header-left-side">
		
		</div>
		<div id="header-right-side">
			<?php 
				if ($_COOKIE['login'] && $_COOKIE['password'] && $_COOKIE['hash']) {
					if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password']) ) {
						if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['hash'] == $_COOKIE['hash'] ) {
							echo "<div id='with-join'>
									<p id='nick'>" . User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['login'] . "</p>
									<div>
										<a id='exit' href='exit.php'>X</a>
										<img id='avatar' src='" . $srcAvatar . "'>
									</div>
								</div>";
						}
					}
				}
				if (!$_COOKIE['login'] || !$_COOKIE['password'] || !$_COOKIE['hash'] || !User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password']) ||  User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['hash'] != $_COOKIE['hash']) {
					echo "<div id='without-join'>
								<a class='link-join' id='link-registration' href='/registration'>Регистрация</a>
								<a class='link-join' id='link-join' href='/join'>Вход</a>
						</div>";
				}
			?>
		</div>
	</div>
	<?php 
		if ( $_GET['succesful'] ) {
			include 'succesful.php';
		}
	?>
	<div id="modal-profile-background">
		<div id="modal-profile-window">
			<?php 
			if ($_COOKIE['login'] && $_COOKIE['password'] && $_COOKIE['hash']) {
					if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password']) ) {
						if ( User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['hash'] == $_COOKIE['hash'] ) {
							echo "<div id='modal-profile-header'>
					<div id='modal-profile-header-left-side'>
						<h2 id='h2-header-title'>МОЙ ПРОФИЛЬ</h2>
					</div>
					<div id='modal-profile-header-right-side'>
						<p id='p-exit-button-profile'>X</p>
					</div>
				</div>
				<div id='modal-profile-content'>
					<div id='modal-profile-content-password-avatar'>
						<div id='modal-profile-avatar'>
							<form action='avatar/index' method='post' enctype='multipart/form-data'>
								<label>
									<input onchange='readFile(this)' accept='image/*' name='path' id='choose-avatar' type='file'>
									<img id='preview-avatar' src='" . $srcAvatar . "'>
								</label>
								<button id='button-change-avatar'>СМЕНИТЬ</button>
							</form>
						</div>
						<div id='modal-profile-password'>
							<form action='/repassword/index' method='post'>
								<input name='password-past' class='input-form-profile' placeholder='СТАРЫЙ ПАРОЛЬ'>
								<input name='password-new' class='input-form-profile' placeholder='НОВЫЙ ПАРОЛЬ'>
								<input name='password-new-again' class='input-form-profile' placeholder='ПОВТОРИТЕ ПАРОЛЬ'>
								<button id='button-change-password'>СМЕНИТЬ</button>
							</form>
						</div>
					</div>
				</div>";
					}
				}
			}
			if (!$_COOKIE['login'] || !$_COOKIE['password'] || !$_COOKIE['hash'] || !User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password']) ||  User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password'])['hash'] != $_COOKIE['hash']) {
				echo "<p id='warning-not-join'>Без входа</p>";
			}
			?>
				
		</div>
	</div>
	<img id="preview" src="">
	<script type="text/javascript">
		document.getElementById('p-exit-button-profile').onclick = function() {
			document.getElementById('modal-profile-background').style.display = "none";
		};
		document.getElementById('avatar').onclick = function() {
			document.getElementById('modal-profile-background').style.display = "block";
		};
		function readFile(input) {
			let file = input.files[0];

			let reader = new FileReader();
 
    		var fileReader = new FileReader();

    		fileReader.readAsDataURL(file);
 
    		fileReader.onload = function() {
        		var url = fileReader.result;

        		console.log(url);

        		var myImg = document.getElementById("preview-avatar");

        		myImg.src = url;
    		}
		}
	</script>
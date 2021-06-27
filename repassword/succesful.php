<?php 
$PAGE_NAME = "Успешно";
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="shortcut icon" href="../img/shortcut icon.png" type="image/png">
	<meta charset="utf-8">
	<title><?php echo $PAGE_NAME; ?></title>
</head>
<body>
	<div id="repassword-succesful">
		<p id="p--succesful">Пароль был успешно сменён</p>
		<nobr><p id="p--back">Выбудете переведены обратно через <span id="second"></span> сек. Если вы не были переведены автоматически то <a id="a--back" href="/"> нажмите сюда</a></p></nobr>
	</div>
	<style type="text/css">
		#repassword-succesful {
			font-family: sans-serif;
			text-align: center;
			font-size: 19px;
		}
		#p--succesful {
			margin-bottom: 5px;
		}
		#a--back {
			color: green;
		}
		#a--back:hover {
			text-decoration: none;
		}
	</style>
	<script type="text/javascript">
		let secondToRedirect = 3;
		document.getElementById('second').innerHTML = secondToRedirect;

		setInterval(function() {
			if ( secondToRedirect == 0 ) {
				document.location.href = 'http://sportfit/diary';
				secondToRedirect = -1;
			}
			if ( secondToRedirect > 0 ) {
				secondToRedirect--;
				document.getElementById('second').innerHTML = secondToRedirect;
			}
		}, 1000);
	</script>
</body>
</html>
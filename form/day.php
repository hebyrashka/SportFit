<?php 
include '../module/class.php';
include '../module/database.php';

$login = $_COOKIE['login'];
$password = $_COOKIE['password'];

$idUser = User::getUser($database->connection, $login, $password)['id'];

$formFoodName = $_POST['name-food-form'];
$formKcal = $_POST['kcal-form'];
$formDate = $_POST['date-form'];
if ( $formFoodName != null && $formKcal != null && $formDate != null ) {
	SQL::Query( $database->connection, "INSERT INTO calories (user, food, summa, dateDay) VALUES ('$idUser', '$formFoodName', '$formKcal', '$formDate')" );
	header('Location: /diary');
}
else {
	header('Location: /diary');
}

?>
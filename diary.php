<?php 
include 'module/class.php';
include 'module/database.php';

if (!$_COOKIE['login'] || !$_COOKIE['password'] || !$_COOKIE['hash'] || !User::getUser($database->connection, $_COOKIE['login'], $_COOKIE['password']) ) {
	header("Location: /join");
}
	
$RANDOMKEY = md5(rand(10000000, 999999999));

$PAGE_NAME = "Дневник питания";

$login = $_COOKIE['login'];
$password = $_COOKIE['password'];

$idUser = User::getUser($database->connection, $login, $password)['id'];

include 'header.php';
?>
<div id="modal-add-background">
	<div id="modal-add-window">
		<div id="modal-add-header">
			<div id="modal-add-header-left-side">
				<h2 id="h2-header-title">ДОБАВИТЬ</h2>
			</div>
			<div id="modal-add-header-right-side">
				<p id="p-exit-button">X</p>
			</div>
		</div>
		<div id="modal-add-content">
			<form action="form/day" method="post" id="form-add">
				<input name="name-food-form" placeholder="НАЗВАНИЕ БЛЮДА" class="input-form-add">
				<input name="kcal-form" placeholder="ККАЛ" class="input-form-add">
				<input name="date-form" class="input-form-add" type="date">
			</form>
		</div>
		<div id="modal-add-footer">
			<button id="button-form-add" form="form-add">ДОБАВИТЬ</button>
		</div>
	</div>
</div>
<div id="content-diary">
	<div id="select-day">
		<div id="select-day-content">
			<?php
			$daysQuery = SQL::Query($database->connection, "SELECT * FROM `calories` WHERE user = '$idUser' ORDER BY dateDay");
			$beDaysQuery = SQL::Query($database->connection, "SELECT * FROM `calories` WHERE user = '$idUser' ORDER BY dateDay");
			$beDaysFetch = SQL::Fetch($beDaysQuery);
			$daysDateBe = array();
			$noneDays = false;
			while ( $daysFetch = SQL::Fetch($daysQuery) ) {
				$continued = true;
				for ($i=0; $i < count($daysDateBe); $i++) { 
					if ( $daysFetch['dateDay'] ==  $daysDateBe[$i] ) {
						$continued = false;
					}
				}
				if ( $continued == true ) {
					$dateKcal = $daysFetch['dateDay'];
					$kcalQuery = SQL::Query($database->connection, "SELECT * FROM `calories` WHERE dateDay = '$dateKcal' AND user = '$idUser'");
					$kcal = 0;
					while ( $kcalFetch = SQL::Fetch($kcalQuery) ) {
						$kcal += $kcalFetch['summa'];
					}
					echo "<a class='days' href='?dateDay=" . $dateKcal . "'><p class='days--date-p'>" . $daysFetch['dateDay'] . "</p><p class='days--kcal-p'>" . $kcal . "</p></a>";
					array_push($daysDateBe, $daysFetch['dateDay']);
					$kcal = 0;
				}
			}
			$daysDateBe = array();
			?>
			<button id="button-add-days" class="days" href="">ДОБАВИТЬ</button>
		</div>
		<div id="margin-scroll"></div>
	</div>
	<div id="kcal-table">
		<table id="table--kcal">
			<?php
			$getDay = $_GET['dateDay'];
			if ( $getDay ) {
				$tableDay = SQL::Query( $database->connection, "SELECT * FROM `calories` WHERE dateDay = '$getDay' AND user = '$idUser'" );
				echo "<tr id='tr--header'>
						<th id='th-name'>Название блюда</th>
						<th id='th-kcal'>Калории</th>
					</tr>";
				while ( $tableDayFetch = SQL::Fetch($tableDay) ) {
					echo "<tr class='tr--show'>
							<td>" . $tableDayFetch['food'] . "</td>
							<td class='td--kcal'>" . $tableDayFetch['summa'] . "</td>
						</tr>";
				}
				$totalKcalQuery = SQL::Query( $database->connection, "SELECT summa FROM `calories` WHERE dateDay = '$getDay' AND user = '$idUser'" );
				$totalKcal = 0;
				while ( $totalKcalFetch = SQL::Fetch( $totalKcalQuery ) ) {
					$totalKcal += $totalKcalFetch['summa'];
				}
				echo "<tr class='tr--show'>
				<td></td>
				<td class='td--kcal'>
					Итого: " . $totalKcal . ' ккал' . "</td>
			</tr>";
			}
			if ( !$_GET['dateDay'] && $beDaysFetch ) {
				echo "<h2 id='h2-day-not-select'>День не выбран</h2>";
			}
			if ( !$_GET['dateDay'] && !$beDaysFetch ) {
				echo "<h2 id='h2-day-not-select'>Нету дней</h2>";
			}
			?>
		</table>
	</div>
</div>
<script type="text/javascript">
	document.getElementById('p-exit-button').onclick = function() {
		document.getElementById('modal-add-background').style.display = "none";
	};
	document.getElementById('button-add-days').onclick = function() {
		document.getElementById('modal-add-background').style.display = "flex";
	}
</script>
<?php 
include 'footer.php';
?>

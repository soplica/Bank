<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['zalogowano'])) header('Location: index.php');
//unset($_SESSION['zalogowano']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Historia przelewów</title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div id="main">
	<div id="header">
		<?php
		echo "Witaj ".$_SESSION['imie']."!";
		?>
	</div>
	<div id="historia">
		<?php
		$polaczenie = new mysqli($db_host,$db_user,$db_pass,$db_name);
		
		$nr_konta = $_SESSION['nr_konta'];
		$zapytanie = $polaczenie->query("SELECT * FROM transakcje WHERE konto_odb = $nr_konta OR konto_nad = $nr_konta ORDER BY data_transakcji DESC");
		$ilosc_wynikow = $zapytanie->num_rows;
		
		echo '<table border="1px"><tr><td width="40px">ID</td>	<td width="80px">Data</td>	<td width="70px">Kwota</td><td width="50px">Waluta</td>	<td width="70px">Saldo przed transakcją</td>		<td width="70px">Saldo po transakcji</td>		<td width="70px">Nadawca</td>	<td width="70px">Odbiorca</td>	<td width="70px">Typ</td></tr></br>';
		
		for($i=0; $i<$ilosc_wynikow; $i++)
		{
		$dane = $zapytanie->fetch_assoc();
		
		$id_transakcji = $dane['id_transakcji'];
		$data_transakcji = $dane['data_transakcji'];
		$kwota_transakcji = $dane['kwota_transakcji'];
		$waluta = $dane['waluta'];
		$saldo_odb_przed = $dane['saldo_odb_przed'];
		$saldo_odb_po = $dane['saldo_odb_po'];
		$saldo_nad_przed = $dane['saldo_nad_przed'];
		$saldo_nad_po = $dane['saldo_nad_po'];
		$konto_odb = $dane['konto_odb'];
		$konto_nad = $dane['konto_nad'];
		
			if($konto_nad == $nr_konta)
			{
			
				echo "<tr><td>$id_transakcji</td><td>$data_transakcji</td><td>$kwota_transakcji</td><td>$waluta</td><td>$saldo_nad_przed</td><td>$saldo_nad_po</td><td>$konto_nad</td><td>$konto_odb</td><td>Wychodzące</td></tr>";
			}
			
			if($konto_odb == $nr_konta)
			{
				echo "<tr><td>$id_transakcji</td><td>$data_transakcji</td><td>$kwota_transakcji</td><td>$waluta</td><td>$saldo_odb_przed</td><td>$saldo_odb_po</td><td>$konto_nad</td><td>$konto_odb</td><td>Przychodzące</td></tr>";
				
			}
		}
		echo "</table>";
		?>
		<form action = "delete.php" method="post">
		<input type="submit" onclick="return confirm('Usunąć historię?');" value="Usuń historię" name="przelewy"/>
		</form>
	</div>
</div>
</body>
</html>
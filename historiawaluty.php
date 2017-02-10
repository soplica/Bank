<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['zalogowano'])) header('Location: index.php');
//unset($_SESSION['zalogowano']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Historia transakcji walutowych</title>
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
		
		$id_klienta = $_SESSION['idklienta'];
		$zapytanie = $polaczenie->query("SELECT * FROM transakcje_walutowe WHERE idklienta = $id_klienta ORDER BY data DESC");
		$ilosc_wynikow = $zapytanie->num_rows;
		
		echo '<table><tr style="background-color: #f7d2d5"><td width="40px">ID</td>	<td width="80px">Data</td>	<td width="70px">Kwota</td>	<td width="70px">Saldo PLN przed transakcją</td>		<td width="70px">Saldo PLN po transakcji</td>		<td width="70px">Saldo EUR przed transakcją</td>	<td width="70px">Saldo EUR po transakcji</td>	<td width="70px">Kurs EUR</td><td width="80px">Typ</td></tr></br>';
		
		for($i=0; $i<$ilosc_wynikow; $i++)
		{
		$dane = $zapytanie->fetch_assoc();
		
		$id_transakcji = $dane['ID'];
		$data_transakcji = $dane['data'];
		$kwota = $dane['kwota'];
		$saldo_pln_przed = $dane['saldo_pln_przed'];
		$saldo_pln_po = $dane['saldo_pln_po'];
		$saldo_euro_przed = $dane['saldo_euro_przed'];
		$saldo_euro_po = $dane['saldo_euro_po'];
		$kurs = $dane['kurs_euro'];
		
		if($id_transakcji%2==0) $color = '#ede8f4';
		else $color = '#f7f7f7';
		
		
			if($saldo_pln_przed>$saldo_pln_po)
			{
			
				echo "<tr style=\"background-color:".$color.";\"><td>$id_transakcji</td><td>$data_transakcji</td><td>$kwota PLN</td><td>$saldo_pln_przed</td><td>$saldo_pln_po</td><td>$saldo_euro_przed</td><td>$saldo_euro_po</td><td>$kurs</td><td>PLN->EUR</td></tr>";
			}
			
			if($saldo_pln_przed<$saldo_pln_po)
			{
				echo "<tr style=\"background-color:".$color.";\"><td>$id_transakcji</td><td>$data_transakcji</td><td>$kwota EUR</td><td>$saldo_pln_przed</td><td>$saldo_pln_po</td><td>$saldo_euro_przed</td><td>$saldo_euro_po</td><td>$kurs</td><td>EUR->PLN</td></tr>";
				
			}
		}
		echo "</table>";
		
		
		?>
		<form action = "delete.php" method="post">
		<input type="submit" onclick="return confirm('Usunąć historię?');" value="Usuń historię" name="waluty"/>
		</form>
	</div>
</div>
</body>
</html>
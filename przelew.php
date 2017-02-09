<?php
session_start();
if(!isset($_SESSION['zalogowano'])) header('Location: index.php');
//unset($_SESSION['zalogowano']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Wykonaj przelew</title>
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
	<div id="lewa">
		<?php
		echo "Numer konta: ".$_SESSION['nr_konta']."</br>";
		echo "Imię: ".$_SESSION['imie']."</br>";
		echo "Nazwisko: ".$_SESSION['nazwisko']."</br>";
		echo "Stan konta: ".$_SESSION['stan_konta']."PLN</br></br>";
		echo "Stan konta EURO: ".$_SESSION['stan_konta_euro']."</br>";
		echo '<a href="przewalutuj.php">Przewalutuj!</a>'."</br></br>";
		echo '<a href="wyloguj.php">Wyloguj się!</a></br>';
		echo '<a href="historia.php">Zobacz historię transakcji!</a>';
		?>
	</div>
	<div id="prawa">
		Przelew</br>
		<form action = "przelewanie.php" method="post">
			Numer konta: <input type="text" name="odb_nr"/></br>
			Imię:		 <input type="text" name="odb_imie"/></br>
			Nazwisko:	 <input type="text" name="odb_nazwisko"/></br>
			Kwota: 	 <input type="text" name="kwota"/><br>
			PLN <input type="radio" name="typ_przelewu" value="pln"/>
			EURO <input type="radio" name="typ_przelewu" value="eur"/>
			<input type="submit" value="Wykonaj!"/></br>
		</form>
		<?php
		if(isset($_SESSION['niepop_dane']))
		{
			echo $_SESSION['niepop_dane'];
			unset($_SESSION['niepop_dane']);
		}
		if(isset($_SESSION['niepop_kwota']))
		{
			echo $_SESSION['niepop_kwota'];
			unset($_SESSION['niepop_kwota']);
		}
		if(isset($_SESSION['brak_srodkow']))
		{
			echo $_SESSION['brak_srodkow'];
			unset($_SESSION['brak_srodkow']);
		}
		if(isset($_SESSION['niewybrany_typ']))
		{
			echo $_SESSION['niewybrany_typ'];
			unset($_SESSION['niewybrany_typ']);
		}
		?>
	</div>
	
</div>

</body>
</html>
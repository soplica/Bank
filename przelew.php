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
	<div class="lewa">
		<?php
		echo '<div class="dane">Pan(i) </div>';
		echo '<div class="dane_l">'.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'</div></br>';
		echo '<div style="clear: both;"></div>';
		
		echo '<div class="dane">numer </div>';
		echo '<div class="dane_l">'.$_SESSION['nr_konta']."</div></br>";
		echo '<div style="clear: both;"></div>';
		
			if(isset($_SESSION['nowy_stan'])) $_SESSION['stan_konta'] = $_SESSION['nowy_stan'];
		
		echo '<div class="dane">stan </div>';
		echo '<div class="dane_l">'.$_SESSION['stan_konta'].'</div>';
		echo '<div class="dane">PLN oraz </div>';
		
			if(isset($_SESSION['nowy_stan_euro'])) $_SESSION['stan_konta_euro'] = $_SESSION['nowy_stan_euro'];
		echo '<div class="dane_l">'.$_SESSION['stan_konta_euro'].'</div>';
		echo '<div class="dane">EUR</div>';
		echo '<div style="clear: both;"></div>';

		echo '<br><a href="wyloguj.php">Wyloguj</a></br>';
		?>
	</div>
	<div class="prawa">
		<div class="wew_napis_l">Przelew</div><br>
		<div style="clear: both;"></div>
		<form id="przelew" action = "przelewanie.php" method="post">
			Numer konta odbiorcy:<br> <input type="text" name="odb_nr"/></br>
			Imię:<br><input type="text" name="odb_imie"/></br>
			Nazwisko:<br><input type="text" name="odb_nazwisko"/></br>
			Kwota: <br><input type="text" name="kwota"/><br>
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
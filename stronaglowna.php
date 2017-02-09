<?php
session_start();
if(!isset($_SESSION['zalogowano'])) header('Location: index.php');
//unset($_SESSION['zalogowano']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Twoje konto</title>
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
		<a href="przelew.php">
			<div class="przycisk">
			WYKONAJ PRZELEW
			</div>
		</a>
		<a href="przewalutuj.php">
			<div class="przycisk">
			PRZEWALUTUJ
			</div>
		</a>
		<div style="clear: both;"></div>
		<a href="historia.php">
		<div class="przycisk">Historia przelewu</div>
		</a>
		<a href="historiawaluty.php">
		<div class="przycisk">Historia waluty</div>
		</a>
		<div style="clear:both;"></div>
		<div class="potwierdzenie">
		<?php
			if(isset($_SESSION['przelew_wykonany']))
			{
				echo "Przelew wykonany!";
				unset($_SESSION['przelew_wykonany']);
			}
			
			if(isset($_SESSION['przewalutowano'])) 
			{
				echo $_SESSION['przewalutowano']."</br></br>";
				unset ($_SESSION['przewalutowano']);
			}
		?>
		</div>
	</div>
	
</div>

</body>
</html>
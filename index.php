<?php 
session_start();
if(isset($_SESSION['zalogowano'])) header("Location: stronaglowna.php");
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>SUPER BANK</title>
	<meta charset="utf8"/>
	<meta name="description" content="test test test test test test test test test test test"/>
	<meta name="keywords" content="test, testy"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	
	<script type="text/javascript">
		function oblicz()
			{
				var kwota = parseFloat(document.getElementById("kwota").value);
				var procent = parseInt(document.getElementById("procent").value);
				if((kwota<=0) || (procent<0)) document.getElementById("wynik").innerHTML=("Niepoprawne dane!");
				else
				{
				var wynik = kwota+kwota*(procent*0.01);
				document.getElementById("wynik").innerHTML = ("Wysokość spłaty wynosi: "+wynik+"zł.");
				}
			}
	</script>
</head>
<body>
<div id="main">
	<div style="text align: center;">
		<h1>* SUPER BANK V.1.01 *	</h1>
	</div>
	<div class="lewa">
		<div class="wew_napis_l">Logowanie</div>
		<div class="wew_napis_r">	<a href="rejestracja.php">Dołącz do nas!</a></div>
		<div style="clear: both;"></div>
		<form action="logowanie.php" method="post">
			Numer konta:<br> <input type = "text" name="nr" placeholder="Podaj nr konta"/><br />
			Hasło: <br> <input type = "password" name="haslo" placeholder="Podaj hasło"/><br />
			<input type="submit" value="Zaloguj!"/>
		</form>
		<?php
		if(isset($_SESSION['nie_zalogowano']))
			{
				echo '<span style="color: red;">Niepoprawne dane logowania!</span>';
				unset($_SESSION['nie_zalogowano']);
			}
		?>
	</div>
	<div class="prawa">
		<div class="wew_napis_l">Kalkulator pożyczki</div>
		<div style="clear: both;"></div>
		Kwota <br> <input type="text" id="kwota" placeholder="PLN"/><br />
		Oprocentowanie <br> <input type="text" id="procent" placeholder="%"/><br />
		<input type="submit" value="Policz!" onclick="oblicz()"/>
	<div id="wynik"></div>
	</div>
	<div style="clear: both;"></div>
	<div id="footer">
	Wszelkie prawa zastrzeżone &copy 2017
	</div>
</div>
</body>
</html>
<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>SUPER BANK</title>
	<meta charset="utf8"/>
	<meta name="description" content="test test test test test test test test test test test"/>
	<meta name="keywords" content="test, testy"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body style="background-color: white;">
	<div id="window">
		<form action="rejestrowanie.php" method="post"><br>
			Imię: <br><input type="text" name="imie" placeholder="2-25 znaków"/><br>
			<?php
			if(isset($_SESSION['niep_imie'])) 
			{
				echo $_SESSION['niep_imie'];
				unset($_SESSION['niep_imie']);
			}
			?>
			Nazwisko: <br><input type="text" name="nazwisko" placeholder="2-25 znaków"/><br>
			<?php
			if(isset($_SESSION['niep_nazwisko'])) 
			{
				echo $_SESSION['niep_nazwisko'];
				unset($_SESSION['niep_nazwisko']);
			}
			?>
			E-mail: <br><input type="text" name="email"placeholder="example@domain.com"/><br>
			<?php
			if(isset($_SESSION['niep_email'])) 
			{
				echo $_SESSION['niep_email'];
				unset($_SESSION['niep_email']);
			}
			if(isset($_SESSION['istnieje_email'])) 
			{
				echo $_SESSION['istnieje_email'];
				unset($_SESSION['istnieje_email']);
			}
			?>
			Hasło: <br><input type="password" name="haslo1" placeholder="••••••••"/><br>
			Powtórz hasło: <br><input type="password" name="haslo2" placeholder="••••••••"/><br>
			<?php
			if(isset($_SESSION['niep_haslo'])) 
			{
				echo $_SESSION['niep_haslo'];
				unset($_SESSION['niep_haslo']);
			}
			if(isset($_SESSION['niep_hasla']))
			{
				echo $_SESSION['niep_hasla'];
				unset($_SESSION['niep_hasla']);
			}
			?>
			
			Akceptuję <a href="regulamin.html">regulamin</a><input type="checkbox" name="reg"/><br>
			<?php
			if(isset($_SESSION['niep_reg'])) 
			{
				echo $_SESSION['niep_reg'];
				unset($_SESSION['niep_reg']);
			}
			?>
			<input type="submit" value="ZAREJESTRUJ"/>
		</form>
	</div>
</body>
</html>
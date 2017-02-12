<?php
session_start();
require_once "connect.php";
//mysqli_query($polaczenie, "SET CHARSET utf8");
//mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
$email = $_POST['email'];
$haslo = $_POST['haslo'];

$polaczenie = @new mysqli($db_host,$db_user,$db_pass,$db_name);
mysqli_query($polaczenie, "SET CHARSET utf8");
mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

if($polaczenie->connect_errno!=0)
	{
		echo "ERROR ".$polaczenie->connect_errno;
	}
else
	{
		$rezultat = $polaczenie->query("SELECT * FROM klienci WHERE email='$email' AND haslo='$haslo'");
		if($rezultat->num_rows > 0)
			{
				$wynik = $rezultat->fetch_assoc();
				$_SESSION['idklienta'] = $wynik['idklienta'];
				$_SESSION['imie'] = $wynik['imie'];
				$_SESSION['nazwisko'] = $wynik['nazwisko'];
				$_SESSION['stan_konta'] = $wynik['stan_konta'];
				$_SESSION['nr_konta'] = $wynik['nr_konta'];
				$_SESSION['stan_konta_euro'] = $wynik['stan_konta_euro'];
				$_SESSION['zalogowano'] = true;
				//echo $imie;
				header("Location: stronaglowna.php");
			}
		else
			{
				$_SESSION['nie_zalogowano'] = true;
				header("Location: index.php");
			}
		
		
		$polaczenie->close();
	}


?>
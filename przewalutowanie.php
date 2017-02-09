<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($db_host,$db_user,$db_pass,$db_name);
if($polaczenie->connect_errno!=0)
{
	echo "ERROR ".$polaczenie->connect_errno;
}
else
{
	$dataczas = new DateTime();
	$data = $dataczas->format('Y-m-d H:i:s');
	if(isset($_POST['typ_przewalutowania']))
	{
		$typ = $_POST['typ_przewalutowania'];
	
	
		if($typ == "pte")
		{
			$kwota = $_POST['kwota'];
			$idklienta = $_SESSION['idklienta'];
			if($kwota<=0)
			{
				$_SESSION['zla_kwota_e'] = '<span style="color: red;">Nieprawidłowa kwota!</span>';
				header ("Location: przewalutuj.php");
			}
			else
			{
				if($kwota>$_SESSION['stan_konta'])
				{
					$_SESSION['brak_srodkow_e'] = '<span style="color: red;">Brak srodków na koncie!</span>';
					header ("Location: przewalutuj.php");
				}
				else
				{
					$stan_konta = $_SESSION['stan_konta'];
					$stan_konta_euro = $_SESSION['stan_konta_euro'];
					$euro = round($_SESSION['euro'],2,PHP_ROUND_HALF_DOWN);
					$dodaj_euro = round($kwota/$euro,2,PHP_ROUND_HALF_DOWN);

					$przewalutowanie = $polaczenie->query("UPDATE klienci SET stan_konta_euro=stan_konta_euro+$dodaj_euro WHERE idklienta=$idklienta");
					$przewalutowanie = $polaczenie->query("UPDATE klienci SET stan_konta=stan_konta-$kwota WHERE idklienta=$idklienta");
					
					$nowy_stan = $polaczenie->query("SELECT * FROM klienci WHERE idklienta=$idklienta");
					$nowy_rezultat = $nowy_stan->fetch_assoc();
					$nowy_stan = $nowy_rezultat['stan_konta'];
					$nowy_stan_euro = $nowy_rezultat['stan_konta_euro'];
					$_SESSION['nowy_stan'] = $nowy_stan;
					$_SESSION['nowy_stan_euro'] = $nowy_stan_euro;
					
					$log = $polaczenie->query("INSERT INTO transakcje_walutowe VALUES('','$data','$kwota','$stan_konta','$nowy_stan','$stan_konta_euro','$nowy_stan_euro','$euro','$idklienta')");
					
					$_SESSION['przewalutowano'] = '<span style="color: green">Przewalutowano!</span>';
					$polaczenie->close();
					header ("Location: stronaglowna.php");
				}
			}
		}
		
		if($typ == "etp")
		{
			$kwota = $_POST['kwota'];
			$idklienta = $_SESSION['idklienta'];
			if($kwota<=0)
			{
				$_SESSION['zla_kwota_e'] = '<span style="color: red;">Nieprawidłowa kwota!</span>';
				header ("Location: przewalutuj.php");
			}
			else
			{
				if($kwota>$_SESSION['stan_konta_euro'])
				{
					$_SESSION['brak_srodkow_e'] = '<span style="color: red;">Brak srodków na koncie!</span>';
					header ("Location: przewalutuj.php");
				}
				else
				{
					$stan_konta = $_SESSION['stan_konta'];
					$stan_konta_euro = $_SESSION['stan_konta_euro'];
					$euro = round($_SESSION['euro'],2,PHP_ROUND_HALF_DOWN);
					$dodaj_pln = round($kwota*$euro,2,PHP_ROUND_HALF_DOWN);

					$przewalutowanie = $polaczenie->query("UPDATE klienci SET stan_konta=stan_konta+$dodaj_pln WHERE idklienta=$idklienta");
					$przewalutowanie = $polaczenie->query("UPDATE klienci SET stan_konta_euro=stan_konta_euro-$kwota WHERE idklienta=$idklienta");
					
					$nowy_stan = $polaczenie->query("SELECT * FROM klienci WHERE idklienta=$idklienta");
					$nowy_rezultat = $nowy_stan->fetch_assoc();
					$nowy_stan = $nowy_rezultat['stan_konta'];
					$nowy_stan_euro = $nowy_rezultat['stan_konta_euro'];
					$_SESSION['nowy_stan'] = $nowy_stan;
					$_SESSION['nowy_stan_euro'] = $nowy_stan_euro;
					
					$log = $polaczenie->query("INSERT INTO transakcje_walutowe VALUES('','$data','$kwota','$stan_konta','$nowy_stan','$stan_konta_euro','$nowy_stan_euro','$euro','$idklienta')");
					
					$_SESSION['przewalutowano'] = '<span style="color: green">Przewalutowano!</span>';
					$polaczenie->close();
					header ("Location: stronaglowna.php");
				}
			}
		}
	}
}

?>
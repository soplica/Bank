<?php
session_start();
require_once "connect.php";
	$odb_nr = $_POST['odb_nr'];
	$odb_imie = $_POST['odb_imie'];
	$odb_nazwisko = $_POST['odb_nazwisko'];
	$kwota = $_POST['kwota'];
	
	//echo $odb_imie." ".$odb_nazwisko; 
$kwota = floatval($kwota);
$nr_konta = $_SESSION['nr_konta'];
$stan_konta = $_SESSION['stan_konta'];
$stan_konta_euro = $_SESSION['stan_konta_euro'];
$dataczas = new DateTime();
$dataczas = $dataczas->format('Y-m-d H:i:s');

$polaczenie = new mysqli($db_host,$db_user,$db_pass,$db_name);
$polaczenie->set_charset('utf8');
if($polaczenie->connect_errno!=0)
{
	echo "ERROR: ".$polaczenie->connect_errno;
}
else
{
	$spr_pop = $polaczenie->query("SELECT * FROM klienci WHERE nr_konta='$odb_nr' AND imie='$odb_imie' AND nazwisko='$odb_nazwisko'");
	$spr_pop_n = $spr_pop->num_rows;
	if($spr_pop_n==0)
	{
		$_SESSION['niepop_dane'] = '<span style = "color: red;">Niepoprawne dane</span>';
		header ("Location: przelew.php");
	}
	else
	{
			
		if($kwota<0)
		{
			$_SESSION['niepop_kwota'] = '<span style = "color: red;">Niepoprawna kwota</span>';
			header ("Location: przelew.php");
		}
		else
		{
			if(!isset($_POST['typ_przelewu']))
			{
				$_SESSION['niewybrany_typ'] = '<span style = "color: red;">Wybierz walutę przelewu!</span>';
				header ("Location: przelew.php");
			}
			else
			{
				//sprawdzanie waluty przelewu
				$typ = $_POST['typ_przelewu'];
				if($typ=="pln")
				{
				
					if($kwota>$stan_konta)
					{
						$_SESSION['brak_srodkow'] = '<span style = "color: red;">Brak środków na koncie!</span>';
						header ("Location: przelew.php");
					}
					else
					{


							
						$saldo_odb_przed = $polaczenie->query("SELECT * FROM klienci WHERE nr_konta = $odb_nr");
							$rezultat = $saldo_odb_przed->fetch_assoc();
						$saldo_odb_przed = $rezultat['stan_konta'];
						$saldo_odb_przed = floatval($saldo_odb_przed);
						$saldo_odb_po = $saldo_odb_przed+$kwota;
						
						$przelew = $polaczenie->query("UPDATE klienci SET stan_konta=stan_konta+$kwota WHERE nr_konta = $odb_nr");
						$przelew = $polaczenie->query("UPDATE klienci SET stan_konta=stan_konta-$kwota WHERE nr_konta = $nr_konta");
								
						$nowy_stan = $polaczenie->query("SELECT stan_konta FROM klienci WHERE nr_konta=$nr_konta");
							$rezultat=$nowy_stan->fetch_assoc();
							$nowy_stan = $rezultat['stan_konta'];
						$_SESSION['nowy_stan'] = $nowy_stan;

								
						$log = $polaczenie->query("INSERT INTO transakcje VALUES('','$dataczas','$kwota','$saldo_odb_przed','$saldo_odb_po','$stan_konta','$nowy_stan','$odb_nr','$nr_konta','PLN')");

						$polaczenie->close();
						unset($_POST['typ_przelewu']);
						$_SESSION['przelew_wykonany'] = true;
						header("Location: stronaglowna.php");
					}
				}
				
				if($typ=="eur")
				{
					if($kwota>$stan_konta_euro)
					{
						$_SESSION['brak_srodkow'] = '<span style = "color: red;">Brak środków na koncie!</span>';
						header ("Location: przelew.php");
					}
					else
					{
						$saldo_odb_przed = $polaczenie->query("SELECT * FROM klienci WHERE nr_konta = $odb_nr");
							$rezultat = $saldo_odb_przed->fetch_assoc();
						$saldo_odb_przed = $rezultat['stan_konta_euro'];
						$saldo_odb_przed = floatval($saldo_odb_przed);
						$saldo_odb_po = $saldo_odb_przed+$kwota;
						$przelew = $polaczenie->query("UPDATE klienci SET stan_konta_euro = stan_konta_euro+$kwota WHERE nr_konta = $odb_nr");
						$przelew = $polaczenie->query("UPDATE klienci SET stan_konta_euro = stan_konta_euro-$kwota WHERE nr_konta = $nr_konta");
						
						$nowy_stan = $polaczenie->query("SELECT stan_konta_euro FROM klienci WHERE nr_konta=$nr_konta");
							$rezultat=$nowy_stan->fetch_assoc();
							$nowy_stan = $rezultat['stan_konta_euro'];
						$_SESSION['nowy_stan_euro'] = $nowy_stan;
						
						$log = $polaczenie->query("INSERT INTO transakcje VALUES('','$dataczas','$kwota','$saldo_odb_przed','$saldo_odb_po',$stan_konta_euro,$nowy_stan,$odb_nr,$nr_konta,'EUR')");
						
						$polaczenie->close();
						$_SESSION['przelew_wykonany'] = true;
						unset($_POST['typ_przelewu']);
						header("Location: stronaglowna.php");
					}
				}
			}
		}
	}
}
?>

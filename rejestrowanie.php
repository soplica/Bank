<?php
session_start();

$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$haslo1 = $_POST['haslo1'];
$haslo2 = $_POST['haslo2'];
$email = $_POST['email'];
$email_s = filter_var($email,FILTER_SANITIZE_EMAIL);
$ok = true;

if(strlen($imie)<2 || strlen($imie)>25)
{
	$_SESSION['niep_imie'] = '<span class="blad">Niepoprawne imie!</span><br>';
	$ok = false;
	header("Location: rejestracja.php");
}

if(strlen($nazwisko)<2 || strlen($nazwisko)>25)
{
	$_SESSION['niep_nazwisko'] = '<span class="blad">Niepoprawne nazwisko!</span><br>';
	$ok = false;
	header("Location: rejestracja.php");
}

if((filter_var($email_s,FILTER_VALIDATE_EMAIL)==false) || ($email!=$email_s))
{
	$_SESSION['niep_email'] = '<span class="blad">Niepoprawny adres email!</span><br>';
	$ok = false;
	header("Location: rejestracja.php");
}

if(strlen($haslo1)<5 || strlen($haslo1)>25 || strlen($haslo2)<5 || strlen($haslo2)>25)
{
	$_SESSION['niep_haslo'] = '<span class="blad">Hasło powinno zawierać od 5 do 25 znaków!</span><br>';
	$ok = false;
	header("Location: rejestracja.php");
}

if($haslo1!=$haslo2)
{
	$_SESSION['niep_hasla'] = '<span class="blad">Podane hasła nie są identyczne!</span><br>';
	$ok = false;
	header("Location: rejestracja.php");
}
if(!isset($_POST['reg']))
{
	$_SESSION['niep_reg'] = '<span class="blad">Akceptuj regulamin!</span><br>';
	$ok = false;
	header("Location: rejestracja.php");
}
//----------------------------------------------------------------------------------------
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try
{
	$polaczenie = new mysqli($db_host,$db_user,$db_pass,$db_name);
	$polaczenie->set_charset('utf8');
	if($polaczenie->connect_errno!=0)
	{	
		throw new Exception(mysqli_connect_errno());
	}
	else
	{
		$zapytanie_email = $polaczenie->query("SELECT * FROM klienci WHERE email='$email_s'");
		if(!$zapytanie_email) throw new Exception($polaczenie->error);
		$ile_maili = $zapytanie_email->num_rows;
		if($ile_maili>0)
		{
			$_SESSION['istnieje_email'] = '<span class="blad">Istnieje już konto z takim mailem!</span><br>';
			$ok = false;
			header("Location: rejestracja.php");
		}
		if($ok==true)
		{
			$nr_konta = rand(111111,999999);
			$powtorzenie = $polaczenie->query("SELECT * FROM klienci WHERE nr_konta=$nr_konta");
			if($powtorzenie->num_rows>0)
			{
				while($powtorzenie->num_rows>0)
				{
					$nr_konta = rand(111111,999999);
					$powtorzenie = $polaczenie->query("SELECT * FROM klienci WHERE nr_konta=$nr_konta");
				}
			}
			if($dodawanie = $polaczenie->query("INSERT INTO klienci VALUES('','$imie','$nazwisko','10000','$nr_konta','$haslo1','1000','$email_s')"))
				echo "Dodano!";
			if(!$dodawanie) throw new Exception($polaczenie->error);
			header ("Location: witam.html");
			$polaczenie->close();
			
		}
	}
}
catch(Exception $ex)
{
		echo "ERROR KURWA ".$ex;
}

?>
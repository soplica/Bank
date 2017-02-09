<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($db_host,$db_user,$db_pass,$db_name);

if(isset($_POST['przelewy']))
{
	$nr_konta = $_SESSION['nr_konta'];
	$czyszczenie = $polaczenie->query("DELETE FROM transakcje WHERE konto_nad = $nr_konta OR konto_odb = $nr_konta");
	header("Location: historia.php");
}

if(isset($_POST['waluty']))
{
	$id_klienta = $_SESSION['idklienta'];
	$czyszczenie = $polaczenie->query("DELETE FROM transakcje_walutowe WHERE idklienta = $id_klienta");
	header("Location: historiawaluty.php");
}


?>
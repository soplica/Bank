<?php
session_start();
if(!isset($_SESSION['zalogowano'])) header('Location: index.php');

$doc = new DOMDocument();
$doc->load('http://www.nbp.pl/kursy/xml/LastA.xml');

$xpath = new DOMXpath($doc);
$result = $xpath->query("//tabela_kursow/pozycja[8]/kurs_sredni/text()");
$data = $xpath->query("//tabela_kursow/data_publikacji/text()");
foreach($result as $amount)
{
    $euro = (float)str_replace(",",".",$amount->nodeValue); 

}
foreach($data as $data)
{
	$data = $data->nodeValue;
}


$_SESSION['euro'] = $euro;
$_SESSION['data_publikacji'] = $data;


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
	<div id="lewa">
		<?php
		echo "Numer konta: ".$_SESSION['nr_konta']."</br>";
		echo "Imię: ".$_SESSION['imie']."</br>";
		echo "Nazwisko: ".$_SESSION['nazwisko']."</br>";
		echo "Stan konta: ".$_SESSION['stan_konta']."PLN</br></br>";
		echo "Stan konta EURO: ".$_SESSION['stan_konta_euro']."</br></br>";
		echo '<a href="wyloguj.php">Wyloguj się!</a></br>';
		echo '<a href="historia.php">Zobacz historię przelewów!</a>';
		
		$data = $_SESSION['data_publikacji'];
		$euro = $_SESSION['euro'];
		?>
	</div>
	<div id="prawa">
		Kurs EURO z dnia: <?php echo $data.": "."<b>".$euro."</b>";  ?></br></br>
		Przewalotowanie!</br>
		<form action = "przewalutowanie.php" method="post">
			Podaj kwotę: <input type="text" name="kwota"/></br>
			PLN => EUR <input type="radio" name="typ_przewalutowania" value="pte"/></br>
			EUR => PLN <input type="radio" name="typ_przewalutowania" value="etp"/></br>
			<input type="submit" name="submit" value="Przewalutuj!"/></br></br>
		</form>
		<?php
		if(isset($_SESSION['zla_kwota_e']))
		{
			echo $_SESSION['zla_kwota_e']."</br>";
			unset($_SESSION['zla_kwota_e']);
		}
		if(isset($_SESSION['brak_srodkow_e']))
		{
			echo $_SESSION['brak_srodkow_e']."</br>";
			unset($_SESSION['brak_srodkow_e']);
		}
		?>
	</div>
	
</div>

</body>
</html>
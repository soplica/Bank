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
		<a href="stronaglowna.php">Super Bank</a>
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
		
		
		$data = $_SESSION['data_publikacji'];
		$euro = $_SESSION['euro'];
		?>
	</div>
	<div class="prawa">
		<div class="wew_napis_l">Przewalutowanie!</div>
		<div style="clear: both;"></div>
		Kurs EURO z dnia: <?php echo $data.": "."<b>".$euro."</b>";  ?></br></br>
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
<?php
require_once("sesja.php");
$HEADER = <<<EOT
	<!DOCTYPE html>
	<html lang="pl"> 
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content= "width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="css/mystyle.css">
	<link rel="stylesheet" href="css/grid-6.css">
	<title>Bank</title>
	</head>
	<body>
		<div id="myFrame">
		<header>
			<div class="row">
				<h1 class="myTitle">Bank</h1>
			</div>	
			<div class="row">	
				<p class="infopage">Twoja bankowość, użytkowniku {{login}}</p>
			</div>
		</header>
	<div class = "row">
EOT;
$BODY = <<<EOT
<div class = "row">
	<div class ="col-2-6">
		<nav>	
			<ul id="menu">
				<li class="active">Nowy Przelew</li>
				<li><a href="twojeprzelewy.php">Twoje Przelewy</a></li>
				<li><a href="wyloguj.php">Wyloguj</a></li>
			</ul>  
		</nav>
	</div>
	<div class ="col-4-6">	
		<article class="articleFrame">
			<h2>Nowy Przelew</h2>
			<section class="sectionFrame">
				<h3>Dane</h3>
				<form method="POST" action="index.php" name="nowy">
				<b>Numer rachunku:</b> <input type="text" name="rachunek"><br><br>
				<b>Nazwa odbiorcy:</b> <input type="text" name="nazwa"><br><br>
				<b>Adres odbiorcy:</b> <input type="text" name="adres"><br><br>
				<b>Tytul przelewu:</b> <input type="text" name="tytul"><br><br>
				<b>Kwota przelewu:</b> <input type="number" name="kwota"><br><br>
				<input type="submit" value="Przelej" name="przelej">
				</form>
			</section>
			<br><br>
		</article>
EOT;
$FOOTER = <<<EOT
	</div>
</div>
	<div class = "row">
		<div class ="col-6-6">
			<footer>
				<p> Copyright &copy; WPPT PWr Kamil Sikorski </p>
			</footer>
		</div>
	</div>
</div>
	
</body>
</html>
EOT;
	$HEADER= (string) str_replace("{{login}}", (string) $_SESSION['Login'], $HEADER); 
	echo $HEADER;
	echo $BODY;
	
function filtruj($zmienna){
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna);
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
if (isset($_POST['przelej']))
{
	$rachunek = filtruj($_POST['rachunek']);
	$nazwa = filtruj($_POST['nazwa']);
	$adres = filtruj($_POST['adres']);
	$tytul = filtruj($_POST['tytul']);
	$kwota = filtruj($_POST['kwota']);
	
	if($nazwa ==="" || $rachunek==="" || $tytul ===""){
		echo "Podaj dane";
	}else{
		$servername = "localhost";
		$username = "root";
		$password = "1234";
		$dbname = "banksql";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 	
		$result = $conn->query("SELECT id FROM users WHERE login = '".$_SESSION['Login']."'");
		$row = $result->fetch_assoc();
		$sql = "INSERT INTO `przelewy`(`UserId`, `Numer`, `Nazwa`, `Adres`, `Tytul`, `Kwota`,`data`)
				VALUES (".$row['id'].", '".$rachunek."','".$nazwa."','".$adres."','".$tytul."',".$kwota.",'".Date("Y-m-d H:i:s")."')";
		if ($conn->query($sql) === TRUE) {
			echo "Transakcje przeprowadzono poprawnie".Date("Y-M-d H:i:s");
		} else {
			echo "Nie udało się przesłać pieniedzy ";
		}
	
	}
	
}
	echo $FOOTER
?>
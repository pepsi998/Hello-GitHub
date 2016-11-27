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
				<li><a href="index.php">Nowy Przelew</a></li>
				<li class="active">Twoje Przelewy</li>
				<li><a href="wyloguj.php">Wyloguj</a></li>
			</ul>  
		</nav>
	</div>
	<div class ="col-4-6">	
		<article class="articleFrame">
			<h2>Twoje Przelewy</h2>
			<section class="sectionFrame">
			
EOT;
$FOOTER = <<<EOT
			</section>
			<br><br>
		</article>
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
	
	$servername = "localhost";
	$username = "root";
	$password = "1234";
	$dbname = "banksql";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 	
	$result = $conn->query("SELECT id FROM users WHERE login = '".$_SESSION['Login']."'");
	$row1 = $result->fetch_assoc();
	$przelewy = $conn->query("SELECT * FROM przelewy WHERE UserId=".$row1['id']." ORDER BY data DESC");
	if ($przelewy->num_rows > 0) {
		while($row = $przelewy->fetch_assoc()) {
			
			echo "<div class='cytat'>Rachunek: " . $row["Numer"]. "<br>Nazwa odbiorcy: " . $row["Nazwa"]. "<br>Adres odbiorcy: " . $row["Adres"]. "<br>Tytul Przelewu: " . $row["Tytul"]. "<br>Kwota Przelewu: " . $row["Kwota"]. "<br>Data Przelewu: " . $row["data"]."</div>";
		}
	} else {
		echo "brak";
	}
	echo $FOOTER
?>
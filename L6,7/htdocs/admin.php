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
	<script>
	function myFunction() {
		var x = document.getElementsByName('potwierdz');
		if(x.length>0)
			x[x.length-1].click();
	}
</script>
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
				<li><a href="wyloguj.php">Wyloguj</a></li>
			</ul>  
		</nav>
	</div>
	<div class ="col-4-6">	
		<article class="articleFrame">
			<h2>Potwierdz</h2>
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
<div class="fixed" onclick='myFunction()'>
<img src="img/laska.jpg" alt="laska" width="120" height="90" style="float: left;">
	<p style="float: right;"> Siema <br>Jestem dzisiaj sam <br>Kliknij po więcej </p>
</div>
</body>
</html>
EOT;
	$servername = "localhost";
	$username = "root";
	$password = "1234";
	$dbname = "banksql";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if(isset($_POST["potwierdz"])){
		$Id = $_POST['ID'];
		$conn->query("UPDATE przelewy SET potwierdzone=TRUE WHERE id=".$Id);
	}

	$HEADER= (string) str_replace("{{login}}", "adminie", $HEADER); 
	echo $HEADER;
	echo $BODY;
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 	
	$przelewy = $conn->query("SELECT * FROM przelewy WHERE ISNULL(potwierdzone) ORDER BY data LIMIT 50");
	if ($przelewy->num_rows > 0) {
		while($row = $przelewy->fetch_assoc()) {
			echo "<form method='POST' action='admin.php'><div class='cytat'>Rachunek: " . $row["Numer"]. "<br>Nazwa odbiorcy: " . $row["Nazwa"]. "<br>Adres odbiorcy: " . $row["Adres"]. "<br>Tytul Przelewu: " . $row["Tytul"]. "<br>Kwota Przelewu: " . $row["Kwota"]. "<br>Data Przelewu: " . $row["data"]."<br><br><input type='number' name='ID' value ='".$row["ID"]."' style='display:none'><input type='submit' value='potwierdz' name='potwierdz'></div></form>";
		}
	} else {
		echo "brak";
	}
	echo $FOOTER;


?>


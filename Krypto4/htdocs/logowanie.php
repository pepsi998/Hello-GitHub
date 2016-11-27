<?php
session_start();
?>

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
				<p class="infopage">Twoja bankowość</p>
			</div>
		</header>
	<div class = "row">
<div class = "row">
	<div class ="col-2-6">
		<nav>	
			<ul id="menu">
			</ul>  
		</nav>
	</div>
	<div class ="col-4-6">	
		<article class="articleFrame">
			<h2>Zaloguj</h2>
			<section class="sectionFrame">
				<form method="POST" action="logowanie.php">
				<b>Login:</b> <input type="text" name="login"><br><br>
				<b>Hasło:</b> <input type="password" name="haslo"><br><br>
				<input type="submit" value="Zaloguj" name="zalogujsie">
				</form>
			</section>
			<br>
			<br>




<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "banksql";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 	
function filtruj($zmienna){
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna);
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
 
if (isset($_POST['zalogujsie']))
{
	$login = filtruj($_POST['login']);
	$haslo = filtruj($_POST['haslo']);
	$result=$conn->query("SELECT * FROM users WHERE login='".$login."'");
	if ($result->num_rows===0){
		if ($haslo !== ""){
			$conn->query("INSERT INTO users (login, password)
				VALUES ('".$login."', '".md5($haslo)."')");
			$_SESSION["Login"] = $login;
			$_SESSION['Time'] = time();
			header("Location: /index.php");
		} else echo "Nie podałeś hasła";
	}
	else {
		$result = $conn->query("SELECT * FROM users WHERE login = '".$login."' AND password='".md5($haslo)."'");
		if($result->num_rows>0){
			$_SESSION["Login"] = $login;
			$_SESSION['Time'] = time();
			header("Location: /index.php");
		}else echo "Podałeś złe hasło";
	}
}
?>

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
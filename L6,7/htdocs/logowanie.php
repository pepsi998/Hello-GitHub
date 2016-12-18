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
	<script src='https://www.google.com/recaptcha/api.js'></script>
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
			<li><a href="poczta/smail.php">Smail</a></li>
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
					<div class="g-recaptcha" data-sitekey="6LdN2A4UAAAAAABA-kXmwkMuIsn4VdPQi-LldhsK"></div>
					<br>
					<input class='button'  type="submit" value="Zaloguj" name="zalogujsie"><a class='button' style='background:#008CBA;' href="przypomnij.php"> Przypomnij hasło </a>
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
require_once 'Myfacebook.php';
checkfacebook();
if (isset($_POST['zalogujsie']))
{
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
		$secret = '6LdN2A4UAAAAAP226buT3311etC0Fb6cAoYKX2hY';
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){
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
					if($login=='admin')
						header("Location: /admin.php");
					else
						header("Location: /index.php");
				}else echo "Podałeś złe hasło";
			}
		}
		else
			echo "<script language='javascript'>alert('Jesteś robotem...');</script>";
		
	}
	else
		echo "<script language='javascript'>alert('Uzupelnij recaptcha');</script>";
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
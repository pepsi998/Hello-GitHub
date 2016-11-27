<form method="POST" action="rejestracja.php">
<b>Login:</b> <input type="text" name="login"><br><br>
<b>Hasło:</b> <input type="password" name="haslo"><br><br>
<input type="submit" value="Zaloguj" name="rejestruj">
</form>



<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "banksql";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 	
function filtruj($zmienna)
{
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe
 
	// usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
 
if (isset($_POST['rejestruj']))
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
		} else echo "Nie podałeś hasła";
	}
	else {
		$result = $conn->query("SELECT * FROM users WHERE login = '".$login."' AND password='".md5($haslo)."'");
		if($result->num_rows>0){
			$_SESSION["Login"] = $login;
			$_SESSION['Time'] = time();
		}else echo "Podałeś złe hasło";
	}
}
?>
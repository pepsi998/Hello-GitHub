<?php

	require_once 'facebook-php-sdk-master/src/facebook.php';
	
	function checkFacebook(){
		$config = array();
		$config['appId'] = '356514284708868'; 
		$config['secret'] = '75433e94d6ad12f21858994e229ff40f'; 
		 
		$fb = new Facebook($config);
		
		if ($fb->getUser()) { 
			$servername = "localhost";
			$username = "root";
			$password = "1234";
			$dbname = "banksql";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 	
			$user = $fb->api('me');
			$_SESSION['login'] = $user['name'];
			$_SESSION["Login"] = $user['name'];
			$_SESSION['Time'] = time();
			$conn->query("INSERT INTO users (login)
						VALUES ('".$login."')");
			$_SESSION['Time'] = time();
			header("location: http://" . $_SERVER['HTTP_HOST'] ."/index.php");
		}
		else {
				$params = array(
					'scope' => 'email',
					'redirect_uri' => 'http://kamazkrypto.pl/logowanie.php'
				);
				echo '<a href="' . $fb->getLoginUrl($params) . '"><img src="img/fb.png" width="50" height="50"/></a>';
		}
	}
	
	function logoutFacebook(){
		$config = array();
		$config['appId'] = '356514284708868'; 
		$config['secret'] = '75433e94d6ad12f21858994e229ff40f'; 
		 
		$fb = new Facebook($config);
		
		if ($fb->getUser()) { 
			$fb->destroySession();
		}
	}
		
?>
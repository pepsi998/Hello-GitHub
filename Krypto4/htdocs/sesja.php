<?php
	session_start();
	function isLogin(){
		if (isset($_SESSION['Time']) && (time() - $_SESSION['Time'] > 1200)) {
			session_unset();  
			session_destroy();
			return false;
		}else{
			if(isset($_SESSION['Time'])){
				$_SESSION['Time'] = time();
				return true;
			}
		}
		return false;
	}
	function getLogin(){
		return $_SESSION['Login'];
	}
	if(!isLogin()){
	header("Location: /logowanie.php");
	}
?>
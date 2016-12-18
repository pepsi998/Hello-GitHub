<?php
session_start();
require_once("sesja.php");
$P = new Page(); 
if($P->isLogin()){
	echo"taaak";
}else{
	echo "nieee:/";
}
?>
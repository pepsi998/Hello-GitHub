<?php
session_start();
require_once("sesja.php");
$P = new Page(); 
if($P->isLogin()){
	echo"tak";
}else{
	echo "nie";
}
?>
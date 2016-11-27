<?php
require_once("sesja.php");
session_unset();  
session_destroy();
header("Location: /logowanie.php");
?>
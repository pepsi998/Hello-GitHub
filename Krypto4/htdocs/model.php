<?php
	
$HEADER = <<<EOT
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
				<p class="infopage">Twoja bankowość {{login}}</p>
			</div>
		</header>
	<div class = "row">
EOT;
$BODY = <<<EOT
<div class = "row">
	<div class ="col-2-6">
		<nav>	
			<ul id="menu">
				<li class="active">Nowy Przelew</li>
				<li><a href="">Twoje Przelewy</a></li>
			</ul>  
		</nav>
	</div>
	<div class ="col-4-6">	
		<article class="articleFrame">
			<h2>Nowy Przelew</h2>
			<section class="sectionFrame">
				<h3>Dane</h3>
				
			</section>
		</article>
EOT;
$FOOTER = <<<EOT
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
EOT;
	echo $HEADER;
	echo $BODY;
	echo $FOOTER
?>
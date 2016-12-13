<?php

	session_start();
	echo "tutaj bedzie skrypt odpowiedzialny za tworzenie i obsluge chmury dla: ".$_SESSION["user"];
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	$login=$_POST['user']; 
	$pass=$_POST['pass']; 
	$a=$login = $_POST['user'];
	$b=$haslo = $_POST['pass'];
	$_SESSION["$a"];
	echo "<br>";
	echo "Wartość zmiennej sesyjnej do zliczania błędów wynosi: " .$_SESSION['$_SESSION["user"]'];
	
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<style> 
	#wyloguj{
	display: inline-block;
	position: absolute;
	right: 550px;
	top: 10px	
	}
	
</style>
</head>
<BODY>
	<div id="glowny">
		<div id="wyloguj"
		<?php
		echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="http://giermach.gredziszewski.pl/z7/logout.php">Wyloguj się!</a> ]</p>';
		?>
		</div>
	</div>
</BODY>
</HTML>

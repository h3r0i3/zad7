<?php

	session_start();
	echo "tutaj bedzie skrypt odpowiedzialny za tworzenie i obsluge chmury dla: ".$_SESSION["user"];
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	$a=$_SESSION["user"];
	echo "<br>";
	$b = $_SESSION["$a"];
	if ($b >1){
	$servername="localhost";
	$username="krisg_lukasz";
	$password="123654";
	$dbname="krisg_lukasz2";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT data FROM logi WHERE user='$a' and proba = 'blad' ORDER BY id DESC LIMIT 1;";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	echo "<br>";
	echo "Ostatnia błędna próba logowania na to konto: ".$a." - odbyła się: ".$row['data'];
	echo "<br>";
	}
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

<?php
session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<style> 
	#formularz{
	display: inline-block;
	position: absolute;
	left: 250px;
	top: 250px	
	}
	
	#wroc{
	display: inline-block;
	position: absolute;
	right: 10px;
	top: 10px	
	}
	
	
</style>
</head>
<BODY>
	<div id="glowny">
		<div id="formularz">
		<form method="post">
		Formularz dodawania konta klienta<br><br>
		Wprowadz login:<br>
		<input type="text" name="user" maxlength="20" size="20"><br>
		Wprowadz haslo:<br>
		<input type="password" name="pass" maxlength="20" size="20"><br>
		Ponownie wpisz haslo:<br>
		<input type="password" name="pass1" maxlength="20" size="20"><br>
		<input type="submit" value="OK"/>
		</div>
		<div id="wroc"><a onclick="location.href='index.php';"><input type="button" style="height:50px;"  value="Wróæ"></div>
		</div>
</form>
</BODY>
</HTML>

<?php

$servername="localhost";
$username="krisg_lukasz";
$password="123654";
$dbname="krisg_lukasz2";

$user = $_POST['user'];
$pass = $_POST['pass'];
$pass1 = $_POST['pass1'];

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM users WHERE user='$user' ";
$result = $conn->query($sql);
if(isset($_POST['user'])){
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo "Login zajêty"; 
		}
	}
	else{
		if($pass != $pass1){
			echo "Has³a s¹ ró¿ne "; 
		}
		else{
			echo "Konto zosta³o utworzone";
			mkdir("$user");
			$myfile = fopen("$user/chmura.php", "w") or die("Unable to open file!");
			$source = "skrypttworzenia.php";
			$destination = "$user/chmura.php";
			copy($source, $destination) or die("B³¹d przy kopiowaniu");
			fclose($myfile);
			$conn = new mysqli($servername, $username, $password, $dbname);
			$sql = "INSERT INTO users (user, pass) 
			VALUES ('$user', '$pass');";
			$result = $conn->query($sql);
			$conn->close();
		}
	}
}
?>

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
		<div id="wroc"><a onclick="location.href='index.php';"><input type="button" style="height:50px;"  value="Wr��"></div>
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
			echo "Login zaj�ty"; 
		}
	}
	else{
		if($pass != $pass1){
			echo "Has�a s� r�ne "; 
		}
		else{
			echo "Konto zosta�o utworzone";
			mkdir("$user");
			mkdir("$user/pliki", 0777);
			$myfile = fopen("$user/chmura.php", "w") or die("Unable to open file!");
			$source = "skrypttworzenia.php";
			$destination = "$user/chmura.php";
			copy($source, $destination) or die("B��d przy kopiowaniu");
			fclose($myfile);
			
			$myfile1 = fopen("$user/download.php", "w") or die("Unable to open file!");
			$source1 = "download1.php";
			$destination1 = "$user/download.php";
			copy($source1, $destination1) or die("B��d przy kopiowaniu");
			fclose($myfile1);
			
			$myfile2 = fopen("$user/odbierz.php", "w") or die("Unable to open file!");
			$source2 = "odbierz1.php";
			$destination2 = "$user/odbierz.php";
			copy($source2, $destination2) or die("B��d przy kopiowaniu");
			fclose($myfile2);
			
			$myfile3 = fopen("$user/wyswietl.php", "w") or die("Unable to open file!");
			$source3 = "wyswietl1.php";
			$destination3 = "$user/wyswietl.php";
			copy($source3, $destination3) or die("B��d przy kopiowaniu");
			fclose($myfile3);
			$conn = new mysqli($servername, $username, $password, $dbname);
			$sql = "INSERT INTO users (user, pass) 
			VALUES ('$user', '$pass');";
			$result = $conn->query($sql);
			$conn->close();
		}
	}
}
?>

<?php
	session_start();
	
	if ((!isset($_POST['user'])) || (!isset($_POST['pass'])))
	{
		header('Location: index.php');
		exit();
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />
<style>
#wroc{
	display: inline-block;
	position: absolute;
	right: 10px;
	top: 10px	
	}
</style>
</HEAD>
<BODY>
<?php
	$login=$_POST['user']; 
	$pass=$_POST['pass']; 
	$a=$login = $_POST['user'];
	$b=$haslo = $_POST['pass'];
	$_SESSION["$a"];
	$servername="localhost";
	$username="krisg_lukasz";
	$password="123654";
	$dbname="krisg_lukasz2";
	$conn = new mysqli($servername, $username, $password, $dbname); 
	$sql = "SELECT status FROM logi WHERE user='$login' ORDER BY id DESC LIMIT 1"; 
	$res = $conn->query($sql);
	$row = $res->fetch_assoc();
	if($row['status']=="zablokowane"){
		mysqli_close($conn); 
		echo "Podane konto jest zablokowane. Prosze skontaktowac sie z administratorem.<br>"; 
		echo "Wartoœæ zmiennej sesyjnej do zliczania b³êdów wynosi: " .$_SESSION["$a"];
	}
	else {

			$polaczenie = @new mysqli($servername, $username, $password, $dbname);
	
			if ($polaczenie->connect_errno!=0)
			{
				echo "Error: ".$polaczenie->connect_errno;
			}
			else{
				$login = $_POST['user'];
				$haslo = $_POST['pass'];
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
				if ($rezultat = @$polaczenie->query(
				sprintf("SELECT * FROM users WHERE user='$a' AND pass='$b'",
				mysqli_real_escape_string($polaczenie,$login),
				mysqli_real_escape_string($polaczenie,$haslo)))){
					$ilu_userow = $rezultat->num_rows;
					if($ilu_userow>0){
						$_SESSION['zalogowany'] = true;
						$wiersz = $rezultat->fetch_assoc();
						$_SESSION['user'] = $wiersz['user'];
						$_SESSION['kolor'] = $wiersz['kolor'];
						$_SESSION['sprawdzacz'] = $a; 
						$pamietacz =$a;

						unset($_SESSION['blad']);
						$rezultat->free_result();
						$servername="localhost";
						$username="krisg_lukasz";
						$password="123654";
						$dbname="krisg_lukasz2";
						$data = date("Y-m-d H:i:s");
						$conn = new mysqli($servername, $username, $password, $dbname);
						$sql = "INSERT INTO logi (user, data, proba) 
						VALUES ('$login', '$data', 'pomyslnie');";
						$result = $conn->query($sql);
						$conn->close();
						header("Location: $a/chmura.php");
						
					}
					else {
						
						$_SESSION['blad'] = '<span style="color:red">Nieprawid³owy login lub has³o!</span>';
						$_SESSION["$a"]++;
						echo $_SESSION["$a"];
						$servername="localhost";
						$username="krisg_lukasz";
						$password="123654";
						$dbname="krisg_lukasz2";
						$data = date("Y-m-d H:i:s");
						$conn = new mysqli($servername, $username, $password, $dbname);
						$sql = "INSERT INTO logi (user, data, proba) 
						VALUES ('$login', '$data', 'blad');";
						$result = $conn->query($sql);
						$conn->close();
						header('Location: index.php');
						
						if($_SESSION["$a"]=="3"){
							$servername="localhost";
							$username="krisg_lukasz";
							$password="123654";
							$dbname="krisg_lukasz2";
							$data = date("Y-m-d H:i:s");
							$conn = new mysqli($servername, $username, $password, $dbname);
							$sql = "INSERT INTO logi (user, data, proba, status) 
							VALUES ('$login', '$data', 'blad', 'zablokowane');";
							$result = $conn->query($sql);
							$conn->close();
							header('Location: index.php');
						}
					}
				}		
			}					
	}
?>
<div id="g³ówny">
	<div id="wroc">
	<?
	echo '[ <a href="index.php">Wróæ</a> ]</p>';
	?></div>
	</div>
</BODY>
</HTML>

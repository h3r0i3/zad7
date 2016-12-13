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
	//odczytanie wartosci
	$login=$_POST['user']; 
	$pass=$_POST['pass']; 
	//zmienna zliczajaca logowania
	if(isset($_SESSION["$login"]));
	else	$_SESSION["$login"]=1;
	//dane do bazy
	$servername="localhost";
	$username="krisg_lukasz";
	$password="123654";
	$dbname="krisg_lukasz2";
	
	
	//polaczenie z baza
	$conn = new mysqli($servername, $username, $password, $dbname); 
	//zapytanie do bazy wyciagniecie statusu
	$sql = "SELECT status FROM logi WHERE user='$login' ORDER BY id DESC LIMIT 1"; 
	//wykonanie zapytania
	$res = $conn->query($sql);
	$row = $res->fetch_assoc();
	//sprawdznie statusu konta
	if($row['status']=="zablokowane"){
		mysqli_close($conn); 
		echo "Podane konto jest zablokowane. Prosze skontaktowac sie z administratorem.<br>"; 
		echo "Wartoœæ zmiennej sesyjnej do zliczania b³êdów wynosi: " .$_SESSION["$login"];
	}
	//jezeli nie zablokowane
	else {
			//polaczenie do bazy
			$polaczenie = @new mysqli($servername, $username, $password, $dbname);
			//sprawdzenie polaczenia
			if ($polaczenie->connect_errno!=0)
			{
				echo "Error: ".$polaczenie->connect_errno;
			}else{//polacenie udane
				
				//ponowne czytanie zmiennych
				$login = $_POST['user'];
				$haslo = $_POST['pass'];
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
				//wykonanie zapytania
				if ($rezultat = @$polaczenie->query(
				sprintf("SELECT * FROM users WHERE user='%s' AND pass='%s'",
				mysqli_real_escape_string($polaczenie,$login),
				mysqli_real_escape_string($polaczenie,$haslo)))){
					//jezeli wartosc wierszy >0 to dane poprawne
					$ilu_userow = $rezultat->num_rows;
					if($ilu_userow>0){
						$_SESSION['zalogowany'] = true;
						$wiersz = $rezultat->fetch_assoc();
						$_SESSION['user'] = $wiersz['user'];
						$_SESSION['kolor'] = $wiersz['kolor'];
						unset($_SESSION['blad']);
						
						//$rezultat->free_result();
						
						//kolejne polaczenie do bazy
						$data = date("Y-m-d H:i:s");
						$conn = new mysqli($servername, $username, $password, $dbname);
						
						$sql = "INSERT INTO logi (user, data, proba) 
						VALUES ('$login', '$data', 'pomyslnie');";
						$result = $polaczenie->query($sql);
						$polaczenie->close();
						header("Location: $login/chmura.php");
						
					}else {
						//sorawdzenie czy zmiena logowanie = 3, jezeli tak to blokada konta
						if($_SESSION["$login"]==3){
							$data = date("Y-m-d H:i:s");
							$conn = new mysqli($servername, $username, $password, $dbname);
							$sql = "INSERT INTO logi (user, data, proba, status) 
							VALUES ('$login', '$data', 'blad', 'zablokowane');";
							$result = $conn->query($sql);
							$conn->close();
							header('Location: index.php');
						}else{
							$_SESSION["$login"]=$_SESSION["$login"]+1;
							$_SESSION['blad'] = '<span style="color:red">Nieprawid³owy login lub has³o!</span>';	
							$data = date("Y-m-d H:i:s");
							$conn = new mysqli($servername, $username, $password, $dbname);
							$sql = "INSERT INTO logi (user, data, proba) 
							VALUES ('$login', '$data', 'blad');";
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

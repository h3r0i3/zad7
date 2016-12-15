<?php
session_start();
$uploaddir = '/home/krisg/domains/gredziszewski.pl/public_html/giermach/z7/'.$_SESSION['user'].'/pliki/';
$uploadfile = $uploaddir . basename($_FILES['plik']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['plik']['tmp_name'], $uploadfile)) {
	$_SESSION["czywyslano"] = "Pozytywnie wysłano plik";
	echo $_SESSION["czywyslano"];
	header('Location: chmura.php');
}
else {
	echo "Problem";
}



?>
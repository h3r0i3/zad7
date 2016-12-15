<?php
session_start();
$dir = '/home/krisg/domains/gredziszewski.pl/public_html/giermach/z7/'.$_SESSION['user'].'/pliki/';

if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh))){
		if ($file != '.' && $file != '..'){
      echo "Nazwa pliku: " . $file . "<br>";
	  echo '[ <a href="http://giermach.gredziszewski.pl/z7/'.$_SESSION['user'].'/download.php/?plik='.$file.'">Download!</a> ]</p>';
		}
    }
    closedir($dh);
  }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<style> 
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
		<div id="wroc"><a onclick="location.href='chmura.php';"><input type="button" style="height:50px;"  value="Wróć"></div>
	</div>
</BODY>
</HTML>

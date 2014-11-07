<?php
$konyv=$_POST['konyv'];
$fejezet=$_POST['fejezet'];
$ugras=$_POST['ugras'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="hu">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
	include("abcsatl.php");
	print("<frameset rows='50,36' border='1'>");
	print("<frame name='szoveg' src='./Mkv.php?konyv=$konyv&fejezet=$fejezet#$ugras'>");
	print("<frame name='lap' src='./magy.htm'>");
	print("</frameset>");
?>
</html>

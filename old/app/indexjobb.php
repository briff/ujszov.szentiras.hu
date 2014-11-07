<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="hu">
<head>


  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>


<body>

<center>
<h1>&Uuml;dv&ouml;z&ouml;lj&uuml;k a g&ouml;r&ouml;g &uacute;jsz&ouml;vets&eacute;gi sz&oacute;szedetben!<br>

</h1>

<h3>&Ouml;n 
<?php
	$a=$_SERVER["REMOTE_ADDR"];
	$h=gethostbyaddr($a);
	$ts=date("YmdHis");
	$fh=fopen("newcounter.dat","a");
	fwrite($fh,$ts.":".$a.":".$h."\n");
	fclose($fh);
	$f=fopen("szamol.dat","r");
	$s=fgets($f,1024);
	$s+=1;
	print($s);
	fclose($f);
	$f=fopen("szamol.dat","w");
	fwrite($f,$s);
	fclose($f);
?>. l&aacute;togat&oacute;nk!</h3>
<img style="width: 887px; height: 452px;" alt="" title="Fil 1,3-8" src="GNT_WH.JPG"><br>

</center>

</body>
</html>

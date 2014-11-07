<?php
	$kapcsolat=mysql_connect("localhost","root","");
	if (!$kapcsolat) die("Nem lehet kapcsolódni a MySQL kiszolgálóhoz.");
	mysql_select_db("ujszovszoszedet",$kapcsolat) or die("Nem lehet az AB-t megnyitni: ".mysql_error());
	mysql_query("set names 'utf8'");
	return $kapcsolat;
?>

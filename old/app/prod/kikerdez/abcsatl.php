<html>
<?php
	$kapcsolat=mysql_connect("localhost","ujszov","markolat");
	if (!$kapcsolat) die("Nem lehet kapcsolódni a MySQL kiszolgálóhoz.");
	mysql_select_db("ujszov",$kapcsolat) or die("Nem lehet az AB-t megnyitni: ".mysql_error());
	return $kapcsolat;
?>
</html>

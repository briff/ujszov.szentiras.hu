<?php
include ("../abcsatl.php");
$eredmeny=mysql_query("SELECT `nev` FROM `vendegk` WHERE `datum` ='$_POST[datum]'") or die(mysql_error());
if (mysql_num_rows($eredmeny) != 1) {
    die("Nem megfelel&otilde; d&aacute;tum <a href=\"javascript:history.back()\">Vissza</a>");
}
mysql_query("DELETE FROM `vendegk` WHERE `datum`='$_POST[datum]'") or die(mysql_error());
header("Location: level_szerkeszt.php");
?>

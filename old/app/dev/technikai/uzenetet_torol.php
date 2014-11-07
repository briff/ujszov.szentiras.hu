<?php
require_once ("../abcsatl.php");
$stmt=$kapcsolat->prepare("SELECT `nev` FROM `vendegk` WHERE `datum` =:datum");
$stmt->bindValue(":datum", $_POST["datum"]);
$eredmeny=execquery($stmt);
if (count($eredmeny) != 1) {
    die("Nem megfelelő dátum <a href=\"javascript:history.back()\">Vissza</a>");
}
$stmt=$kapcsolat->prepare("DELETE FROM `vendegk` WHERE `datum`=:datum");
$stmt->bindValue(":datum", $_POST["datum"]);
execquery($stmt);
header("Location: level_szerkeszt.php");
?>

<?
require_once("helper/konyvnevek.php");
$loc=explode("/", $_GET["path"]);
$_GET["konyv"]=konyvkeres($loc[0]);
$_GET["fejezet"]=(isset($loc[1]))?$loc[1]:1;
$_GET["vers"]=(isset($loc[2]))?$loc[2]:1;
$_GET["szo"]=(isset($loc[3]))?$loc[3]+100*$loc[2]+10000*$loc[1]+1000000*$_GET["konyv"]:0;
include("book.php");
?>

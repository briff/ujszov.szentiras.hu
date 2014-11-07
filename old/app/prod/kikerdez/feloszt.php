<html>
<?php
include("./abcsatl.php");
include("./perik2fh.php");
settype($iranyszam,"integer");
if ($iranyszam<2) $iranyszam=10;
//print($iranyszam."<br>");
$felt=perik2fh($perikopa);
//print($felt);
$eredmeny=mysql_query("SELECT `konyvek`.`fh`,`konyvek`.`gk`,`konyvek`.`unic`,`szot`.`szal` FROM `konyvek`,`szot` WHERE `konyvek`.`gk`=`szot`.`gk`
    AND ($felt) GROUP BY `konyvek`.`gk` ORDER BY `konyvek`.`fh` ASC",$kapcsolat);
$egesz=array();
//print("<table border='1'>\n");
//print("<tr><td>fh</td><td>gk</td><td>unic</td><td>szal</td></tr>\n");
//print(mysql_num_rows($eredmeny)."<br>");
for ($i=0;$i<mysql_num_rows($eredmeny);$i++)
{
    $sor=mysql_fetch_row($eredmeny);
    $egesz[$i]=$sor;
//    print("<tr>\n<td>\n<font face='Palatino Linotype'>\n$sor[0]\n</font>\n</td>\n<td>\n<font face='Palatino Linotype'>\n
//	$sor[1]\n</font>\n</td>\n<td>\n<font face='Palatino Linotype'>\n$sor[2]</font>\n</td>\n<td>
//	<font face='Palatino Linotype'>\n$sor[3]</font>\n</td>\n</tr>\n");
}
//print("</table>");
$oldalak_szama=floor(mysql_num_rows($eredmeny)/$iranyszam);
$maradek=mysql_num_rows($eredmeny) % $iranyszam;
$csoportok=array();
print("<h3>A sz&oacute;t&aacute;rf&uuml;zet lapjai elk&eacute;sz&uuml;ltek.</h3>\n");
print(mysql_num_rows($eredmeny)." sor ker&uuml;lt a sz&oacute;t&aacute;rba.<br>\n");
$ssz=0;
$osztott=array();
for ($i=1;$i<$oldalak_szama+1;$i++)
{
    $csoportok[$i]=($iranyszam+floor($maradek/$oldalak_szama)+((($maradek%$oldalak_szama)>=$i)?1:0));
    $osztott[$i]=array();
    for ($j=0;$j<$csoportok[$i];$j++)
    {
//	print($j."<br>");
	$osztott[$i][$j]=$egesz[$ssz][0];
	$ssz++;
    }
    $kuld=implode(',',$osztott[$i]);
    print("<form name='form$i' action='kiir.php' method='post'>\n");
    print("<input type='hidden' value='$kuld' name='fhk'>\n");
    print("<a href='#$i' name='$i' onClick='javascript:document.form$i.submit()'>$i. oldal</a><br>\n");
    print("</form>\n");
//    print("<a href='./kiir.php?fhk=$kuld'>$i. oldal</a><br>\n");
}
#Ha nem sikerült egy teljes oladlt kitennünk, másként kell számolni:
if ($oldalak_szama==0) {
    $kuld="";
    for($j=0;$j<$maradek;$j++) {
	$kuld.=$egesz[$ssz][0].",";
	$ssz++;
    }
    $kuld=rtrim($kuld, ",");
    print("<form name='form' action='kiir.php' method='post'>\n");
    print("<input type='hidden' value='$kuld' name='fhk'>\n");
    print("<a href='#1' name='1' onClick='javascript:document.form.submit()'>$i. oldal</a><br>\n");
    print("</form>\n");
}
?>
</html>

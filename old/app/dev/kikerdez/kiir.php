<html>
<?php
require_once("./abcsatl.php");
//print($fhk);
$felt="`konyvek`.`fh`='".str_replace(",","' OR `konyvek`.`fh`='",$fhk)."' ";
//print("<br>\n".$felt."<br>\n");
$eredmeny=mysql_query("SELECT `szot`.`szal`, `szot`.`mj` FROM `szot`, `konyvek`
    WHERE ($felt) AND `szot`.`gk`=`konyvek`.`gk`
    ORDER BY `fh` ASC",$kapcsolat) or die (mysql_error());
print("<table border='1' style='border-collapse: collapse'>");
while ($sor=mysql_fetch_row($eredmeny))
{
    print("<tr><td width=\"50%\">".$sor[0]."<pre>\t</pre></td><td>".$sor[1]."</td></tr>\n");
}
print("</table>");
?>
<script langue="javascript" type="text/javascript">
   window.print();
</script>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript">
function torol (datum) {
    if (confirm("Biztos torlod az uzenetet a kovetkezo datummal: "+datum+"?")) {
	document.torloform.datum.value=datum;
	document.torloform.submit();
    }
}

function valasz(datum)
    {
    document.form.vdatum.value=datum;
    }
</script>
<style>
<!--
	a:visited    { color: #000000 }
	a:link    { color: #000000 }

-->
</style>
</head>
<body bgcolor="#f2ee9d">
<form name="torloform" action="uzenetet_torol.php" method="post">
<input type="hidden" name="datum" value="">
</form>
    <?php
    include("../abcsatl.php");
    include("./level_kiir.php");
    if (!isset($oldal))	$oldal=1;
    $sorok_szama_sql=mysql_query("SELECT `datum` FROM `vendegk`",$kapcsolat);
    $sorok_szama=mysql_num_rows($sorok_szama_sql);
    $oldalak_szama=ceil($sorok_szama/50);
    print("<br>");
    for ($i=1;$i<=$oldalak_szama;$i++)
	{
	if ($oldalak_szama!=1)
	    {
	    ($i!=$oldal)?print("<a href=\"$_SERVER[PHP_SELF]?oldal=$i\">$i</a> "):print($i.' ');
	    }
	}
    $limit=($oldal-1)*50;
    if ($limit<0) $limit=0;
    $eredmeny=mysql_query("SELECT `nev`,`e-mail`,`datum`,`uzenet`,`ssz` FROM `vendegk` ORDER BY `datum` DESC LIMIT $limit,50",$kapcsolat) or die(mysql_error());
    while ($egy_sor=mysql_fetch_row($eredmeny))
    	{
	kiir($egy_sor,true);
	}
    print("<br>");
    for ($i=1;$i<=$oldalak_szama;$i++)
	{
	if ($oldalak_szama!=1)
	    {
	    ($i!=$oldal)?print("<a href=\"$_SERVER[PHP_SELF]?oldal=$i\">$i</a> "):print($i.' ');
	    }
	}
    ?>
</body>
</html>

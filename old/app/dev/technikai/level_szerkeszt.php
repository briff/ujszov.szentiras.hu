<html>
<head>
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
    require_once("../abcsatl.php");
    require_once("./level_kiir.php");
    $oldal=(isset($_GET['oldal']))?$_GET['oldal']:1;
    $stmt=$kapcsolat->prepare("SELECT COUNT(`datum`) as db FROM `vendegk`");
    $sorok_szama=execquery($stmt);
    $sorok_szama=$sorok_szama[0]["db"];
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
    $stmt=$kapcsolat->prepare("SELECT `nev`,`e-mail`,`datum`,`uzenet`,`ssz` FROM `vendegk` ORDER BY `datum` DESC LIMIT :limit,50");
    $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    $eredmeny=execquery($stmt);
    foreach ($eredmeny as $egy_sor)
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

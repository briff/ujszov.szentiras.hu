<?php
$nev=(isset($_POST['nev']))?$_POST['nev']:"";
$vdatum=(isset($_POST['vdatum']))?$_POST['vdatum']:"";
$email=(isset($_POST['email']))?$_POST['email']:"";
$hiba=true;
global $hiba;
    if(isset($_POST['uzenet']))
	{
	$uzenet=$_POST['uzenet' ];
	if ($uzenet=="")
	    {
	    print("<font color=\"red\">");
	    print("<center><h2>Az &uuml;zenet mez&otilde; kit&ouml;t&eacute;se k&ouml;telez&otilde;</h2></center>");
	    print("<center><a style=\"color: red\" href=\"#alja\">Javítás</a></center>");
	    print("</font>");
	    }
	elseif ($nev=="")
	    {
	    print("<font color=\"red\">");
	    print("<center><h2>A n&eacute;v mez&otilde; kit&ouml;t&eacute;se k&ouml;telez&otilde;</h2></center>");
	    print("<center><a style=\"color: red\" href=\"#alja\">Javítás</a></center>");
	    print("</font>");
	    }
	elseif (strtolower($jelszo) != "esik")
	    {
	    print("<font color=\"red\">");
	    print("<center><h2>A közmondásban a dobozba be kell írni az ,,esik\" szót.</h2></center>");
	    print("<center><a style=\"color: red\" href=\"#alja\">Javítás</a></center>");
	    print("</font>");
	    }
	else
	    {
	    include("abcsatl.php");
	    if (!isset($email))
		{
		$email="";
		}
	    $a=getenv('REMOTE_ADDR');
	    $ts=date("Y.m.d. H:i:s");
	    $uzenet=htmlspecialchars($uzenet);
	    $uzenet=str_replace("&amp;","&",$uzenet);
	    $nev=htmlspecialchars($nev);
	    $nev=str_replace("&amp;","&",$nev);
	    $uzenet=nl2br($uzenet);
	    if ($vdatum!="")
		{
		$vnev_sql=mysql_query("SELECT `nev`,`ssz` FROM `vendegk` WHERE `datum`='$vdatum'",$kapcsolat);
		$vnev=mysql_fetch_row($vnev_sql);
		$uzenet="<i>V&aacute;lasz $vnev[0] $vnev[1]. &uuml;zenet&eacute;re:</i><br>".$uzenet;
		}
	    $sorokszama_sql=mysql_query("SELECT `ssz` FROM `vendegk` ORDER BY `ssz` DESC LIMIT 0,1");
	    $sorok_szama=mysql_fetch_row($sorokszama_sql);
	    $sorok_szama=$sorok_szama[0];
	    $sorok_szama++;
	    mysql_query("INSERT INTO `vendegk` (`nev`,`e-mail`,`datum`,`uzenet`,`ssz`) VALUES ('$nev','$email','$ts','$uzenet','$sorok_szama')") or die(mysql_error());
	    $hiba=false;
	    }
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="hu">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso8859-2">
<style type="text/css">
	a:visited    { color: #000000 }
	a:link    { color: #000000 }
	body { margin: 10px; margin-top: 0px; }
</style>
</head>
<body bgcolor="#f2ee9d">
<script language="javascript" type="text/javascript">
function valasz(datum)
    {
    document.form.vdatum.value=datum;
    }
</script>
    <?php
    include("abcsatl.php");
    include("./technikai/level_kiir.php");
    if (!isset($oldal))	$oldal=1;
    $sorok_szama_sql=mysql_query("SELECT COUNT(`datum`) FROM `vendegk`",$kapcsolat);
    $sorok_szama=mysql_fetch_row($sorok_szama_sql);
    $sorok_szama=$sorok_szama[0];
    $oldalak_szama=ceil($sorok_szama/50);
    print("<br>");
    for ($i=1;$i<=$oldalak_szama;$i++)
	{
	if ($oldalak_szama!=1)
	    {
	    ($i!=$oldal)?print("<a href='./level.php?oldal=$i'>$i</a> "):print($i.' ');
	    }
	}
    $limit=($oldal-1)*50;
    if ($limit<0) $limit=0;
    $eredmeny=mysql_query("SELECT `nev`,`e-mail`,`datum`,`uzenet`,`ssz` FROM `vendegk` ORDER BY `datum` DESC LIMIT $limit,50",$kapcsolat) or die(mysql_error());
    while ($egy_sor=mysql_fetch_row($eredmeny))
    	{
	kiir($egy_sor,false);
	}
    ?>
<form name="form" action="<?php print($_SERVER['PHP_SELF']); ?>" method="post">
<b>N&eacute;v:</b><br>
<input type="text" name="nev" value="<?php print(($hiba && isset($_POST['nev']))?$_POST['nev']:""); ?>"><br>
<b>E-mail:</b> <i>(Kit&ouml;lt&eacute;se nem k&ouml;telez&otilde;, a k&ouml;nnyebb kapcsolatfelv&eacute;telt szolg&aacute;lja)</i><br>
<input type="text" name="email" value="<?php print(($hiba && isset($_POST['email']))?$_POST['email']:""); ?>"><br>
<b>Robotszûrés:</b> <i>Aki m&aacute;snak vermet &aacute;s, maga <input type="text" name="jelszo" size="4" maxlength="4" value="<?php print(($hiba && isset($_POST['vdatum']))?$_POST['jelszo']:""); ?>"> bele. </i><br>
<b>&Uuml;zenet:</b><br>
<a name="alja"></a>
<textarea name="uzenet" rows="14" cols="80"><?php print(($hiba && isset($_POST['uzenet']))?$_POST['uzenet']:""); ?></textarea><br><br>
<input type="hidden" name="vdatum" value="<?php print(($hiba && isset($_POST['vdatum']))?$_POST['vdatum']:""); ?>">
<input type="submit" value="Elk&uuml;ld">
</form>
</body>
</html>

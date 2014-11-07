<?php
require_once("helper/init.php");
require_once("view/skeleton.php");

$nev=(isset($_POST['nev']))?$_POST['nev']:"";
$vdatum=(isset($_POST['vdatum']))?$_POST['vdatum']:"";
$email=(isset($_POST['email']))?$_POST['email']:"";
$jelszo=(isset($_POST['jelszo']))?$_POST['jelszo']:"";
$hiba=true;
global $hiba;
    if(isset($_POST['uzenet']))
	{
	$uzenet=$_POST['uzenet' ];
	if ($uzenet=="")
	    {
	    print("<font color=\"red\">");
	    print("<center><h2>Az üzenet mező kitötése kötelező</h2></center>");
	    print("<center><a style=\"color: red\" href=\"#alja\">Javítás</a></center>");
	    print("</font>");
	    }
	elseif ($nev=="")
	    {
	    print("<font color=\"red\">");
	    print("<center><h2>A név mező kitötése kötelező</h2></center>");
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
	    require_once("abcsatl.php");
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
		$stmt=$kapcsolat->prepare("SELECT `nev`,`ssz` FROM `vendegk` WHERE `datum`=:vdatum");
		$stmt->bindValue(":vdatum", $vdatum);
		$vnev=execquery($stmt);
		$uzenet="<i>Válasz ".$vnev[0]["nev"]." ".$vnev[0]["ssz"].". üzenetére:</i><br>".$uzenet;
		}
	    $stmt=$kapcsolat->prepare("SELECT `ssz` FROM `vendegk` ORDER BY `ssz` DESC LIMIT 0,1");
	    $sorok_szama=execquery($stmt);
	    $sorok_szama=$sorok_szama[0]["ssz"];
	    $sorok_szama++;
	    $stmt=$kapcsolat->prepare("INSERT INTO `vendegk` (`nev`,`e-mail`,`datum`,`uzenet`,`ssz`) VALUES (:nev,:email,:ts,:uzenet,:ssz)");
	    $stmt->bindValue(":nev", $nev);
	    $stmt->bindValue(":email", $email);
	    $stmt->bindValue(":ts", $ts);
	    $stmt->bindValue(":uzenet", $uzenet);
	    $stmt->bindValue(":ssz", $sorok_szama);
	    if (execquery($stmt))
		    $hiba=false;
	    }
	}
?>
<script language="javascript" type="text/javascript">
function valasz(datum)
    {
    document.getElementById("vdatum").value=datum;
    }
</script>
    <?php
    require_once("abcsatl.php");
    require_once("./technikai/level_kiir.php");
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
	    ($i!=$oldal)?print("<a href='./level.php?oldal=$i'>$i</a> "):print($i.' ');
	    }
	}
    $limit=($oldal-1)*50;
    if ($limit<0) $limit=0;
    $stmt=$kapcsolat->prepare("SELECT `nev`,`e-mail`,`datum`,`uzenet`,`ssz` FROM `vendegk` ORDER BY `datum` DESC LIMIT :limit,50");
    $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    $eredmeny=execquery($stmt);
    foreach ($eredmeny as $egy_sor)
    	{
	kiir($egy_sor,false);
	}
    ?>
<form name="form" action="<?php print($_SERVER['PHP_SELF']); ?>" method="post">
<b>Név:</b><br>
<input type="text" name="nev" value="<?php print(($hiba && isset($_POST['nev']))?$_POST['nev']:""); ?>"><br>
<b>E-mail:</b> <i>(Kitöltése nem kötelező, a könnyebb kapcsolatfelvételt szolgálja)</i><br>
<input type="text" name="email" value="<?php print(($hiba && isset($_POST['email']))?$_POST['email']:""); ?>"><br>
<b>Robotszűrés:</b> <i>Aki másnak vermet ás, maga <input type="text" name="jelszo" size="4" maxlength="4" value="<?php print(($hiba && isset($_POST['vdatum']))?$_POST['jelszo']:""); ?>"> bele. </i><br>
<b>Üzenet:</b><br>
<a name="alja"></a>
<textarea name="uzenet" rows="14" cols="80"><?php print(($hiba && isset($_POST['uzenet']))?$_POST['uzenet']:""); ?></textarea><br><br>
<input type="hidden" name="vdatum" id="vdatum" value="<?php print(($hiba && isset($_POST['vdatum']))?$_POST['vdatum']:""); ?>">
<input type="submit" value="Elküld">
</form>
</body>
</html>

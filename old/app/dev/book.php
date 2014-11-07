<?
require_once("helper/init.php");
require_once("view/skeleton.php");
?>
<?php
$konyvid=$_GET['konyv'];
$fejezet=$_GET['fejezet'];
if (isset($_GET['vers'])) $versugras=$_GET['vers'];
if (isset($_GET['szo'])) $szo=$_GET['szo'];
?>
<div id="szoveg">
<p style="text-align: justify"><font face="Palatino Linotype" size="4">
<?php
#	Kezdõértékek definiálása:
	require_once("abcsatl.php");
	require_once("helper/konyvnevek.php");
	$vers=1;
	$fh=$konyvid*1000000;
	$konyv=konyvnev($konyvid);
	if ($konyv == null) die ("A program egy könyv sorszámát várja (1-27), és ezt kapta: $konyvid");
	$fh=$fh+10000*$fejezet;
	$fhe=$fh-10000;
	$fhk=$fh+10000;
#	Adabbázisból lekérdezés:
	$ab="konyvek";
	$stmt=$kapcsolat->prepare("SELECT fh,unic FROM ".$ab." WHERE fh>:fh AND fh<:fhk ORDER BY fh ASC");
	$stmt->bindValue(":fh", $fh, PDO::PARAM_INT);
	$stmt->bindValue(":fhk", $fhk, PDO::PARAM_INT);
	$eredmeny=execquery($stmt);
	if (count($eredmeny)==0) print("Üres az adatbázis.");
#	Aktuális könyv címének kiírása:
	print ($konyv." ");
	if ($fh<10000000) {
			if (substr($fh,1,1)!=0) print substr($fh,1,1);
			print (substr($fh,2,1));
	} else {
			if (substr($fh,2,1)!=0) print substr($fh,2,1);
			print (substr($fh,3,1));
	}
	print("<br>");
#	Tartalom kiírása:
	foreach ($eredmeny as $egy_sor) {
		if ($egy_sor["fh"]>$fh+2000)
		    break;
		if ($egy_sor["fh"]>$fh+99) {
		    print("<sup>");
		    $link="";
		    if ($fh<10000000) {
		        if (substr($egy_sor["fh"],3,1)<>0) $link=substr($egy_sor["fh"],3,1);
		        $link=$link.substr($egy_sor["fh"],4,1);
		    } else {
		    	if (substr($egy_sor["fh"],4,1)<>0) $link=substr($egy_sor["fh"],4,1);
			$link=$link.substr($egy_sor["fh"],5,1);
		    }
		    $fh=$egy_sor["fh"];
		    $vers++;
		    print("<a name='$link' id='v$link' class='versid'>$link</a>");
		    print("</sup>");
		}
		$focused = ($_GET['szo'] == $egy_sor['fh'])?" focused" :"";
		if ($_SESSION['nojavascript']) {
			print("<a class=\"txt$focused\" href='".$_SERVER['PHP_SELF']."?konyv=".$konyvid."&fejezet=".$fejezet."&vers=".$link."&szo=".$egy_sor["fh"]."#$link' id='fh".$egy_sor["fh"]."' >");
		} else {
			print("<a class=\"txt$focused\"  id='fh".$egy_sor["fh"]."'  >");
			//?konyv=".$konyvid."&fejezet=".$fejezet."&vers=".$link."&szo=".$egy_sor["fh"]."' id='fh".$egy_sor["fh"]."' >");
		}
		print($egy_sor["unic"]);
		print("</a>");
		print("\n");
	}
#	Fókusz beállítása, ha kell:
	if (isset($versugras))
	{
	    print("<script language='javascript'>");
	    print("[x,y]=findPos(document.getElementById('v$versugras'));");
	    print("window.scrollTo(0,y);");
	    print("</script>");
	}
# Ezt elvileg újabban nem focus tulajdonsággal, hanem focused class-al kezelem. 2011.okt.15
#	if (isset($szo))
#	{
#	    print("<script language='javascript'>");
#	    print("document.getElementById('fh$szo').focus();");
#	    print("</script>");
#	}
#	Következõ könyv link:
	print ("</font></p><p align='center'><font face='Palatino Linotype' size='5'>");
	$fejezet++;
        $kovkonyv=floor($fh/1000000);
	$stmt=$kapcsolat->prepare("SELECT `hossz` FROM `konyvhossz` WHERE `konyv_id`=:kovkonyv");
	$stmt->bindValue(":kovkonyv", $kovkonyv);
	$konyvhossz=execquery($stmt);
	$konyvhossz=$konyvhossz[0]["hossz"];
	if ($fejezet<=$konyvhossz) print ("<br><a href='book.php?fejezet=$fejezet&konyv=$kovkonyv' id='kovetkezo'><u>Következő</u></a>");
	print ("</font></p>\n");
#	Ha nem letezo konyvet irt be
	if ($fejezet-1>$konyvhossz) {
	    print("<i>$konyv könyvben csak $konyvhossz fejezet van.</i>");
	}

?>
<script type="text/javascript" language="javascript">
var words = $("a.txt");
$(words).href="";
$(words).click(function(ev) {
	$("a.focused").removeClass("focused");
	$(ev.target).addClass("focused");
	var fh = $(ev.target).attr("id").substr(2);
	$("#explframe").attr("src", "explicate.php?fh=" + fh);
	$("#explicate").show();
});
</script>
</div>
<?
$explicate = true;
require_once("view/_footer.php");
?>

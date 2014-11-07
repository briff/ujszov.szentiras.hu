<?php
require_once("helper/init.php");
$fh=$_GET['fh'];
$ab="konyvek";
$szotab="szot";
require_once("view/_header.php");
?>
<style type="text/css">
	a:visited    { color: #000000 }
	a:link    { color: #000000 }
	a.underlined { text-decoration: underline; }
	p	{ font-family: Palatino Linotype;  margin: 0px;}
	.tartalom	{ text-align: center; }
	th.fejlec	{ text-align: center; }
</style>
<script language="javascript" type="text/javascript">
function ugras(fh) {
    if (!fh)
    	return;
    var konyv=Math.floor(fh/1000000);
    var fejezet=Math.floor((fh % 1000000)/10000);
    var vers=Math.floor((fh % 10000)/100);
    var parentLoc=parent.location.href;
    var pd = parent.document;
    var newParentLoc="book.php?konyv="+konyv+"&fejezet="+fejezet;
    if (parentLoc.indexOf(newParentLoc)>-1) {
	removeFocused(pd);
	var szo = pd.getElementById("fh"+fh);
	addClass(szo, "focused");
        location.href="explicate.php?fh="+fh;
    } else {
	parent.location.href=newParentLoc+"&vers="+vers+"&szo="+fh;
    }
}
</script>
<?php
    function elemez($mit,$keres) {
    /** $mit nevű 'szótár' fájlban megkeresi a $keres '.'-al elválaszott részeit.**/
	#inicializacio
	$terms=explode(".",trim($keres));
	$dict=array();
	$re="";
	#szotar feltoltese
	$f=fopen($mit,'r');
	while (!feof($f)) {
		$sor=explode("\t",fgets($f,1024));
		$sor[0]=rtrim($sor[0],".");
		if ($sor[0] != "") //az utolsó üres sor
			$dict[$sor[0]]=$sor[1];
	}
	#Ellenorzo kiiras
	//print("<pre>");
	//print_r($dict);
	//print("</pre>");
	#Keresesi terminusok "leforditasa"
	foreach ($terms as $term) {
		if ($term != "")
		$re.=trim($dict[$term]).", ";
	}
	$re=rtrim($re, ", ");
	#visszateres
	//print($re);
	return $re;
    }
    function fhbollink($fh) {
	global $kapcsolat;
	$stmt=$kapcsolat->prepare("SELECT lh FROM `konyvek` WHERE fh='$fh'");
	$stmt->bindValue(":fh", $fh);
	$eredmeny=execquery($stmt);
	$lh=($eredmeny==null)?"":ltrim($eredmeny[0]["lh"]);
	$vissza=array(/*lh,konyv,fejezet,vers,szo*/);
	$vissza[0]=$lh;
	$vissza[1]=floor($fh/1000000);
	$vissza[2]=floor($fh/10000)-100*$vissza[1];
	$vissza[3]=floor($fh/100)-100*$vissza[2]-10000*$vissza[1];
	$vissza[4]=$fh-100*$vissza[3]-10000*$vissza[2]-1000000*$vissza[1];
	return($vissza);
    }
    function printlink($text, $fh, $nojs) { // Előző/következő szóalakok linkjeit jeleníti meg.
    	$info = fhbollink($fh);
	print("<a class=\"underlined\" href=\"");
	if ($nojs) {
		print("book.php?konyv=".$info[1]."&fejezet=".$info[2]."&vers=".$info[3]."&szo=".$fh."#$info[3]\" target=\"_top");
	} else {
		print("javascript:ugras($fh)");
	}
	print("\">".$text."</a> ".$info[0]."<br>\n");
    }








	# csatlakozas az adatbazishoz
	require_once("abcsatl.php");
	$fhkeres=$fh;
	# a megfelelo sor lekerese az adatbazisbol
	$stmt=$kapcsolat->prepare("SELECT $ab.lh,$ab.unic,$ab.mj,$ab.szf,$ab.elem,$ab.szal,$ab.lj,$ab.gk,$szotab.mj,$szotab.valt FROM $ab,$szotab WHERE $ab.fh=:fh AND $szotab.gk=$ab.gk");
	$stmt->bindValue(":fh", $fh);
	$eredmeny=execquery($stmt, true, PDO::FETCH_NUM);
	if ($eredmeny == null)  die("A szót nem találom. Hibakód: ".print_r($kapcsolat->errorInfo(), true));
	$sorok_szama=count($eredmeny);
	if ($sorok_szama == 0) die("Nem találom a szót az adatbázisban\n");
	print ("<table border='3' style='border-collapse: collapse; border-color: #111111;'>\n");

	# tablazat fejlece
	print ("<tr>\n");
	print ("\t<th class=\"fejlec\">Szó helye</th>\n");
	print ("\t<th class=\"fejlec\">Görög alak</th>\n");
	print ("\t<th class=\"fejlec\">Magyar jelentés</th>\n");
	print ("\t<th class=\"fejlec\">Szófaj</th>\n");
	print ("\t<th class=\"fejlec\">Elemzés</th>\n");
	print ("\t<th class=\"fejlec\">Szótári alak</th>\n");
	print ("\t<th class=\"fejlec\">Változatok</th>\n</tr>");

	$egy_sor=$eredmeny[0];
	print ("<tr>\n");
	for ($v=0;$v<=5;$v++) { # tablazat feltoltese atatokkal 
		if ($v==4) {
			$elemzett=elemez("elem.txt",$egy_sor[4]);
			print ("\t<td><p class='tartalom' title='$elemzett'>$egy_sor[4]</p></td>\n");
		} elseif ($egy_sor[$v] !="") {
			print ("\t<td><p class='tartalom'>$egy_sor[$v]</p></td>\n");
		} else {
			print ("\t<td><p class='tartalom'>-</p></td>\n");
			# celát létrehoz, beleír, kilép belõle
		}
	}

	# a változatok is a táblázatba kerülnek
	print ("<td>");
	if ($egy_sor[9]!="") {
		print("<font face='palatino linotype'>".$egy_sor[9]."</font>\n");
	} else {
		print("nincsenek\n");
	}
	print ("</td></tr></table>\n");

	# Szotari informaciok
	print ("<strong> Szótári információk: </strong>\n");
	if ($egy_sor[8]!="") {
		print("<span style='font-family: Palatino Linotype'>".$egy_sor[8]."</span><br>\n");
	} else {
		print ("nincsenek<br>\n");
	}

	# labjegyzet, megjegyzes
	$labjegyzet=$egy_sor[6];
	print ("<strong>");
	print ("Lábjegyzet:  ");
	print ("</strong>\n");
	if($labjegyzet !="") {
		print ($labjegyzet);
	} else {
		print ("nincs\n");
	}
	print ("<br>\n");


	print ("<br>\n");
	print("<br>\n");
	?>
<table border='0' width='100%' style='border-collapse: collapse;'>
  <tr>
    <td>
	<?
#	Konkordancia szerinti elso/utolso
	$stmt=$kapcsolat->prepare("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' order by fh asc limit 0,1");
	$konkordancia_first=execquery($stmt);
	$stmt=$kapcsolat->prepare("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' order by fh desc limit 0,1");
	$konkordancia_last=execquery($stmt);
	$feh=$konkordancia_first[0]["fh"];
	$fkh=$konkordancia_last[0]["fh"];
	$hepax=false; //Csak egyszer fordul elő
	if ($feh != $fh) {
		printlink("Első azonos szótári alakú szó:", $feh, $_SESSION['nojavascript']);
	} elseif ($feh != $fkh) {
		print("Ez az első ilyen szóalak\n");
	} else {
		$hepax=true;
		print("Hapaxlegomenon\n");
	}
	print("<br>\n");
#	Konkordancia szerinti elozo/kovetkezo
	$stmt=$kapcsolat->prepare("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' and fh>:fh order by fh asc limit 0,1");
	$stmt->bindValue(":fh", $fh);
	$konkordancia_next=execquery($stmt);
	$stmt=$kapcsolat->prepare("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' and fh<:fh order by fh desc limit 0,1");
	$stmt->bindValue(":fh", $fh);
	$konkordancia_prev=execquery($stmt);
	$feh=$konkordancia_prev[0]["fh"];
	$fkh=$konkordancia_next[0]["fh"];
	if ($feh) {
		printlink("Előző azonos szótári alakú szó:", $feh, $_SESSION['nojavascript']);
	}
	if ($fkh) {
		printlink("Következő azonos szótári alakú szó:", $fkh, $_SESSION['nojavascript']);
	} elseif (!$hepax) {
		print("Ez az utolsó ilyen szóalak\n");
	}
	?>
    </td>
    <td>
    	<?
#	Szotari alak szerinti elozo/kovetkezo
	$stmt=$kapcsolat->prepare("SELECT feh,fkh FROM $ab WHERE fh=:fh");
	$stmt->bindValue(":fh", $fh);
	$eredmeny=execquery($stmt);
	$feh=$eredmeny[0]["feh"];
	$fkh=$eredmeny[0]["fkh"];
	printlink("Abc-rendben előző szóalak:", $feh, $_SESSION['nojavascript']);
	printlink("Abc-rendben következő szóalak:", $fkh, $_SESSION['nojavascript']);
#Elõzõ és következõ linkek ^
?>
    </td>
  </tr>
</table>
<?require_once("view/_footer.php");?>

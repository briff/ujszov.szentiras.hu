<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="hu">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<style type="text/css">
	a:visited    { color: #000000 }
	a:link    { color: #000000 }
	p	{ font-family: Palatino Linotype;  margin: 0px;}
	.fejlec	{ text-align: center; font-weight: bold; }
	.tartalom	{ text-align: center; }
</style>
<script language="javascript" type="text/javascript">
function ugras(fh) {
    if (!fh)
    	return;
    var konyv=Math.floor(fh/1000000);
    var fejezet=Math.floor((fh % 1000000)/10000);
    var ugras=Math.floor((fh % 10000)/100);
    var Mkv=parent.szoveg.location.href;
    var newMkv="Mkv.php?konyv="+konyv+"&fejezet="+fejezet;
    if (Mkv.indexOf(newMkv+"&")>-1) {
    	parent.szoveg.document.getElementById("fh"+fh).focus();
    } else {
	parent.szoveg.location.href=newMkv+"&ugras="+ugras+"&ugras_szo="+fh;
    }
    parent.lap.location.href="db3.php?fh="+fh;
}
</script>
</head>
<body  bgcolor="#999898">
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
	/*
	$bontott=explode(".",$keres);
	#a '.' határolójeleknél felbontja a $keres paramétert, és a bontott tömbben tárolja.
	$keres="";
	$k=0;
	$tfile=array(array());
	$f=fopen($mit,'r');
	while (!feof($f))
	    {
	    $sor=fgets($f,1024);
	    $szo="";
	    $j=0;
	    while ($sor[$j]!=".")
		{
		$szo=$szo.$sor[$j];
		$j++;
		}
	    $tfile[$k][0]=$szo;
	    $tfile[$k][1]=substr($sor,$j+2);
	    $k++;
	    }
	for ($l=0;$l<(count($bontott)-1);$l++)
	{
	    $i=0;
	    foreach ($tfile as $sor)
		{
		if ($sor[0]==$bontott[$l])
		    {
		    $bontott[$l]=$tfile[$i][1];
		    }
		$i++;
		}
	    if ($l<(count($bontott)-2))
		{
		$keres=$keres.$bontott[$l].", ";
		}
	    else
		{
		$keres=$keres.$bontott[$l];
		}
	    }
#	$keres="'".$keres."'";
	return $keres;
	*/
    }
    function fhbollink($fh) {
	$eredmeny=mysql_query("SELECT lh FROM `konyvek` WHERE fh='$fh'");
	$lh=mysql_fetch_row($eredmeny);
	$lh[0]=ltrim($lh[0]);
	$vissza=array(/*lh,konyv,fejezet,vers,szo*/);
	$vissza[0]=$lh[0];
	$vissza[1]=floor($fh/1000000);
	$vissza[2]=floor($fh/10000)-100*$vissza[1];
	$vissza[3]=floor($fh/100)-100*$vissza[2]-10000*$vissza[1];
	$vissza[4]=$fh-100*$vissza[3]-10000*$vissza[2]-1000000*$vissza[1];
	return($vissza);
    }








	include("abcsatl.php");
	# csatlakozas az adatbazishoz
	$fhkeres=$fh;
	//$ab=include("melyik_tabla.php");
	$ab="konyvek";
	$eredmeny=mysql_query("SELECT $ab.lh,$ab.unic,$ab.mj,$ab.szf,$ab.elem,$ab.szal,$ab.lj,$ab.gk,szot.mj,szot.valt FROM $ab,szot WHERE $ab.fh='$fh' AND szot.gk=$ab.gk",$kapcsolat)
or die("A szót nem találom. Fejlesz&eacute;s alatt.".mysql_error());
	$sorok_szama=mysql_num_rows($eredmeny);
	# a megfelelo sor lekerese az adatbazisbol
	print ("<table border='3' style='border-collapse: collapse; border-color: #111111;'>\n");
	if ($sorok_szama != 0) {
//		print ("<font face='Palatino Linotype' size='5'>");
		print ("<tr>\n");
		print ("\t<td><p class='fejlec'>Sz&oacute; helye</p></td>\n");
		print ("\t<td><p class='fejlec'>G&ouml;r&ouml;g alak</p></td>\n");
		print ("\t<td><p class='fejlec'>Magyar jelent&eacute;s</p></td>\n");
		print ("\t<td><p class='fejlec'>Sz&oacute;faj</p></td>\n");
		print ("\t<td><p class='fejlec'>Elemz&eacute;s</p></td>\n");
		print ("\t<td><p class='fejlec'>Sz&oacute;t&aacute;ri alak</p></td>\n");
		print ("\t<td><p class='fejlec'>V&aacute;ltozatok</p></td>\n</tr>");
		# tablazat fejlece
		if ($egy_sor=mysql_fetch_row($eredmeny)) {
			print ("<tr>\n");
			for ($v=0;$v<=5;$v++) {
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
		}
//		print ("</font>");
	} else {
		print("Nem tal&aacute;lom a sz&oacute;t az adatb&aacute;zisban\n");
	}
#	 tablazat feltoltese atatokkal ^

	//$eredmeny=mysql_query("SELECT lj,gk FROM $ab WHERE fh='$fh'",$kapcsolat);
	//$sorok_szama=mysql_num_rows($eredmeny) or die("A sz&oacute;t nem tal&aacute;lom. Fejlesz&eacute;s alatt");
//	print ("<br>");
	//$egy_sor=mysql_fetch_row($eredmeny);
	$gk=$egy_sor[7];
	$labjegyzet=$egy_sor[6];
	//$eredmeny=mysql_query("SELECT mj,valt FROM szot WHERE gk='$gk'",$kapcsolat);
	print ("<td>");
	if ($egy_sor[9]!="") {
		print("<font face='palatino linotype'>".$egy_sor[9]."</font>\n");
	} else {
		print("nincsenek\n");
	}
	# a változatok is a táblázatba kerülnek, de a lekérdezés már elõkészíti a következõt
	print ("</td></tr></table>\n");
	print ("<strong> Sz&oacute;t&aacute;ri inform&aacute;ci&oacute;k: </strong>\n");
	if ($egy_sor[8]!="") {
		print("<span style='font-family: Palatino Linotype'>".$egy_sor[8]."</span><br>\n");
	} else {
		print ("nincsenek<br>\n");
	}
#	 labjegyzet, megjegyzes ^





	print ("<font face='Palatino linotype'><strong>");
	print ("L&aacute;bjegyzet:  ");
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
#	Konkordancia szerinti elso
	$konkordancia_first_sql=mysql_query("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' order by fh asc limit 0,1");
	$konkordancia_last_sql=mysql_query("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' order by fh desc limit 0,1");
	$konkordancia_first=mysql_fetch_row($konkordancia_first_sql);
	$konkordancia_last=mysql_fetch_row($konkordancia_last_sql);
	$feh=$konkordancia_first[0];
	$fkh=$konkordancia_last[0];
	$elozo=fhbollink($feh);
	$kovetkezo=fhbollink($fkh);
	if ($feh != $fh) {
		print("<a href=\"javascript:ugras($feh)\">Els&otilde; azonos sz&oacute;t&aacute;ri alak&uacute; sz&oacute;:</a> ");
		print($elozo[0]."\n");
	} elseif ($feh != $fkh) {
		print("Ez az els&otilde; ilyen sz&oacute;alak\n");
	} else {
		$hepax=true;
		print("Hapaxlegomenon\n");
	}
	print("<br>\n");
#	Konkordancia szerinti elozo/kovetkezo
	$konkordancia_next_sql=mysql_query("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' and fh>'$fh' order by fh asc limit 0,1");
	$konkordancia_prev_sql=mysql_query("SELECT fh,lh FROM $ab WHERE szal='".$egy_sor[5]."' and fh<'$fh' order by fh desc limit 0,1");
	$konkordancia_next=mysql_fetch_row($konkordancia_next_sql);
	$konkordancia_prev=mysql_fetch_row($konkordancia_prev_sql);
	$feh=$konkordancia_prev[0];
	$fkh=$konkordancia_next[0];
	$elozo=fhbollink($feh);
	$kovetkezo=fhbollink($fkh);
	if ($feh) {
		print("<a href=\"javascript:ugras($feh)\">El&otilde;z&otilde; azonos sz&oacute;t&aacute;ri alak&uacute; sz&oacute;:</a> ");
		print($elozo[0]."<br>\n");
	}
	if ($fkh) {
		print("<a href=\"javascript:ugras($fkh)\">K&ouml;vetkez&otilde; azonos sz&oacute;t&aacute;ri alak&uacute; sz&oacute;:</a> ");
		print($kovetkezo[0]."<br>\n");
	} elseif (!$hepax) {
		print("Ez az utols&oacute; ilyen sz&oacute;alak\n");
	}
	?>
    </td>
    <td>
    	<?
#	Szotari alak szerinti elozo/kovetkezo
	$eredmeny=mysql_query("SELECT feh,fkh FROM $ab WHERE fh='$fh'",$kapcsolat);
	$egy_sor=mysql_fetch_row($eredmeny);
#	$eredmeny=mysql_query("SELECT fh FROM $ab WHERE gk=(SELECT gk FROM $ab WHERE
	$feh=$egy_sor[0];
	$fkh=$egy_sor[1];
	$elozo=fhbollink($feh);
	$kovetkezo=fhbollink($fkh);
	print("<a href=\"javascript:ugras($feh)\">Abc-rendben el&otilde;z&otilde; sz&oacute;alak:</a>");
	print($elozo[0]."<br>\n");
	print("<a href=\"javascript:ugras($fkh)\">Abc-rendben k&ouml;vetkez&otilde; sz&oacute;alak:</a>");
	print($kovetkezo[0]."<br>\n");
	mysql_close($kapcsolat);
#Elõzõ és következõ linkek ^
?>
    </td>
  </tr>
</table>
<br><i>Az egeret az elemz&eacute;s f&ouml;l&eacute; h&uacute;zva megjelenik magyarul.</i>
</body>
</html>

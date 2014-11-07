<?php

$konyvek_tablename="konyvek";
$szotar_tablename="szot";

function debug ($var) {
	(is_array($var))?print_r($var):print($var);
}
function konyvtarkiir($kezdo_kvt) {
	//print("$kezdo_kvt");
  	if (! is_dir($kezdo_kvt)) {
	print("Az adatforrásokat a <i>$kezdo_kvt</i> mappának kéne tartalmaznia. Ezt én nem találom.");
	return;
	}
	print("   <ul class=\"mappa\">\n");
	print("    <li>$kezdo_kvt</li>\n");
	print("     <ul class=\"fajlok\">\n");
	$kvt=opendir($kezdo_kvt);
	while (($element=readdir($kvt)) !== false) {
		if ($element=="." || $element == "..") continue;
		if (is_dir("$kezdo_kvt/$element")) {
			//print("<ul class=\"mappa\">\n");
			//print("<li> $element</li>\n");
			//print("konyvtarkiir(\"$kezdo_kvt/$element\");");
			konyvtarkiir("$kezdo_kvt/$element");
			//print("</ul>\n");

		} else {
			print("      <li><a href=\"javascript:setFajl('$kezdo_kvt/$element')\">");
			print("$element<a></li>\n");
		}
	}
	closedir($kvt);
	print("     </ul>\n");
	print("   </ul>\n");
	return;
}
function konyvek_query( $tordelt, $insert=false) { // Ha insert=true, akkor update helyett insert
global $konyvek_tablename;
for ($i=count($tordelt);$i<=16;$i++) { //Inicializálatlan mezők feltöltése
	if (isset($tordelt[$i])) print("HIBA! Töröltem egy értékes adatot: ".$tordelt[$i]."<br />\n");
	$tordelt[$i]="";
}
return ($insert) ?
	"INSERT INTO `".$konyvek_tablename."` (`lh`, `fh`, `feh`, `fkh`, `unic`,
	  `grae`, `rk`, `ef`, `lj`, `mj`, `szf`, `elem`, `bk`,
	  `felelos`, `gk`, `hj`, `szal`)
	 VALUES ('".$tordelt[0]."', '".$tordelt[1]."', '".$tordelt[2].
	  "', '".$tordelt[3]."', '".$tordelt[4]."', '".$tordelt[5].
	  "', '".$tordelt[6]."', '".$tordelt[7]."', '".$tordelt[8].
	  "', '".$tordelt[9]."', '".$tordelt[10]."', '".$tordelt[11].
	  "', '".$tordelt[12]."', '".$tordelt[13]."', '".$tordelt[14].
	  "', '".$tordelt[15]."', '".$tordelt[16]."') ;"
	:
	"UPDATE `".$konyvek_tablename."` SET `lh`='".$tordelt[0]."',
	 `fh`='".$tordelt[1]."', `feh`='".$tordelt[2]."',
	 `fkh`='".$tordelt[3]."', `unic`='".$tordelt[4]."',
	 `grae`='".$tordelt[5]."', `rk`='".$tordelt[6]."',
	 `ef`='".$tordelt[7]."', `lj`='".$tordelt[8]."',
	 `mj`='".$tordelt[9]."', `szf`='".$tordelt[10]."',
	 `elem`='".$tordelt[11]."', `bk`='".$tordelt[12]."',
	 `felelos`='".$tordelt[13]."', `gk`='".$tordelt[14]."',
	 `hj`='".$tordelt[15]."', `szal`='".$tordelt[16]."'
	 WHERE `fh`='".$tordelt[1]."';";
}
function szotar_query( $tordelt, $insert=false) { // Ha insert=true, akkor update helyett insert
global $szotar_tablename;
for ($i=count($tordelt);$i<=7;$i++) { //Inicializálatlan mezők feltöltése
	if (isset($tordelt[$i])) print("HIBA! Töröltem egy értékes adatot: ".$tordelt[$i]."<br />\n");
	$tordelt[$i]="";
}
return ($insert) ?
	"INSERT INTO `".$szotar_tablename."` (`gk`, `szal`, `szf`, `valt`, `mj`, `elem`, `strong`, `bk`)
	VALUES (
	 '".$tordelt[0]."', '".$tordelt[1]."', '".$tordelt[2]."', '".$tordelt[3].
	 "', '".$tordelt[4]."', '".$tordelt[5]."', '".$tordelt[6]."', '".$tordelt[7]."');"
	:
	"UPDATE `".$szotar_tablename."` SET 
	 `szal`='".$tordelt[1]."', `szf`='".$tordelt[2]."',
	 `valt`='".$tordelt[3]."', `mj`='".$tordelt[4]."',
	 `elem`='".$tordelt[5]."', `strong`='".$tordelt[6]."',
	 `bk`='".$tordelt[7]."'
	 WHERE `gk`='".$tordelt[0]."';";
}
function fajlolvas(&$file, &$query, $tipus, $general){
	$j=0;
	while (($sor = trim(fgets($file))) && (memory_get_usage()<8000000)) {
		$tordelt=explode("\t", $sor);
		for ($i=0;$i<count($tordelt); $i++) { //Idézőjelek levágása a mezők elejéről/végéről
			/* Nem tudom, miért így volt megoldva. Honnan kerülne bele a \ karakter az idézőjelek elé... Töröltem. 2014.03.15.
			if (strlen($tordelt[$i])>0 && (substr($tordelt[$i],0,2) =="\\\"" && substr($tordelt[$i],strlen($tordelt[$i])-2) == "\\\""))
				$tordelt[$i]=substr($tordelt[$i],2,-2);
			$tordelt[$i] = str_replace("\\"."\"", "\"", $tordelt[$i]);
			*/
			if (strlen($tordelt[$i])>0 && (substr($tordelt[$i],0,1) =="\"" && substr($tordelt[$i],strlen($tordelt[$i])-1) == "\""))
				$tordelt[$i]=substr($tordelt[$i],1,-1);
			$tordelt[$i] = str_replace("'", "\\"."'", $tordelt[$i]);
		}
		$query[$j]=$tipus($tordelt, $general);
//		print($query[$j]);
		$j++;
	}
//	return (memory_get_usage);
}
function execsql(&$query,&$kapcsolat) {
	$affect=0;
	foreach($query as $one_query) {
		mysql_query($one_query, $kapcsolat) or print(mysql_error()."<br>".$one_query);
		if (mysql_affected_rows() > 1) {
			print("Ebb&oacute;l valami&eacute;rt ".mysql_affected_rows()."sort is &aacute;t&iacute;rtam:<br>\n");
			print($one_query);
		}
		$affect+=mysql_affected_rows();
		//print($one_query."<br>\n");
	}
	return $affect;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style lang="text/css">
p.it {
	font-style: italic;
	font-size:10pt;
}
ul.mappa {
	font-family: courier;
	list-style-image: url(convert_files/mappa.png);
}
ul.fajlok {
	font-family: courier;
	list-style-image: url(convert_files/fajl.png);
}
a {
  	color: #000000;
  }
p.help span {
	display: none;
}
p.help:hover span {
	display: inline;
	font-style: italic;
}
</style>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript">
function setFajl (ujErtek) {
	document.form.fajl_text.value=ujErtek;
}
function elkuld() {
	if (document.form.fajl_text.value.length==0) {
		alert("Nincs megadva fájlnév.");
	} else {
		document.form.fajl.value=document.form.fajl_text.value;
		document.form.submit();
	}
}
</script>
</head>
<body>
<?php
/*
print("<pre>");
print_r($tordelt);
print("</pre>");
*/
$time=time();
$begin=$time;
$affect=0;
$read=0;
if (isset ($_POST["fajl"]) && file_exists($_POST["fajl"])) {
	if (!isset($_POST["tipus"]) ) die("Nincs megadva a konvertálás típusa.");
	$tipus=$_POST["tipus"]."_query";
	$tablename=${$_POST['tipus']."_tablename"};
	$general=(isset($_POST["general"]) && $_POST["general"]);
	$kapcsolat=include("../abcsatl.php");
	if ($general) {
		print("Kor&aacute;bbi adatok t&ouml;rl&eacute;se az adatb&aacute;zisb&oacute;l...");
		mysql_query("TRUNCATE TABLE `".$tablename."`;") or die(mysql_error());
		print(" OK<br>\n");
	}
	$query=array();
	$file=fopen($_POST["fajl"],"r");
	print("Fájl olvasása...");
	fajlolvas($file, $query, $tipus, $general);
	while (!feof($file)) {
		print("<br>\nMegtelt a mem&oacute;ria ".count($query)." sor olvas&aacute;sa ut&aacute;n. (");
		$read+=count($query);
		print(time()-$time);
		print("s)<br>\n");
		print("Írás az adatbázisba...");
		$affect_now=execsql($query,$kapcsolat);
		$affect+=$affect_now;
		$query=array();
		print("<br>\nMem&oacute;ria felszabad&iacute;tva, $affect_now sor friss&iacute;tve az adatb&aacute;zisban. (");
		print(time()-$time."s)<br>\n");
		$time=time();
		fajlolvas($file,$query,$tipus, $general);
	}
	print("A f&aacute;jl v&eacute;g&eacute;re &eacute;rtem ".count($query)." sor ut&aacute;n. (");
	$read+=count($query);
	print(time()-$time);
	print("s)<br>\n");
	$time=time();
	print("Írás az adatbázisba...");
	$affect_now=execsql($query,$kapcsolat);
	$affect+=$affect_now;
	print(" (");
	print(time()-$time);
	print("s)<br>\n");
	fclose($file);
	print("<br>\nKonvertálás sikeresen befejezve.<br>\n");
	print("&Ouml;sszesen $read sort olvastam, ebb&otilde;l $affect sor friss&uuml;lt, ");
	print(time()-$begin);
	print("s alatt.<br>\n");
	$optstart=time();
	print("T&aacute;bla optimaliz&aacute;l&aacute;... ");
	mysql_query("OPTIMIZE TABLE `".$tablename."`", $kapcsolat) or die(mysql_error());
	$opttime=time()-$optstart;
	print("OK ($opttime s)<br>\n");
	mysql_close($kapcsolat);

/*
print("<pre>");
print_r($tordelt);
print("</pre>");
*/
	die("</body>\n</html>\n");
}
?>
<h1>Konvertáló program</h1>
<p>Ezen a felületen kereszül lehet frissíteni az adatbázist.</p>
<p class="it">A program bemenete egy .txt, vagy egy .csv tabulátorokkal tagolt
szövegfájl, mely frissítendő sorokat tartalmazza. A szövegelválasztó karakter
a dupla idézőjel ("). Elvileg készült egy makró, ami legenerálja,
de az imént említett beállítások mellett csv, vagy txt szabvánnyal
elmentve az Excell automatikusan legenerálja.
Íme két mintasor:</p>

<pre>"Mt 1,1,1"	1010101	27030517	27221934	"&#914;&#943;&#946;&#955;&#959;&#962;"	"Bivblo""	"b i b k o s"	1	""	"könyv"	"nm."	"f.sg.nom."	"976"	""	9760	""	"&#946;&#943;&#946;&#955;&#959;&#962;&#44;&#32;&#45;&#959;&#965;"</pre>
<p class="it">Valamint szótár:</p>
<pre>210	"&#7936;&#947;&#945;&#955;&#955;&#953;&#940;&#969;"	"verb."	"&#7936;&#947;&#945;&#955;&#955;&#953;&#940;&#969;, &#7936;&#947;&#945;&#955;&#955;&#953;&#940;&#963;&#969; ?, &#7968;&#947;&#945;&#955;&#955;&#943;&#945;&#963;&#945;, &#7968;&#947;&#945;&#955;&#955;&#953;&#940;&#954;&#945; ?, ?, ?"	"&#246;r&#252;l, &#246;rvendezik, ujjong"	"ELEM"	"STRONG"	"BK"</pre>
<hr><p></p>
<form name="form" acion="<? print($_SERVER['PHP_SELF']); ?>" method="post">
  <p>Milyen típusú fájlt kell konvertálni?</p>
  <p><label for="konyvek">Könyvek</label> <input type="radio" name="tipus" value="konyvek" id="konyvek" checked />
     <label for="szotar">Szótár</label> <input type="radio" name="tipus" value="szotar" id="szotar" /></p>
  <p class="help"><label for="general">General update</label> <input type="checkbox" name="general" id="general" />
    <span class="helpmsg">
      Abban az esetben, ha az új verzióban kevesebb szó van
    </span>
  </p>
  <p>Melyik a forrásfájl?</p>
  <p><input type="text" name="fajl_text" disabled>
   <input type="hidden" name="fajl" />
   <input type="button" value="Konvertál" onclick="elkuld()" /></p>
  <?php
  konyvtarkiir("forrasok");
  ?>

</body>
</html>

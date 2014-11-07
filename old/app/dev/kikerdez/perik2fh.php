<html>
<?php
function konyvek()
#Visszatétérsi értéke egy tömb, mely könyvneveket, és sorszámukat tartalmaz.(nev=>id)
#Használja a konyvnevek fájlt.
{
    $konyvek=array();
    $konyvek_sql=mysql_query("SELECT `nev`, `konyv_id` FROM `konyvnevek`");
    while ($sor=mysql_fetch_row($konyvek_sql))
    	$konyvek[strtolower(trim($sor[0]))]=$sor[1];
    /*
    if (!($fajl=fopen("./konyvek.dat","r")))
    {
	print("HIBA! Nem tal&aacute;lom a konyvek.dat f&aacute;jlt");
	return false;
    }
    while ($sor=fgets($fajl,1024))
    {
	array_push($konyvek,strtolower(trim($sor)));
    }
    */
    return $konyvek;
}
function helybolfh ($hely, $elejekell)
#$hely egy tömb (konyv, fejezet, vers, szo) mezõkkel.
#A tömb nem asszociatív, és nincs feltélenúl meg minden adata.
#$elejekell logikai típusú: a perikopa elsõ szavát keressük? (ellenkezõ esetben az utolsót)
#visszaad egy ellenõrizetlen fh-t.
{
    if (!$elejekell) $hely[count($hely)-1]++;
    for ($i=count($hely);$i<5;$i++)
    {
	$hely[$i]=$elejekell;
    }
    return ($hely[0]*1000000+$hely[1]*10000+$hely[2]*100+$hely[3]);
    
} 
function ellenoriz ($hely)
#Egy ,,lh" helyrõl dönti el, hogy megfelelõ formátumú-e.
#Ez a következõkbõl áll:
#    -a szóköz elõtti rész benne van-e a konyvnevek táblában.
#    -a megengedettnél több szóközt (1) vagy vesszõt (2) tartalmaz.
#    -csupa pozitiv egesz szam szerepel-e (ellenkezo esetben probal korrigalni)
#A fuggveny a vegen egy tombbel ter vissza, ami a konyv, fejezet, vers, szo-t tartalmazza.
{
    if (!($konyvek=konyvek())) return false;
    $konyv=explode(" ",$hely);
    if (count($konyv)>2)
    {
	print("HIBA: $hely <br>");
	return false;
    }
    $index=$konyvek[strtolower($konyv[0])];
    if ($index == "")
    {
	print("Nincs ilyen k&ouml;ny: $konyv[0] <br>");
	return false;
    }
    $szamok=explode(",",$konyv[1]);
    if (count($szamok)>3)
    {
	print("HIBA: $konyv[1] <br>");
	return false;
    }
    array_unshift($szamok,$index);
    if ($szamok[1]=="") unset($szamok[1]);
    //print (count($szamok)."!<br>\n");
    for ($i=0;$i<count($szamok);$i++)
    {
	settype($szamok[$i],"integer");
	if ($szamok[$i]<1)
	{
	    print("HIBA: ez csak pozitiv lehetne$i: $szamok[$i] <br>");
	}
    }
    return $szamok;
}

function perik2fh ($perikopa)
#A perikópákból létrehoz egy tömböt, melynek elemei a perikópában szereplõ különbözõ a szavak fh-i.
#A tombot sql-feltetelle osszefuzve adja vissza
{
//    require_once ("./abcsatl.php");
    $osszesfh=array();
    $helyek=explode(".", $perikopa);
    for ($i=0;$i<count($helyek);$i++)
    {
	//if (strpos($helyek[$i], '-')>0)
	//{
	    $hatar=explode('-', $helyek[$i]);
	    if ($hatar[0]=="") break;
	    $tovabb=true;
	    ($kezd=ellenoriz($hatar[0])) ? ($fhk=helybolfh($kezd, true)) : $tovabb=false;
	    if (!$tovabb) break;
	    if (count($hatar)>1 && $hatar[1]!="")
	    {
		($veg=ellenoriz($hatar[1])) ? $fhv=helybolfh($veg, false) : $tovabb=false;
		if (!$tovabb) break;
	    }
	    else
	    {
		$fhv=helybolfh($kezd, false);
		if (count ($hatar)>2) print("Nem használtam fel a k&ouml;vetkez&otilde;t, mert hib&aacute;s form&aacute;tumot adna: ". implode("-",$hatar[2]));
	    }
	    $fhtartomany=array($fhk,$fhv);
	    array_push($osszesfh,$fhtartomany);
    }
    $helyek="";
    $osszesfh_felt=array();
    for ($i=0;$i<count($osszesfh);$i++)
    {
	$osszesfh_felt[$i]="(`konyvek`.`fh`>='".$osszesfh[$i][0]."' AND `konyvek`.`fh`<'".$osszesfh[$i][1]."')";
    }
    $helyek=implode(" OR ", $osszesfh_felt);
//    print($helyek);
    return (($helyek)?$helyek:0);
}

?>
</html>

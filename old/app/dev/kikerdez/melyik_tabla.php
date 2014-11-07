<html>
<?php


#Kikeresi a keresendõ nevet, vagy fh-t, és kiadja a mellét tartozó másik adatot
array($konyv_nev);
array($szam_fh);
$szam_fh[0]=0;
$konyv_nev[0]="";
for ($i=1;$i<=27;$i++)
    {
    $szam_fh[$i]=$i*1000000;
    }
#feltölti sorban a megfelelõ fh könyvinformációkkal a $szam_fh tömböt
$fajl=fopen("./konyvek.dat","r");
$i=1;
while (!(feof($fajl)))
    {
    $konyv_nev[$i]=fgets($fajl);
    $konyv_nev[$i]=substr($konyv_nev[$i],0,strlen($konyv_nev[$i])-1);
    $i++;
    }
fclose($fajl);
#feltölti sorban a megfelelõ könyvnevekkel a $konyv_nev tömbböt, a konyvek.dat fájl alalján
if ($nkeres!="")
    {
    $i=1;
    while (($i<=27) && ($konyv_nev[$i]!=$nkeres))
	{
	$i++;
	}
    return($szam_fh[$i]);
#    print($szam_fh[$i]);
    }
if ($fhkeres!="")
    {
    $fhkeres=floor($fhkeres/1000000)*1000000;
    $i=1;
    while (($i<=27) && ($szam_fh[$i]!=$fhkeres))
	{
	$i++;
	}
    return($konyv_nev[$i]);
#    print($konyv_nev[$i]);
    }
?>
</html>
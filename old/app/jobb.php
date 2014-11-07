<html lang="hu">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso8859-2">
</head>
<?php
	include("abcsatl.php");/*
	$nkeres=$konyv;
	$fh=include("./melyik_tabla.php");
	$fh=$fh+$fejezet*10000;
	$fh=$fh+101;
	$nkeres="";
	$fhkeres=$fh;
	$ab=include("./melyik_tabla.php");
	$eredmeny=mysql_query("SELECT fh FROM konyvek WHERE fh=$fh",$kapcsolat) or die("Nincs ilyen");
	$egy_sor=mysql_fetch_row($eredmeny);
	$ssz=$egy_sor[0];
	$file=fopen("technikai.dat","r");
	while (!(feof($file)))
		{
			$sor=fgets($file,1024);
			$i=0;
			$char="a";
			$nev="";
			while ($char<>":")
				{
					$char=substr($sor,$i,1);
					$i++;
					$nev=$nev.$char;
				}
			$nev=substr($nev,0,strlen($nev)-1);
			if ($nev==$konyv)
				{
					$j=$i;
					while ($char<>";")
						{
							$char=substr($sor,$j,1);
							$j++;
							$szam=$szam.$char;
						}
					settype($szam,"integer");
					if ($fejezet>$szam)
						{
							print("<h2>HIBA!!!<br>Az Ön kérése: ".$ab.": ".$fejezet."<br>Nincs ennyi ennyi fejezet.<br>
							A k&ouml;nyv utols&oacute; fejezete: $szam</h2>");
							break;
						}
					else
						{*/
							print("<frameset rows='50,36' border='1'>");
							print("<frame name='szoveg' src='./Mkv.php?konyv=$konyv&fejezet=$fejezet#$ugras'>");
							print("<frame name='lap' src='./magy.htm'>");
							print("</frameset>");/*
							break;
						}
				}
			
		}*/
?>
</html>

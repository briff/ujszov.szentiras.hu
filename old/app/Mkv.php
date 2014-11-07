<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
	a	{ text-decoration: none }
	a:visited    { color: #000000 }
	a:link    { color: #000000 }
	a:focus    { color: #ff0000 }

</style>
</head>
<body>
<p><font face="Palatino Linotype" size="4">
<?php
#	A fejlécben lévõ mutató beállítása:
#	if (!(isset($ugras)))
#	    {
#	    $ugras=1;
#	    }
#	$mutato="$konyv $fejezet, $ugras";
#	print("<script language='javascript'>");
#	print("parent.parent.fenn.location.href='./fenn.php?ugras=$mutato'");
#	print("</script>");
#	Kezdõértékek definiálása:
	include("abcsatl.php");
	$vers=1;
	//$ab=$konyv;
	//$nkeres=$ab;
	//$fh=include("./melyik_tabla.php");
	$fh=$konyv*1000000;
	$konyv_sql=mysql_query("SELECT `nev` FROM `konyvnevek` WHERE `konyv_id`='$konyv' AND `tipus`='default'");
	$konyv2=mysql_fetch_row($konyv_sql) or die ("A program egy k&ouml;nyv sorsz&aacute;m&aacute;t v&aacute;rja (1-27), &eacute;s ezt kapta: $konyv")/* $konyv=array($fh/1000000)*/; 
	$konyv=$konyv2[0];
	$fh=$fh+10000*$fejezet;
	$fhe=$fh-10000;
	$fhk=$fh+10000;
	//$vers=1;
#	Adabbázisból lekérdezés:
	$ab="konyvek";
	$eredmeny=mysql_query("SELECT fh,unic FROM konyvek WHERE fh>$fh AND fh<($fh+8500) ORDER BY fh ASC");
	if ($eredmeny=="") print("Üres az adatbázis.");
#	Aktuális könyv címének kiírása:
	print ($konyv." ");
	if ($fh<10000000)
		{
			if (substr($fh,1,1)!=0) print substr($fh,1,1);
			print (substr($fh,2,1));
		}
	else
		{
			if (substr($fh,2,1)!=0) print substr($fh,2,1);
			print (substr($fh,3,1));
		}
	print("<br>");
#	Tartalom kiírása:
	while ($egy_sor=mysql_fetch_row($eredmeny))
		{
		if ($egy_sor[0]>$fh+2000)
		    break;
		if ($egy_sor[0]>$fh+99)
		    {
		    print("<sup>");
		    $link="";
		    if ($fh<10000000)
		        {
		        if (substr($egy_sor[0],3,1)<>0) $link=substr($egy_sor[0],3,1);
		        $link=$link.substr($egy_sor[0],4,1);
		        }
		    else
		        {
		    	if (substr($egy_sor[0],4,1)<>0) $link=substr($egy_sor[0],4,1);
			$link=$link.substr($egy_sor[0],5,1);
			}
		    $fh=$egy_sor[0];
		    $vers++;
		    print("<a name='$link'>$link</a>");
		    print("</sup>");
		    }
		print("<a href='db3.php?fh=$egy_sor[0]' target='lap' id='fh$egy_sor[0]' >");
		print($egy_sor[1]);
		print("</a>");
		print("\n");
		}
#	Fókusz beállítása, ha kell:
	if (isset($ugras_szo))
	{
	    print("<script language='javascript'>");
	    print("document.getElementById('fh$ugras_szo').focus();");
	    print("</script>");
	}
#	Következõ könyv link:
	print ("</font></p><p align='center'><font face='Palatino Linotype' size='5'>");
	$fejezet++;
	$kovkonyv=floor($fh/1000000);
	$konyvhossz_sql=mysql_query("SELECT `hossz` FROM `konyvhossz` WHERE `konyv_id`='$kovkonyv'") or print(mysql_error());
	$konyvhossz=mysql_fetch_row($konyvhossz_sql);
	$konyvhossz=$konyvhossz[0];
	if ($fejezet<=$konyvhossz) print ("<br><a href='Mkv.php?fejezet=$fejezet&konyv=$kovkonyv' id='kovetkezo'><u>K&ouml;vetkez&otilde;</u></a>");
	print ("</font></p>\n");
#	Ha nem letezo konyvet irt be
	if ($fejezet-1>$konyvhossz) {
	    print("<i>$konyv k&ouml;nyvben csak $konyvhossz fejezet van.</i>");
	}
	mysql_close($kapcsolat);

?>
</body>
</html>

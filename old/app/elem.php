<html>
<?php
#	print($keres."<br>");
	$bontott=explode(".",$keres);
	#a '.' határolójeleknél felbontja a $keres paramétert, és a bontott tömbben tárolja.
#	print(count($bontott)."<br>");
	for ($i=0;$i<(count($bontott)-1);$i++)
		{
		$bontott[$i]=$bontott[$i].".";
		}
	$keres="";
	$l=0;
	for ($l=0;$l<(count($bontott)-1);$l++)
	{
	$k=0;
#	print("<br>");
	$tfile=array(array());
	$f=fopen($mit,'r');
	while (!feof($f))
		{
		$sor=fgets($f,1024);
		$szo="";
		$j=0;
		while ($sor[$j]!==".")
			{
			$szo=$szo.$sor[$j];
			$j++;
			}
		$szo=$szo.".";
		$tfile[$k][0]=$szo;
		$szo="";
		$j++;
		$j++;
		for ($j;$j<=strlen($sor);$j++)
			{
			$szo=$szo.$sor[$j];
			}
		$tfile[$k][1]=$szo;
		$k++;
		}
	$j=0;
	$i=0;
	foreach ($tfile as $sor)
		{
		foreach($sor as $mezo)
			{
			if ($j==1)
				{
					continue;
				}
			if ($mezo==$bontott[$l])
				{
				$bontott[$l]=$tfile[$i][1];
				}
			$j++;
			}
		$j=0;
		$i++;
		}
	$keres=$keres.$bontott[$l].", ";
	}
#	print($keres);
return $keres;
?>
</html>
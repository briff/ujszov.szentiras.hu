<?php
//$mit: tomb    nev email datum uzenet ssz
function kiir( $mit, $admine )
{
	print ("<table border='0' cellspacing='0' cellpadding='0' width='100%'>\n");
	//fejlec:
	$oszlopszam=3;
	if ($admine) $oszlopszam+=2;
	print ("  <tr>\n");
	print ("    <td width='30' height='30'><img src='level_files/bf.gif' alt=''></td>\n");
	print ("    <td background='level_files/f1.gif' width='238'>\n");
	print ("      ".$mit["nev"]."\n");
	print ("    </td>\n");
	print ("    <td background='level_files/f2.gif'>\n");
	print ("      ".$mit["ssz"]."\n");
	print ("    </td>\n");
	if ($admine) {
	    print ("    <td background='level_files/f2.gif'>\n");
	    print ("      <a href=\"javascript:torol('".$mit["datum"]."')\"> Töröl </a>\n");
	    print ("    </td>\n");
	    print ("    <td background='level_files/f2.gif'>\n");
	    print ("      \n");
	    print ("    </td>\n");
	}
	print ("    <td background='level_files/f2.gif' align='right'>\n");
	print ("      ".$mit["datum"]."\n");
	print ("    </td>\n");
	print ("    <td width='30'><img src='level_files/jf.gif' alt=''></td>\n");
	print ("  </tr>\n");
	//valasz:
	print ("  <tr>\n");
	print ("    <td bgcolor='#e4e2e4' background='level_files/b.gif'>&nbsp</td>\n");
	print ("    <td bgcolor='#e4e2e4' colspan='$oszlopszam' align='center'>\n");
	print ("      <a href='#alja' onClick=\"javascript:valasz('".$mit["datum"]."')\">Válasz erre</a>");
	print ("    </td>\n");
	print ("    <td bgcolor='#e4e2e4' background='level_files/j.gif'>&nbsp;</td>\n");
	print ("  </tr>\n");
	//uzenet:
	print ("  <tr>\n");
	print ("    <td bgcolor='#e4e2e4' background='level_files/b.gif'>&nbsp</td>\n");
	print ("    <td bgcolor='#e4e2e4' align='justify' colspan='$oszlopszam'>\n");
	print ("      ".$mit["uzenet"]."\n");
	print ("    </td>\n");
	print ("    <td bgcolor='#e4e2e4' background='level_files/j.gif'>&nbsp;</td>\n");
	print ("  </tr>\n");
	//alja:
	print ("  <tr>\n");
	print ("    <td bgcolor='#b8b7b7'></td>\n");
	print ("    <td background='level_files/f1.gif' height='5'></td>\n");
	print ("    <td background='level_files/f2.gif' height='5' colspan='$oszlopszam'></td>\n");
	print ("  </tr>\n");
	print ("</table>\n");
	print ("<br>\n");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gradient Themeset</title>
<style type="text/css">
body {
	background-color: #FFFFFF;
	color: #000000;
}
table {
	font: 9pt  arial, sans-serif;
	color: #000000;
}
td
.topbar {
	border-width:0px;
	background-image:  url('fenn_files/fenn_hnav_bg.gif');
	background-repeat: repeat-x;
	
}
.topstrip{
	background-image:  url('fenn_files/fenn_topstrip.gif');
	background-repeat: repeat-x;
	background-position: left top
}
p.white{
	color: #ffffff;
}
</style>
</head>

<body leftmargin="0" topmargin="5">
<table width="106%" border="0" cellspacing="0" cellpadding="0" height="35">
  <tr>
    <td height="25" valign="top">
      <table width="100%" height="25" cellpadding="0" cellspacing="0">
        <tr>
          <td width="154" valign="top">
          <img src="fenn_files/fenn_toptab.gif" border="0" width="154" height="25" /></td>
          <td width="100%" class="topbar">
	    <p class="white">
	     G&ouml;r&ouml;g &Uacute;jsz&ouml;vets&eacute;g - Magyar nyelvtani elemz&eacute;sekkel
	    </p>
	  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top" class="topstrip" height="10">
    <img src="fenn_files/fenn_topbar.gif" border="0" width="388" height="10" /></td>
  </tr>
    <?php
    if (isset($ugras))
	{
        print("<br>Utols&oacute; ug&aacute;s: ".$ugras);
	}
    ?>
  </table>
</body>
</html>

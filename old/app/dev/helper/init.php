<?
session_start();
require_once('helper/log.php');
// Check if cookies just have been enabled
if (isset($_SESSION['first']) && $_SESSION['nocookie']) {
	$_SESSION['nocookie'] = false;
}
// Check if cookies are enabled
if (isset($_GET['ns']) && !isset($_SESSION['first'])) { // Cookies are disabled
	initsession(false);
}
if (!isset($_SESSION['first'])) { // User first enters here
	$_SESSION['first'] = true;
	$loc=$_SERVER['PHP_SELF'].'?ns&'.http_build_query($_GET);
	header('Location: '.$loc);
}
if ($_SESSION['first']) { // Cookies are enabled and this is the first fulfilled query
	initsession(true);
}

/** Initiates requires session variables
* @param $cookie must be TRUE, if cookies are enabled
*/
function initsession($cookie) {
	$_SESSION['nocookie'] = !$cookie;
	$_SESSION['nojavascript'] = true;
	$_SESSION['arrive'] = time();
	$_SESSION['lastclick'] = $_SESSION['arrive'];
	$_SESSION['click'] = 0;
	$_SESSION['first'] = false;
}
######################## LOG QUERY ########################
if ($_SESSION['nocookie'] === false && $_SESSION['first'] === false) { // TODO Át kéne tenni a releváns oldalakra
	$now=time();
	log_click($_SERVER['PHP_SELF'].'?ns&'.http_build_query($_GET), ++$_SESSION['click'], $now-$_SESSION['arrive'], $now-$_SESSION['lastclick']);
	$_SESSION['lastclick'] = $now;
}
if (!isset($_SESSION['arrive'])) {
	$a=$_SERVER["REMOTE_ADDR"];
	if ($a != "193.225.109.57") { //monitoring kihagyasa
	$h=gethostbyaddr($a);
	$ts=date("YmdHis");
	$fh=fopen("newcounter.dat","a");
	fwrite($fh,$ts.":".$a.":".$h."\n");
	fclose($fh);
	$f=fopen("szamol.dat","r");
	$ssz=fgets($f,1024);
	$ssz+=1;
	fclose($f);
	$f=fopen("szamol.dat","w");
	fwrite($f,$ssz);
	fclose($f);
	$_SESSION['ssz'] = $ssz;
	}
}

?>

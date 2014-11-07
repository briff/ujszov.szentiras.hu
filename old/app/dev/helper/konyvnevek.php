<?
require_once("abcsatl.php");

function konyvkeres ($konyvnev, $tipus="default") {
# Adott könyvnév alapján visszaadja az újszövetségben elfoglalt sorszámát,
	global $kapcsolat;
	$stmt = $kapcsolat->prepare("select konyv_id from konyvnevek where nev like :konyvnev and tipus=:tipus");
	$stmt->bindValue(":konyvnev", $konyvnev);
	$stmt->bindValue(":tipus", $tipus);
	$eredmeny=execquery($stmt);
	if (count($eredmeny) < 1) return null;
	return $eredmeny[0]["konyv_id"];
}

function konyvnev ($ssz, $tipus="default") {
# Visszaadja, hogy az adott számú könyvhöz milyen név tartozik (eg 1->Mt)
	global $kapcsolat;
	$stmt = $kapcsolat->prepare("select nev from konyvnevek where konyv_id = :ssz and tipus=:tipus");
	$stmt->bindValue(":ssz", $ssz);
	$stmt->bindValue(":tipus", $tipus);
	$eredmeny=execquery($stmt);
	if (count($eredmeny) < 1) return null;
	return $eredmeny[0]["nev"];
}
?>

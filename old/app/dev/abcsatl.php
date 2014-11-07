<?php

function connect() {
  $host = 'localhost';
  $username = 'ujszov';
  $database = 'ujszov';
  $pass = '';
  try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $pass );
  } catch (Exception $e) {
    die("Nem lehet kapcsolódni az SQL kiszolgálóhoz.");
  }
  if (!$conn) die("Nem lehet kapcsolódni az SQL kiszolgálóhoz.");

  global $debug;
  if ($debug)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

  $stmt = $conn->prepare('SET NAMES \'utf8\';');
  $stmt->execute();

  return $conn;
}
function execquery($stmt, $errormsg=true, $fetchmode=PDO::FETCH_ASSOC) {
#Lefuttatja a megfelelően előkészített, felparaméterezett statement-et és visszaadja az eredménytömböt
  $stmt->execute();
  if ($errormsg && $stmt->errorCode() != "00000") {
    echo ("Adatbázis hiba: ");
    print_r($stmt->errorInfo());
    return false;
  }
  $stmt->setFetchMode($fetchmode);
  $result = $stmt->fetchAll();
  return $result;
}

$kapcsolat = connect();

?>

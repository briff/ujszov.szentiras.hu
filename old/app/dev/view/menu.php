<?
require_once("helper/konyvnevek.php");
?>
    <div class="span-4" id="menu">



<div class="box" id="form">
<form name="form" action="./book.php" method="get">
<h3>Könyv:<br />
    <select name="konyv">
<?
for ($i=1;$i<=27;$i++) { ?>
      <option value="<?=$i?>" <?=(isset($_GET['konyv']))&&$_GET['konyv']==$i?"selected":""?>><?=konyvnev($i)?></option>
<?}
?>
    </select>
  </h3>

  <h3>Fejezet:<br />
    <input name="fejezet" value="<?=(isset($_GET["fejezet"]))?$_GET["fejezet"]:1?>" size="1" type="text">
  </h3>

  <h3 title="Nem kötelező kitölteni" class="dolt">Vers:<br />
    <input name="vers" value="<?=(isset($_GET["vers"]))?$_GET["vers"]:""?>" size="1" type="text">
  </h3>


  <input value="KERES" type="submit"><br>

</form>
</div>

<div class="box" id="menulist">
<ul>
  <li><a href="segitseg.php">Segítségkérés</a></li>
  <li><a href="level.php">Üzenőfal</a></li>
  <li><a href="help.php">Tájékoztató</a></li>
  <li><a href="rovjegyz.php">Rövidítésjegyzék</a></li>
  <li><a href="linkek.php">Linktár</a></li>
  <li><a href="letolthetok.php">Letölthető fájlok</a></li>
</ul>
</div>

    </div>

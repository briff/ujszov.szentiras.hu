<?php

$fh = $_GET['fh'];
if (strlen($fh) == 7) {
    $fh = "0" . $fh;
}
$fh = preg_replace('/(\d\d)(\d\d)(\d\d)(\d\d)/','2${1}0${2}0${3}00${4}0',$fh);
header("Location: /text/$fh",TRUE,301);
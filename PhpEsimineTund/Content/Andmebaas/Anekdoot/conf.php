<?php
$serverinimi = "localhost";
$kasutaja = "root";
$parool = "";
$andmebaas = "anekdoodid";

$yhendus = new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");
?>
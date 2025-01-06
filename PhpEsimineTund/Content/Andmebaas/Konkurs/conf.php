<?php
$serverinimi = "d132037.mysql.zonevs.eu";
$kasutaja = "d132037_jelizaveta";
$parool = "Semiramida2004";
$andmebaas = "d132037_konkurss";

$yhendus = new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");
?>
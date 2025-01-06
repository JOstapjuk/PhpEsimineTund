<?php

$serverinimi = "d132037.mysql.zonevs.eu";
$kasutaja = "d132037_jelizaveta2";
$parool = "Semiramida2004";
$andmebaas = "d132037_jelizaveta";

$conn = new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$conn->set_charset("utf8");
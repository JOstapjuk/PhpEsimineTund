<?php

$serverinimi = "localhost";
$kasutaja = "jelizaveta";
$parool = "123456";
$andmebaas = "jelizaveta";

$yhendus = new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");
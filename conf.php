<?php
$kasutaja = "***";
$parool = "***";
$andmebaas = "***";
$serverinimi = "localhost";

$yhendus = new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");


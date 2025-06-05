<?php
$kasutaja = "d133845_jekguz";
$parool = "Erik89love";
$andmebaas = "d133845_phpbaas";
$serverinimi = "d133845.mysql.zonevs.eu";

$yhendus = new mysqli($serverinimi,$kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");

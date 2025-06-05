<?php
$kasutaja = "**********";
$parool = "*******";
$andmebaas = "**********";
$serverinimi = "********";

$yhendus = new mysqli($serverinimi,$kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");

<?php
$kasutaja = "jekguz";
$parool = "1234";
$andmebaas = "kellasepp";
$serverinimi = "localhost";

$yhendus = new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");


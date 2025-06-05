<?php
$parool = 'admin';
$sool = 'cool';
$kryp = crypt($parool, $sool);
echo $kryp;
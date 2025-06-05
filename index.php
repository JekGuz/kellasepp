<?php
ob_start();
session_start();
require_once("zoneconf.php");
require_once("abifunktsioonid.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>php index leht</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include("header.php");
?>
<!-- navegeerimismenüü -->
<?php
include("nav.php");

?>
<!-- content kaustast failide sisud -->
<main>
    <?php
    $lubatud_lehed = ['avaleht.php', 'table.php', 'inputADD.php', 'registration.php'];
    if (isset($_GET["leht"]) && in_array($_GET["leht"], $lubatud_lehed)) {
        include('content/' . $_GET["leht"]);
    } else {
        include('content/avaleht.php');
    }
    ?>
</main>
<!-- footer -->
<?php
include("footer.php");
?>
</body>
</html>
<?php ob_end_flush(); ?>
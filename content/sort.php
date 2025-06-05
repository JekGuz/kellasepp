<?php
require_once(__DIR__ . '/../zoneconf.php');
require_once(__DIR__ . '/../abifunktsioonid.php');

$sorttulp = "kuupaev"; // vaikimisi sorteerimine

if (isset($_GET["sort"])) {
    $sorttulp = $_GET["sort"];
}

// Küsi tellimused valitud sorteerimisega
$andmed = kysiTellimused($sorttulp);
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Tellimuste loetelu</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<h1 id="pealkiri">Kellatöökoja tellimused</h1>

<div id="sort">
    Sorteeri:
    <a href="index.php?leht=sort.php&sort=nimi">Kliendi järgi</a> |
    <a href="index.php?leht=sort.php&sort=teenus_nimi">Teenuse järgi</a> |
    <a href="index.php?leht=sort.php&sort=kuupaev">Kuupäeva järgi</a> |
    <a href="index.php?leht=sort.php&sort=status">Staatuse järgi</a>
</div>
<br>
<table id="base">
    <tr>
        <th>Klient</th>
        <th>Teenus</th>
        <th>Kuupäev</th>
        <th>Staatus</th>
    </tr>

    <?php foreach ($andmed as $rida): ?>
        <tr>
            <td><?= htmlspecialchars($rida->klient) ?></td>
            <td><?= htmlspecialchars($rida->teenus) ?></td>
            <td><?= htmlspecialchars($rida->kuupaev) ?></td>
            <td><?= htmlspecialchars($rida->status) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
</body>
</html>

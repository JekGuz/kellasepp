<div>
    <?php
    require(__DIR__ . '/../zoneconf.php');
    require(__DIR__ . '/../abifunktsioonid.php');

    // Только админ может удалять и изменять
    if (isset($_GET["kustutusid"]) && isAdmin()) {
        kustutaTellimus($_GET["kustutusid"]);
        header("Location: index.php?leht=table.php");
        exit();
    }
    if (isset($_GET["muutmine"]) && isAdmin()) {
    muudaTellimus(
        $_GET["muudetudid"],
        $_GET["klientID"],
        $_GET["teenusID"],
        $_GET["kuupaev"],
        $_GET["status"]
    );
    header("Location: index.php?leht=table.php");
    exit();
    }

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'kuupaev';
    $tellimused = kysiTellimused($sort);
    ?>
    <h1 id="pealkiri">Kellatöökoja teenuste klientide tellimuste logi</h1>
    <div id="sort">
        Sorteeri:
        <a href="index.php?leht=table.php&sort=nimi">Kliendi järgi</a> |
        <a href="index.php?leht=table.php&sort=teenus_nimi">Teenuse järgi</a> |
        <a href="index.php?leht=table.php&sort=kuupaev">Kuupäeva järgi</a> |
        <a href="index.php?leht=table.php&sort=status">Staatuse järgi</a> |
    </div>
    <br>
    <table id="base">
        <tr>
            <?php if (isAdmin()): ?><th>Haldus</th><?php endif; ?>
            <th>Klient</th>
            <th>Teenus</th>
            <th>Kuupäev</th>
            <th>Staatus</th>
        </tr>

        <?php foreach ($tellimused as $tellimus): ?>
            <tr>
                <?php if (isAdmin() && isset($_GET["muutmisid"]) && $_GET["muutmisid"] == $tellimus->id): ?>
                    <form method="get" action="index.php">
                        <input type="hidden" name="leht" value="table.php">
                        <td>
                            <input type="submit" name="muutmine" value="Salvesta">
                            <a href="index.php?leht=table.php">Katkesta</a>
                            <input type="hidden" name="muudetudid" value="<?= $tellimus->id ?>">
                        </td>
                        <td><?= looRippMenyy("SELECT klientID, CONCAT(nimi, ' ', perenimi) FROM klient", "klientID", $tellimus->klientID) ?></td>
                        <td><?= looRippMenyy("SELECT teenusID, teenus_nimi FROM teenus", "teenusID", $tellimus->teenusID) ?></td>
                        <td><input type="date" name="kuupaev" value="<?= $tellimus->kuupaev ?>"></td>
                        <td><input type="text" name="status" value="<?= $tellimus->status ?>"></td>
                    </form>
                <?php else: ?>
                    <?php if (isAdmin()): ?>
                        <td>
                            <a href="index.php?leht=table.php&muutmisid=<?= $tellimus->id ?>">Muuda</a> |
                            <a href="index.php?leht=table.php&kustutusid=<?= $tellimus->id ?>" onclick="return confirm('Kas kustutada?')">Kustuta</a>
                        </td>
                    <?php endif; ?>
                    <td><?= $tellimus->klient ?></td>
                    <td><?= $tellimus->teenus ?></td>
                    <td><?= $tellimus->kuupaev ?></td>
                    <td><?= $tellimus->status ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
</div>
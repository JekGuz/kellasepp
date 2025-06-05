<?php
require_once(__DIR__ . '/../zoneconf.php');
require_once(__DIR__ . '/../abifunktsioonid.php');
// Обработка добавления
if (isset($_POST["tellimuselisamine"])) {
    lisaTellimus($_POST["klientID"], $_POST["teenusID"], $_POST["kuupaev"], $_POST["status"]);
    header("Location: index.php?leht=inputADD.php&success=tellimus2");
    exit();
}
if (isset($_POST["klientlisamine"])) {
    lisaKlient($_POST["nimi"], $_POST["perenimi"], $_POST["telefon"], $_POST["email"]);
    header("Location: index.php?leht=inputADD.php&success=klient");
    exit();
}
if (isset($_POST["teenuselisamine"])) {
    lisaTeenus($_POST["teenus_nimi"], $_POST["hind"], $_POST["tarneaeg"]);
    header("Location: index.php?leht=inputADD.php&success=teenus");
    exit();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Andmete lisamine</title>
</head>
<body>

<h1 id="pealkiri">Lisamisvorm</h1>
<?php if (isset($_GET["success"])): ?>
    <p style="color: green; text-align: center;">
        <?php
        if ($_GET["success"] === "tellimus2") echo "✅ Tellimus lisatud!";
        if ($_GET["success"] === "klient") echo "✅ Klient lisatud!";
        if ($_GET["success"] === "teenus") echo "✅ Teenus lisatud!";
        ?>
    </p>
<?php endif; ?>
<div id="vormid">
    <!-- Форма заказа в таблице -->
    <form method="post" id="tellimus-vorm">
        <h2>Tellimuse lisamine</h2>
        <table>
            <tr>
                <td><label>Klient:</label></td>
                <td><?= looRippMenyy("SELECT klientID, CONCAT(nimi, ' ', perenimi) FROM klient", "klientID") ?></td>
                <td><button type="button" id="btn-klient" onclick="toggleForm('klient-vorm', 'btn-klient')"><strong>+</strong></button></td>
            </tr>
            <tr>
                <td><label>Teenus:</label></td>
                <td><?= looRippMenyy("SELECT teenusID, teenus_nimi FROM teenus", "teenusID") ?></td>
                <td>
                    <?php if (isAdmin()): ?>
                        <button type="button" id="btn-teenus" onclick="toggleForm('teenus-vorm', 'btn-teenus')"><strong>+</strong></button>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><label for="kuupaev">Kuupäev:</label></td>
                <td><input type="date" id="kuupaev" name="kuupaev" required></td>
                <td></td>
            </tr>
            <tr>
                <td><label for="status">Staatus:</label></td>
                <td><input type="text" id="status" name="status" value="Millist staatust soovite?" required></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="tellimuselisamine" value="Lisa tellimus"></td>
                <td></td>
            </tr>
        </table>
    </form>

    <!-- Скрытая форма клиента -->
    <div id="klient-vorm" style="display: none; margin-top: 20px;">
        <form method="post">
            <h2>Uue kliendi lisamine</h2>

            <label for="nimi">Nimi:</label><br>
            <input type="text" id="nimi" name="nimi" required><br><br>

            <label for="perenimi">Perenimi:</label><br>
            <input type="text" id="perenimi" name="perenimi" required><br><br>

            <label for="tel">Telefon:</label><br>
            <input type="text" id="tel" name="telefon"><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br><br>

            <input type="submit" name="klientlisamine" value="Lisa klient">
        </form>
    </div>

    <!-- Скрытая форма услуги/ только админ -->
    <?php if (isAdmin()): ?>
        <div id="teenus-vorm" style="display: none; margin-top: 20px;">
            <form method="post">
                <h2>Uue teenuse lisamine</h2>

                <label for="teenus-nimi">Teenuse nimi:</label><br>
                <input type="text" id="teenus-nimi" name="teenus_nimi" required><br><br>

                <label for="hind">Hind (€):</label><br>
                <input type="number" id="hind" step="0.01" name="hind"><br><br>

                <label for="tarneaeg">Tarneaeg:</label><br>
                <input type="date" id="tarneaeg" name="tarneaeg"><br><br>

                <input type="submit" name="teenuselisamine" value="Lisa teenus">
            </form>
        </div>
    <?php endif; ?>

</div>

<script>
    function toggleForm(formId, buttonId) {
        const form = document.getElementById(formId);
        const button = document.getElementById(buttonId);

        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
            button.innerHTML = "<strong>–</strong>";
        } else {
            form.style.display = "none";
            button.innerHTML = "<strong>+</strong>";
        }
    }
</script>


</body>
</html>

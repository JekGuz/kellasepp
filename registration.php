<?php
include('zoneconf.php');
session_start();
global $yhendus;

$error = "";
$success = "";

if (!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['pass2'])) {
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = trim($_POST['pass']);
    $pass2 = trim($_POST['pass2']);

    if ($pass !== $pass2) {
        $error = "Paroolid ei ühti!";
    } else {
        $sool = "cool";
        $krypt = crypt($pass, $sool);

        // Проверим: если пользователь — админ, то можно установить onadmin
        $onadmin = (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_POST['onadmin'])) ? 1 : 0;

        // Проверка, существует ли уже такой пользователь
        $paring = $yhendus->prepare("SELECT id FROM kasutajad WHERE kasutaja=?");
        $paring->bind_param("s", $login);
        $paring->execute();
        $paring->store_result();

        if ($paring->num_rows > 0) {
            $error = "Kasutaja on juba olemas!";
        } else {
            $paring->close();
            $paring = $yhendus->prepare("INSERT INTO kasutajad (kasutaja, parool, onadmin) VALUES (?, ?, ?)");
            $paring->bind_param("ssi", $login, $krypt, $onadmin);
            if ($paring->execute()) {
                $success = "Kasutaja on edukalt loodud! Kui soovite administraatori õigusi, võtke ühendust meie IT-spetsialistiga.";
            } else {
                $error = "Registreerimisel ilmnes viga. Palun kontrollige andmeid ja proovige uuesti.";
            }
        }

        $paring->close();
        $yhendus->close();
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Registreerimine</title>
    <link rel="stylesheet" href="style/style.css">    
</head>
<header>
    <h1>Registreerimine</h1>
</header>
<body>
<!-- <h1 id="pealkiri">Registreerimine</> -->

<?php if ($error): ?>
    <p style="color: red; font-weight: bold;"><?= $error ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green; font-weight: bold;"><?= $success ?></p>
<?php endif; ?>

<form action="" method="post">
    <table id="logi">
        <tr>
            <td>
                <label for="login"><strong>Login:</strong></label>
            </td>
            <td>
                <input type="text" name="login" value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '' ?>" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="pass"><strong>Salasõna:</strong></label>
            </td>
            <td>
                <input type="password" name="pass" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="pass2"><strong>Korda salasõna:</strong></label>
            </td>
            <td>
                <input type="password" name="pass2" required>
            </td>
        </tr>

        <tr>
            <td></td>
            <td><input type="submit" value="Registreeri" class="btn-link"></td>
        </tr>
    </table>
    <h1 id="pealkiri"><a id="back" href="login2.php"> ← Tagasi sisselogimise juurde</a></h1>
</form>
</body>
<footer>
    <div id="jalusekiht">
        Lehe tegi Jekaterina ♥
    </div>
</footer>
</html>
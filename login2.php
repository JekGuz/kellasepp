<?php include('zoneconf.php'); ?>
<?php
session_start();
/*
if (isset($_SESSION['tuvastamine'])) {
    header('Location: insex.php');
    exit();
}*/
//kontrollime kas väljad on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    global $yhendus;
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $sool = 'cool';
    $kryp = crypt($pass, $sool);
    //kontrollime kas andmebaasis on selline kasutaja ja parool
    $paring = $yhendus->prepare("SELECT kasutaja, parool, onadmin FROM kasutajad 
                                 WHERE kasutaja=? AND parool=?");
    $paring->bind_param('ss', $login, $kryp);
    $paring->bind_result($kasutaja, $parool, $onadmin);
    $paring->execute();

    //$valjund = mysqli_query($yhendus, $paring);
    //kui on, siis loome sessiooni ja suuname
    /*if (mysqli_num_rows($valjund)==1) {
        $_SESSION['tuvastamine'] = 'misiganes';
        header('Location: kaubahaldus.php');
    } else {
        echo "kasutaja või parool on vale";
    }*/
    if ($paring->fetch() && $parool == $kryp) {
        $_SESSION['kasutaja'] = $login;
        //заменила if ($onadmin == 1) на то что ниже
        $_SESSION['admin'] = ($onadmin == 1);
        //if ($onadmin == 1) {
            //$_SESSION['admin'] = true;
        //}
        header('location: index.php');
        $yhendus->close();
        exit();
    } else {
    $error = "Kasutajanimi või parool on vale!";
    $yhendus->close();
}
}

// регистрация (приязана к кнопке регистрации)
if (isset($_POST['action']) && $_POST['action'] == 'Registreerimine') {
    header('Location: registration.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="style/style.css">
</head>
<header>
    <h1>Tere Tulemast, palun logige sisse</h1>
</header>
<form action="" method="post">
    <br>
    <table id ="logi">
        <tr>
            <td>
                <label for="login"><strong>Login:</strong></label>
            </td>
            <td>
                <input type="text" id="login" name="login">
            </td>
        </tr>
        <tr>
            <td>
                <label for="password"><strong>Password:</strong></label>
            </td>
            <td>
                <input type="password" id="password" name="pass">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="action" value="Registreerimine">
            </td>
            <td>
                <input type="submit" value="Logi sisse">
            </td>
        </tr>
    </table>
    <?php if (!empty($error)): ?>
        <p style="color: red; font-weight: bold;"><?= $error ?></p>
    <?php endif; ?>
</form>
<br>
<footer>
    <div id="jalusekiht">
        Lehe tegi Jekaterina ♥
    </div>
</footer>
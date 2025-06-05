<?php
require_once('zoneconf.php');

// Проверка прав администратора
if (!function_exists('isAdmin')) {
    function isAdmin() {
        return isset($_SESSION['admin']) && $_SESSION['admin'];
    }
}

// ЗАПРОС ЗАКАЗОВ ПУТЕМ СОРТИРОВКИ И ПОИСКА
if (!function_exists('kysiTellimused')) {
    function kysiTellimused($sorttulp = "kuupaev", $otsisona = "") {
        global $yhendus;

        $lubatud = ["kuupaev", "status", "nimi", "teenus_nimi"];
        if (!in_array($sorttulp, $lubatud)) {
            return [];
        }

        $asendused = [
            "nimi" => "klient.nimi",
            "teenus_nimi" => "teenus.teenus_nimi",
            "kuupaev" => "tellimus2.kuupaev",
            "status" => "tellimus2.status"
        ];
        $sorttulp_realne = $asendused[$sorttulp];

        $otsisona = "%" . addslashes(strip_tags($otsisona)) . "%";

        $kask = $yhendus->prepare("
            SELECT tellimus2.tellimusID, klient.nimi, klient.klientID, teenus.teenus_nimi, teenus.teenusID, tellimus2.kuupaev, tellimus2.status
            FROM tellimus2
            JOIN klient ON tellimus2.klientID = klient.klientID
            JOIN teenus ON tellimus2.teenusID = teenus.teenusID
            WHERE klient.nimi LIKE ? OR teenus.teenus_nimi LIKE ?
            ORDER BY $sorttulp_realne " . ($sorttulp === "kuupaev" ? "DESC" : "ASC") . "
        ");

        $kask->bind_param("ss", $otsisona, $otsisona);
        $kask->bind_result($id, $klient, $klientID, $teenus, $teenusID, $kuupaev, $status);
        $kask->execute();

        $hoidla = array();
            while ($kask->fetch()) {
            $tellimus = new stdClass();
            $tellimus->id = $id;
            $tellimus->klient = htmlspecialchars($klient);
            $tellimus->klientID = $klientID;
            $tellimus->teenus = htmlspecialchars($teenus);
            $tellimus->teenusID = $teenusID;
            $tellimus->kuupaev = $kuupaev;
            $tellimus->status = htmlspecialchars($status);
            array_push($hoidla, $tellimus);
            }
        return $hoidla;
            }
        }

// ДОБАВЛЕНИЕ НОВОГО ЗАКАЗА
if (!function_exists('lisaTellimus')) {
    function lisaTellimus($klientID, $teenusID, $kuupaev, $status) {
        global $yhendus;
        $kask = $yhendus->prepare("INSERT INTO tellimus2 (klientID, teenusID, kuupaev, status) VALUES (?, ?, ?, ?)");
        $kask->bind_param("iiss", $klientID, $teenusID, $kuupaev, $status);
        $kask->execute();
    }
}

// ДОБАВЛЕНИЕ НОВОГО КЛИЕНТА
if (!function_exists('lisaKlient')) {
    function lisaKlient($nimi, $perenimi, $telefon, $email) {
        global $yhendus;
        $kask = $yhendus->prepare("INSERT INTO klient (nimi, perenimi, telefon, email) VALUES (?, ?, ?, ?)");
        $kask->bind_param("ssss", $nimi, $perenimi, $telefon, $email);
        $kask->execute();
    }
}

// ДОБАВЛЕНИЕ НОВОГО УСЛУГИ
if (!function_exists('lisaTeenus')) {
    function lisaTeenus($nimetus, $hind, $tarneaeg) {
        global $yhendus;
        $kask = $yhendus->prepare("INSERT INTO teenus (teenus_nimi, hind, tarneaeg) VALUES (?, ?, ?)");
        $kask->bind_param("sds", $nimetus, $hind, $tarneaeg);
        $kask->execute();
    }
}

// СОЗДАНИЕ ВЫПАДАЮЩЕГО МЕНЮ
if (!function_exists('looRippMenyy')) {
    function looRippMenyy($sqllause, $valikunimi, $valitudid = "") {
        global $yhendus;
        $kask = $yhendus->prepare($sqllause);
        $kask->bind_result($id, $sisu);
        $kask->execute();

        $tulemus = "<select name='$valikunimi'>";
        while ($kask->fetch()) {
            $valitud = ($id == $valitudid) ? " selected='selected'" : "";
            $tulemus .= "<option value='$id'$valitud>$sisu</option>";
        }
        $tulemus .= "</select>";
        return $tulemus;
    }
}

// Удаление
if (!function_exists('kustutaTellimus')) {
    function kustutaTellimus($id) {
        global $yhendus;
        $kask = $yhendus->prepare("DELETE FROM tellimus2 WHERE tellimusID = ?");
        $kask->bind_param("i", $id);
        $kask->execute();
    }
}

// Изменение
if (!function_exists('muudaTellimus')) {
    function muudaTellimus($id, $klientID, $teenusID, $kuupaev, $status) {
        global $yhendus;
        $kask = $yhendus->prepare("
            UPDATE tellimus2 SET klientID = ?, teenusID = ?, kuupaev = ?, status = ? WHERE tellimusID = ?
        ");
        $kask->bind_param("iissi", $klientID, $teenusID, $kuupaev, $status, $id);
        $kask->execute();
    }
}
?>

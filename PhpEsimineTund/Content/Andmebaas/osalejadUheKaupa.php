<?php
require ('conf2.php');// Kaasa andmebaasi konfiguratsioonifail.

global $yhendus; // Muutke andmebaasiühendus skriptis kasutamiseks muutuvaks globaalseks.
if (isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM osalejad WHERE id = ?"); //päringu osaleja kustutamiseks ID järgi.
    $kask->bind_param("i", $_REQUEST["kustuta"]); //Siduge parameeter 'id' päringule täisarvuna.
    $kask->execute(); // Täitke päring määratud kirje kustutamiseks.
}

if (isset($_REQUEST["uusOsaleja"]) && !empty($_REQUEST["nimi"]) && !empty($_REQUEST["telefon"]) && !empty($_REQUEST["pilt"]) && !empty($_REQUEST["synniaeg"])) {
    $kask = $yhendus->prepare("INSERT INTO osalejad (nimi, telefon, pilt, synniaeg) VALUES (?, ?, ?, ?)"); // Koostage sisestuspäring.
    $kask->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["pilt"], $_REQUEST["synniaeg"]); // Siduge sisendväärtused (kõik stringid) päringule.
    $kask->execute();
}

function arvutaVanus($synniaeg) {
    $synn = new DateTime($synniaeg);
    $tana = new DateTime();
    // Arvuta kuupäevade erinevus
    $vahe = $tana->diff($synn);
    return $vahe->y;
}

?>
<!doctype html>
<html lang="et">
<head>
    <title>Osalejad andmebaasist</title>
    <link rel="stylesheet" href="styleLoomad.css">
</head>
<body>
<h1>Osalejad 1 kaupa</h1>
<div class="container">
    <div id="meny">
        <ul>
            <?php
            global $yhendus;
            $paring = $yhendus->prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad");
            $paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
            $paring->execute();

            while ($paring->fetch()) {
                echo "<li><a href='?osaleja_id=$id'> <img src='$pilt' alt='pilt' width='150px'></a></li>";
            }
            ?>
        </ul>
        <?php
        echo '<button id="btn_lisa"><a href="?lisamine=jah">Lisa osaleja</a></button>'; // Kuva osaleja pildi.
        ?>
    </div>
    <div id="sisu">
        <?php
        if (isset($_REQUEST['osaleja_id'])) {
            $paring = $yhendus->prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad WHERE id = ?");
            $paring->bind_param("i", $_REQUEST["osaleja_id"]);
            $paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
            $paring->execute();

            if ($paring->fetch()) {
                echo "<div class='osajale-info'>";
                echo "<h3>Osaleja nimi: $nimi</h3>";
                echo "<p><strong>Telefon:</strong> $telefon</p>";
                echo "<img src='$pilt' alt='pilt' width='150px'>";
                echo "<p><strong>Sünniaeg:</strong> $synniaeg</p>";
                echo "<p><strong>Osaleja vanus: </strong>".arvutaVanus($synniaeg)."</p>";
                echo "<br>";
                echo "<button><a href='?kustuta=$id'>Kustuta</a></button>";
                echo "</div>";
            }
        }

        if (isset($_REQUEST['lisamine'])) {
            ?>
            <form action="?" method="post">
                <input type="hidden" value="jah" name="uusOsaleja">
                <label for="nimi">Nimi:</label>
                <input type="text" id="nimi" name="nimi" required>
                <br>
                <label for="telefon">Telefon:</label>
                <input type="text" id="telefon" name="telefon" required>
                <br>
                <label for="pilt">Pilt (URL):</label>
                <input type="text" id="pilt" name="pilt" required>
                <br>
                <label for="synniaeg">Sünniaeg:</label>
                <input type="date" id="synniaeg" name="synniaeg" required>
                <br>
                <input type="submit" value="Lisa">
            </form>
            <?php
        }
        ?>
    </div>
</div>
<footer>
    <?php
    echo "<br>";
    echo "Jelizaveta Ostapjuk &copy;";
    echo "<br>";
    echo date('Y.m.d');
    ?>
</footer>
</body>
</html>
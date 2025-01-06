<?php
require 'conf2.php'; // Kaasa andmebaasiühendus

global $yhendus;
// Osaleja kustutamine
if (isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM osalejad WHERE id = ?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
}

// Uue osaleja lisamine
if (!empty($_REQUEST["nimi"]) && !empty($_REQUEST["telefon"]) && !empty($_REQUEST["pilt"]) && !empty($_REQUEST["synniaeg"])) {
    $kask = $yhendus->prepare("INSERT INTO osalejad (nimi, telefon, pilt, synniaeg) VALUES (?, ?, ?, ?)");
    $kask->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["pilt"], $_REQUEST["synniaeg"]);
    $kask->execute();
}

// Osalejate tabamine
$paring = $yhendus->prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad");
$paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
$paring->execute();

function arvutaVanus($synniaeg) {
    $synn = new DateTime($synniaeg);
    $tana = new DateTime();
    // Arvuta kuupäevade erinevus
    $vahe = $tana->diff($synn);
    return $vahe->y;
}
?>
    <!DOCTYPE html>
    <html lang="et">
    <head>
        <meta charset="UTF-8">
        <title>Matkale Registreerimine</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <h1>Matkale Registreerimine</h1>
    <h2>Osaleja lisamine</h2>
    <form action="?" method="post">
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

    <h2>Registreeritud Osalejad</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nimi</th>
            <th>Telefon</th>
            <th>Pilt</th>
            <th>Sünniaeg</th>
            <th>Vanus</th>
            <th>Kustuta</th>
        </tr>
        <?php
        while ($paring->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($id) . "</td>";
            echo "<td>" . htmlspecialchars($nimi) . "</td>";
            echo "<td>" . htmlspecialchars($telefon) . "</td>";
            echo "<td><img src='" . htmlspecialchars($pilt) . "' alt='Osaleja pilt' width='100'></td>";
            echo "<td>" . htmlspecialchars($synniaeg) . "</td>";
            echo "<td>" . arvutaVanus($synniaeg) . "</td>";
            echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
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
<?php $yhendus->close(); ?>
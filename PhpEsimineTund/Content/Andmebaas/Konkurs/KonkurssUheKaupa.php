<?php
require('conf/conf.php');
global $yhendus;

require_once 'includes/functions.inc.php';
checkAccess();

if (isset($_REQUEST["uusKonkurss"]) && !empty($_REQUEST["konkursiNimi"]) && !empty($_REQUEST["korraldaja"])) {
    $kask = $yhendus->prepare("INSERT INTO konkurss (konkursiNimi, korraldaja, lisamisaeg, punktid, kommentaarid) VALUES (?, ?, NOW(), 0, '')");
    $kask->bind_param("ss", $_REQUEST["konkursiNimi"], $_REQUEST["korraldaja"]);
    $kask->execute();
}

if (isset($_POST["uusKomment"]) && !empty($_POST["kommentaar"])) {
    $konkurssId = $_POST["uusKomment"];
    $uusKommentaar = $_POST["kommentaar"];
    $kask = $yhendus->prepare("UPDATE konkurss SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?");
    $Koment = $uusKommentaar . "\n";
    $kask->bind_param("si", $Koment, $konkurssId);
    $kask->execute();

    header("Location: ?konkurss=$konkurssId");
}

if (isset($_GET["hea_konkurss_id"])) {
    $konkurssId = $_GET["hea_konkurss_id"];
    $kask = $yhendus->prepare("UPDATE konkurss SET punktid = punktid + 1 WHERE id = ?");
    $kask->bind_param("i", $konkurssId);
    $kask->execute();

    header("Location: ?konkurss=$konkurssId");
}

if (isset($_REQUEST["halb_konkurss_id"])) {
    $punktid_paringx = $yhendus->prepare("SELECT punktid FROM konkurss WHERE id = ?");
    $punktid_paringx->bind_param("i", $_REQUEST["halb_konkurss_id"]);
    $punktid_paringx->execute();
    $punktid_tulemus = $punktid_paringx->get_result();
    
    if ($punktid_rida = $punktid_tulemus->fetch_assoc()) {
        if ($punktid_rida['punktid'] > 0) {
            $paring = $yhendus->prepare("UPDATE konkurss SET punktid = punktid - 1 WHERE id = ?");
            $paring->bind_param("i", $_REQUEST["halb_konkurss_id"]);
            $paring->execute();
        }
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<?php
include_once 'header.php';
?>

<div class="container">
    <div class="nav">
        <h3>Konkursside nimekiri</h3>
        <ul>
            <?php
            $kask = $yhendus->prepare("SELECT id, konkursiNimi FROM konkurss ORDER BY id");
            $kask->bind_result($id, $konkursiNimi);
            $kask->execute();
            while ($kask->fetch()) {
                echo "<li><a href='?konkurss=$id'>$konkursiNimi</a></li>";
            }
            ?>
        </ul>
    </div>

    <div class="main-content">
        <?php
        if (isset($_REQUEST["konkurss"])) {
            $konkurssId = $_REQUEST["konkurss"];
            $kask = $yhendus->prepare("SELECT konkursiNimi, korraldaja, lisamisaeg, punktid, kommentaarid FROM konkurss WHERE id = ?");
            $kask->bind_param("i", $konkurssId);
            $kask->bind_result($konkursiNimi, $korraldaja, $lisamisaeg, $punktid, $kommentaarid);
            $kask->execute();
            if ($kask->fetch()) {
                echo "<h2>Konkursi nimi: " . htmlspecialchars($konkursiNimi) . "</h2>";
                echo "<p><strong>Korraldaja:</strong> " . htmlspecialchars($korraldaja) . "</p>";
                echo "<p><strong>Lisamisaeg:</strong> $lisamisaeg</p>";
                echo "<p><strong>Punktid:</strong> $punktid</p>";
                echo "<p><strong>Kommentaarid:</strong><br>" . nl2br(htmlspecialchars($kommentaarid)) . "</p>";

                echo "<h3>Lisa kommentaar</h3>";
                echo "<form action='?' method='post'>
                        <input type='hidden' name='uusKomment' value='$konkurssId'>
                        <textarea name='kommentaar' rows='3' required></textarea><br>
                        <button type='submit'>Lisa kommentaar</button>
                      </form>";

                echo "<p><a href='?hea_konkurss_id=$konkurssId'>Lisa +1 punkt</a> | 
                      <a href='?halb_konkurss_id=$konkurssId'>Võta -1 punkt</a></p>";
            }
        }
        ?>

        <h3>Lisa uus konkurss</h3>
        <form action="?" method="post">
            <input type="hidden" name="uusKonkurss" value="jah">
            <label for="konkursiNimi">Konkursi Nimi:</label><br>
            <input type="text" id="konkursiNimi" name="konkursiNimi" required><br><br>

            <label for="korraldaja">Korraldaja:</label><br>
            <input type="text" id="korraldaja" name="korraldaja" required><br><br>

            <button type="submit">Lisa konkurss</button>
        </form>
    </div>
</div>

<?php
include_once 'footer.php';
?>
</body>
</html>

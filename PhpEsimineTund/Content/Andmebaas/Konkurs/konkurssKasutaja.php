<?php

global $yhendus;
require('conf/conf.php');

require_once 'includes/functions.inc.php';
checkAccess();

//Konkurssi lisamine
if (!empty($_REQUEST["uusKonkurss"])) {
    $paring = $yhendus -> prepare("insert into konkurss (konkursiNimi, lisamisaeg) values (?,now())");
    $paring ->bind_param('s', $_REQUEST["uusKonkurss"]);
    $paring -> execute();
    header("Location:$_SERVER[PHP_SELF]");
}

//kommentaaride lisamine
if (isset($_REQUEST["uusKomment"])) {
    $paring = $yhendus -> prepare("UPDATE konkurss SET kommentaarid=CONCAT(kommentaarid,?) WHERE id=?");
    $kommentLisa ="\n".$_REQUEST["komment"];
    $paring -> bind_param('si', $kommentLisa, $_REQUEST["uusKomment"]);
    $paring -> execute();
    header("Location:$_SERVER[PHP_SELF]");
}

// tabeli uuendamine + 1 punkt
if (isset($_REQUEST["hea_konkurss_id"])) {
    $paring = $yhendus -> prepare("UPDATE konkurss set punktid = punktid+1
where id = ?");
    $paring -> bind_param("i", $_REQUEST["hea_konkurss_id"]);
    $paring -> execute();
    header("Location:$_SERVER[PHP_SELF]");
}

// tabeli uuendamine -1 punkt
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
<form action="?">
    <label for="uusKonkurss">Lisa konkursi nimi</label>
    <input type="text" name="uusKonkurss" id="uusKonkurss">
    <input type="submit" value="OK">
</form>

<table border="1">
    <tr>
        <th>KonkursiNimi</th>
        <th>LisamisAeg</th>
        <th>Punktid</th>
        <th>Kommentaarid</th>
        <th colspan="3">Haldus</th>
    </tr>
    <?php
    //tabeli sisu kuvamine
    $paring = $yhendus -> prepare("Select id, konkursiNimi, lisamisaeg, punktid, kommentaarid from konkurss where avalik=1");
    $paring -> bind_result($id ,$konkurssnimi, $lisamisaeg, $punktid, $kommentaarid);
    $paring -> execute();
    while ($paring -> fetch()) {
        echo "<tr>";
        $konkursid = htmlspecialchars($konkurssnimi);
        $kommentaarid = nl2br(htmlspecialchars($kommentaarid));
        echo "<td>".$konkurssnimi."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$kommentaarid."</td>";
        ?>
        <td>
            <form action="?">
                <input type="hidden" name="uusKomment" value="<?=$id?>">
                <input type="text" name="komment" id="komment">
                <input type="submit" value="Lisa kommentaar">
            </form>
        </td>
        <?php
        echo "<td><a href='?hea_konkurss_id=$id' class='link-button'>Lisa 1 punkt</a></td>";
        echo "<td><a href='?halb_konkurss_id=$id' class='link-button'>Võtta 1 punkt</a></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
<?php
$yhendus -> close();
?>
<?php
include_once 'footer.php';
?>

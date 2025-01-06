<?php

global $yhendus;
require('conf/conf.php');

require_once 'includes/functions.inc.php';
checkAccess('admin');

//Konkurssi lisamine
if (!empty($_REQUEST["uusKonkurss"])) {
    $paring = $yhendus -> prepare("insert into konkurss (konkursiNimi, lisamisaeg) values (?,now())");
    $paring ->bind_param('s', $_REQUEST["uusKonkurss"]);
    $paring -> execute();
    header("Location:$_SERVER[PHP_SELF]");
}

if (isset($_REQUEST["kustutaKomment"])) {
    $paring = $yhendus->prepare("UPDATE konkurss SET kommentaarid = '' where id = ?");
    $paring->bind_param("i", $_REQUEST["kustutaKomment"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

if (isset($_REQUEST["resetPunktid"])) {
    $paring = $yhendus->prepare("UPDATE konkurss SET punktid = 0 WHERE id = ?");
    $paring->bind_param("i", $_REQUEST["resetPunktid"]);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//kustutamine
if (isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM konkurss WHERE id = ?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
if (isset($_REQUEST["naita"])) {
    $paring = $yhendus->prepare("UPDATE konkurss SET avalik = 1 where id = ?");
    $paring->bind_param("i", $_REQUEST["naita"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
if (isset($_REQUEST["peida"])) {
    $paring = $yhendus->prepare("UPDATE konkurss SET avalik = 0 where id = ?");
    $paring->bind_param("i", $_REQUEST["peida"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
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
        <th>Avalik</th>
        <th colspan="4">Haldus</th>
    </tr>
    <?php
    //tabeli sisu kuvamine
    $paring = $yhendus -> prepare("Select id, konkursiNimi, lisamisaeg, punktid, kommentaarid, avalik from konkurss");
    $paring -> bind_result($id ,$konkurssnimi, $lisamisaeg, $punktid, $kommentaarid, $avalik);
    $paring -> execute();
    while ($paring->fetch()) {
        echo "<tr>";
        $konkursid = htmlspecialchars($konkurssnimi);
        $kommentaarid = nl2br(htmlspecialchars($kommentaarid));
        echo "<td>".$konkursid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$kommentaarid."</td>";
        echo "<td>".$avalik."</td>";
        echo "<td><a href='?kustuta=$id'>Kustuta konkurs</a></td>";
        echo "<td><a href='?resetPunktid=$id'>Punktide nullimine</a></td>";
        echo "<td><a href='?kustutaKomment=$id'>Kustuta komment</a></td>";
        echo "<td>";
        if ($avalik == 1) {
            echo "
        <form method='post'>
            <input type='hidden' name='peida' value='$id'>
            <button type='submit'>Peida</button>
        </form>";
        } else {
            echo "
        <form method='post'>
            <input type='hidden' name='naita' value='$id'>
            <button type='submit'>Näita</button>
        </form>";
        }
        echo "</td>";
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

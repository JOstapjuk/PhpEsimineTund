<?php
require("abifunktsioonid.php");

if (isset($_REQUEST["grupilisamine"])) {
    $result = lisaGrupp($_REQUEST["uuegrupinimi"]);
    header("Location: index.php");
    exit();
}
if (isset($_REQUEST["kaubalisamine"])) {
    lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
    header("Location: index.php");
    exit();
}
if (isset($_REQUEST["kustutusid"])) {
    kustutaKaup($_REQUEST["kustutusid"]);
}
if (isset($_REQUEST["muutmine"])) {
    muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
}

$sorttulp="nimetus";
$otsisona="";
if(isSet($_REQUEST["sort"])){
    $sorttulp=$_REQUEST["sort"];
}
if(isSet($_REQUEST["otsisona"])){
    $otsisona=$_REQUEST["otsisona"];
}
$kaubad=kysiKaupadeAndmed($sorttulp, $otsisona);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Kaupade leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>Andmed mitmes tabelis</h1>
    <form action="index.php" method="post">
        <h2>Kauba lisamine</h2>
        <dl>
            <dt>Nimetus:</dt>
            <dd><input type="text" name="nimetus" required /></dd>
            <dt>Kaubagrupp:</dt>
            <dd><?php echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id"); ?></dd>
            <dt>Hind:</dt>
            <dd><input type="number" name="hind" step="0.01" required /></dd>
        </dl>
        <input type="submit" name="kaubalisamine" value="Lisa kaup" />
    </form>

    <form action="index.php" method="post">
        <h2>Grupi lisamine</h2>
        <input type="text" name="uuegrupinimi" required />
        <input type="submit" name="grupilisamine" value="Lisa grupp" />
    </form>

    <form action="index.php" method="get">
        <h2>Kaubade otsimine</h2>
        <input type="text" name="otsisona" value="<?= htmlspecialchars($otsisona) ?>" />
        <input type="submit" value="Otsi" />
    </form>

    <br>
    <table>
        <h2>Kaupade loetelu</h2>
        <tr>
            <th><a href="index.php?sort=nimetus&otsisona=<?= urlencode($otsisona) ?>">Nimetus</a></th>
            <th><a href="index.php?sort=grupinimi&otsisona=<?= urlencode($otsisona) ?>">Kaubagrupp</a></th>
            <th><a href="index.php?sort=hind&otsisona=<?= urlencode($otsisona) ?>">Hind</a></th>
            <th>Haldus</th>
        </tr>
        <?php foreach ($kaubad as $kaup): ?>
            <tr>
                <?php if (isset($_REQUEST["muutmisid"]) && intval($_REQUEST["muutmisid"]) == $kaup->id): ?>
                    <form action="index.php" method="post">
                        <td><input type="text" name="nimetus" value="<?= htmlspecialchars($kaup->nimetus) ?>" /></td>
                        <td>
                            <?php echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id", $kaup->kaubagrupi_id); ?>
                        </td>
                        <td><input type="number" name="hind" value="<?= htmlspecialchars($kaup->hind) ?>" step="0.01" /></td>
                        <td>
                            <input type="hidden" name="muudetudid" value="<?= $kaup->id ?>" />
                            <input type="submit" name="muutmine" value="Muuda" />
                            <input type="submit" name="katkestus" value="Katkesta" />
                        </td>
                    </form>
                <?php else: ?>
                    <td><?= htmlspecialchars($kaup->nimetus) ?></td>
                    <td><?= htmlspecialchars($kaup->grupinimi) ?></td>
                    <td><?= htmlspecialchars($kaup->hind) ?></td>
                    <td>
                        <a href="index.php?kustutusid=<?= $kaup->id ?>" onclick="return confirm('Kas ikka soovid kustutada?')">Kustuta</a>
                        <a href="index.php?muutmisid=<?= $kaup->id ?>">Muuda</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

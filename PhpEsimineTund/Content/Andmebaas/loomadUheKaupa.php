<?php
require ('conf.php');

global $yhendus;
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

if(isset($_REQUEST["uusLoom"]) && !empty($_REQUEST["loomanimi"])){

    $paring=$yhendus->prepare("INSERT INTO loomad(loomanimi, varv, omanik, pilt)
VALUES (?, ?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"], $_REQUEST["varv"],
        $_REQUEST["omanik"], $_REQUEST["pilt"]);
    $paring->execute();
}
?>
<!doctype html>
<html lang="et">
<head>
    <title>Loomad andmebaasist</title>
    <link rel="stylesheet" href="styleLoomad.css">
</head>
<body>
<h1>Loomad 1 kaupa</h1>
<div class="container">
    <div id="meny">
        <ul>
            <?php
            global $yhendus;
            $paring = $yhendus->prepare("SELECT id, loomanimi FROM loomad");
            $paring->bind_result($id, $loomanimi);
            $paring->execute();

            while ($paring->fetch()) {
                echo "<li><a href='?looma_id=$id'> $loomanimi</a></li>";
            }
            ?>
        </ul>
        <?php
        echo '<button id="btn_lisa"><a href="?lisamine=jah">Lisa loom</a></button>';
        ?>
    </div>
    <div id="sisu">
        <?php
        if (isset($_REQUEST['looma_id'])) {
            $paring = $yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad WHERE id=?");
            $paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
            $paring->bind_param("i", $_REQUEST['looma_id']);
            $paring->execute();

            if ($paring->fetch()) {
                echo "<div class='looma-info' style='background-color: $varv'>";
                echo "<h3>Loomanimi: $loomanimi</h3>";
                echo "<p><strong>Omanik:</strong> $omanik</p>";
                echo "<img src='$pilt' alt='pilt' width='150px'>";
                echo "<br>";
                echo "<button><a href='?kustuta=$id'>Kustuta</a></button>";
                echo "</div>";
            }
        }

        if (isset($_REQUEST['lisamine'])) {
            ?>
            <form action="?" method="post">
                <input type="hidden" value="jah" name="uusLoom">
                <label for="loomanimi">Loomanimi</label>
                <input type="text" id="loomanimi" name="loomanimi">
                <label for="varv">Värv</label>
                <input type="color" id="varv" name="varv">
                <label for="omanik">Omanik</label>
                <input type="text" id="omanik" name="omanik">
                <label for="pilt">Pilt</label>
                <textarea name="pilt" id="pilt" rows="3" placeholder="Sisesta pildi link"></textarea>
                <input type="submit" value="Lisa loom">
            </form>
            <?php
        }
        ?>
    </div>
</div>
</body>
</html>
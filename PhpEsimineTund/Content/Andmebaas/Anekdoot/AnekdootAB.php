<?php
require('conf2.php');
global $yhendus;

if (isset($_REQUEST["uusAnekdood"]) && !empty($_REQUEST["nimetus"]) && !empty($_REQUEST["kuupaev"]) && !empty($_REQUEST["kirjeldus"])) {
    $kask = $yhendus->prepare("INSERT INTO anekdoot (nimetus, kuupaev, kirjeldus) VALUES (?, ?, ?)");
    $kask->bind_param("sss", $_REQUEST["nimetus"], $_REQUEST["kuupaev"], $_REQUEST["kirjeldus"]);
    $kask->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <title>Anekdoodid Andmebaasist</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="AnekdootStyle.css">
</head>
<body>
<header>
    <h1>Anekdoodid Andmebaasist</h1>
</header>

<div class="container">
    <div class="nav">
        <h3>Anekdoodid</h3>
        <ul>
            <?php
            $kask = $yhendus->prepare("SELECT id, nimetus FROM anekdoot ORDER BY id");
            $kask->bind_result($id, $nimetus);
            $kask->execute();
            while ($kask->fetch()) {
                echo "<li><a href='?anekdood=$id'>$nimetus</a></li>";
            }
            ?>
        </ul>
    </div>

    <div class="main-content">
        <?php
        if (isset($_REQUEST["anekdood"])) {
            $anekdootId = $_REQUEST["anekdood"];
            $kask = $yhendus->prepare("SELECT nimetus, kirjeldus FROM anekdoot WHERE id = ?");
            $kask->bind_param("i", $anekdootId);
            $kask->bind_result($nimetus, $kirjeldus);
            $kask->execute();
            if ($kask->fetch()) {
                echo "<h2>$nimetus</h2>";
                echo "<p>$kirjeldus</p>";
            }
        }
        ?>

        <h3>Lisa uus anekdoot</h3>
        <form action="?" method="post">
            <input type="hidden" name="uusAnekdood" value="jah">
            <label for="nimetus">Nimetus:</label><br>
            <input type="text" id="nimetus" name="nimetus" required><br><br>

            <label for="kuupaev">Kuupäev:</label><br>
            <input type="date" id="kuupaev" name="kuupaev" required><br><br>

            <label for="kirjeldus">Kirjeldus:</label><br>
            <textarea id="kirjeldus" name="kirjeldus" rows="4" required></textarea><br><br>

            <button type="submit">Lisa anekdoot</button>
        </form>
    </div>
</div>

<footer>
    <p>Jelizaveta Ostapjuk 2024 &copy;</p>
</footer>
</body>
</html>

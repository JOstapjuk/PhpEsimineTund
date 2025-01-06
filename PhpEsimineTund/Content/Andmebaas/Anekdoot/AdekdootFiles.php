<!DOCTYPE html>
<html lang="et">
<head>
    <title>Anekdoodid Failidest</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="AnekdootStyle.css">
</head>
<body>
<header>
    <h1>Anekdoodid Failidest</h1>
</header>

<div class="container">
    <div class="nav">
        <h3>Anekdoodid</h3>
        <ul>
            <?php
            $anekdoodid = ['Anekdoodid/Anekdood1.php', 'Anekdoodid/Anekdood2.php'];

            foreach ($anekdoodid as $anekdoot) {
                require($anekdoot);
                if (isset($Anekdood['nimetus'])) {
                    echo "<li><a href='?anekdood=$anekdoot'>{$Anekdood['nimetus']}</a></li>";
                }
            }
            ?>
        </ul>
    </div>

    <div class="main-content">
        <?php
        if (isset($_REQUEST["anekdood"])) {
            $anekdootId = $_REQUEST["anekdood"];
            if (in_array($anekdootId, $anekdoodid)) {
                require($anekdootId);
                if (isset($Anekdood)) {
                    echo "<h2>{$Anekdood['nimetus']}</h2>";
                    echo "<p>{$Anekdood['kirjeldus']}</p>";
                }
            }
        }
        ?>
    </div>
</div>

<footer>
    <p>Jelizaveta Ostapjuk 2024 &copy;</p>
</footer>
</body>
</html>

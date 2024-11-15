<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP tunnitööd</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
//päis
include('header.php');
?>
<?php
//navigeerimis menu
include('nav.php')
?>
<section>
    <?php
    if (isset($_GET["leht"])) {
        include('content/'.$_GET["leht"]);
    }
    else {
        include('content/kodu.php');
    }
    ?>
</section>
<?php
echo "<br>";
//jalus
include('footer.php');
?>
</body>
</html>


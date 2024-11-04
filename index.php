<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP tunnitööd</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<header>
    <h1>PHP tunnitööd</h1>
</header>
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
        echo "Tere tulemast!";
    }
    ?>
</section>
<?php
echo "Jelizaveta Ostapjuk&copy;";
echo "<br>";
echo date('Y:m:d');
?>
</body>
</html>

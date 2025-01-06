<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TARpv23 jõulu konkursid</title>
    <link rel="stylesheet" href="css/KonkursStyle.css">
</head>
<body>
<h1>TARpv23 jõulu konkursid</h1>
<nav>
    <ul>
        <?php
        if (isset($_SESSION['useruid'])) {
            if ($_SESSION['useruid'] === 'admin') {
                echo "<li><a href='KonkurssAdmin.php'>Admin</a></li>";
            } else {
                echo "<li><a href='konkurssKasutaja.php'>Kasutaja</a></li>";
                echo "<li><a href='KonkurssUheKaupa.php'>Ühe kaupa</a></li>";
            }

            echo "<li><a href='includes/logout.inc.php'>Logi välja</a></li>";
            echo "<li><strong> Tere, " . htmlspecialchars($_SESSION['useruid']) . "</strong></li>";
        } else {
            echo "<li><a href='signup.php'>Registreeru</a></li>";
            echo "<li><a href='login.php'>Logi sisse</a></li>";
        }
        ?>
    </ul>
</nav>
<!DOCTYPE html>
<html>
<head>
    <title>Peoõhtu registreerimisvorm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Peoõhtu registreerimisvorm</h1>
<nav>
    <ul>
        <?php
        if (isset($_SESSION['useruid'])) {
            if ($_SESSION['useruid'] === 'admin') {
                echo "<li><a href='osalejadAdmin.php'>Osalejad haldus</a></li>";
                echo "<li><a href='peoohtuAdmin.php'>Sündmused haldus</a></li>";
            } else {
                echo "<li><a href='peoohtu.php'>Jõulupidu</a></li>";
                echo "<li><a href='osalejadReg.php'>Jõulupidu registreerimine</a></li>";
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
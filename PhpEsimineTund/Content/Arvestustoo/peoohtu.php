<?php
global $yhendus;
require 'includes/dbh.inc.php';
require 'includes/functions.inc.php';
checkAccess();
?>
<?php
include_once 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Peoõhtu registreerimisvorm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>TTHK Jõulupidu</h1>
<p>Olete kutsutud meie kooli jõulupeole. <br>Kutsuge oma sõbrad ja pere.<br> Seal saab olema palju lõbu!</p>
<img src="joulupidu.jpg" alt="Jõulupidu" width="400" height="300">

<table border="1">
    <tr>
        <th>Sündmus</th>
        <th>Aeg</th>
    </tr>

    <?php
    //näita andmeid
    $paring = $yhendus->prepare("SELECT id ,Sundmus, Aeg FROM peoohtuevent ORDER BY Aeg ASC");
    $paring->bind_result($id, $Sundmus, $Aeg);
    $paring->execute();
    while ($paring->fetch()) {
        echo "<tr>";
        $Sundmus = htmlspecialchars($Sundmus);
        $Aeg = htmlspecialchars($Aeg);
        echo "<td>" . $Sundmus . "</td>";
        echo "<td>" . $Aeg . "</td>";
        echo "</tr>";
    }
    ?>

</table>

<?php
include_once 'footer.php';
?>
<?php
$yhendus -> close();
?>
</body>
</html>
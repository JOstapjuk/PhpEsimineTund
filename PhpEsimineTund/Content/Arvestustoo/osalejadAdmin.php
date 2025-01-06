<?php
global $yhendus;
require 'includes/dbh.inc.php';
require 'includes/functions.inc.php';
checkAccess('admin');

//lisamine
if (!empty($_REQUEST["Eesnimi"]) && !empty($_REQUEST["Perekonnannimi"]) && !empty($_REQUEST["Email"])) {
    $kask = $yhendus->prepare("INSERT INTO osalejad (name, surname, email) VALUES (?, ?, ?)");
    $kask->bind_param("sss", $_REQUEST["Eesnimi"], $_REQUEST["Perekonnannimi"], $_REQUEST["Email"]);
    $kask->execute();
}

//kustutamine
if (isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM osalejad WHERE id = ?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
}

//näita andmeid
$paring = $yhendus->prepare("SELECT id, name, surname, email FROM osalejad");
$paring->bind_result($id, $name, $surname, $email);
$paring->execute();

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
<h1>Osalejad admin leht</h1>
<h2>TTHK Jõulupidu registreerimisvorm</h2>

<form action="?" method="post">
    <input type="hidden" value="jah" name="uusOsaleja">
    <label for="Eesnimi">Nimi:</label>
    <input type="text" id="Eesnimi" name="Eesnimi" required>
    <br>
    <label for="Perekonnannimi">Perekonnannimi:</label>
    <input type="text" id="Perekonnannimi" name="Perekonnannimi" required>
    <br>
    <label for="Email">Email:</label>
    <input type="text" id="Email" name="Email" required>
    <br>
    <input type="submit" value="Registreeru">
</form>

<h2>Osalejad tabelis</h2>

<table border="1">
    <tr>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Email</th>
        <th>Haldus</th>
    </tr>

    <?php
    //näita andmeid
    while ($paring->fetch()) {
        echo "<tr>";
        $name = htmlspecialchars($name);
        $surname = htmlspecialchars($surname);
        $email = htmlspecialchars($email);
        echo "<td>" . $name . "</td>";
        echo "<td>" . $surname . "</td>";
        echo "<td>" . $email . "</td>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
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
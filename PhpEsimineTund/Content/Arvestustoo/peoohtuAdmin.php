<?php
global $yhendus;
require 'includes/dbh.inc.php';
require 'includes/functions.inc.php';
checkAccess('admin');

//Kontrollida, kas seansis on eduteade ja määrata selle kuvamiseks
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

//lisamine
if (!empty($_REQUEST["Sundmus"]) && !empty($_REQUEST["Aeg"])) {
    $kask = $yhendus->prepare("INSERT INTO peoohtuevent (Sundmus, Aeg) VALUES (?, ?)");
    $kask->bind_param("ss", $_REQUEST["Sundmus"], $_REQUEST["Aeg"]);
    if ($kask->execute()) {
        $_SESSION['success_message'] = "Lisamine õnnelikult!";
        header("Location: peoohtuAdmin.php");
        exit();
    } else {
        echo "Viga lisamisel.";
    }
}

//kustutamine
if (isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM peoohtuevent WHERE id = ?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Peoõhtu registreerimisvorm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include_once 'header.php'; ?>
<h1>TTHK Jõulupidu admin leht</h1>

<h2>Sündmusid lisamine</h2>

<form action="?" method="post">
    <input type="hidden" value="jah" name="uusSundmus">
    <label for="Sundmus">Sündmus:</label>
    <input type="text" id="Sundmus" name="Sundmus" required>
    <br>
    <label for="Aeg">Aeg:</label>
    <input type="text" id="Aeg" name="Aeg" required>
    <br>
    <input type="submit" value="Lisa">
</form>

<?php
//Edukuse teate kuvamine, kui see on määratud
if (isset($success_message)) {
    echo "<p>" . $success_message . "</p>";
}

?>

<h2>Sündumsid tabelis</h2>
<table border="1">
    <tr>
        <th>Sündmus</th>
        <th>Aeg</th>
        <th>Haldus</th>
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
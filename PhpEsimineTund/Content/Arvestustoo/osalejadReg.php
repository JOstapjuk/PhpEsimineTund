<?php
global $yhendus;
require 'includes/dbh.inc.php';
require 'includes/functions.inc.php';
checkAccess();

//Kontrollida, kas seansis on eduteade ja määrata selle kuvamiseks
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

//lisamine
if (!empty($_REQUEST["Eesnimi"]) && !empty($_REQUEST["Perekonnannimi"]) && !empty($_REQUEST["Email"])) {
    $kask = $yhendus->prepare("INSERT INTO osalejad (name, surname, email) VALUES (?, ?, ?)");
    $kask->bind_param("sss", $_REQUEST["Eesnimi"], $_REQUEST["Perekonnannimi"], $_REQUEST["Email"]);
    if ($kask->execute()) {
        $_SESSION['success_message'] = "Registreerimine õnnelikult!";
        header("Location: osalejadReg.php");
        exit();
    } else {
        echo "Viga registreerimisel.";
    }
}

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
<h1>TTHK Jõulupidu registreerimisvorm</h1>

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

<?php
//Edukuse teate kuvamine, kui see on määratud
if (isset($success_message)) {
    echo "<p>" . $success_message . "</p>";
}

?>

<?php
include_once 'footer.php';
?>
<?php
$yhendus -> close();
?>
</body>
</html>

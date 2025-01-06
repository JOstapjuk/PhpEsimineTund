<?php
include_once 'header.php';
?>
<section class="signup-form">
    <h2>Registreerimine</h2>
    <div class="signup-form-form">
        <form action="includes/signup.inc.php" method="post">
            <input type="text" name="name" placeholder="Kogu nimi..."/>
            <input type="text" name="email" placeholder="Email..."/>
            <input type="text" name="uid" placeholder="Kasutajanimi..."/>
            <input type="password" name="pwd" placeholder="Parool..."/>
            <input type="password" name="pwdrepeat" placeholder="Korrake parooli..."/>
            <button type="submit" name="submit">Registreeru</button>
        </form>
    </div>
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyinput") {
            echo "<p>Palun täitke kõik väljad!</p>";
        }
        else if ($_GET['error'] == "invaliduid") {
            echo "<p>Vale kasutajanimi!</p>";
        }
        else if ($_GET['error'] == "invalidemail") {
            echo "<p>Vale email!</p>";
        }
        else if ($_GET['error'] == "invalidpwd") {
            echo "<p>Vale parool!</p>";
        }
        else if ($_GET['error'] == "passworddontmatch") {
            echo "<p>Paroolid ei ühti!</p>";
        }
        else if ($_GET['error'] == "stmtfailed") {
            echo "<p>Midagi läks valesti!</p>";
        }
        else if ($_GET['error'] == "usernametaken") {
            echo "<p>Kasutajanimi juba võetud!</p>";
        }
        else if ($_GET['error'] == "none") {
            echo "<p>Edukalt registreerunud!</p>";
        }
    }
    ?>
</section>

<?php
include_once 'footer.php';
?>

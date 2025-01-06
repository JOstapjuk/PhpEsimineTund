<?php
include_once 'header.php';
?>
<section class="signup-form">
    <h2>Logi sisse</h2>
    <div class="signup-form-form">
        <form action="includes/login.inc.php" method="post">
            <input type="text" name="uid" placeholder="Kasutajanimi/Email..."/>
            <input type="password" name="pwd" placeholder="Parool..."/>
            <button type="submit" name="submit">Logi sisse</button>
        </form>
    </div>
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyinput") {
            echo "<p>Palun täitke kõik väljad!</p>";
        }
        else if ($_GET['error'] == "wronglogin") {
            echo "<p>Vale sisselogimise teave!</p>";
        }
    }
    ?>
</section>



<?php
include_once 'footer.php';
?>

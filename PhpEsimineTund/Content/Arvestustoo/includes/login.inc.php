<?php
global $yhendus;

if (isset($_POST['submit'])) {

    $username = $_POST['uid'];
    $pwd = $_POST['pwd'];

    include_once 'dbh.inc.php';
    include_once 'functions.inc.php';

    if (emptyInputLogin($username, $pwd) !== false) {
        header('location: ../login.php?error=emptyinput');
        exit();
    }

    loginUser($yhendus, $username, $pwd);
}
else {
    header('location: ../login.php');
    exit();
}
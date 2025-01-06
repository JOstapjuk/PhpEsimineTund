<?php
require_once 'dbh.inc.php';
global $yhendus;

function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat) {
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function invalidUid($username) {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function pwdMatch($pwd, $pwdrepeat) {
    if ($pwd !== $pwdrepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function uidExists($yhendus, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? or usersEmail = ?;";
    $stmt = mysqli_stmt_init($yhendus);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../signup.php?error=stmtfailed');
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
    }
    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($yhendus, $name, $email, $username, $pwd) {
    $sql = "insert into users (usersName, usersEmail, UsersUid, usersPwd) values (?,?,?,?)";
    $stmt = mysqli_stmt_init($yhendus);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../signup.php?error=stmtfailed');
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('location: ../signup.php?error=none');
    exit();
}

function emptyInputLogin($username, $pwd) {
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($yhendus, $username, $pwd) {
    $uidExists = uidExists($yhendus, $username, $username);

    if ($uidExists === false) {
        header('location: ../login.php?error=wronglogin');
        exit();
    }

    $pwdHashed = $uidExists['usersPwd'];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header('location: ../login.php?error=wronglogin');
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION['userid'] = $uidExists['id'];
        $_SESSION['useruid'] = $uidExists['usersUid'];
        if ($_SESSION['useruid'] === 'admin') {
            header('location: ../osalejadAdmin.php');
            exit();
        }
        else {
            header('location: ../peoohtu.php');
            exit();
        }
    }
}
function checkAccess($requiredRole = null) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['useruid'])) {
        header('Location: login.php?error=notloggedin');
        exit();
    }

    if ($requiredRole && $_SESSION['useruid'] !== $requiredRole) {
        header('Location: peoohtu.php?error=accessdenied');
        exit();
    }
}
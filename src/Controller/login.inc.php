<?php
if (isset($_POST["submit"])) {

    $usernameLogin = isset($_POST["username"]) ? $_POST["username"] : "";
    $pwdLogin = isset($_POST["pwd"]) ? $_POST["pwd"] : "";

    require_once 'dbh.inc.php';
    require_once 'form.php';
    require_once 'user.php';

    if (emptyInputLogin($usernameLogin, $pwdLogin) !== false) {
        header("location: ../View/LogIn/login.php?error=emptyinput");
        exit();
    } else if (!uidExists($conn, $usernameLogin, $usernameLogin)) {
        header("location: ../View/LogIn/login.php?error=wronglogin");
        exit();
    } else if (!checkedUser($conn, $usernameLogin)) {
        header("location: ../View/LogIn/login.php?signup=true");
        exit();
    }
    loginUser($conn, $usernameLogin, $pwdLogin);
} else {
    header("location: ../View/LogIn/login.php");
    exit();
}

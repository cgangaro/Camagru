<?php
if (!isset($_POST["submit"])) {
    header("location: ../View/SignUp/signup.php ");
    exit();
} else {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $username = isset($_POST["uid"]) ? $_POST["uid"] : "";
    $pwd = isset($_POST["pwd"]) ? $_POST["pwd"] : "";
    $pwdRepeat = isset($_POST["pwdrepeat"]) ? $_POST["pwdrepeat"] : "";

    require_once 'dbh.inc.php';
    require_once 'form.php';
    require_once 'user.php';

    if (emptyInputSignup($email, $username, $pwd, $pwdRepeat) !== false) {
        header("location: ../View/SignUp/signup.php?error=emptyinput");
        exit();
    }
    if (!validInput($username, 0)) {
        header("location: ../View/SignUp/signup.php?error=invaliduid");
        exit();
    }
    if (!validInput($email, 1)) {
        header("location: ../View/SignUp/signup.php?error=invalidemail");
        exit();
    }
    if (!validInput($pwd, 2)) {
        header("location: ../View/SignUp/signup.php?error=invalidpassword");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../View/SignUp/signup.php?error=passwordsdontmatch");
        exit();
    }
    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../View/SignUp/signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $email, $username, $pwd);
}

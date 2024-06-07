<?php
require_once 'dbh.inc.php';
require_once 'form.php';
require_once 'user.php';

if (isset($_POST['emailForReset'])) {
    $email = $_POST['emailForReset'];
    if (emptyInputLogin($email, $email)) {
        echo "error:emptyinput";
        exit();
    }
    if (!validInput($email, 1)) {
        echo "error:invalidemail";
        exit();
    }
    $user = uidExists($conn, $email, $email);
    if (!$user) {
        echo "error:emaildoesntexist";
        exit();
    }
    if (!checkedUserEmail($conn, $email)) {
        echo "error:emailnotverified";
        exit();
    }
    $verificationToken = bin2hex(random_bytes(16));
    if (initToken($conn, $user['userId'], $user['userName'], $verificationToken)) {
        if (sendResetPasswordMail($email, $verificationToken)) {
            echo "successreseetrequestpassword";
            exit();
        } else {
            echo "error:sendresetpasswordmail";
            exit();
        }
    } else {
        echo "error:inittoken";
        exit();
    }
} else if (isset($_POST["pwd"]) && isset($_POST["pwdRepeat"]) && isset($_POST["token"])) {
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdRepeat'];
    $token = $_POST["token"];
    if (pwdMatch($pwd, $pwdRepeat)) {
        echo "error:pwddontmatch";
        exit();
    }
    if (!validInput($pwd, 2)) {
        echo "error:pwdinvalid";
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql_select = "SELECT * FROM users WHERE token = '$token'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $sql_update = "UPDATE users SET userPwd = '$hashedPwd' WHERE token = '$token'";
        if (mysqli_query($conn, $sql_update)) {
            $sql_update = "UPDATE users SET token = '' WHERE token = '$token'";
            if (mysqli_query($conn, $sql_update)) {
                echo "successresetpassword";
                exit();
            } else {
                echo "error:mysqliqueryerror";
                exit();
            }
        } else {
            echo "error:mysqliqueryerror";
            exit();
        }
    } else {
        echo "error:tokenselecterror";
        exit();
    }
    mysqli_close($conn);
} else {
    header("location: ../../index.php");
}
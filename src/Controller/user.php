<?php

require_once 'mail.php';

function uidExists($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE userName = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../View/SignUp/signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $email, $username, $pwd)
{
    $verificationToken = bin2hex(random_bytes(16));
    $sql = "INSERT INTO users (userName, userEmail, userPwd, token, checked, notif) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $check = 0;
    $notif = 1;
    mysqli_stmt_bind_param($stmt, "ssssss", $username, $email, $hashedPwd, $verificationToken, $check, $notif);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (sendVerificationMail($username, $email, $verificationToken)) {
        header("location: ../View/Verify/verify.php?awaiting=true");
    } else {
        header("location: ../signup.php?error=emailsend");
    }
    exit();
}

function checkedUser($conn, $username)
{
    $sql_select = "SELECT * FROM users WHERE userName = '$username' AND checked = '1'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        return true;
    } else {
        mysqli_close($conn);
        return false;
    }
}

function checkedUserEmail($conn, $email)
{
    $sql_select = "SELECT * FROM users WHERE userEmail = '$email' AND checked = '1'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        return true;
    } else {
        mysqli_close($conn);
        return false;
    }
}

function loginUser($conn, $username, $pwd)
{
    $uidExists = uidExists($conn, $username, $username);
    if ($uidExists === false) {
        header("location: ../View/LogIn/login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../View/LogIn/login.php?error=wronglogin");
        exit();
    } else if ($checkPwd === true) {
        initToken($conn, $uidExists["userId"], $uidExists["userName"], '');
        session_start();
        $_SESSION["userid"] = $uidExists["userId"];
        $_SESSION["useruid"] = $uidExists["userName"];
        header("location: ../index.php");
        exit();
    }
}

function changeUsername($conn, $userId, $username, $newUsername)
{
    $sql_select = "SELECT * FROM users WHERE userId = '$userId' AND userName = '$username'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $sql_update = "UPDATE users SET userName = '$newUsername' WHERE userId = '$userId'";
        if (mysqli_query($conn, $sql_update)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    } else {
        mysqli_close($conn);
        return false;
    }
}

function changeEmail($conn, $userId, $username, $newEmail)
{
    $sql_select = "SELECT * FROM users WHERE userId = '$userId' AND userName = '$username'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $sql_update = "UPDATE users SET userEmail = '$newEmail' WHERE userId = '$userId'";
        if (mysqli_query($conn, $sql_update)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    } else {
        mysqli_close($conn);
        return false;
    }
}

function changePassword($conn, $userId, $username, $newPassword)
{
    $sql_select = "SELECT * FROM users WHERE userId = '$userId' AND userName = '$username'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $hashedPwd = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql_update = "UPDATE users SET userPwd = '$hashedPwd' WHERE userId = '$userId'";
        if (mysqli_query($conn, $sql_update)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    } else {
        mysqli_close($conn);
        return false;
    }
}

function initToken($conn, $userId, $username, $newToken)
{
    $sql_select = "SELECT * FROM users WHERE userId = '$userId' AND userName = '$username'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $sql_update = "UPDATE users SET token = '$newToken' WHERE userId = '$userId' AND userName = '$username'";
        if (mysqli_query($conn, $sql_update)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    } else {
        mysqli_close($conn);
        return false;
    }
}

function getUsernameWithUserid($conn, $userId)
{
    $sql = "SELECT * FROM users WHERE userId = '$userId'";
    $resultat = mysqli_query($conn, $sql);
    $ligne = mysqli_fetch_assoc($resultat);
    if (isset($ligne['userName'])) {
        return $ligne['userName'];
    } else {
        return '';
    }
}

function getUseridWithImageid($conn, $imageId)
{
    $sql = "SELECT * FROM images WHERE id = '$imageId'";
    $resultat = mysqli_query($conn, $sql);
    $ligne = mysqli_fetch_assoc($resultat);
    if (isset($ligne['author_id'])) {
        return $ligne['author_id'];
    } else {
        return '';
    }
}

function getEmailWithUserid($conn, $userId)
{
    $sql = "SELECT * FROM users WHERE userId = '$userId' AND notif = '1'";
    $resultat = mysqli_query($conn, $sql);
    $ligne = mysqli_fetch_assoc($resultat);
    if (isset($ligne['userEmail'])) {
        return $ligne['userEmail'];
    } else {
        return '';
    }
}

function reverseCommentNotif($conn, $userId)
{
    $sql_select = "SELECT * FROM users WHERE userId = '$userId' AND notif = '1'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $sql_update = "UPDATE users SET notif = '0' WHERE userId = '$userId'";
        if (mysqli_query($conn, $sql_update)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    } else {
        $sql_update = "UPDATE users SET notif = '1' WHERE userId = '$userId'";
        if (mysqli_query($conn, $sql_update)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    }
}

function checkCommentNotif($conn, $userId)
{
    $sql_select = "SELECT * FROM users WHERE userId = '$userId' AND notif = '1'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        return true;
    } else {
        return false;
    }
}

function updateCommentNotif($conn, $userId, $val)
{
    $sql_select = "SELECT * FROM users WHERE userId = '$userId'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $sql_update = "UPDATE users SET notif = '$val' WHERE userId = '$userId'";
        if (mysqli_query($conn, $sql_update)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    } else {
        return false;
    }
}

<?php

require_once 'dbh.inc.php';
require_once 'user.php';

$status = 'awaiting';

if (isset($_GET["token"])) {
    $token = $_GET["token"];
    $sql_select = "SELECT * FROM users WHERE token = '$token' AND checked = '0'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        $sql_update = "UPDATE users SET checked = '1' WHERE token = '$token'";
        if (mysqli_query($conn, $sql_update)) {
            $sql_update = "UPDATE users SET token = '' WHERE token = '$token'";
            if (mysqli_query($conn, $sql_update)) {
                header("location: ../View/Verify/verify.php?success=true");
            } else {
                header("location: ../View/Verify/verify.php?error=mysqliqueryerror");
            }
        } else {
            header("location: ../View/Verify/verify.php?error=mysqliqueryerror");
        }
    } else {
        header("location: ../View/Verify/verify.php?error=tokenselecterror");
    }
    mysqli_close($conn);
} else if (!isset($_GET["success"]) && !isset($_GET["awaiting"]) && !isset($_GET["error"])) {
    header("location: ../../index.php");
}

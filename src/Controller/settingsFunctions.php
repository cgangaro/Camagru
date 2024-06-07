<?php
require_once 'dbh.inc.php';
require_once 'form.php';
require_once 'user.php';

if (isset($_POST['username'])) {
    $newUsername = $_POST['username'];
    if (emptyInputLogin($newUsername, $newUsername)) {
        echo "error:emptyinput";
        exit();
    }
    if (!validInput($newUsername, 0)) {
        echo "error:invaliduid";
        exit();
    }
    if (uidExists($conn, $newUsername, $newUsername)) {
        echo "error:uidexist";
        exit();
    }
    session_start();
    if (changeUsername($conn, $_SESSION['userid'], $_SESSION['useruid'], $newUsername)) {
        $_SESSION["useruid"] = $newUsername;
        echo "successchangeusername";
        exit();
    } else {
        echo "error:changeusername";
        exit();
    }
} else if (isset($_POST['email'])) {
    $newEmail = $_POST['email'];
    if (emptyInputLogin($newEmail, $newEmail)) {
        echo "error:emptyinput";
        exit();
    }
    if (!validInput($newEmail, 1)) {
        echo "error:invalidemail";
        exit();
    }
    if (uidExists($conn, $newEmail, $newEmail)) {
        echo "error:emailexist";
        exit();
    }
    session_start();
    if (changeEmail($conn, $_SESSION['userid'], $_SESSION['useruid'], $newEmail)) {
        echo "successchangeemail";
        exit();
    } else {
        echo "error:changeemail";
        exit();
    }
} else if (isset($_POST['password'])) {
    $newPassword = $_POST['password'];
    if (emptyInputLogin($newPassword, $newPassword)) {
        echo "error:emptyinput";
        exit();
    }
    if (!validInput($newPassword, 2)) {
        echo "error:invalidpassword";
        exit();
    }
    session_start();
    if (changePassword($conn, $_SESSION['userid'], $_SESSION['useruid'], $newPassword)) {
        echo "successchangepassword";
        exit();
    } else {
        echo "error:changepassword";
        exit();
    }
} else if (isset($_POST['commentNotif'])) {
    $commentNotif = $_POST['commentNotif'];
    if ($commentNotif == 1) {
        $commentNotif = 0;
    } else {
        $commentNotif = 1;
    }
    session_start();
    if (updateCommentNotif($conn, $_SESSION['userid'], $commentNotif)) {
        echo 'success';
    } else {
        echo 'error:updatecommentnotif';
    }
} else {
    header("location: ../../index.php");
}
<?php

require_once 'dbh.inc.php';
require_once 'user.php';
require_once 'mail.php';
require_once 'images.php';

if (session_status() <= 0 || !isset($_SESSION['userid'])) {
    header("location: ../../index.php");
}

if (isset($_POST['imageid']) && isset($_POST['imageauthorid']) && isset($_POST['comment'])) {

    session_start();
    if (!isset($_SESSION['userid'])) {
        echo "error:useridwrong";
        exit();
    }
    $authorId = $_SESSION["userid"];
    if ($authorId < 0) {
        echo "error:authoridwrong";
        exit();
    }
    $imageId = $_POST['imageid'];
    echo 'test';
    echo '  ' . checkImageExist($conn, $imageId);
    if ($imageId < 0 || checkImageExist($conn, $imageId) == 0) {
        echo "errr:imageidwrong";
        exit();
    }
    $imageAuthorId = $_POST['imageauthorid'];
    if ($imageAuthorId < 0) {
        echo "error:imageauthoridwrong";
        exit();
    }
    $comment = $_POST['comment'];
    if (strlen($comment) <= 0 || strlen($comment) > 240) {
        echo "error:commentwrong";
        exit();
    }
    $comment = htmlspecialchars($comment);
    $sql = "INSERT INTO comments (image_id, author_id, comment) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error:stmtpreparefailed";
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $imageId, $authorId, $comment);
    if ($stmt->execute()) {
        echo "Success";
        $email = getEmailWithUserid($conn, $imageAuthorId);
        sendCommentNotifMail($email);
    } else {
        echo "error:stmtexecutefailed";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "error:missingarguments";
}

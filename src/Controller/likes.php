<?php

require_once 'dbh.inc.php';
require_once 'images.php';

if (session_status() <= 0 || !isset($_SESSION['userid'])) {
    header("location: ../../index.php");
}

if (isset($_POST['imageid']) && isset($_POST['liked'])) {

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
    if ($imageId < 0 || checkImageExist($conn, $imageId) == 0) {
        echo "error:imageidwrong";
        exit();
    }
    $liked = $_POST['liked'];
    if ($liked) {
        $sql_select = "SELECT * FROM likes WHERE image_id = '$imageId' AND author_id = '$authorId'";
        $res = mysqli_query($conn, $sql_select);
        if (mysqli_num_rows($res) > 0) {
            $sql_delete = "DELETE FROM likes WHERE image_id = '$imageId' AND author_id = '$authorId'";
            if (mysqli_query($conn, $sql_delete)) {
                echo "Successdelete";
            } else {
                echo "error:mysqliquery";
            }
        } else {
            echo "error:linedoesntexist";
        }
        mysqli_close($conn);
    } else {
        $sql = "INSERT INTO likes (image_id, author_id) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "error:stmtpreparefailed";
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $imageId, $authorId);
        if ($stmt->execute()) {
            echo "Successadd";
        } else {
            echo "error:stmtexecutefailed";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo "error:missingarguments";
}

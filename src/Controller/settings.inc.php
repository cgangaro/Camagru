<?php
session_start();
if (!isset($_SESSION["useruid"])) {
    session_destroy();
    header("location: ../../index.php");
}

require_once 'dbh.inc.php';
require_once 'user.php';

$commentNotifCheck = checkCommentNotif($conn, $_SESSION["userid"]);

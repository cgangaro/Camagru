<?php
session_start();
if (!isset($_SESSION["useruid"])) {
    session_destroy();
    header("location: ../../index.php");
}

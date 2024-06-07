<?php
if (!isset($_GET['token'])) {
    header("location: ../../index.php");
}
$token = $_GET['token'];

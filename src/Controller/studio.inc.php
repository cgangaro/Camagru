<?php
require_once 'dbh.inc.php';

session_start();
if (!isset($_SESSION["useruid"])) {
    session_destroy();
    header("location: ../../index.php");
}

$imageArray = array();
$userID = $_SESSION['userid'];
$sql = "SELECT * FROM images WHERE author_id = '$userID'";
$resultat = mysqli_query($conn, $sql);
while ($ligne = mysqli_fetch_assoc($resultat)) {
    array_push($imageArray, ['id' => $ligne['id'], 'file_data' => $ligne['file_data']]);
}
$imageArray = array_reverse($imageArray);

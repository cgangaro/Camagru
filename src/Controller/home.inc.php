<?php
require_once 'dbh.inc.php';

$imagesArray = array();
$usersArray = array();
$commentsArray = array();
$likesArray = array();
$gallery = array();
$galleryToDisplay = array();

$userId = isset($_SESSION["userid"]) ? $_SESSION["userid"] : 0;

$sql = "SELECT * FROM images";
$resultat = mysqli_query($conn, $sql);
while ($ligne = mysqli_fetch_assoc($resultat)) {
    array_push($imagesArray, ['id' => $ligne['id'], 'file_data' => $ligne['file_data'], 'author_id' => $ligne['author_id']]);
}

$sql = "SELECT * FROM users";
$resultat = mysqli_query($conn, $sql);
while ($ligne = mysqli_fetch_assoc($resultat)) {
    array_push($usersArray, [
        'id' => $ligne['userId'],
        'userName' => $ligne['userName']
    ]);
}

$sql = "SELECT * FROM comments";
$resultat = mysqli_query($conn, $sql);
while ($ligne = mysqli_fetch_assoc($resultat)) {
    array_push($commentsArray, [
        'id' => $ligne['id'],
        'image_id' => $ligne['image_id'],
        'author_id' => $ligne['author_id'],
        'author_name' => authorNameReturn($ligne['author_id'], $usersArray),
        'comment' => $ligne['comment']
    ]);
}

$sql = "SELECT * FROM likes";
$resultat = mysqli_query($conn, $sql);
while ($ligne = mysqli_fetch_assoc($resultat)) {
    array_push($likesArray, [
        'id' => $ligne['id'],
        'image_id' => $ligne['image_id'],
        'author_id' => $ligne['author_id']
    ]);
}

foreach ($imagesArray as $img) {
    array_push($gallery, [
        'image_id' => $img['id'],
        'file_data' => $img['file_data'],
        'author_id' => $img['author_id'],
        'author_name' => authorNameReturn($img['author_id'], $usersArray),
        'comments' => commentsReturn($img['id'], $commentsArray),
        'likes' => likesReturn($img['id'], $likesArray),
        'liked' => checkLiked($img['id'], $likesArray, $userId)
    ]);
}

$gallery = array_reverse($gallery);

$nbPage = ceil(count($gallery) / 5);
$page = 1;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page <= 0) {
        $page = 1;
    }
    $firstItem = ($page - 1) * 5;
    if ($firstItem >= count($gallery)) {
        $firstItem = 0;
        $page = 1;
    }
    if (count($gallery) >= ($firstItem + 5)) {
        for ($i = $firstItem; $i < ($firstItem + 5); $i++) {
            array_push($galleryToDisplay, $gallery[$i]);
        }
    } else {
        for ($i = $firstItem; $i < count($gallery); $i++) {
            array_push($galleryToDisplay, $gallery[$i]);
        }
    }
} else {
    if (count($gallery) >= 5) {
        for ($i = 0; $i < 5; $i++) {
            array_push($galleryToDisplay, $gallery[$i]);
        }
    } else {
        for ($i = 0; $i < count($gallery); $i++) {
            array_push($galleryToDisplay, $gallery[$i]);
        }
    }
}

function authorNameReturn($authorId, $usersArray)
{
    foreach ($usersArray as $user) {
        if ($user['id'] == $authorId) {
            return $user['userName'];
        }
    }
}

function commentsReturn($imgId, $commentsArray)
{
    $returnArray = array();
    foreach ($commentsArray as $comment) {
        if ($comment['image_id'] == $imgId) {
            array_push($returnArray, $comment);
        }
    }
    return $returnArray;
}

function likesReturn($imgId, $likesArray)
{
    $count = 0;
    foreach ($likesArray as $like) {
        if ($like['image_id'] == $imgId) {
            $count++;
        }
    }
    return $count;
}

function checkLiked($imgId, $likesArray, $userId)
{
    foreach ($likesArray as $like) {
        if ($like['image_id'] == $imgId && $like['author_id'] == $userId) {
            return true;
        }
    }
    return false;
}

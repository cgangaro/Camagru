<?php

require_once 'dbh.inc.php';

if (session_status() <= 0 || !isset($_SESSION['userid'])) {
    header("location: ../../index.php");
}

if (isset($_POST['removeImage'])) {
    $imageToRemoveId = isset($_POST['removeId']) ? $_POST['removeId'] : -1;
    if ($imageToRemoveId < 0) {
        header("location: ../View/Studio/studio.php?error=wronginformationsforremoveimage");
    }
    session_start();
    $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : -1;
    if ($userId < 0) {
        header("location: ../View/Studio/studio.php?error=wronginformationsforremoveimage");
    }
    if (checkImageAndAuthorExist($conn, $imageToRemoveId, $userId)) {

        $sql_select = "DELETE FROM images WHERE id = '$imageToRemoveId' AND author_id = '$userId'";
        if (mysqli_query($conn, $sql_select)) {
            $sql_select = "DELETE FROM comments WHERE image_id = '$imageToRemoveId'";
            if (mysqli_query($conn, $sql_select)) {
                $sql_select = "DELETE FROM likes WHERE image_id = '$imageToRemoveId'";
                if (mysqli_query($conn, $sql_select)) {
                    header("location: ../View/Studio/studio.php?remove=success");
                } else {
                    mysqli_close($conn);
                    header("location: ../View/Studio/studio.php?error=cantremovelikes");
                }
            } else {
                mysqli_close($conn);
                header("location: ../View/Studio/studio.php?error=cantremovecomments");
            }
        } else {
            mysqli_close($conn);
            header("location: ../View/Studio/studio.php?error=cantremove");
        }

    } else {
        header("location: ../View/Studio/studio.php?error=imagedoesntexistorbadauthor");
    }
}

// IMAGE PATHS
$photoTakenPath = '../Media/Upload/photoTaken.png';
$imageToSavePath = '../Media/Upload/imageToSave.png';

if (isset($_POST['submit'])) {

    $dataURL = isset($_POST['dataURL']) ? $_POST['dataURL'] : "";
    $filterSelected = isset($_POST['filterSelected']) ? $_POST['filterSelected'] : "";
    $upload = isset($_POST['uploadType']) ? $_POST['uploadType'] : false;
    if (empty($filterSelected) && $upload != true) {
        header("location: ../View/Studio/studio.php?error=nofilters");
    }
    if (!empty($filterSelected) && $filterSelected[strlen($filterSelected)-1] == ';') {
        $filterSelected = substr($filterSelected, 0, -1);
    }
    $fitlersArray = array();
    if (!empty($filterSelected)) {
        $fitlersArray = explode(';', $filterSelected);
    }
    if (empty($dataURL)) {
        header("location: ../View/Studio/studio.php?error=dataurlempty-$fitlersArray");
    }
    // Supprimer le préfixe 'data:image/png;base64,' pour obtenir les données binaires réelles
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dataURL));
    if (!$data) {
        header("location: ../View/Studio/studio.php?error=base64decodefailed");
    }

    // IMAGE SIZE
    $imageDest_width = 600;
    $imageDest_height = 600;
    $imageWidthMin = 400;
    $imageHeightMin = 400;

    // SAVE BINARY DATA IN FILE
    if (!file_put_contents($photoTakenPath, $data)) {
        header("location: ../View/Studio/studio.php?error=fileputcontentfailed");
    }
    $imageTaken = imagecreatefrompng($photoTakenPath);
    if (!$imageTaken) {
        header("location: ../View/Studio/studio.php?error=imagecreatefrompngfailed");
    }
    $photoTaken_width = imagesx($imageTaken);
    $photoTaken_height = imagesy($imageTaken);
    if (!$photoTaken_width || !$photoTaken_height) {
        header("location: ../View/Studio/studio.php?error=imagesizefailed");
    }
    if ($photoTaken_width < $imageWidthMin || $photoTaken_height < $imageHeightMin) {
        header("location: ../View/Studio/studio.php?error=imagesizetoosmall");
    }


    $percentForResize = getPercentForResize($photoTaken_width, $photoTaken_height, $imageDest_width, $imageDest_height);

    if ($percentForResize <= 0.0) {
        header("location: ../View/Studio/studio.php?error=percentforresizeerror");
    }

    $imageResized_witdh = round($percentForResize * $photoTaken_width);
    $imageResized_height = round($percentForResize * $photoTaken_height);
    $imageResized = imagecreatetruecolor($imageResized_witdh, $imageResized_height);
    if (!$imageResized) {
        header("location: ../View/Studio/studio.php?error=imagecreatefailed");
    }
    if (!imagecopyresampled(
        $imageResized,
        $imageTaken,
        0,
        0,
        0,
        0,
        $imageResized_witdh,
        $imageResized_height,
        $photoTaken_width,
        $photoTaken_height
    )) {
        header("location: ../View/Studio/studio.php?error=imagecopy1failed");
    }

    $x_for_crop = round((imagesx($imageResized) - $imageDest_width) / 2);
    if ($x_for_crop < 0)
        $x = 0;
    $y_for_crop = round((imagesy($imageResized) - $imageDest_height) / 2);
    if ($y_for_crop < 0)
        $y_for_crop = 0;
    $croppedImage = imagecrop($imageResized, ['x' => $x_for_crop, 'y' => $y_for_crop, 'width' => $imageDest_width, 'height' => $imageDest_height]);
    if (!$croppedImage) {
        header("location: ../View/Studio/studio.php?error=imagecropfailed");
    }
    
    $mainImg = $croppedImage;
    if (!empty($fitlersArray)) {
        foreach ($fitlersArray as $filter) {
            $filterPath = '../Media/Filters/' . $filter . '300.png';
            $mainImg = addFilter($mainImg, $filterPath, $imageToSavePath);
            if ($mainImg == false) {
                header("location: ../View/Studio/studio.php?error=imagecopyfailed");
            }
        }
    } else {
        imagepng($mainImg, $imageToSavePath);
    }
    header("location: ../View/Studio/studio.php?error=none&imageready=true");
}

function addFilter($mainImg, $filterPath, $imageToSavePath) {
    $filter = imagecreatefrompng($filterPath);
    if (!imagecopy($mainImg, $filter, 0, (imagesy($mainImg) / 2 - 1), 0, 0, imagesx($filter), imagesy($filter))) {
        return false;
    }
    imagepng($mainImg, $imageToSavePath);
    return imagecreatefrompng($imageToSavePath);
}

function getPercentForResize($photoTaken_width, $photoTaken_height, $imageDest_width, $imageDest_height)
{
    $percent = 1.0;
    if ($photoTaken_width < $imageDest_width) {
        $percent = $imageDest_width / $photoTaken_width;
    }
    if ($photoTaken_height * $percent < $imageDest_height) {
        $percent = $imageDest_height / $photoTaken_height;
    }
    if ($photoTaken_width > $photoTaken_height) {
        $percent = $imageDest_height / $photoTaken_height;
    } else {
        $percent = $imageDest_width / $photoTaken_width;
    }
    return $percent;
}

if (isset($_POST['submitSave'])) {
    session_start();
    $imageToSaveData = file_get_contents($imageToSavePath);
    $requete = "INSERT INTO images (file_data, author_id) VALUES (?, ?)";
    $statement = $conn->prepare($requete);
    $statement->bind_param("ss", $imageToSaveData, $_SESSION["userid"]);
    if (!$statement->execute()) {
        //Erreur lors de l'enregistrement de l'image dans la base de données, voir $statement->error
        header("location: ../View/Studio/studio.php?error=stmtfailed");
    }
    $statement->close();
    header("location: ../View/Studio/studio.php?error=none");
}

if (isset($_POST['submitCancelSave'])) {
    header("location: ../View/Studio/studio.php");
}

function checkImageAndAuthorExist($conn, $imageId, $authorId) {
    $sql_select = "SELECT * FROM images WHERE id = '$imageId' AND author_id = '$authorId'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        return true;
    } else {
        mysqli_close($conn);
        return false;
    }
}

function checkImageExist($conn, $imageId) {
    $sql_select = "SELECT * FROM images WHERE id = '$imageId'";
    $res = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($res) > 0) {
        return 1;
    } else {
        return 0;
    }
}

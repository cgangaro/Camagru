<?php
require_once '../../Controller/studio.inc.php';
include_once '../Header/header.php';
?>

<style>
    <?php include 'studio.css'; ?>
</style>

<div class="studioBody">
    <div class="card customCard" id="studioCard">
        <p class="title">
            Studio
        </p>
        <div class="cardContent">
            <?php
            if (isset($_GET['imageready']) && $_GET['imageready'] == true) {
                echo '<img src="../../Media/Upload/imageToSave.png" />';
            } else {
                echo '<div id="camera">
                    <video id="video" autoplay="true" class="mainPicture">Video stream not available.</video>
                    <canvas id="canvas" class="d-none"></canvas>
                </div>
                <div id="cameraWaiting">
                    <p>No device found</br>If a device is connected, please wait</p>
                </div>
                <div id="uploadFilePart">
                    <input type="file" id="selectFile" name="selectFile" accept="image/png" style="display: none;" />
                    <input id="selectFileButton" class="button is-link studioActionButton" type="button" value="Browse..." onclick="document.getElementById(\'selectFile\').click();" />
                </div>
                <div id="filterPart">
                <p class="title">
                    Filters
                </p>
                <div id="filterGallery">
                    <div class="filterGalleryLine">
                        <img id="cenaFilter" src="../../Media/Filters/Cena/cena_cadre.png" />
                        <img id="dassinFilter" src="../../Media/Filters/Dassin/dassin_cadre.png" />
                        <img id="hallidayFilter" src="../../Media/Filters/Halliday/halliday_cadre.png" />
                    </div>
                    <div class="filterGalleryLine">
                        <img id="knoxvilleFilter" src="../../Media/Filters/Knoxville/knoxville_cadre.png" />
                        <img id="lennonFilter" src="../../Media/Filters/Lennon/lennon_cadre.png" />
                        <img id="pesciFilter" src="../../Media/Filters/Pesci/pesci_cadre.png" />
                    </div>
                </div>
            </div>';
            }
            ?>
        </div>
        <?php
        if (isset($_GET['imageready']) && $_GET['imageready'] == true) {
            echo '<div id="saveButtons" class="studioButtons">
                    <form id="save" action="../../Controller/images.php" method="POST">
                        <button id="saveButton" class="button is-link studioActionButton" type="submit" name="submitSave" value="">Save</button>
                    </form>
                    <form id="cancelSave" action="../../Controller/images.php" method="POST">
                        <button id="cancelSaveButton" class="button is-link studioActionButton" type="submit" name="submitCancelSave" value="">Cancel</button>
                    </form>
                    </div>';
        } else {
            echo '<div id="chooseButtons" class="studioButtons">
                <button id="takePhoto" class="button is-link studioActionButton" disabled>Take Photo</button>
                <button id="chooseUploadPicture" class="button is-link studioActionButton">Upload</button>
                </div>
                <div id="confirmationButtons" class="studioButtons">
                    <form id="savePicture" action="../../Controller/images.php" method="POST">
                        <input type="hidden" id="dataURLInput" name="dataURL">
                        <input type="hidden" id="filterSelectInput" name="filterSelected">
                        <input type="hidden" id="uploadTypeInput" name="uploadType">
                        <button id="sendPicture" class="button is-link studioActionButton" type="submit" name="submit" value="" disabled>Choose</button>
                    </form>
                    <button id="cancelButton" class="button is-link studioActionButton">Cancel</button>
                </div>';
        }
        ?>
    </div>
    <div class="card customCard" id="galleryCard">
        <p class="title">
            My Gallery
        </p>
        <?php
        if (count($imageArray) > 0) {
            foreach ($imageArray as $galleryImage) {
                echo '
                <div class="imageDivGalleryPerso">
                <form id="removeForm_' . $galleryImage['id'] . '" action="../../Controller/images.php" method="POST">
                    <input type="hidden" id="removeInput_' . $galleryImage['id'] . '" name="removeId" value="' . $galleryImage['id'] . '">
                    <button id="removeButton_' . $galleryImage['id'] . '" class="button removeButton" type="submit" name="removeImage"><span class="icon">
                        <i class="fa-solid fa-trash"></i>
                    </span></button>
                </form>
                <img class="galleryImage" src="data:image/png;base64,' . base64_encode($galleryImage['file_data']) . '"/>
                </div>
                ';
            }
        } else {
            echo '<p id="emptyGallery">No image yet</p>';
        }
        ?>
    </div>
</div>

<?php
if (!isset($_GET['imageready'])) {
    echo '<script type="text/javascript" src="studio.js"></script>';
}
include_once '../Footer/footer.php';
?>
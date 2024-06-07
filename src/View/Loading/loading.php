<?php
require_once '../../Controller/loading.inc.php';
include_once '../Header/header.php';
?>

<style>
    <?php include 'loading.css'; ?>
</style>

<div class="centerDiv">
    <div class="card centerCard" id="verifyCard">
        <div class="card-content">
            <p class='title'>
                The parameter has been changed
            </p>
            <?php
            echo '
            <a href="' . $_SERVER['SERVER_NAME'] . '/View/Settings/settings.php" class="button is-link">
                Go to Settings
            </a>
            ';
            ?>
        </div>
    </div>
</div>

<?php
include_once '../Footer/footer.php';
?>
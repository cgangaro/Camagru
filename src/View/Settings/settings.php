<?php
include_once '../../Controller/settings.inc.php';
include_once '../Header/header.php';
?>

<style>
    <?php include 'settings.css'; ?>
</style>

<div class="centerDiv">
    <div class="card centerCard" id="settingsCard">
        <div class="card-content">
            <p class="title" id="settingsTitle">
                Settings
            </p>
            <div id="settingsButtonsPart">
                <button id="changeUsernameButton" class="button is-link">Change Username</button>
                <button id="changeEmailButton" class="button is-link">Change Email</button>
                <button id="changePasswordButton" class="button is-link">Change Password</button>
                <form id="commentNotifForm">
                    <?php
                    echo '<input id="commentNotifInput" class="input" name="commentNotif" value="';
                    echo $commentNotifCheck;
                    echo '" type="hidden">';
                    echo '<button id="commentNotifButton" class="button is-link" type="button">';
                    if ($commentNotifCheck) {
                        echo 'Desactive notification for each new comment';
                    } else {
                        echo 'Active notification for each new comment';
                    }
                    echo '</button>';
                    ?>
                </form>
            </div>
            <form id="changeSettingsForm">
                <input id="settingsInput" class="input" name="" type="text" placeholder="">
            </form>
            <div id="confirmSettingsButtonsPart">
                <button id="settingsUpdateButton" class="button is-link">Update</button>
                <button id="settingsCancelButton" class="button is-link is-light">Cancel</button>
            </div>
            <p id="returnerror"></p>
        </div>
    </div>
</div>
<script type="text/javascript" src="settings.js"></script>
<script type="text/javascript" src="../all.js"></script>

<?php
include_once '../Footer/footer.php';
?>
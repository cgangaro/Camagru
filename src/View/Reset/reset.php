<?php
require_once '../../Controller/reset.inc.php';
include_once '../Header/header.php';
?>

<style>
    <?php include 'reset.css'; ?>
</style>

<div class="centerDiv">
    <div class="card centerCard" id="resetCard">
        <div class="card-content" id="pwdResetSuccessContent">
            <p class="title">
                Password Reset Successfully
            </p>
            <a href="/View/LogIn/login.php" class="button is-link">
                Log in
            </a>
        </div>
        <div class="card-content" id="pwdResetContent">
            <p class="title">
                Password Reset
            </p>
            <form id="resetForm">
                <input id="resetPwdInput" class="input" type="password" name="pwd" placeholder="Password...">
                <input id="resetPwdRepeatInput" class="input" type="password" name="pwdRepeat" placeholder="Repeat password...">
                <?php
                echo '<input id="resetTokenInput" value="';
                echo $token;
                echo '" class="input" type="hidden" name="token">';
                ?>
            </form>
            <button id="resetButton" class="button is-link">Reset Password</button>
            <p id="resetError"></p>
        </div>
    </div>
</div>
<script type="text/javascript" src="reset.js"></script>

<?php
include_once '../Footer/footer.php';
?>
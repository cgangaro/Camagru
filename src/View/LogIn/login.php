<?php
include_once '../Header/header.php';
?>

<style>
    <?php include 'login.css'; ?>
</style>

<div class="centerDiv">
    <div class="card centerCard" id="signinCard">
        <div class="card-content">
            <p class="title">
                Log In
            </p>
            <form id="loginForm" action="../../Controller/login.inc.php" method="POST">
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input class="input" type="text" name="username" placeholder="Username...">
                    </div>
                </div>
                <div id="passwordField" class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input" type="password" name="pwd" placeholder="Password...">
                    </div>
                </div>
                <a id="resetPasswordLogin" href="../ResetRequest/resetRequest.php">Reset Password</a>
                <div class="field is-grouped">
                    <div class="control">
                        <button id="loginButton" class="button is-link" type="submit" name="submit">Submit</button>
                    </div>
                </div>
                <?php
                if (isset($_GET["error"])) {
                    echo "<div class='errorMsgDiv'>";
                    if ($_GET["error"] == "emptyinput")
                        echo "<p>Fill in all fields!</p>";
                    else if ($_GET["error"] == "wronglogin")
                        echo "<p>Incorrect login information!</p>";
                    echo "</div>";
                } else if (isset($_GET["signup"])) {
                    echo "<div class='confirmationMsgDiv'>
                            <p>Please check yours emails to complete the registration</p>
                        </div>";
                }
                ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="login.js"></script>

<?php
include_once '../Footer/footer.php';
?>
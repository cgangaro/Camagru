<?php
include_once '../Header/header.php';
?>
<style>
    <?php include 'signup.css'; ?>
</style>

<div class="centerDiv">
    <div class="card centerCard" id="signupCard">
        <div class="card-content">
            <p class="title">
                Sign Up
            </p>
            <form id="signupForm" action="../../Controller/signup.inc.php" method="POST">
                <div class="field">
                    <label class="label">Username</label>
                    <div class="control">
                        <input class="input" type="text" name="uid" placeholder="Username...">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="text" name="email" placeholder="Email...">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input" type="password" name="pwd" placeholder="Password...">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Repeat password</label>
                    <div class="control">
                        <input class="input" type="password" name="pwdrepeat" placeholder="Repeat password...">
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button id="signupButton" class="button is-link" type="submit" name="submit">Submit</button>
                    </div>
                </div>
                <?php
                if (isset($_GET["error"])) {
                    echo "<div class='errorMsgDiv'>";
                    if ($_GET["error"] == "emptyinput")
                        echo "<p>Fill in all fields!</p>";
                    else if ($_GET["error"] == "invaliduid")
                        echo "<p>Invalid username ([a-Z, 0-9, -_], 5 char min, 10 char max), must contain a special character, a number and an uppercase letter.</p>";
                    else if ($_GET["error"] == "invalidemail")
                        echo "<p>Choose a proper email!</p>";
                    else if ($_GET["error"] == "invalidpassword")
                        echo "<p>Invalid password ([a-Z, 0-9, +-_~@*%$], 8 char min), must contain a special character, a number and an uppercase letter.</p>";
                    else if ($_GET["error"] == "passwordsdontmatch")
                        echo "<p>Passwords doesn't match!</p>";
                    else if ($_GET["error"] == "usernametaken")
                        echo "<p>Username or email already taken!</p>";
                    else if ($_GET["error"] == "stmtfailed")
                        echo "<p>Something went wrong, try again!</p>";
                    else if ($_GET["error"] == "emailsend")
                        echo "<p>Something went wrong with your mail adresse, try again!</p>";
                    echo "</div>";
                }
                ?>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript" src="signup.js"></script>

<?php
include_once '../Footer/footer.php';
?>
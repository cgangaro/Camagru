<?php
require_once '../../Controller/verify.inc.php';
include_once '../Header/header.php';
?>

<style>
    <?php include 'verify.css'; ?>
</style>

<div class="centerDiv">
    <div class="card centerCard" id="verifyCard">
        <div class="card-content">
            <?php
            if (isset($_GET["awaiting"])) {
                echo "<p class='title'>
                        Awaiting verification
                    </p>";
                echo "<p>
                        Please check yours emails to complete the registration
                    </p>";
            } else if (isset($_GET["success"])) {
                echo "<p class='title'>
                        Registration completed successfully
                    </p>";
                echo '<a href="' . $_SERVER['SERVER_NAME'] . '/View/LogIn/login.php" class="button is-link">
                        Log in
                    </a>';
            } else if (isset($_GET["error"])) {
                echo "<p class='title'>
                        Error during registration.
                    </p>";
                echo '<p class="textInfos">You may already be registered.</p>';
                echo '<a href="' . $_SERVER['SERVER_NAME'] . '/View/LogIn/login.php" class="button is-link">
                        Log in
                    </a>';
            }
            ?>
            </form>
        </div>
    </div>
</div>

<?php
include_once '../Footer/footer.php';
?>
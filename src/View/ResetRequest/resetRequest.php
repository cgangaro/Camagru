<?php
include_once '../Header/header.php';
?>

<style>
    <?php include 'resetRequest.css'; ?>
</style>

<div class="centerDiv">
    <div class="card centerCard" id="signinCard">
        <div class="card-content">
            <p class="title">
                Password Reset Request
            </p>
            <form id="resetRequestForm">
                <input id="resetRequestInput" class="input" type="email" name="emailForReset" placeholder="Your email...">
            </form>
            <button id="resetRequestButton" class="button is-link">Submit Request</button>
            <p id="resetRequestError"></p>
        </div>
    </div>
</div>
<script type="text/javascript" src="resetRequest.js"></script>
<script type="text/javascript" src="../all.js"></script>

<?php
include_once '../Footer/footer.php';
?>
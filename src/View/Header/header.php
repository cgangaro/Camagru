<?php
if (!isset($_SESSION['useruid'])) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css" />
    <link rel="shortcut icon" href="#">
    <title>Camagru</title>
</head>

<body>
    <style>
        <?php
        include 'header.css';
        include '../all.css';
        ?>
    </style>
    <nav id="navBarForLaptop" class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <?php
            echo '
            <a class="navbar-item" href="' . $_SERVER['SERVER_NAME'] . '/index.php">
                <p class="camagruTitle">Camagru</p>
            </a>
            ';
            ?>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <div class="navbar-item">
                    <div class="buttons">
                        <?php
                        echo '
                        <a href="' . $_SERVER['SERVER_NAME'] . '/index.php" class="button is-primary">
                            <strong>Gallery</strong>
                        </a>
                        ';
                        ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION["useruid"])) {
                    echo '
                    <div class="navbar-item">
                        <div class="buttons">
                            <a href="' . $_SERVER['SERVER_NAME'] . '/View/Studio/studio.php" class="button is-primary">
                                <strong>Add Picture</strong>
                            </a>
                        </div>
                    </div>
                ';
                }
                ?>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <?php
                        if (isset($_SESSION["useruid"])) {
                            echo "<a href='" . $_SERVER['SERVER_NAME'] . "/Controller/logout.inc.php' class='button is-light'>
                                <strong>Log Out</strong>
                                </a>";
                            echo "<a href='" . $_SERVER['SERVER_NAME'] . "/View/Settings/settings.php' class='button is-light'>
                                <strong>Settings</strong>
                                </a>";
                        } else {
                            echo "<a href='" . $_SERVER['SERVER_NAME'] . "/View/SignUp/signup.php' class='button is-primary'>
                                <strong>Sign up</strong>
                                </a>";
                            echo "<a href='" . $_SERVER['SERVER_NAME'] . "/View/LogIn/login.php' class='button is-light'>
                                Log in
                                </a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <nav id="navBarForPhone" role="navigation" aria-label="main navigation">
        <div id="mainMenu">
            <?php
            echo '
                <a href="' . $_SERVER['SERVER_NAME'] . '/index.php" id="logoLink">
                    <p class="camagruTitle">Camagru</p>
                </a>
            ';
            ?>
            <a id="burgerMenu" class="icon" onclick="burgerMenu()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div id="menuUnrolled">
            <?php
            echo '
                <a href="' . $_SERVER['SERVER_NAME'] . '/index.php">
                    Gallery
                </a>
            ';
            ?>
            <?php
            if (isset($_SESSION["useruid"])) {
                echo "<a href='" . $_SERVER['SERVER_NAME'] . "/View/Studio/studio.php'>
                    <strong>Studio</strong>
                </a>";
                echo "<a href='" . $_SERVER['SERVER_NAME'] . "/View/Settings/settings.php'>
                    <strong>Settings</strong>
                </a>";
                echo "<a href='" . $_SERVER['SERVER_NAME'] . "/Controller/logout.inc.php'>
                    <strong>Log Out</strong>
                </a>";
            } else {
                echo "<a href='" . $_SERVER['SERVER_NAME'] . "/View/SignUp/signup.php'>
                    <strong>Sign up</strong>
                </a>";
                echo "<a href='" . $_SERVER['SERVER_NAME'] . "/View/LogIn/login.php'>
                    Log in
                </a>";
            }
            ?>
        </div>
    </nav>

    <?php
    echo '
    <script type="text/javascript" src="' . $_SERVER['SERVER_NAME'] . '/View/Header/header.js"></script>
    ';
    ?>
    
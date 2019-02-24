<!DOCTYPE html>

<?php
session_start();
$userDisplay = ((isset($_SESSION["userExists"]) && $_SESSION["userExists"]) ? "block" : "none");
$passDisplay = ((isset($_SESSION["passwordMatches"]) && !$_SESSION["passwordMatches"]) ? "block" : "none");
$userError = "<p class='error' style='display: " . $userDisplay . ";'>Username already exists.</p>";
$passwordError = "<p class='error' style='display: " . $passDisplay . ";'>Does not match password.</p>";
$_SESSION["userExists"] = NULL;
$_SESSION["passwordMatches"] = NULL;
?>

<html>
    <head>
        <title>Log in</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
        <script src="js/signup.js"></script>
    </head>

    <body class="part1">
        <?php include_once("navbar.php") ?>
        <form class="login border-box" action="server/signup_server.php" method="post">
            <div id="username">
                <label for="user">Username</label>
                <input type="text" id="user" name="username">
                <?=$userError;?>
            </div>
            <div id="password">
                <label for="pass">Password</label>
                <input type="password" id="pass" name="password" required>
            </div>
            <div id="confirm-password">
                <label for="confirm-pass">Confirm Password</label>
                <input type="password" id="confirm-pass" name="confirm-pass" required>
                <?=$passwordError;?>
            </div>
            <input type="submit" class="button" value="Sign up">
        </form>
    </body>
</html>

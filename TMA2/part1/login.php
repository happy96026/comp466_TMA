<!DOCTYPE html>

<?php
session_start();
$display = ($_SESSION["badAuth"] && $_SESSION["badAuth"] ? "block" : "none");
$userError = "<p class='error' style='display: " . $display . 
                ";'>Username does not exist or password does not match.</p>";
$_SESSION["badAuth"] = NULL;
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
    </head>

    <body class="part1">
        <?php include_once("navbar.php") ?>
        <form class="login border-box" action="server/login_server.php" method="post">
            <div id="username">
                <label for="user">Username</label>
                <input type="text" id="user" name="username">
            </div>
            <div id="password">
                <label for="pass">Password</label>
                <input type="password" id="pass" name="password" required>
                <?=$userError;?>
            </div>
            <input type="submit" class="button" value="Log in">
        </form>
        <div class="login border-box" id="signup">
            Don't have an account? <a href="signup.php">Sign up</a>
        </div>
    </body>
</html>

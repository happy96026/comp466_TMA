<!DOCTYPE html>

<?php
session_start();
$errorDisplay = isset($_SESSION["invalid"]) ? "block" : "none";
$error = "<p class='error' style='display: " . $errorDisplay . ";'>Invalid URL.</p>";

$username = isset($_SESSION["url"]) ? $_SESSION["url"] : "";
$input = "<input type='text' id='url' name='url' value='" . $username . "' required>";

$_SESSION["invalid"] = NULL;
$_SESSION["url"] = NULL;
?>

<html>
    <head>
        <title>Add a bookmark</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
        <script src="js/add.js"></script>
    </head>

    <body class="part1">
        <?php include_once("navbar.php") ?>
        <div class="content">
            <div id="add">
                <div class="label">
                    <label class="label-header">Add a bookmark</label>
                </div>
                <form class="border-box" action="server/add_server.php" method="post" id="form">
                    <div class="input">
                        <label for="name">Name:</label>
                        <input id="name" type="text" name="name"></input>
                    </div>
                    <div class="input">
                        <label for="url">URL:</label>
                        <?=$input;?>
                        <?=$error;?>
                    </div>
                    <input type="submit" class="button" id="submit" value="Add">
                </form>
            </div>
        </div>
    </body>
</html>

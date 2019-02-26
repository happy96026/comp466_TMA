<!DOCTYPE html>

<?php
require("classes/Database.php");

session_start();
$username = $_SESSION["username"];
$id = $_GET["id"];

$db = Database::getDatabase();
$bookmark = $db->getBookmark($username, $id);
if (!$bookmark) {
    header("Location: your_bookmarks.php");
    exit();
}

$name = $bookmark["name"];
$url = $bookmark["url"];

$nameInput = "<input id='name' type='text' name='name' value='" . $name . "'>";
$urlInput = "<input id='url' type='text' name='url' value='" . $url . "'>";
$idInput = "<input type='hidden' name='id' value='" . $id . "'>";

$errorDisplay = isset($_SESSION["invalid"]) ? "block" : "none";
$error = "<p class='error' style='display: " . $errorDisplay . ";'>Invalid URL.</p>";

$username = isset($_SESSION["url"]) ? $_SESSION["url"] : "";
$input = "<input type='text' id='url' name='url' value='" . $username . "' required>";

$_SESSION["invalid"] = NULL;
$_SESSION["url"] = NULL;
?>

<html>
    <head>
        <title>Edit a bookmark</title>
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
                    <label class="label-header">Edit a bookmark</label>
                </div>
                <form id="form" class="border-box" method="post" action="server/edit_server.php">
                    <div class="input">
                        <label for="name">Name:</label>
                        <?=$nameInput;?>
                    </div>
                    <div class="input">
                        <label for="url">URL:</label>
                        <?=$urlInput;?>
                        <?=$error;?>
                    </div>
                    <input type="submit" class="button" id="submit" value="Edit">
                    <?=$idInput;?>
                </form>
            </div>
        </div>
    </body>
</html>

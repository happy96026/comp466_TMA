<!DOCTYPE html>

<?php
require("classes/Database.php");

function createBookmark($name, $url, $id) {
    $li = "<li>
        <a href='" . $url . "'>" . $name . "</a>
        <div id='" . $id . "'>
            <button class='button edit'>Edit</button>
            <button class='button delete'>Delete</button>
        </div>
    </li>";
    return $li;
}

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: logout.php");
    exit();
}
$username = $_SESSION["username"];
$db = Database::getDatabase();
$title = $_SESSION["username"] . "'s bookmarks";

$arr = $db->getBookmarks($username);
$lis = "";
for ($i = 0; $i < count($arr); $i++) {
    $name = $arr[$i]["name"];
    $url = $arr[$i]["url"];
    $id = $arr[$i]["id"];
    $lis = $lis . createBookmark($name, $url, $id);
}
?>

<html>
    <head>
        <title><?=$title;?></title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
        <script src="js/your_bookmarks.js"></script>
    </head>

    <body class="part1">
        <?php include_once("navbar.php") ?>
        <div class="content">
            <div id="your-bookmarks">
                <div class="label">
                <label class="label-header"><?=$title;?></label>
                    <a class="button" href="add.php" id="add">Add</a>
                </div>
                <form id="form">
                    <ul class="border-box">
                        <?=$lis;?>
                    </ul>
                    <input type='hidden' id='id' name='id'>
                </form>
            </div>
        </div>
    </body>
</html>

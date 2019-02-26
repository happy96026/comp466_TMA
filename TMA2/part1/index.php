<!DOCTYPE html>

<?php
require("classes/Database.php");

function createListItem($url) {
    $name = $url;
    return "<li><a href='" . $url . "'>" . $name . "</a></li>";
}

session_start();

$db = Database::getDatabase();
$top10 = $db->getTop10();
$lis = "";
for ($i = 0; $i < count($top10); $i++) {
    $lis = $lis . createListItem($top10[$i]["url"]);
}
?>

<html>
    <head>
        <title>Welcome to Bookmarks!</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
    </head>

    <body class="part1">
        <?php include_once("navbar.php") ?>
        <div class="content">
            <div id="top10">
                <label class="label-header">Top 10 Bookmarks</label>
                <ol class="border-box">
                    <?=$lis;?>
                </ol>
            </div>
        </div>
    </body>
</html>

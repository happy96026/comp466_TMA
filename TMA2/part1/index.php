<!DOCTYPE html>

<?php
session_start();
$_SESSION["username"] = "happy96026";
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
                <h1>Top 10 Bookmarks</h1>
                <ol class="border-box">
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                    <li><a href="#">Title</a></li>
                </ol>
            </div>
        </div>
    </body>
</html>

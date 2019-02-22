<!DOCTYPE html>

<?php
session_start();
?>

<html>
    <head>
        <title>Edit bookmarks</title>
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
            <div id="your-bookmarks">
                <div class="label">
                    <label>Your Bookmarks</label>
                    <button class="button">Add</button>
                </div>
                <ul class="border-box">
                    <li>
                        <a href="#">Title</a>
                        <button class="button">Edit</button>
                        <button class="button">Delete</button>
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>

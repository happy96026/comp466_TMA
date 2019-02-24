<!DOCTYPE html>
<?php
?>

<html>
    <head>
        <title>Welcome to Learner 101!</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
    </head>

    <body class="part2">
        <?php include_once("navbar.php") ?>
        <div class="content">
            <label class="label-header">Category</label>
            <form id="category-container" action="courses.php">
                <button class="category button">Web Design</button>
                <button class="category button">Machine Learning</button>
                <button class="category button">Algorithms</button>
            </form>
        </div>
    </body>
</html>

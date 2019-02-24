<!DOCTYPE html>

<html>
    <head>
        <title>Courses</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
        <!--<script src="js/course_info.js"></script>-->
    </head>

    <body class="part2" id="tutor">
        <?php include_once("navbar.php"); ?>
        <aside class="border-box">
            <ul id="syllabus">
                <li class="button unit">Introduction to HTML</li>
                <div class="active">
                    <li class="button unit">Introduction to CSS</li>
                    <li class="button sub-unit active">asdfasdf asdfjlkasdf waeijopzxc asd</li>
                    <li class="button sub-unit">asdfasdf</li>
                    <li class="button sub-unit">asdfasdf</li>
                    <li class="button sub-unit">asdfiwef</li>
                </div>
                <li class="button unit">Yoyoyoyoyoyo</li>
            </ul>
        </aside>
        <div class="content">
            <?php include_once("notes.php"); ?>
            <!--<?php include_once("quiz.php"); ?>-->
            <form id="buttons">
                <button class="button" id="prev" name="id" value="1">Prev</button>
                <button class="button" id="next" name="id" value="2">Next</button>
            </form>
        </div>
    </body>
</html>

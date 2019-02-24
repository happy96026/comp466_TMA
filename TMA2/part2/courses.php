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
    </head>

    <body class="part2">
        <?php include_once("navbar.php") ?>
        <div class="content">
            <label class="label-header">Courses</label>
            <form id="course-container" action="course_info.php">
                <button class="course button">
                    <div class="name">Introduction to Web Design</div>
                    <div class="author">Min Soung Choi</div>
                </button>
                <button class="course button">
                    <div class="name">Introduction to Django</div>
                    <div class="author">Min Soung Choi</div>
                </button>
                <button class="course button">
                    <div class="name">Introduction to Flask</div>
                    <div class="author">Min Soung Choi</div>
                </button>
            </form>
        </div>
    </body>
</html>

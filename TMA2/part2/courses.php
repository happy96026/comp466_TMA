<!DOCTYPE html>
<?php
require_once("helper/CourseData.php");
require_once("helper/database.php");

session_start();

$buttons = "";
$conn = createConn();
$courseData = new CourseData($conn);
$courses = $courseData->getCoursesInCategory($_GET["category"]);

if (empty($courses)) {
    http_response_code(404);
    include("404.php");
    die();
}
foreach ($courses as $course) {
    $name = $course["name"];
    $tutor = $course["tutor"];
    $id = $course["course_id"];
    $buttons = "$buttons
        <button class='course button' name='id' value='$id'>
            <div class='name'>$name</div>
            <div class='tutor'>$tutor</div>
        </button>
    ";
}
?>

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
                <?=$buttons;?>
            </form>
        </div>
    </body>
</html>

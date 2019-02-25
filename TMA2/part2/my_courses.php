<!DOCTYPE html>

<?php
require_once("helper/Registration.php");
require_once("helper/database.php");

session_start();
$username = $_SESSION["username"];
if (!isset($username)) {
    header("Location: logout.php");
}

$conn = createConn();
$registration = new Registration($conn);

$courses = $registration->getUserCourses($username);

$buttons = "";
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

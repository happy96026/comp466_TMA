<!DOCTYPE html>
<?php
require_once("helper/CourseData.php");
require_once("helper/Registration.php");
require_once("helper/database.php");

session_start();

function getSyllabus($syllabus) {
    $prevUnit = -1;
    $dict = array();

    foreach ($syllabus as $lesson) {
        $unit = $lesson["unit_id"];
        $name = $lesson["name"];
        if ($unit != $prevUnit) {
            $arr = array();
            $arr["button"] = "
                <button class='button unit'>
                    <i class='arrow-up'></i>
                    $name
                </button>
            ";
            $arr["li"] = "";
            $dict[$unit] = $arr;
            $prevUnit = $unit;
        } else {
            $li = $dict[$unit]["li"];
            $li = "$li<li class='button sub-unit'>$name</li>";
            $dict[$unit]["li"] = $li;
        }
    }

    $ulContent = "";
    foreach ($dict as $item) {
        $button = $item["button"];
        $li = $item["li"];
        $ul = "<ul class='sub-unit-container'>$li</ul>";
        $ulContent = "$ulContent<li class='unit-container'>$button $ul</li>";
    }
    
    return $ulContent;
}

$buttons = "";
$conn = createConn();
$courseData = new CourseData($conn);
$course = $courseData->getCourse($_GET["id"]);
$syllabus = $courseData->getSyllabus($_GET["id"]);

if (empty($course)) {
    http_response_code(404);
    include("404.php");
    die();
}

$desc = $course["description"];
$aboutDiv = "
    <div class='border-box'>
        <div>$desc</div>
    </div>
";

$ulContent = getSyllabus($syllabus);
$courseId = $_GET["id"];
$username = $_SESSION["username"];

$registration = new Registration($conn);
$registered = $registration->userRegistered($username, $courseId);

$registerContent = $registered ? "Go to course" : "Register";
$registerButton = "<button id='register' class='button' name='id' value='$courseId'>$registerContent</button>";

$hidden = $registered ? "" : "none;";
$withdrawButton = "<button style='display: $hidden;' class='button' id='withdraw' name='id' value='$courseId'>Withdraw</button>"
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
        <script src="js/course_info.js"></script>
    </head>

    <body class="part2">
        <?php include_once("navbar.php"); ?>
        <div class="content" id="course">
            <label class="label-header">Introduction to Web Design</label>
            <div class="section">
                <label class="label-header">About</label>
                <div class="border-box">
                    <?=$desc;?>
                </div>
            </div>
            <div class="section">
                <label class="label-header">Syllabus</label>
                <ul id="syllabus">
                    <?=$ulContent;?>
                </ul>
            <div>
                <form class="buttons" method="post" action="server/register_redirect.php" id="form">
                    <?=$withdrawButton?>
                    <?=$registerButton?>
                </form>
            </div>
    </body>
</html>

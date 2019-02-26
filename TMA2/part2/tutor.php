<!DOCTYPE html>

<?php
require_once("helper/database.php");
require_once("helper/CourseData.php");
require_once("helper/Registration.php");
require_once("helper/Parser.php");
require_once("helper/Builder.php");

session_start();

$conn = createConn();
$courseData = new CourseData($conn);
$lessonId = $_GET["id"];
$lesson = $courseData->getLesson($lessonId);
$lessonContent = $lesson["content"];
$courseId = $lesson["course_id"];
$unitId = $lesson["unit_id"];

if (empty($lesson)) {
    http_response_code(404);
    include("404.php");
    die();
}

$username = $_SESSION["username"];
$registration = new Registration($conn);
if (!(isset($username) && $registration->userRegistered($username, $courseId))) {
    http_response_code(403);
    include("403.php");
    die();
}

$syllabus = $courseData->getSyllabus($courseId);
$arr = array();
foreach ($syllabus as $tempLesson) {
    $tempOrderId = $tempLesson["order_id"];
    $tempUnitId = $tempLesson["unit_id"];
    $tempLessonId = $tempLesson["lesson_id"];
    $tempName = $tempLesson["name"];
    $type = ($tempOrderId == 0) ? "unit" : "sub-unit";
    $active = ($tempLessonId == $lessonId) ? "active" : "";
    $button = ($tempUnitId == $unitId || $tempOrderId == 0) ? 
                "<button class='button $type $active' name='id' value='$tempLessonId'>$tempName</button>" : "";
    if (!isset($arr[$tempUnitId])) {
        $arr[$tempUnitId] = $button;
    } else {
        $arr[$tempUnitId] = $arr[$tempUnitId] . $button;
    }
}

$activeDiv = $arr[$unitId];
$arr[$unitId] = "<div class='active'>$activeDiv</div>";
$finalDiv = join($arr);

$lessonIds = array_map(function($x) {return $x["lesson_id"];}, $syllabus);
$currentIndex = array_search($lessonId, $lessonIds);
$prevId = $currentIndex - 1 >= 0 ? $lessonIds[$currentIndex - 1] : NULL;
$nextId = $currentIndex + 1 < count($lessonIds) ? $lessonIds[$currentIndex + 1] : NULL;

$parsedContent = Parser::parse($lessonContent);
$htmlContent = Builder::buildHTML($parsedContent);
$htmlButtons = Builder::buildButton($parsedContent, $prevId, $nextId);
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

    <body class="part2" id="tutor">
        <?php include_once("navbar.php"); ?>
        <aside class="border-box">
            <form action="">
                <ul id="syllabus">
                    <?=$finalDiv;?>
                </ul>
            </form>
        </aside>
        <div class="content">
            <?=$htmlContent;?>
            <form id="buttons">
                <?=$htmlButtons;?>
            </form>
        </div>
    </body>
</html>

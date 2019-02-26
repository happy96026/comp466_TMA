<?php
require_once("../helper/database.php");
require_once("../helper/Authentication.php");
require_once("../helper/Parser.php");
require_once("../helper/CourseData.php");

function sendAnswers($lessonId) {
    $conn = createConn();
    $courseData = new CourseData($conn);
    $lesson = $courseData->getLesson($lessonId);
    $parsed = Parser::parse($lesson["content"]);
    $content = $parsed["content"];
    
    $answers = array();
    foreach ($content as $question) {
        array_push($answers, $question["answer"]);
    }
    
    return $answers;
}

$_POST = json_decode(file_get_contents("php://input"), true);
$arr = array();

if ($_POST["type"] == "auth_user") {
    $conn = createConn();
    $auth = new Authentication($conn);
    $exist = $auth->userExists($_POST["username"]);
    $arr["exist"] = $exist;
} else if ($_POST["type"] == "check_quiz") {
    $arr = sendAnswers($_POST["lesson_id"]);
}

echo json_encode($arr);
?>

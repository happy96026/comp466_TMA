<?php
require_once("../helper/Authentication.php");
require_once("../helper/database.php");

session_start();

$conn = createConn();
$auth = new Authentication($conn);
$courseId = $_POST["id"];
$getParam = isset($courseId) ? "?id=$courseId" : "";

$userExists = $auth->userExists($_POST["username"]);
$passwordMatches = $_POST["password"] === $_POST["confirm-pass"];

if (!$userExists && $passwordMatches) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["userExists"] = NULL;
    $_SESSION["passwordMatches"] = NULL;
    $auth->addUser($_POST["username"], $_POST["password"]);
    if ($courseId) {
        header("Location: ../course_info.php$getParam");
    } else {
        header("Location: ../my_courses.php");
    }
} else {
    $_SESSION["userExists"] = $userExists;
    $_SESSION["passwordMatches"] = $passwordMatches;
    header("Location: ../signup.php$getParam");
}

?>

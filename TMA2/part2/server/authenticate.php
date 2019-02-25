<?php
require_once("../helper/Authentication.php");
require_once("../helper/database.php");

session_start();

$conn = createConn();
$auth = new Authentication($conn);
$courseId = $_POST["id"];
$getParam = isset($courseId) ? "?id=$courseId" : "";

if ($auth->authUser($_POST["username"], $_POST["password"])) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["badAuth"] = NULL;
    if ($courseId) {
        header("Location: ../course_info.php$getParam");
    } else {
        header("Location: ../my_courses.php");
    }
} else {
    $_SESSION["badAuth"] = TRUE;
    header("Location: ../login.php$getParam");
}
?>

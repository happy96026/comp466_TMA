<?php

require_once("../helper/Registration.php");
require_once("../helper/database.php");

session_start();


$conn = createConn();
$registration = new Registration($conn);
$username = $_SESSION["username"];
$courseId = $_POST["id"];

if (isset($username)) {
    if (!$registration->userRegistered($username, $courseId)) {
        $registration->registerUser($username, $courseId);
    }
    header("Location: ../tutor.php?id=$courseId");
} else {
    $_SESSION["goto"] = "course_info";
    $_SESSION["id"] = $courseId;
    header("Location: ../login.php?id=$courseId");
}
?>

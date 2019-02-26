<?php

require_once("../helper/Registration.php");
require_once("../helper/database.php");

session_start();

$conn = createConn();
$registration = new Registration($conn);
$username = $_SESSION["username"];
$courseId = $_POST["id"];

if ($registration->userRegistered($username, $courseId)) {
    $registration->withdrawCourse($username, $courseId);
};

header("Location: ../my_courses.php");
?>

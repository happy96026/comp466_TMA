<?php
define("HOST", "localhost");
define("USERNAME", "comp466user");
define("PASSWORD", "password");
define("DB_NAME", "TMA2_part2");
define("AUTH_TABLE", "Authentication");
define("LESSON", "Lesson");
define("COURSE", "Course");
define("REGISTRATION", "Registration");

function createConn() {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB_NAME);
    return $conn;
}
?>

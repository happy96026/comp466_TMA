<?php
define("HOST", "localhost");
define("USERNAME", "comp466user");
define("PASSWORD", "password");
define("DB_NAME", "TMA2_part2");
define("AUTH_TABLE", "Authentication");
define("LESSON", "Lesson");
define("COURSE", "Course");
define("REGISTRATION", "Registration");
function dbInit($conn) {
    $query = "DROP TABLE IF EXISTS " . LESSON . ";";
    $conn->query($query);

    $query = "DROP TABLE IF EXISTS " . REGISTRATION . ";";
    $conn->query($query);

    $query = "DROP TABLE IF EXISTS " . COURSE . ";";
    $conn->query($query);

    $query = "DROP TABLE IF EXISTS " . AUTH_TABLE . ";";
    $conn->query($query);

    $query = "CREATE TABLE " . AUTH_TABLE . " (
        username VARCHAR(30),
        password VARCHAR(20) NOT NULL,
        PRIMARY KEY(username)
    )";
    $conn->query($query);

    $query = "CREATE TABLE " . COURSE . " (
        id INT AUTO_INCREMENT,
        name TEXT,
        description TEXT,
        PRIMARY KEY(id)
    );";
    $conn->query($query);

    $query = "CREATE TABLE " . LESSON . " (
        course_id INT,
        id INT,
        name TEXT,
        type TEXT,
        PRIMARY KEY(course_id, id),
        FOREIGN KEY (course_id) REFERENCES " . COURSE . "(id)
    );";
    $conn->query($query);

    $query = "CREATE TABLE " . REGISTRATION . " (
        username VARCHAR(30),
        course_id INT,
        PRIMARY KEY(username, course_id),
        FOREIGN KEY (course_id) REFERENCES " . COURSE . "(id),
        FOREIGN KEY (username) REFERENCES " . AUTH_TABLE . "(username)
    );";
    $conn->query($query);

    $courseID = 1;
    dbAddCourse($conn, $courseID, "Comp 466", "Comp 466 Notes");
    array(
        array(
            "name" => "Introduction 1 - the Web, HTML5, and CSS",
            "path" => "1.xml",
            "type" => "unit"
        ),
        array(
            "name" => "Introduction to Computers and the Internet",
            "path" => "1_0.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Web Server (Apache and IIS)",
            "path" => "1_1.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Introduction to HTML5",
            "path" => "1_2.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Introduction to HTML5: Part 2",
            "path" => "1_3.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Introduction to Cascading Style Sheets (CSS): Part 1",
            "path" => "1_4.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Introduction to Cascading Style Sheets (CSS): Part 2",
            "path" => "1_5.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Unit 1 Quiz",
            "path" => "quiz1.xml",
            "type" => "quiz"
        ),
        array(
            "name" => "Introduction 2 - Client side Scripting in JavaScript",
            "path" => "2.xml",
            "type" => "unit"
        ),
        array(
            "name" => "Introduction to Scripting",
            "path" => "2_1.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Control Statement in JavaScript",
            "path" => "2_2.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Functions in JavaScript",
            "path" => "2_3.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Arrays, Objects, and Document Object Model (DOM) in JavaScript",
            "path" => "2_4.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Event Handling in JavaScript",
            "path" => "2_5.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Canvas in HTML5",
            "path" => "2_6.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Unit 2 Quiz",
            "path" => "quiz2.xml",
            "type" => "quiz"
        ),
        array(
            "name" => "XML and Ajax",
            "path" => "3.xml",
            "type" => "unit"
        ),
        array(
            "name" => "Extended Markup Language (XML)",
            "path" => "3_1.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Ajax and Ajax-enabled Rich Internet Applications",
            "path" => "3_2.xml",
            "type" => "sub_unit"
        ),
        array(
            "name" => "Unit 3 Quiz",
            "path" => "quiz3.xml",
            "type" => "quiz"
        )
    );
}

function dbAddCourse($conn, $id, $name, $desc) {
    $query = "INSERT INTO " . COURSE . "
        VALUES (" . $id . ", '" . $name . "', '" . $desc . "');
    ";
    $conn->query($query);
}

function dbAddLesson($conn, $courseId, $id, $name, $type) {
    $query = "INSERT INTO " . LESSON . "
        VALUES (" . $courseID . ", " . $id . ", '" . $name . "', '" . $desc . "');
    ";
    $conn->query($query);
}

function createConn() {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB_NAME);
    return $conn;
}

$conn = createConn();
dbInit($conn);


?>

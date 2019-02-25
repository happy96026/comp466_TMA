<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/part2/helper/database.php");

function dbAddCourse($conn, $id, $name, $tutor, $category, $desc) {
    $query = "INSERT INTO " . COURSE . " VALUES ($id, '$name', '$tutor', '$category', '$desc')";
    $conn->query($query);
}

function dbAddLesson($conn, $courseId, $unitId, $orderId, $name, $content) {
    $query = 'INSERT INTO ' . LESSON . '(course_id, unit_id, order_id, name, content)
        VALUES (' . $courseId . ', ' . $unitId . ', "' . $orderId . '", "' . $name . '", "' . $content . '");
    ';
    return $conn->query($query);
}

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
        course_id INT AUTO_INCREMENT,
        name TEXT,
        tutor TEXT,
        category TEXT,
        description TEXT,
        PRIMARY KEY(course_id)
    );";
    $conn->query($query);

    $query = "CREATE TABLE " . LESSON . " (
        lesson_id INT AUTO_INCREMENT,
        course_id INT NOT NULL,
        unit_id INT NOT NULL,
        order_id INT NOT NULL,
        name TEXT NOT NULL,
        content TEXT,
        PRIMARY KEY(lesson_id),
        FOREIGN KEY (course_id) REFERENCES " . COURSE . "(course_id)
    );";
    $conn->query($query);

    $query = "CREATE TABLE " . REGISTRATION . " (
        username VARCHAR(30),
        course_id INT,
        PRIMARY KEY(username, course_id),
        FOREIGN KEY (course_id) REFERENCES " . COURSE . "(course_id),
        FOREIGN KEY (username) REFERENCES " . AUTH_TABLE . "(username)
    );";
    $conn->query($query);

    $courseId = 1;
    dbAddCourse($conn, $courseId, "Comp 466 - Advanced Technologies for Web-Based System", "Min Soung Choi", "Web Development", "Comp 466 Notes");
    $arr = array(
        array(
            "name" => "Introduction 1 - the Web, HTML5, and CSS",
            "path" => "1.xml",
            "unit" => 1,
            "order" => 0
        ),
        array(
            "name" => "Introduction to Computers and the Internet",
            "path" => "1_0.xml",
            "unit" => 1,
            "order" => 1
        ),
        array(
            "name" => "Web Server (Apache and IIS)",
            "path" => "1_1.xml",
            "unit" => 1,
            "order" => 2
        ),
        array(
            "name" => "Introduction to HTML5",
            "path" => "1_2.xml",
            "unit" => 1,
            "order" => 3
        ),
        array(
            "name" => "Introduction to HTML5: Part 2",
            "path" => "1_3.xml",
            "unit" => 1,
            "order" => 4
        ),
        array(
            "name" => "Introduction to Cascading Style Sheets (CSS): Part 1",
            "path" => "1_4.xml",
            "unit" => 1,
            "order" => 5
        ),
        array(
            "name" => "Introduction to Cascading Style Sheets (CSS): Part 2",
            "path" => "1_5.xml",
            "unit" => 1,
            "order" => 6
        ),
        array(
            "name" => "Unit 1 Quiz",
            "path" => "quiz1.xml",
            "unit" => 1,
            "order" => 7
        ),
        array(
            "name" => "Introduction 2 - Client side Scripting in JavaScript",
            "path" => "2.xml",
            "unit" => 2,
            "order" => 0
        ),
        array(
            "name" => "Introduction to Scripting",
            "path" => "2_1.xml",
            "unit" => 2,
            "order" => 1
        ),
        array(
            "name" => "Control Statement in JavaScript",
            "path" => "2_2.xml",
            "unit" => 2,
            "order" => 2
        ),
        array(
            "name" => "Functions in JavaScript",
            "path" => "2_3.xml",
            "unit" => 2,
            "order" => 3
        ),
        array(
            "name" => "Arrays, Objects, and Document Object Model (DOM) in JavaScript",
            "path" => "2_4.xml",
            "unit" => 2,
            "order" => 4
        ),
        array(
            "name" => "Event Handling in JavaScript",
            "path" => "2_5.xml",
            "unit" => 2,
            "order" => 5
        ),
        array(
            "name" => "Canvas in HTML5",
            "path" => "2_6.xml",
            "unit" => 2,
            "order" => 6
        ),
        array(
            "name" => "Unit 2 Quiz",
            "path" => "quiz2.xml",
            "unit" => 2,
            "order" => 7
        ),
        array(
            "name" => "XML and Ajax",
            "path" => "3.xml",
            "unit" => 3,
            "order" => 0
        ),
        array(
            "name" => "Extended Markup Language (XML)",
            "path" => "3_1.xml",
            "unit" => 3,
            "order" => 1
        ),
        array(
            "name" => "Ajax and Ajax-enabled Rich Internet Applications",
            "path" => "3_2.xml",
            "unit" => 3,
            "order" => 2
        ),
        array(
            "name" => "Unit 3 Quiz",
            "path" => "quiz3.xml",
            "unit" => 3,
            "order" => 3
        )
    );

    for ($i = 0; $i < count($arr); $i++) {
        $name = $arr[$i]["name"];
        $path = $arr[$i]["path"];
        $unit = $arr[$i]["unit"];
        $order = $arr[$i]["order"];
        $content = file_get_contents("../xml/" . $path);
        $result = dbAddLesson($conn, $courseId, $unit, $order, $name, $content);
    }
}

$conn = createConn();
dbInit($conn);
?>

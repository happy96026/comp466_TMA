<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/part2/helper/database.php");

class CourseData {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCategories() {
        $courseTable = COURSE;

        $conn = $this->conn;
        $query = "SELECT DISTINCT category FROM $courseTable";
        $result = $conn->query($query);

        $arr = array();
        while ($row = $result->fetch_array()) {
            array_push($arr, $row["category"]);
        }

        return $arr;
    }

    public function getCoursesInCategory($category) {
        $courseTable = COURSE;

        $conn = $this->conn;
        $query = "SELECT course_id, name, tutor FROM $courseTable WHERE category = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        $arr = array();
        while ($row = $result->fetch_array()) {
            array_push($arr, $row);
        }

        return $arr;
    }

    public function getCourse($courseId) {
        $courseTable = COURSE;

        $conn = $this->conn;
        $query = "SELECT * FROM $courseTable WHERE course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_array()) {
            return $row;
        }

        return NULL;
    }
    
    public function getSyllabus($courseId) {
        $lessonTable = LESSON;

        $conn = $this->conn;
        $query = "SELECT lesson_id, course_id, unit_id, order_id, name FROM $lessonTable WHERE course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        $arr = array();
        while ($row = $result->fetch_array()) {
            array_push($arr, $row);
        }

        return $arr;
    }

    public function getLesson($lessonId) {
        $lessonTable = LESSON;

        $conn = $this->conn;
        $query = "SELECT * FROM $lessonTable WHERE lesson_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $lessonId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_array()) {
            return $row;
        }

        return NULL;
    }
}
?>

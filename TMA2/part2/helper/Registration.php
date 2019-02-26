<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/part2/helper/database.php");

class Registration {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserCourses($username) {
        $courseTable = COURSE;
        $regTable = REGISTRATION;

        $conn = $this->conn;
        $query = "
            SELECT c.course_id, c.name, c.tutor
            FROM $courseTable AS c, $regTable as r
            WHERE c.course_id = r.course_id AND r.username = ?
        ;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $arr = array();
        while ($row = $result->fetch_array()) {
            array_push($arr, $row);
        }

        return $arr;
    }

    public function userRegistered($username, $courseId) {
        $regTable = REGISTRATION;

        $conn = $this->conn;
        $query = "SELECT * FROM $regTable WHERE username = ? AND course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $username, $courseId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0 ? TRUE : FALSE;
    }

    public function registerUser($username, $courseId) {
        $regTable = REGISTRATION;

        $conn = $this->conn;
        $query = "INSERT INTO $regTable VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $username, $courseId);
        $stmt->execute();
    }

    public function withdrawCourse($username, $courseId) {
        $regTable = REGISTRATION;
        
        $conn = $this->conn;
        $query = "DELETE FROM $regTable WHERE username = ? AND course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $username, $courseId);
        $stmt->execute();
    }
}
?>

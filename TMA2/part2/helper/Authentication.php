<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/part2/helper/database.php");

class Authentication {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function authUser($username, $password) {
        $authTable = AUTH_TABLE;

        $conn = $this->conn;
        $query = "SELECT * FROM $authTable WHERE USERNAME = ? AND PASSWORD = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? TRUE : FALSE;
    }

    public function userExists($username) {
        $authTable = AUTH_TABLE;

        $conn = $this->conn;
        $query = "SELECT username FROM $authTable  WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? TRUE : FALSE;
    }

    public function addUser($username, $password) {
        $authTable = AUTH_TABLE;

        $conn = $this->conn;
        $query = "INSERT INTO $authTable VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
    }
}
?>

<?php
class Database {
    public static $AUTH_TABLE = "authentication";
    public static $BOOKMARK_TABLE = "bookmark";

    public $conn;
    public $host;
    public $username;
    public $dbName;

    public static function getDatabase() {
        $host = "localhost";
        $username = "comp466user";
        $password = "password";
        $dbName = "TMA2_part1";

        $_SESSION["db"] = new Database($host, $username, $password);
        $db = $_SESSION["db"];
        $db->selectDB($dbName);
        $db->initialize();

        return $db;
    }

    public function __construct($host, $username, $password) {
        $conn = new mysqli($host, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->host = $host;
        $this->username = $username;
        $this->conn = $conn;
    }

    public function selectDB($name) {
        $conn = $this->conn;
        if (!$conn->ping()) {
            echo "hello";
        }
        if (!$conn->select_db($name)) {
            die("Could not select database.");
        }
        $dbName = $name;
    }

    public function close() {
        $this->conn->close();
    }

    public function initialize() {
        $conn = $this->conn;
        $query = "CREATE TABLE IF NOT EXISTS " . self::$AUTH_TABLE . " (
            username VARCHAR(30),
            password VARCHAR(20) NOT NULL,
            PRIMARY KEY(username)
        )";
        $conn->query($query);

        $query = "CREATE TABLE IF NOT EXISTS " . self::$BOOKMARK_TABLE . " (
            id INT AUTO_INCREMENT,
            username VARCHAR(30),
            name TEXT,
            url VARCHAR(200),
            PRIMARY KEY(id),
            FOREIGN KEY (username) REFERENCES " . self::$AUTH_TABLE . "(username)
        );";
        $conn->query($query);
    }

    public function authUser($username, $password) {
        $query = "SELECT * FROM " . self::$AUTH_TABLE . " WHERE 
            username = '" . $username . "' AND 
            password = '" . $password . "';";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function userExists($username) {
        $query = "SELECT username FROM " . self::$AUTH_TABLE . " WHERE 
            username = '" . $username . "';";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addUser($username, $password) {
        $query = "INSERT INTO " . self::$AUTH_TABLE . "
            VALUES ('" . $username . "', '" . $password . "');
        ";
        $this->conn->query($query);
    }

    public function getBookmark($username, $id) {
        $query = "SELECT * FROM " . self::$BOOKMARK_TABLE . " WHERE
            username = '" . $username . "' AND id = " . $id . "
            LIMIT 1;";
        
        $result = $this->conn->query($query);

        while ($row = $result->fetch_array()) {
            return $row;
        }

        return NULL;
    }

    public function getBookmarks($username) {
        $query = "SELECT * FROM " . self::$BOOKMARK_TABLE . " WHERE
            username = '" . $username . "';";
        $result = $this->conn->query($query);
        $arr = array();

        while ($row = $result->fetch_array()) {
            array_push($arr, $row);
        }

        return $arr;
    }

    public function addBookmark($username, $name, $url) {
        $query = "INSERT INTO " . self::$BOOKMARK_TABLE . " (username, name, url)
            VALUES ('" . $username . "', '" . $name . "', '" . $url . "');";
        $this->conn->query($query);
    }

    public function deleteBookmark($username, $id) {
        $query = "DELETE FROM " . self::$BOOKMARK_TABLE . "
            WHERE id = " . $id . "
            AND username = '" . $username . "';";
        $this->conn->query($query);
    }

    public function updateBookmark($id, $name, $url) {
        $query = "UPDATE " . self::$BOOKMARK_TABLE . "
            SET url = '" . $url . "', name = '" . $name . "'
            WHERE id = " . $id . ";";
        $this->conn->query($query);
    }

    public function getTop10() {
        $query = "SELECT url, COUNT(url) FROM " . self::$BOOKMARK_TABLE . "
            GROUP BY url ORDER BY COUNT(url) DESC LIMIT 10;";
        $result = $this->conn->query($query);
        $arr = array();

        while ($row = $result->fetch_array()) {
            array_push($arr, $row);
        }

        return $arr;
    }
}
?>

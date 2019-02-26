<?php
require("../classes/Database.php");

session_start();
$username = $_SESSION["username"];
$id = $_POST["id"];

$db = Database::getDatabase();
$bookmark = $db->deleteBookmark($username, $id);
header("Location: ../your_bookmarks.php");
?>

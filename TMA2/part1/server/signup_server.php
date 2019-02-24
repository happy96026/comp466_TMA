<?php
require("../classes/Database.php");
session_start();

$db = Database::getDatabase();
$userExists = $db->userExists($_POST["username"]);
$passwordMatches = $_POST["password"] === $_POST["confirm-pass"];

if (!$userExists && $passwordMatches) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["userExists"] = NULL;
    $_SESSION["passwordMatches"] = NULL;
    $db->addUser($_POST["username"], $_POST["password"]);
    header("Location: ../your_bookmarks.php");
} else {
    $_SESSION["userExists"] = $userExists;
    $_SESSION["passwordMatches"] = $passwordMatches;
    header("Location: ../signup.php");
}
?>

<?php
require("../classes/Database.php");
session_start();

$db = Database::getDatabase();
if ($db->authUser($_POST["username"], $_POST["password"])) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["badAuth"] = NULL;
    header("Location: ../your_bookmarks.php");
} else {
    $_SESSION["badAuth"] = TRUE;
    header("Location: ../login.php");
}
?>

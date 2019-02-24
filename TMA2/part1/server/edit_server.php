<?php
require("../classes/Database.php");

session_start();
$username = $_SESSION["username"];
$id = $_POST["id"];

$db = Database::getDatabase();
$bookmark = $db->getBookmark($username, $id);
if (!$bookmark) {
    header("Location: your_bookmarks.php");
    exit();
}

if (isset($_POST["url"])) {
    $url = $_POST["url"];
    $ch = curl_init();
    $opts = array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_URL => $url,
        CURLOPT_NOBODY => TRUE,
        CURLOPT_TIMEOUT => 15,
    );
    curl_setopt_array($ch, $opts);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code == 200 || $code == 302) {
        $valid = TRUE;
    } else {
        $valid = FALSE;
        $_SESSION["url"] = $url;
        $_SESSION["invalid"] = TRUE;
    }
} else {
    $valid = FALSE;
}

if ($valid) {
    $db->updateBookmark($id, $_POST["name"], $_POST["url"]);
    header("Location: ../your_bookmarks.php");
} else {
    header("Location: ../edit.php?id=" . $id);
}
?>

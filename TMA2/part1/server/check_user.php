<?php
require("../classes/Database.php");

$db = Database::getDatabase();

if (isset($_POST["username"])) {
    var_export($db->userExists($_POST["username"]), FALSE);
} else {
    echo "true";
}
?>

<?php
require_once("../helper/database.php");
require_once("../helper/Authentication.php");

$_POST = json_decode(file_get_contents("php://input"), true);
$arr = array();

if ($_POST["type"] == "auth_user") {
    $conn = createConn();
    $auth = new Authentication($conn);
    $exist = $auth->userExists($_POST["username"]);
    $arr["exist"] = $exist;
}

echo json_encode($arr);
?>

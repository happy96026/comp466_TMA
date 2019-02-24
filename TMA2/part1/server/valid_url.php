<?php
$_POST = json_decode(file_get_contents("php://input"), true);
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
    }
} else {
    $valid = FALSE;
}

$arr = array("valid" => $valid);
echo json_encode($arr);
?>

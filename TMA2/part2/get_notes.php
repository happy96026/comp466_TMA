<?php
//$content = file_get_contents("notes/note3.json");
//$json = json_decode($content, true);
//unlink("testing.txt");
//for ($i = 0; $i < count($json["sections"]); $i++) {
    //$name = $json["sections"][$i]["topic"];
    //file_put_contents("testing.txt", "<name>" . $name . "</name>\n", FILE_APPEND);
    //for ($j = 0; $j < count($json["sections"][$i]["notes"]); $j++) {
        //$str = "<point>" . $json["sections"][$i]["notes"][$j] . "</point>\n";
        //file_put_contents("testing.txt", $str, FILE_APPEND);
    //}
    //file_put_contents("testing.txt", "\n", FILE_APPEND);
//}

$content = file_get_contents("quizzes/quiz3.json");
$json = json_decode($content, true);
unlink("testing.txt");

for ($i = 0; $i < count($json["questions"]); $i++) {
    file_put_contents("testing.txt", "<question-container>\n", FILE_APPEND);
    $question = $json["questions"][$i]["question"];
    $choices = $json["questions"][$i]["choices"];
    $answer = $json["questions"][$i]["answer"];
    file_put_contents("testing.txt", "\t<question>" . $question . "</question>\n", FILE_APPEND);
    $str = "\t<choices>\n";
    for ($j = 0; $j < count($choices); $j++) {
        $str = $str . "\t\t<choice>" . $choices[$j] . "</choice>\n";
    }
    $str = $str. "\t</choices>\n";
    file_put_contents("testing.txt", $str, FILE_APPEND);
    file_put_contents("testing.txt", "\t<answer>" . $answer . "</answer>\n", FILE_APPEND);
    file_put_contents("testing.txt", "</question-container>\n", FILE_APPEND);
    file_put_contents("testing.txt", "\n", FILE_APPEND);
}
?>

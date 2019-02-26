<?php
class Builder {
    public static function buildHTML($parsed) {
        if ($parsed["meta"]["type"] == "quiz") {
            return self::buildQuiz($parsed);
        }

        return self::buildUnit($parsed);
    }

    private static function buildUnit($parsed) {
        $name = $parsed["name"];
        $content = $parsed["content"];
        $arr = array();
        $prevElement = "";
        $index = -1;
        foreach ($content as $element) {
            $currElement = $element[0];
            $content = $element[1];
            if ($currElement == "para") {
                $str = "<p>$content</p>";
            } else {
                $str = "<li>$content</li>";
            }
            if ($prevElement != $currElement) {
                $prevElement = $currElement;
                $index++;
                array_push($arr, array($currElement, ""));
            }

            $tmpArr = $arr[$index];
            $tmpArr[1] = $tmpArr[1] . $str;
            $arr[$index] = $tmpArr;
        }

        $output = "";
        foreach ($arr as $subArr) {
            $str = $subArr[1];
            if ($subArr[0] == "para") {
                $output = "$output $str";
            } else {
                $output = "$output<ul>$str</ul>";
            }
        }
        
        $output = "
            <label class='label-header'>$name</label>
            <div class='border-box' id='notes'>
                $output
            </div>
        ";

        return $output;
    }

    private static function buildQuiz($parsed) {
        $name = $parsed["name"];
        $content = $parsed["content"];
        $questionIndex = 0;
        $choiceIndex = 0;
        $questionTag = "";
        foreach ($content as $questionContainer) {
            $question = $questionContainer["question"];
            $choices = $questionContainer["choices"];

            $labelTag = "<label>$question</label>";
            $choiceTag = "";
            $choiceNumber = 0;
            foreach ($choices as $choice) {
                $choiceTag = "$choiceTag
                    <div class='choice'>
                        <input 
                            id='choice$choiceIndex' 
                            type='radio' name='question$questionIndex' value='$choiceNumber'>
                        <label for='choice$choiceIndex'>$choice</label>
                    </div>
                ";
                $choiceIndex++;
                $choiceNumber++;
            }

            $questionTag = "$questionTag<div class='border-box quiz'>$labelTag $choiceTag</div>";
            $questionIndex++;
        }
        
        return "<script src='js/quiz.js'></script><label class='label-header'>$name</label>$questionTag";
    }

    public static function buildButton($parsed, $prevId, $nextId) {
        $prevButton = "";
        $nextButton = "";
        $checkButton = "";
        $hide = "";
        if ($parsed["meta"]["type"] == "quiz") {
            $hide = "style='display: none;'";
            $checkButton = "<button class='button' type='button' id='check'>Check</button>";
        }

        if ($prevId) {
            $prevButton = "<button class='button' id='prev' name='id' value='$prevId'>Prev</button>";
        }
        if ($nextId) {
            $nextButton = "<button class='button' id='next' name='id' value='$nextId' $hide>Next</button>";
        }

        return "$prevButton $nextButton $checkButton";
    }
}
?>

<?php

class Parser {
    
    public static function parse($content) {
        $pattern = "/\<lesson\>([\s\S]*)\<\/lesson\>/";
        preg_match($pattern, $content, $matches);

        if ($matches[1]) {
            $pattern = "/\<meta\>([\s\S]*)\<\/meta\>[\s]*\<name\>([\s\S]*)\<\/name\>[\s]*\<content\>([\s\S]*)\<\/content\>/";
            preg_match($pattern, $content, $matches);
            $metaStr = $matches[1];
            $name = $matches[2];
            $contentStr = $matches[3];
            if ($metaStr && isset($name) && $contentStr) {
                $meta = self::parseMeta($metaStr);
                if ($meta) {
                    if ($meta["type"] == "unit" || $meta["type"] == "topic") {
                        $content = self::parseUnit($contentStr);
                    } else {
                        $content = self::parseQuiz($contentStr);
                    }
                    if ($content) {
                        return array(
                            "meta" => $meta,
                            "name" => $name,
                            "content" => $content
                        );
                    }
                }
            }
        }

        return NULL;
    }

    private static function parseUnit($content) {
        $arr = array();

        $pattern = "/(\<point\>([\s\S]*?)\<\/point\>|\<para\>([\s\S]*?)\<\/para\>)/";
        preg_match_all($pattern, $content, $matches);
        for ($i = 0; $i < count($matches[0]); $i++) {
            if (strpos($matches[0][$i], "<point>") !== false) {
                array_push($arr, array("point", $matches[2][$i]));
            } else {
                array_push($arr, array("para", $matches[3][$i]));
            }
        }

        return $arr;
    }

    private static function parseQuiz($content) {
        $pattern = "/\<question-container\>([\s\S]*?)\<\/question-container\>/";
        preg_match_all($pattern, $content, $matches);
        $arr = array();
        foreach ($matches[1] as $match) {
            array_push($arr, self::parseQuestion($match));
        }

        return $arr;
    }

    private static function parseQuestion($question) {
        $pattern = "/\<question\>([\s\S]*)\<\/question\>[\s]*\<choices\>([\s\S]*)\<\/choices\>[\s]*\<answer\>([\s\S]*)\<\/answer\>/";
        preg_match($pattern, $question, $matches);
        $question = $matches[1];
        $choicesStr = $matches[2];
        $answer = (int) $matches[3];

        $choices = self::parseChoices($choicesStr);

        if (isset($question) && isset($choices) && isset($answer)) {
            return array(
                "question" => $question,
                "choices" => $choices,
                "answer" => $answer
            );
        }
        return NULL;
    }

    private static function parseChoices($choices) {
        $pattern = "/\<choice\>([\s\S]*?)\<\/choice\>/";
        preg_match_all($pattern, $choices, $matches);

        return $matches[1];
    }

    private static function parseMeta($meta) {
        $pattern = "/\<course\>([\s\S]*)\<\/course\>[\s]*\<tutor\>([\s\S]*)\<\/tutor\>[\s]*\<unit\>([\s\S]*)\<\/unit\>[\s]*\<order\>([\s\S]*)\<\/order\>[\s]*\<type\>([\s\S]*)\<\/type\>/";
        preg_match($pattern, $meta, $matches);
        if (isset($matches[1]) && isset($matches[2]) && isset($matches[3]) && isset($matches[4]) && isset($matches[5])) {
            return array(
                "course" => $matches[1],
                "tutor" => $matches[2],
                "unit" => (int) $matches[3],
                "order" => (int) $matches[4],
                "type" => $matches[5]
            );
        }
        return NULL;
    }
}
?>

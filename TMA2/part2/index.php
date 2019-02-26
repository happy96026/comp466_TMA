<!DOCTYPE html>
<?php
require_once("helper/CourseData.php");
require_once("helper/database.php");

session_start();

$conn = createConn();
$courseData = new CourseData($conn);
$categories = $courseData->getCategories();

$buttons = "";
foreach ($categories as $category) {
    $buttons = "$buttons<button class='category button' name='category' value='$category'>$category</button>";
}
?>

<html>
    <head>
        <title>Welcome to Learner 101</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
    </head>

    <body class="part2">
        <?php include_once("navbar.php") ?>
        <div class="content">
            <label class="label-header">Categories</label>
            <form id="category-container" action="courses.php">
                <?=$buttons;?>
            </form>
        </div>
    </body>
</html>

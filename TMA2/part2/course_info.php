<!DOCTYPE html>

<html>
    <head>
        <title>Courses</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
        <script src="js/course_info.js"></script>
    </head>

    <body class="part2">
        <?php include_once("navbar.php"); ?>
        <div class="content" id="course">
            <label class="label-header">Introduction to Web Design</label>
            <div class="section">
                <label class="label-header">About</label>
                <div class="border-box">
                    <div>
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
                    </div>
                </div>
            </div>
            <div class="section">
                <label class="label-header">Syllabus</label>
                <ul id="syllabus">
                    <li class="unit-container">
                        <button class="button unit">
                            <i class="arrow-up"></i>
                            Hi
                        </button>
                        <ul class="sub-unit-container">
                            <li class="button sub-unit">asdfasdf</li>
                            <li class="button sub-unit">asdfasdf</li>
                            <li class="button sub-unit">asdfasdf</li>
                            <li class="button sub-unit">asdfiwef</li>
                        </ul>
                    </li>
                    <li class="unit-container">
                        <button class="button unit">
                            <i class="arrow-up"></i>
                            Hello
                        </button>
                        <ul class="sub-unit-container">
                            <li class="button sub-unit">asdfasdf</li>
                            <li class="button sub-unit">asdfasdf</li>
                            <li class="button sub-unit">asdfasdf</li>
                            <li class="button sub-unit">asdfiwef</li>
                        </ul>
                    </li>
                </ul>
                </div>
                <form class="buttons" method="post" action="tutor.php">
                    <button id="register" class="button">Register</button>
                </form>
            </div>
    </body>
</html>

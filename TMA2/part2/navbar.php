<?php 
function getButton() {
    if (!isset($_SESSION["username"])) {
        $button = '<a class="nav-button id="login" href="login.php">Log in</a>';
    } else {
        $button = '<button class="nav-button" id="profile">Profile</button>
        <ul class="dropdown-content">
            <li class="border-box">
                <a class="nav-button" href="courses.php">Courses</a>
            </li>
            <li class="border-box">
                <a class="nav-button" href="server/logout.php">Log out</a>
            </li>
        </ul>';
    }

    return $button;
}

function getDropdown() {
    $noDropdownPages = array("login.php", "signup.php");
    if (in_array(basename($_SERVER["REQUEST_URI"]), $noDropdownPages)) {
        return "";
    } else {
        return '<div class="dropdown">' . getButton() . '</div>';
    }
}
?>

<nav class="border-box">
    <div>
        <a href="/part2" id="banner">Learner 101</a>
    </div>
    <div>
        <?=getDropdown();?>
    </div>
    <script src="js/navbar.js"></script>
</nav>

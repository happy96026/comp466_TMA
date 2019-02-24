<nav class="border-box">
    <div>
        <a href="/part1" id="banner">Bookmarker</a>
    </div>
    <div>
        <?=getDropdown();?>
    </div>
    <script src="js/navbar.js"></script>
</nav>

<?php 
function getButton() {
    if (!isset($_SESSION["username"])) {
        $button = '<a class="nav-button id="login" href="login.php">Log in</a>';
    } else {
        $button = '<button class="nav-button" id="profile">Profile</button>
        <ul class="dropdown-content">
            <li class="border-box">
                <a class="nav-button" href="your_bookmarks.php">Your bookmarks</a>
            </li>
            <li class="border-box">
                <a class="nav-button" href="logout.php">Log out</a>
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

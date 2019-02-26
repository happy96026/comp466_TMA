<?php
    session_start();
    $_SESSION["username"] = NULL;
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/part1");
?>

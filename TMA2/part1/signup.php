<!DOCTYPE html>

<html>
    <head>
        <title>Log in</title>
        <link rel="stylesheet" type="text/css" href="../shared/styles.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"
        ></script>
    </head>

    <body class="part1">
        <?php include_once("navbar.php") ?>
        <div class="login border-box">
            <div id="username">
                <label for="user">Username</label>
                <input type="text" id="user" name="username">
            </div>
            <div id="password">
                <label for="pass">Password (minimum length is 8)</label>
                <input type="password" id="pass" name="password" minlength="8" required>
            </div>
            <div id="confirm-password">
                <label for="confirm-pass">Confirm Password</label>
                <input type="password" id="confirm-pass" name="password" required>
            </div>
            <input type="submit" value="Sign up">
        </div>
    </body>
</html>

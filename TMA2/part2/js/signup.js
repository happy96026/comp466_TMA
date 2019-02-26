$(document).ready(function() {
    var username = document.getElementById("user");
    var password = document.getElementById("pass");
    var confirmPassword = document.getElementById("confirm-pass");

    username.addEventListener("input", function() {
        var asyncRequest = new XMLHttpRequest();
        asyncRequest.open("Post", "server/ajax_interface.php", true);
        asyncRequest.setRequestHeader("Content-Type", "application/json");
        asyncRequest.addEventListener(
            "readystatechange",
            function() {
                if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                    let json = JSON.parse(asyncRequest.responseText);
                    let exist = json["exist"];
                    if (exist) {
                        document.getElementsByClassName("error")[0].style.display = "block";
                    } else {
                        document.getElementsByClassName("error")[0].style.display = "none";
                    }
                }
            },
            false
        );

        if (this.value) {
            asyncRequest.send(JSON.stringify({ type: "auth_user", username: this.value }));
        } else {
            document.getElementsByClassName("error")[0].style.display = "none";
        }
    });

    password.addEventListener("input", function() {
        if (confirmPassword.value) {
            if (confirmPassword.value !== password.value) {
                document.getElementsByClassName("error")[1].style.display = "block";
            } else {
                document.getElementsByClassName("error")[1].style.display = "none";
            }
        } else {
            document.getElementsByClassName("error")[1].style.display = "none";
        }
    });

    confirmPassword.addEventListener("input", function() {
        if (confirmPassword.value) {
            if (confirmPassword.value !== password.value) {
                document.getElementsByClassName("error")[1].style.display = "block";
            } else {
                document.getElementsByClassName("error")[1].style.display = "none";
            }
        } else {
            document.getElementsByClassName("error")[1].style.display = "none";
        }
    });
});

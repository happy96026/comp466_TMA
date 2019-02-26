$(document).ready(function() {
    var url = document.getElementById("url");
    var form = document.getElementById("form");
    var validateTime = new Date();

    url.addEventListener("input", function() {
        var inputTime = new Date();
        var asyncRequest = new XMLHttpRequest();
        var urlString =
            url.value.includes("http://") || url.value.includes("https://")
                ? url.value
                : "http://" + url.value;
        asyncRequest.open("Post", "server/valid_url.php", true);
        asyncRequest.setRequestHeader("Content-Type", "application/json");
        asyncRequest.addEventListener(
            "readystatechange",
            function() {
                if (
                    asyncRequest.readyState == 4 &&
                    asyncRequest.status == 200 &&
                    inputTime > validateTime
                ) {
                    validateTime = inputTime;
                    var json = JSON.parse(asyncRequest.responseText);
                    if (json["valid"]) {
                        document.getElementsByClassName("error")[0].style.display = "none";
                    } else {
                        document.getElementsByClassName("error")[0].style.display = "block";
                    }
                }
            },
            false
        );
        if (url.value) {
            asyncRequest.send(JSON.stringify({ url: urlString }));
        } else {
            document.getElementsByClassName("error")[0].style.display = "none";
        }
    });

    form.onsubmit = function() {
        var urlString =
            url.value.includes("http://") || url.value.includes("https://")
                ? url.value
                : "http://" + url.value;
        url.value = urlString;
        return true;
    };
});

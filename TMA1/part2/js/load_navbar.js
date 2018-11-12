var currentScript = document.currentScript;

$(document).ready(function() {
    var navbarPath =
        currentScript.src
            .split("/")
            .slice(0, -1)
            .join("/") + "/../navbar.html";

    $(".navbar").load(navbarPath);
});

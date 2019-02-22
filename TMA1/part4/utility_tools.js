"use strict";

$(document).ready(function() {
    function loadJS(tool) {
        var asyncRequest = new XMLHttpRequest();
        asyncRequest.addEventListener(
            "readystatechange",
            function() {
                if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                    eval(asyncRequest.responseText);
                }
            },
            false
        );
        asyncRequest.open("Get", tool + "/" + tool + ".js", true);
        asyncRequest.send();
    }

    function loadHTML(tool) {
        var asyncRequest = new XMLHttpRequest();
        asyncRequest.addEventListener(
            "readystatechange",
            function() {
                if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                    document.getElementById("tool").innerHTML = asyncRequest.responseText;
                    loadJS(tool);
                }
            },
            false
        );
        asyncRequest.open("Get", tool + "/" + tool + ".html", true);
        asyncRequest.send();
    }

    var measurmentButton = document.getElementById("measurement-button");
    var mortgageButton = document.getElementById("mortgage-button");
    var bmiButton = document.getElementById("bmi-button");
    loadHTML("measurement_converter");
    measurmentButton.addEventListener("click", function() {
        loadHTML("measurement_converter");
        this.classList.add("active");
        mortgageButton.classList.remove("active");
        bmiButton.classList.remove("active");
    });
    mortgageButton.addEventListener("click", function() {
        loadHTML("mortgage_calculator");
        this.classList.add("active");
        bmiButton.classList.remove("active");
        measurmentButton.classList.remove("active");
    });
    bmiButton.addEventListener("click", function() {
        loadHTML("bmi_calculator");
        this.classList.add("active");
        mortgageButton.classList.remove("active");
        measurmentButton.classList.remove("active");
    });
});

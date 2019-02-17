"use strict";

var jsonData;
var index = 0;
var loaded = 0;
var prevIndex = null;
var random = false;
var play;
var duration = 4000;
var indices = [];

function mod(n, m) {
    return ((n % m) + m) % m;
}

function loadImage(i) {
    var image = jsonData[i];
    if (!image.object.complete) {
        image.object.onload = function() {
            displayImage(image);
        };
    } else {
        displayImage(image);
    }
}

function displayImage(image) {
    var canvas = document.getElementsByTagName("canvas")[0];
    var context = canvas.getContext("2d");

    var select = document.getElementsByTagName("select")[0];
    var transition = select.options[select.selectedIndex].value;

    var start;
    var length = 1000;
    context.clearRect(0, 0, canvas.width, canvas.height);

    if (transition == "fade") {
        var fade = function(ts) {
            if (!start) start = ts;
            var progress = ts - start;
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.globalAlpha = Math.min(Math.abs(1.0 - progress / (length / 2)), 1.0);
            if (progress < length / 2) {
                if (prevIndex != null) {
                    render(jsonData[prevIndex]);
                }
            } else {
                render(image);
            }
            if (progress < length) {
                requestAnimationFrame(fade);
            }
        };
        requestAnimationFrame(fade);
    } else {
        render(image);
    }
}

function render(image) {
    var canvas = document.getElementsByTagName("canvas")[0];
    var context = canvas.getContext("2d");
    var args = getDrawImageArgs(image.object);

    context.drawImage(image.object, args[0], args[1], args[2], args[3]);
    context.font = "15px Arial";
    context.textAlign = "center";
    context.fillText(image.caption, canvas.width / 2, canvas.height - 5);
}

function getDrawImageArgs(imageObj) {
    var canvas = document.getElementsByTagName("canvas")[0];
    var width = imageObj.width;
    var height = imageObj.height;
    var ratio, dx, dy;
    var captionHeight = 25;

    if (canvas.width / width < (canvas.height - captionHeight) / height) {
        // Width is larger than height
        ratio = canvas.width / width;
        width *= ratio;
        height *= ratio;
        dx = 0;
        dy = (canvas.height - height) / 2;
    } else {
        // Height is larger than width
        ratio = (canvas.height - captionHeight) / height;
        width *= ratio;
        height *= ratio;
        dx = (canvas.width - width) / 2;
        dy = 0;
    }

    return [dx, dy, width, height];
}

function generateRandomIndex() {
    if (indices.length == 0) {
        for (let i = 0; i < 20; i++) {
            indices.push(i);
        }
    }
    var rand = Math.floor(Math.random() * indices.length);
    var value = indices.splice(rand, 1)[0];
    return value;
}

function getNextIndex() {
    if (random) {
        prevIndex = index;
        return generateRandomIndex();
    } else {
        prevIndex = index++;
        return mod(index, jsonData.length);
    }
}

$(document).ready(function() {
    var asyncRequest = new XMLHttpRequest();
    asyncRequest.addEventListener(
        "readystatechange",
        function() {
            if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                var canvas = document.getElementsByTagName("canvas")[0];
                canvas.width = canvas.scrollWidth;
                canvas.height = canvas.scrollHeight;
                jsonData = JSON.parse(asyncRequest.responseText);
                for (let image of jsonData) {
                    let imageObj = new Image();
                    imageObj.src = "img/" + image.path;
                    imageObj.onload = function() {
                        loaded++;
                        if (loaded == jsonData.length) {
                            document.getElementById("loader").style.display = "none";
                            loadImage(index);
                            play = setInterval(function() {
                                index = getNextIndex();
                                loadImage(index);
                            }, duration);
                            let playButton = document.getElementById("play");
                            playButton.addEventListener("click", function() {
                                if (play) {
                                    this.childNodes[0].nodeValue = "Play";
                                    clearInterval(play);
                                    play = null;
                                } else {
                                    this.childNodes[0].nodeValue = "Stop";
                                    play = setInterval(function() {
                                        index = getNextIndex();
                                        loadImage(index);
                                    }, duration);
                                }
                            });
                            let prevButton = document.getElementById("prev");
                            prevButton.addEventListener("click", function() {
                                if (!random) {
                                    prevIndex = index--;
                                    index = mod(index, jsonData.length);
                                    loadImage(index);
                                }
                            });
                            let nextButton = document.getElementById("next");
                            nextButton.addEventListener("click", function() {
                                if (!random) {
                                    prevIndex = index++;
                                    index = mod(index, jsonData.length);
                                    loadImage(index);
                                }
                            });
                        }
                    };
                    image.object = imageObj;
                }
                let orderButton = document.getElementById("order");
                orderButton.addEventListener("click", function() {
                    var rightButtons = document.getElementsByClassName("right")[0];
                    if (random) {
                        this.childNodes[0].nodeValue = "Random";
                        rightButtons.classList.remove("disabled");
                        random = false;
                    } else {
                        this.childNodes[0].nodeValue = "Sequential";
                        rightButtons.classList.add("disabled");
                        random = true;
                    }
                });
            }
        },
        false
    );
    asyncRequest.open("Get", "images.json", true);
    asyncRequest.send();
});

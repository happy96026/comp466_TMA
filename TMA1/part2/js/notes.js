"use strict";

var currentScript = document.currentScript;

function createSection(section, sectionName) {
    var div = document.createElement("div");
    div.setAttribute("class", "category");

    var h1 = document.createElement("h1");
    h1.appendChild(document.createTextNode(sectionName));
    div.appendChild(h1);

    section.notes.forEach(function(note) {
        var p = document.createElement("p");
        p.appendChild(document.createTextNode(note));
        div.appendChild(p);
    });

    return div;
}

function loadNotes(asyncRequest) {
    if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
        var content = document.getElementsByClassName("content")[0];
        var firstLink = content.getElementsByTagName("a")[0];

        var notes = JSON.parse(asyncRequest.responseText);
        notes.sections.forEach(function(section) {
            var sectionName = notes.unit + "." + section.number + " " + section.topic;
            var div = createSection(section, sectionName);
            content.insertBefore(div, firstLink);
        });
    }
}

$(document).ready(function() {
    var asyncRequest = new XMLHttpRequest();
    asyncRequest.addEventListener(
        "readystatechange",
        function() {
            loadNotes(asyncRequest);
        },
        false
    );
    asyncRequest.open("Get", currentScript.getAttribute("path"), true);
    asyncRequest.send();
});

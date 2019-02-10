"use strict";

var searchParams = new URLSearchParams(window.location.search);
var unitSection = searchParams.get("section");
var unit = unitSection.split(".")[0];
var sectionNumber = unitSection.split(".")[1];

function createSection(section, sectionName) {
    var div = document.createElement("div");
    div.setAttribute("class", "category");

    var h1 = document.createElement("h1");
    h1.appendChild(document.createTextNode(sectionName));
    div.appendChild(h1);

    var ul = document.createElement("ul");
    div.appendChild(ul);
    section.notes.forEach(function(note) {
        var li = document.createElement("li");
        li.appendChild(document.createTextNode(note));
        ul.appendChild(li);
    });

    return div;
}

function loadSection(section) {
    var content = document.getElementsByClassName("content")[0];
    var form = content.children[0];
    var sectionName = unit + "." + section.number + " " + section.topic;
    document.title = sectionName;
    var div = createSection(section, sectionName);
    content.insertBefore(div, form);
}

$(document).ready(function() {
    var asyncRequest = new XMLHttpRequest();
    asyncRequest.addEventListener(
        "readystatechange",
        function() {
            if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                var notes = JSON.parse(asyncRequest.responseText);
                for (let section of notes.sections) {
                    if (section.number == sectionNumber) {
                        loadSection(section);
                        break;
                    }
                }
            }
        },
        false
    );
    asyncRequest.open("Get", "notes/note" + unit + ".json", true);
    asyncRequest.send();
});

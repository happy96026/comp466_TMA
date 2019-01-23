"use strict";

// Units must be hardcoded
var units = [1, 2, 3];

function loadSidebar(notes) {
    var form = document.getElementsByClassName("sidebar")[0].getElementsByTagName("form")[0];
    var input = form.getElementsByTagName("input")[0];
    var unitList = document.createElement("ul");
    for (let note of notes) {
        let unitItem = document.createElement("li");
        let unitHeader = document.createElement("h1");
        let sectionList = document.createElement("ul");
        for (let section of note.sections) {
            let sectionItem = document.createElement("li");
            sectionItem.appendChild(
                document.createTextNode(note.unit + "." + section.number + ". " + section.topic)
            );
            sectionItem.addEventListener("click", function() {
                input.setAttribute("value", note.unit + "." + section.number);
                form.submit();
            });
            sectionList.appendChild(sectionItem);
        }
        unitHeader.appendChild(document.createTextNode(note.unit + ". " + "Add Unit Name"));
        unitItem.appendChild(unitHeader);
        unitItem.appendChild(sectionList);
        unitList.appendChild(unitItem);
    }
    form.appendChild(unitList);
}

$(document).ready(function() {
    var notes = [];
    for (let unit of units) {
        let asyncRequest = new XMLHttpRequest();
        asyncRequest.addEventListener("readystatechange", function() {
            if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                var note = JSON.parse(asyncRequest.responseText);
                notes.push(note);
                if (notes.length == units.length) {
                    notes.sort(function(x, y) {
                        if (x.unit < y.unit) return -1;
                        if (x.unit > y.unit) return 1;
                        return 0;
                    });
                    loadSidebar(notes);
                }
            }
        });
        let path = "notes/note" + unit + ".json";
        asyncRequest.open("Get", path, true);
        asyncRequest.send();
    }
});

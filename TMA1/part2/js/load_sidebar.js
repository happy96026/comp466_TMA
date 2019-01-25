"use strict";

// Units must be hardcoded
var units = [1, 2, 3];
// Start and end links
var links = [
    {
        text: "Home",
        path: "/part2"
    },
    {
        text: "End",
        path: "/part2/end.html"
    }
];

function createLinkItemNode(link) {
    var linkNode = document.createElement("a");
    linkNode.setAttribute("href", link.path);
    linkNode.appendChild(document.createTextNode(link.text));

    var itemNode = document.createElement("li");
    itemNode.appendChild(linkNode);

    return itemNode;
}

function loadSidebar(notes) {
    var form = document.getElementsByClassName("sidebar")[0].firstElementChild;
    var input = form.getElementsByTagName("input")[0];
    var navList = document.createElement("ul");
    navList.appendChild(createLinkItemNode(links[0]));

    for (let note of notes) {
        let unitItem = document.createElement("li");
        let unitHeader = document.createElement("h1");
        let sectionList = document.createElement("ul");

        sectionList.style.display = "none";
        unitHeader.addEventListener("click", function() {
            this.classList.toggle("active");
            if (sectionList.style.display === "block") {
                sectionList.style.display = "none";
            } else {
                sectionList.style.display = "block";
            }
        });

        for (let section of note.sections) {
            let sectionItem = document.createElement("li");
            sectionItem.setAttribute("section", note.unit + "." + section.number);
            sectionItem.appendChild(
                document.createTextNode(note.unit + "." + section.number + ". " + section.topic)
            );
            sectionItem.addEventListener("click", function() {
                input.setAttribute("value", note.unit + "." + section.number);
                form.submit();
            });
            sectionList.appendChild(sectionItem);
        }

        unitHeader.appendChild(document.createTextNode(note.unit + ". " + note.title));
        unitItem.appendChild(unitHeader);
        unitItem.appendChild(sectionList);
        navList.appendChild(unitItem);
    }

    navList.appendChild(createLinkItemNode(links[1]));
    form.appendChild(navList);
}

function highlightCurrentNodes() {
    var navList = document.getElementsByClassName("sidebar")[0].firstElementChild.lastElementChild;
    var pathArr = window.location.pathname.split("/");
    var currentFile = pathArr[pathArr.length - 1];
    var childNodes = navList.childNodes;

    if (currentFile === "" || currentFile === "index.html") {
        let item = childNodes[0];
        item.classList.add("current");
    } else if (currentFile === "notes.html") {
        const urlParams = new URLSearchParams(window.location.search);
        let section = urlParams.get("section");
        let sectionItem = navList.querySelector("li[section='" + section + "']");
        sectionItem.classList.add("current");

        let unitItem = sectionItem.parentNode.parentNode;
        unitItem.classList.add("current");

        var event = new Event("click");
        unitItem.firstElementChild.dispatchEvent(event);
    } else if (currentFile === "end.html") {
        let item = childNodes[childNodes.length - 1];
        item.classList.add("current");
    }
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
                    highlightCurrentNodes();
                }
            }
        });
        let path = "notes/note" + unit + ".json";
        asyncRequest.open("Get", path, true);
        asyncRequest.send();
    }
});

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
var itemIndex = -1;

function createLinkItemNode(link) {
    var linkNode = document.createElement("a");
    linkNode.classList.add("title-container");
    linkNode.setAttribute("href", link.path);
    linkNode.appendChild(document.createTextNode(link.text));

    var itemNode = document.createElement("li");
    itemNode.appendChild(linkNode);

    return itemNode;
}

function createQuizItem(unitNumber) {
    var p = document.createElement("p");
    p.appendChild(document.createTextNode("Unit " + unitNumber + " Quiz"));

    var sectionItem = document.createElement("li");
    sectionItem.appendChild(p);
    sectionItem.setAttribute("quiz", unitNumber);
    sectionItem.setAttribute("index", ++itemIndex);

    return sectionItem;
}

function loadSidebar(notes) {
    var form = document.getElementsByClassName("sidebar")[0].firstElementChild;
    var input = form.getElementsByTagName("input")[0];
    var navList = document.createElement("ul");
    navList.appendChild(createLinkItemNode(links[0]));

    for (let note of notes) {
        let unitItem = document.createElement("li");
        let titleContainer = document.createElement("div");
        titleContainer.classList.add("title-container");
        let unitHeader = document.createElement("h1");
        let arrow = document.createElement("i");
        let sectionList = document.createElement("ul");

        sectionList.classList.add("section");
        sectionList.style.display = "none";
        titleContainer.addEventListener("click", function() {
            this.classList.toggle("active");
            if (sectionList.style.display === "block") {
                sectionList.style.display = "none";
            } else {
                sectionList.style.display = "block";
            }
        });

        for (let section of note.sections) {
            let p = document.createElement("p");
            p.appendChild(
                document.createTextNode(note.unit + "." + section.number + ". " + section.topic)
            );

            let sectionItem = document.createElement("li");
            sectionItem.setAttribute("section", note.unit + "." + section.number);
            sectionItem.setAttribute("index", ++itemIndex);
            sectionItem.appendChild(p);
            sectionItem.addEventListener("click", function() {
                input.setAttribute("name", "section");
                input.setAttribute("value", note.unit + "." + section.number);
                input.parentElement.setAttribute("action", "notes.html");
                form.submit();
            });
            sectionList.appendChild(sectionItem);
        }

        let quizItem = createQuizItem(note.unit);
        sectionList.appendChild(quizItem);
        quizItem.addEventListener("click", function() {
            input.setAttribute("name", "quiz");
            input.setAttribute("value", note.unit);
            input.parentElement.setAttribute("action", "quiz.html");
            form.submit();
        });

        unitHeader.appendChild(document.createTextNode(note.unit + ". " + note.title));
        titleContainer.appendChild(unitHeader);
        titleContainer.appendChild(arrow);
        unitItem.appendChild(titleContainer);
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

    if (currentFile == "" || currentFile == "index.html") {
        let item = childNodes[0];
        item.childNodes[0].classList.add("current");
    } else if (currentFile == "notes.html" || currentFile == "quiz.html") {
        let key = currentFile == "notes.html" ? "section" : "quiz";
        const urlParams = new URLSearchParams(window.location.search);
        let value = urlParams.get(key);
        let sectionItem = navList.querySelector("li[" + key + "='" + value + "']");
        sectionItem.classList.add("current");

        let unitItem = sectionItem.parentNode.parentNode;
        unitItem.childNodes[0].classList.add("current");

        var event = new Event("click");
        unitItem.firstElementChild.dispatchEvent(event);
    } else if (currentFile == "end.html") {
        let item = childNodes[childNodes.length - 1];
        item.childNodes[0].classList.add("current");
    }
}

function getActionNameValue(index) {
    var action, name, value;

    if (index == -1) {
        action = "/part2";
        name = value = "";
    } else if (index == itemIndex + 1) {
        action = "end.html";
        name = value = "";
    } else {
        let li = document.querySelector("li[index='" + index + "']");
        if (li.hasAttribute("section")) {
            action = "notes.html";
            name = "section";
            value = li.getAttribute("section");
        } else {
            action = "quiz.html";
            name = "quiz";
            value = li.getAttribute("quiz");
        }
    }

    return [action, name, value];
}

function linkButtons() {
    var buttons = document.getElementsByClassName("buttons")[0];
    var submits = buttons.querySelectorAll("input[type='submit']");
    var form = buttons.parentElement;
    var hidden = form.children[0];

    var pathArr = window.location.pathname.split("/");
    var currentFile = pathArr[pathArr.length - 1];
    var current = document.getElementsByClassName("current")[1];
    if (currentFile == "notes.html" || currentFile == "quiz.html") {
        let index = parseInt(current.getAttribute("index"));
        let prev = getActionNameValue(index - 1);
        let next = getActionNameValue(index + 1);

        submits[0].addEventListener("click", function() {
            form.setAttribute("action", prev[0]);
            hidden.setAttribute("name", prev[1]);
            hidden.setAttribute("value", prev[2]);
        });
        submits[1].addEventListener("click", function() {
            form.setAttribute("action", next[0]);
            hidden.setAttribute("name", next[1]);
            hidden.setAttribute("value", next[2]);
        });
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
                    linkButtons();
                }
            }
        });
        let path = "notes/note" + unit + ".json";
        asyncRequest.open("Get", path, true);
        asyncRequest.send();
    }
});

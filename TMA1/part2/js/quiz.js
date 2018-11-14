"use strict";

var currentScript = document.currentScript;
var choiceID = 0;

// https://stackoverflow.com/questions/610406/javascript-equivalent-to-printf-string-format
if (!String.prototype.format) {
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != "undefined" ? args[number] : match;
        });
    };
}

function createQuestion(question, index) {
    var questionDiv = document.createElement("div");
    questionDiv.setAttribute("class", "question");

    var questionP = document.createElement("p");
    questionP.appendChild(document.createTextNode(index + 1 + ". " + question.question));

    questionDiv.appendChild(questionP);

    question.choices.forEach(function(choice) {
        var input = document.createElement("input");
        input.setAttribute("type", "radio");
        input.setAttribute("name", "question" + index);
        input.setAttribute("id", "choice" + choiceID);
        input.setAttribute("value", choice.toLowerCase());
        choiceID++;

        var label = document.createElement("label");
        label.setAttribute("for", input.id);
        label.appendChild(document.createTextNode(choice));

        questionDiv.appendChild(input);
        questionDiv.appendChild(label);
    });

    return questionDiv;
}

function checkQuiz(form, questions) {
    var questionDivs = Array.from(form.getElementsByClassName("question"));
    var noCorrect = 0;
    var noQuestions = questions.length;
    for (let [i, div] of questionDivs.entries()) {
        var checkMarks = div.querySelectorAll(".checkmark, .xmark");
        checkMarks.forEach(function(checkMark) {
            checkMark.remove();
        });
        var correctChoice = div.getElementsByTagName("input")[questions[i].answer];
        var choice = div.querySelector("input:checked");

        var checkMark = document.createElement("p");
        checkMark.setAttribute("class", "checkmark");
        checkMark.appendChild(document.createTextNode("\u2714"));
        correctChoice.nextSibling.after(checkMark);

        if (choice == correctChoice) {
            div.setAttribute("class", "correct");
            noCorrect++;
        } else {
            div.setAttribute("class", "incorrect");
            if (choice != null) {
                var xMark = document.createElement("p");
                xMark.setAttribute("class", "xmark");
                xMark.appendChild(document.createTextNode("\u2718"));
                choice.nextSibling.after(xMark);
            }
        }
    }

    var result = document.getElementById("result");
    while (result.hasChildNodes()) {
        result.removeChild(result.lastChild);
    }
    var percentage = (noCorrect / noQuestions) * 100;
    var resultText = "You have gotten {0} out of {1} question right ({2}%).".format(
        noCorrect,
        noQuestions,
        Number.isInteger(percentage) ? percentage : percentage.toFixed(1)
    );
    result.appendChild(document.createTextNode(resultText));
}

function loadQuiz(asyncRequest) {
    if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
        var form = document.getElementsByTagName("form")[0];
        var checkButton = form.getElementsByTagName("input")[0];

        var questions = JSON.parse(asyncRequest.responseText).questions;
        for (let [i, question] of questions.entries()) {
            var div = createQuestion(question, i);
            form.insertBefore(div, checkButton);
        }

        checkButton.addEventListener(
            "click",
            function() {
                checkQuiz(form, questions);
            },
            false
        );
    }
}

$(document).ready(function() {
    var asyncRequest = new XMLHttpRequest();
    asyncRequest.addEventListener(
        "readystatechange",
        function() {
            loadQuiz(asyncRequest);
        },
        false
    );
    asyncRequest.open("Get", currentScript.getAttribute("path"), true);
    asyncRequest.send();
});

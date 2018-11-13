"use strict";

var currentScript = document.currentScript;

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

    for (let [i, choice] of question.choices.entries()) {
        var input = document.createElement("input");
        input.setAttribute("type", "radio");
        input.setAttribute("name", "question" + index);
        input.setAttribute("id", "choice" + i);
        input.setAttribute("value", choice.toLowerCase());

        var label = document.createElement("label");
        label.setAttribute("for", input.id);
        label.appendChild(document.createTextNode(choice));

        questionDiv.appendChild(input);
        questionDiv.appendChild(label);
    }

    return questionDiv;
}

function checkQuiz(form, questions) {
    var questionDivs = Array.from(form.getElementsByClassName("question"));
    var noCorrect = 0;
    var noQuestions = questions.length;
    for (let [i, div] of questionDivs.entries()) {
        var choice = div.querySelector("[value='" + questions[i].answer.toLowerCase() + "']");
        if (choice.checked) {
            noCorrect++;
        }
    }

    var result = document.getElementById("result");
    while (result.hasChildNodes()) {
        result.removeChild(result.lastChild);
    }
    var resultText = "You have gotten {0} out of {1} question right ({2}%).".format(
        noCorrect,
        noQuestions,
        (noCorrect / noQuestions) * 100
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

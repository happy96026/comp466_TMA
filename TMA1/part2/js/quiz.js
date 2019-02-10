"use strict";

var searchParams = new URLSearchParams(window.location.search);
var quiz = searchParams.get("quiz");
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
    questionDiv.classList.add("category");

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

        let choiceDiv = document.createElement("div");
        choiceDiv.appendChild(input);
        choiceDiv.appendChild(label);
        questionDiv.appendChild(choiceDiv);
    });

    return questionDiv;
}

function checkQuiz(content, questions) {
    var questionDivs = Array.from(content.getElementsByClassName("question"));
    var noCorrect = 0;
    var noQuestions = questions.length;
    for (let [i, div] of questionDivs.entries()) {
        var correctChoice = div.getElementsByTagName("input")[questions[i].answer];
        var choice = div.querySelector("input:checked");

        var checkMark = document.createElement("p");
        checkMark.classList.add("mark");
        checkMark.appendChild(document.createTextNode("\u2714"));
        correctChoice.parentElement.appendChild(checkMark);

        if (choice == correctChoice) {
            div.classList.add("correct");
            noCorrect++;
        } else {
            div.classList.add("incorrect");
            if (choice != null) {
                var xMark = document.createElement("p");
                xMark.classList.add("mark");
                xMark.appendChild(document.createTextNode("\u2718"));
                choice.nextSibling.after(xMark);
            }
        }
    }

    var result = document.getElementById("result");
    result.style.display = "block";
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
        var content = document.getElementsByClassName("content")[0];
        var title = "Unit " + quiz + " Quiz";
        content.children[0].appendChild(document.createTextNode(title));
        document.title = title;
        var result = content.children[1];

        var questions = JSON.parse(asyncRequest.responseText).questions;
        for (let [i, question] of questions.entries()) {
            var div = createQuestion(question, i);
            content.insertBefore(div, result);
        }

        var checkButton = document.getElementsByTagName("button")[0];
        checkButton.addEventListener(
            "click",
            function() {
                checkQuiz(content, questions);
                var buttons = document.getElementsByClassName("buttons")[0];
                buttons.children[1].style.display = "inline-block";
                buttons.removeChild(buttons.children[2]);
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
    asyncRequest.open("Get", "quizzes/quiz" + quiz + ".json", true);
    asyncRequest.send();
});

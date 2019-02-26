"use strict";

$(document).ready(function() {
    function checkQuiz() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "server/ajax_interface.php");
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.addEventListener("readystatechange", function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var json = JSON.parse(xhr.responseText);
                var questions = document.getElementsByClassName("quiz");
                var correct = 0;
                for (let i = 0; i < questions.length; i++) {
                    let question = questions[i];
                    let checked = document.querySelector("input[name='question" + i + "']:checked");
                    if (checked) {
                        let label = checked.parentElement.getElementsByTagName("label")[0];
                        let mark = document.createElement("div");
                        mark.classList.add("mark");

                        if (checked.value == json[i]) {
                            question.classList.add("correct");
                            mark.appendChild(document.createTextNode("\u2714"));
                            correct++;
                        } else {
                            question.classList.add("incorrect");
                            mark.appendChild(document.createTextNode("\u2718"));
                        }
                        label.appendChild(mark);
                    } else {
                        question.classList.add("incorrect");
                    }
                }

                let content = document.getElementsByClassName("content")[0];
                let button = document.getElementById("buttons");
                let result = document.createElement("div");
                result.classList.add("border-box");
                result.appendChild(
                    document.createTextNode(
                        "You have gotten " + correct + " out of " + questions.length + "right."
                    )
                );
                content.insertBefore(result, button);

                var checkButton = document.getElementById("check");
                checkButton.style.display = "none";

                var nextButton = document.getElementById("next");
                nextButton.style.display = "block";
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const lessonId = urlParams.get("id");
        xhr.send(JSON.stringify({ type: "check_quiz", lesson_id: lessonId }));
    }

    var checkButton = document.getElementById("check");
    checkButton.addEventListener("click", function() {
        checkQuiz();
    });
});

$(document).ready(function() {
    var unitContainers = document.getElementsByClassName("unit-container");
    for (let unitContainer of unitContainers) {
        let button = unitContainer.getElementsByTagName("button")[0];
        let ul = unitContainer.getElementsByTagName("ul")[0];
        let arrow = button.getElementsByClassName("arrow-up")[0];

        button.addEventListener("click", function() {
            ul.classList.toggle("active");
            arrow.classList.toggle("active");
        });
    }
});

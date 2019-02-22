"use strict";

$(document).ready(function() {
    var profile = document.getElementById("profile");
    if (profile) {
        let dropdownContent = document.getElementsByClassName("dropdown-content")[0];
        profile.addEventListener("click", function() {
            dropdownContent.classList.toggle("active");
        });
    }
});

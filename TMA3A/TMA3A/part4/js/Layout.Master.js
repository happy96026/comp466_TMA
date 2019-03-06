"use strict";

function toggleDropDownContent(content) {
	var dropDownContentList = document.getElementsByClassName("dropdown-content");
	for (let dropDownContent of dropDownContentList) {
		if (dropDownContent !== content) {
			dropDownContent.classList.remove("active");
		} else {
			dropDownContent.classList.toggle("active");
		}
	}
}

$(document).ready(function () {
	//var dropDownList = document.getElementsByClassName("dropdown");

	//for (let dropDown of dropDownList) {
	//	let button = dropDown.getElementsByClassName("nav-button")[0];
	//	let content = dropDown.getElementsByClassName("dropdown-content")[0];
	//	button.addEventListener("click", function (e) {
	//		toggleDropDownContent(content);
	//		e.stopPropagation();
	//	})
	//}

	//document.addEventListener("click", function () {
	//	var dropDownContentList = document.getElementsByClassName("dropdown-content");
	//	for (let dropDownContent of dropDownContentList) {
	//		dropDownContent.classList.remove("active");
	//	}
	//})
});
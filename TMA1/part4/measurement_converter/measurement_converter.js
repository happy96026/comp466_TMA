"use strict";

$(document).ready(function() {
    var conversion;

    function convert(type, unit1, unit2, value) {
        var converter = conversion[type];
        if (isNaN(value) || value == "") {
            return "";
        }

        if (converter.hasOwnProperty([unit1, unit2])) {
            value = value * converter[[unit1, unit2]];
        } else if (converter.hasOwnProperty([unit2, unit1])) {
            value = value / converter[[unit2, unit1]];
        }
        return +parseFloat(value).toFixed(4);
    }

    function loadConverter(type) {
        var inputs = document.getElementsByClassName("input");
        var inputLeft = inputs[0].getElementsByTagName("input")[0];
        var inputRight = inputs[1].getElementsByTagName("input")[0];
        var selectLeft = inputs[0].getElementsByTagName("select")[0];
        var selectRight = inputs[1].getElementsByTagName("select")[0];
        inputLeft.value = "";
        inputRight.value = "";

        var selects = [selectLeft, selectRight];
        for (let select of selects) {
            while (select.firstChild) {
                select.removeChild(select.firstChild);
            }
            for (let unit of conversion[type]["units"]) {
                let option = document.createElement("option");
                option.setAttribute("value", unit);
                option.appendChild(document.createTextNode(unit));
                select.appendChild(option);
            }
        }
        inputLeft.oninput = function() {
            inputRight.value = convert(type, selectLeft.value, selectRight.value, inputLeft.value);
        };
        inputRight.oninput = function() {
            inputLeft.value = convert(type, selectRight.value, selectLeft.value, inputRight.value);
        };
        selectLeft.onchange = function() {
            inputRight.value = convert(type, selectLeft.value, selectRight.value, inputLeft.value);
        };
        selectRight.onchange = function() {
            inputLeft.value = convert(type, selectRight.value, selectLeft.value, inputRight.value);
        };
    }

    var asyncRequest = new XMLHttpRequest();
    asyncRequest.addEventListener("readystatechange", function() {
        if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
            conversion = JSON.parse(asyncRequest.responseText);
            for (let type in conversion) {
                let units = new Set();
                for (let unitPair in conversion[type]) {
                    for (let unit of unitPair.split(",")) {
                        units.add(unit);
                    }
                }
                conversion[type]["units"] = units;
            }
            loadConverter("weight");
            document
                .getElementsByClassName("container")[0]
                .children[0].addEventListener("change", function() {
                    loadConverter(this.value);
                });
        }
    });
    asyncRequest.open("Get", "measurement_converter/conversion.json", true);
    asyncRequest.send();
});

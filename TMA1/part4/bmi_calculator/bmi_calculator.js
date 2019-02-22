"use strict";

$(document).ready(function() {
    function categorize(bmi) {
        if (bmi < 18.5) {
            return ["underweight", "Underweight"];
        } else if (bmi < 25) {
            return ["normalweight", "Normal Weight"];
        } else if (bmi < 30) {
            return ["overweight", "Overweight"];
        }
        return ["obesity", "Obesity"];
    }

    function calcBmiMetric(cm, kg) {
        var status = document.getElementById("status");
        var bmiValue = document.getElementById("bmi-value");
        cm = parseFloat(cm);
        kg = parseFloat(kg);

        if (!isNaN(cm) && cm && !isNaN(kg) && kg) {
            var bmi = kg / Math.pow(cm / 100, 2);
            bmi = +parseFloat(bmi).toFixed(1);
            bmiValue.innerHTML = "";
            bmiValue.appendChild(document.createTextNode(bmi));

            var category = categorize(bmi);
            status.innerHTML = "";
            status.appendChild(document.createTextNode(category[1]));

            bmiValue.className = "";
            status.className = "";
            bmiValue.classList.add(category[0]);
            status.classList.add(category[0]);
        } else {
            bmiValue.innerHTML = "";
            status.innerHTML = "";
        }
    }

    function calcBmiImperial(ft, inches, lbs) {
        var status = document.getElementById("status");
        var bmiValue = document.getElementById("bmi-value");
        ft = parseInt(ft);
        inches = parseInt(inches);
        lbs = parseFloat(lbs);

        if (!isNaN(ft) && ft && !isNaN(inches) && inches && !isNaN(lbs) && lbs) {
            var bmi = (lbs / Math.pow(ft * 12 + inches, 2)) * 703;
            bmi = +parseFloat(bmi).toFixed(1);
            bmiValue.innerHTML = "";
            bmiValue.appendChild(document.createTextNode(bmi));

            var category = categorize(bmi);
            status.innerHTML = "";
            status.appendChild(document.createTextNode(category[1]));

            bmiValue.className = "";
            status.className = "";
            bmiValue.classList.add(category[0]);
            status.classList.add(category[0]);
        } else {
            bmiValue.innerHTML = "";
            status.innerHTML = "";
        }
    }

    var metricButton = document.getElementById("metric-button");
    var metricDiv = document.getElementById("metric");
    var imperialButton = document.getElementById("imperial-button");
    var imperialDiv = document.getElementById("imperial");

    var cmInput = document.getElementById("cm");
    var kgInput = document.getElementById("kg");
    var ftInput = document.getElementById("ft");
    var inInput = document.getElementById("in");
    var lbsInput = document.getElementById("lbs");

    metricButton.addEventListener("click", function() {
        metricDiv.style.display = "block";
        imperialDiv.style.display = "none";

        this.classList.add("active");
        imperialButton.classList.remove("active");

        calcBmiMetric(cmInput.value, kgInput.value);
    });

    imperialButton.addEventListener("click", function() {
        metricDiv.style.display = "none";
        imperialDiv.style.display = "block";

        this.classList.add("active");
        metricButton.classList.remove("active");

        calcBmiImperial(ftInput.value, inInput.value, lbsInput.value);
    });

    cmInput.addEventListener("input", function() {
        calcBmiMetric(this.value, kgInput.value);
    });
    kgInput.addEventListener("input", function() {
        calcBmiMetric(cmInput.value, this.value);
    });
    ftInput.addEventListener("input", function() {
        calcBmiImperial(this.value, inInput.value, lbsInput.value);
        if (this.value.indexOf(".") > -1) {
            this.value = this.value.split(".")[0];
        }
    });
    inInput.addEventListener("input", function() {
        calcBmiImperial(ftInput.value, this.value, lbsInput.value);
        if (this.value.indexOf(".") > -1) {
            this.value = this.value.split(".")[0];
        }
    });
    lbsInput.addEventListener("input", function() {
        calcBmiImperial(ftInput.value, inInput.value, this.value);
    });
});

$(document).ready(function() {
    function calcPayment(principal, interest, number) {
        return (
            (principal * interest * Math.pow(1 + interest, number)) /
            (Math.pow(1 + interest, number) - 1)
        );
    }

    function calcRegular(principal, yearlyInterest, frequency, years) {
        var payment = calcPayment(principal, yearlyInterest / frequency, years * frequency);
        var totalPayment = payment * frequency * years;
        var totalInterest = totalPayment - principal;
        return [payment, totalPayment, totalInterest];
    }

    function calcAccelerated(principal, yearlyInterest, frequency, years) {
        var monthlyPayment = calcPayment(principal, yearlyInterest / 12, years * 12);
        var payment = monthlyPayment * (13 / frequency);
        var total = principal;
        var totalPayment = 0;

        while (total > 0) {
            total = total * (1 + yearlyInterest / frequency);
            if (total > monthlyPayment) {
                totalPayment += payment;
            } else {
                totalPayment += total;
            }
            total -= payment;
        }

        var totalInterest = totalPayment - principal;

        return [payment, totalPayment, totalInterest];
    }

    var principal = document.getElementById("principal");
    var interest = document.getElementById("interest");
    var amortization = document.getElementById("amortization");
    var frequency = document.getElementById("frequency");

    principal.addEventListener("change", function() {
        if (this.value < 0) {
            this.value = 0;
        }
        this.value = parseFloat(this.value).toFixed(2);
    });

    interest.addEventListener("change", function() {
        if (this.value < 0) {
            this.value = 0;
        }
        this.value = +parseFloat(this.value).toFixed(2);
    });

    var calculate = document.getElementById("calculate");
    var result = document.getElementById("result");
    calculate.addEventListener("click", function() {
        if (principal.value && interest.value && amortization.value && frequency.value) {
            var paymentResult;
            var principalValue = parseFloat(principal.value);
            var interestValue = parseFloat(interest.value) / 100;
            var amortizationValue = parseInt(amortization.value);
            switch (frequency.value) {
                case "monthly":
                    paymentResult = calcRegular(
                        principalValue,
                        interestValue,
                        12,
                        amortizationValue
                    );
                    break;
                case "semi-monthly":
                    paymentResult = calcRegular(
                        principalValue,
                        interestValue,
                        24,
                        amortizationValue
                    );
                    break;
                case "bi-weekly":
                    paymentResult = calcRegular(
                        principalValue,
                        interestValue,
                        26,
                        amortizationValue
                    );
                    break;
                case "weekly":
                    paymentResult = calcRegular(
                        principalValue,
                        interestValue,
                        52,
                        amortizationValue
                    );
                    break;
                case "bi-weekly-accelerated":
                    paymentResult = calcAccelerated(
                        principalValue,
                        interestValue,
                        26,
                        amortizationValue
                    );
                    break;
                case "weekly-accelerated":
                    paymentResult = calcAccelerated(
                        principalValue,
                        interestValue,
                        52,
                        amortizationValue
                    );
                    break;
            }
            result.innerHTML = "";
            result.appendChild(
                document.createTextNode(
                    "Mortgage payment is $" + parseFloat(paymentResult[0]).toFixed(2) + "."
                )
            );
            result.appendChild(document.createElement("br"));
            result.appendChild(
                document.createTextNode(
                    "Total payment is $" + parseFloat(paymentResult[1]).toFixed(2) + "."
                )
            );
            result.appendChild(document.createElement("br"));
            result.appendChild(
                document.createTextNode(
                    "Total interest payment is $" + parseFloat(paymentResult[2]).toFixed(2) + "."
                )
            );
            result.style.display = "block";
        }
    });
});

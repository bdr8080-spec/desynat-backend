// Toggle password visibility
document.querySelectorAll(".toggle-password").forEach((toggle) => {
    toggle.addEventListener("click", function () {
        const input = this.parentElement.querySelector("input");
        const isPassword = input.getAttribute("type") === "password";

        input.setAttribute("type", isPassword ? "text" : "password");

        // Toggle icon
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});

document.querySelectorAll(".toggle-password").forEach((toggle) => {
    toggle.addEventListener("click", function () {
        const input = this.parentElement.querySelector("input");
        const isPassword = input.getAttribute("type") === "password";

        // Toggle between text/password
        input.setAttribute("type", isPassword ? "text" : "password");

        // Toggle the icon style
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});

// otp input
const inputs = document.querySelectorAll(".otp-input");
inputs.forEach((input, index) => {
    input.addEventListener("input", (e) => {
        const value = e.target.value;
        // Allow only digits
        if (!/^[0-9]$/.test(value)) {
            e.target.value = "";
            return;
        }
        // Move to next input
        if (value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !e.target.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

// tel-input

$(".tel-input").intlTelInput({
    initialCountry: "auto",
    nationalMode: false,
    formatOnDisplay: true,
    separateDialCode: false,
    preferredCountries: [],
    geoIpLookup: (cb) => {
        $.get("https://ipinfo.io", () => {}, "jsonp").always((resp) =>
            cb(resp?.country || "")
        );
    },
    utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/utils.js",
});

function resetIntlTelInput() {
    if (typeof intlTelInputUtils === "undefined") return;
    const currentText = telInput.intlTelInput(
        "getNumber",
        intlTelInputUtils.numberFormat.E164
    );
    if (typeof currentText === "string")
        telInput.intlTelInput("setNumber", currentText);
}

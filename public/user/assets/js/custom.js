// Toggle password visibility
document.querySelectorAll(".toggle-passwordone").forEach((toggle) => {
    toggle.addEventListener("click", function () {
        const input = this.parentElement.querySelector("input");
        const isPassword = input.getAttribute("type") === "password";

        input.setAttribute("type", isPassword ? "text" : "password");

        // Toggle icon
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});

document.querySelectorAll(".toggle-passwordtwo").forEach((toggle) => {
    toggle.addEventListener("click", function () {
        const input = this.parentElement.querySelector("input");
        const isPassword = input.type === "password";

        // Toggle between text/password
        input.type = isPassword ? "text" : "password";

        // Toggle icon classes
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

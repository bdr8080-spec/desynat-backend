// Toggle password visibility
document.querySelectorAll('.toggle-passwordone').forEach(toggle => {
    toggle.addEventListener('click', function () {
    const input = this.parentElement.querySelector('input');
    const isPassword = input.getAttribute('type') === 'password';

    input.setAttribute('type', isPassword ? 'text' : 'password');

    // Toggle icon
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
    });
});

document.querySelectorAll('.toggle-password').forEach(toggle => {
  toggle.addEventListener('click', function () {
    const input = this.parentElement.querySelector('input');
    const isPassword = input.type === 'password';

    // Toggle between text/password
    input.type = isPassword ? 'text' : 'password';

    // Toggle icon classes
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
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

$(document).ready(function () {
  const telInput = $(".tel-input");

  telInput.intlTelInput({
    initialCountry: "auto",
    nationalMode: false,
    formatOnDisplay: true,
    separateDialCode: false,
    preferredCountries: [],
    geoIpLookup: function (callback) {
      $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
        const countryCode = (resp && resp.country) ? resp.country : "";
        callback(countryCode);
      });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
  });

  // Reset function
  function resetIntlTelInput() {
    if (typeof intlTelInputUtils === "undefined") return;
    const currentText = telInput.intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
    if (typeof currentText === "string") {
      telInput.intlTelInput("setNumber", currentText);
    }
  }

  // Optional: run it once on load
  resetIntlTelInput();
});

// tel-input end



// country js
$(document).ready(function() {
    $('.dropdown-item').on('click', function() {
      const countryName = $(this).data('country');
      const countryFlag = $(this).data('flag');

      // Update button content
      $('#selectedCountry').text(countryName);
      $('#selectedFlag').attr('src', countryFlag);

      // Close the dropdown
      $('.dropdown-menu').removeClass('show');
    });
  });

  // country js end


//   currency js

$(document).ready(function() {
    // When a currency item is clicked
    $('.currency .dropdown-item').on('click', function() {
        // Get the selected currency text (e.g. KWD, BHD)
        var selectedCurrency = $(this).find('.label-text').text().trim();

        // Update the button text
        $('#selectedCurrency').text(selectedCurrency);

        // Optionally close the dropdown
        $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('toggle');
    });

    // Optional: close icon functionality inside topDropdonw
    $('.topDropdonw i.fa-xmark').on('click', function() {
        $(this).closest('.dropdown-menu').removeClass('show');
    });
});

//   currency js end


const container = document.querySelector('.suggestStore_contenar');

let isDown = false;
let startX;
let scrollLeft;

container.addEventListener('mousedown', (e) => {
  isDown = true;
  container.classList.add('active');
  startX = e.pageX - container.offsetLeft;
  scrollLeft = container.scrollLeft;
});

container.addEventListener('mouseleave', () => {
  isDown = false;
  container.classList.remove('active');
});

container.addEventListener('mouseup', () => {
  isDown = false;
  container.classList.remove('active');
});

container.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - container.offsetLeft;
  const walk = (x - startX) * 1.2; // scroll speed
  container.scrollLeft = scrollLeft - walk;
});
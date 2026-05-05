<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">

    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<style>
#otpSentMessage {
    white-space: nowrap;
}
</style>

<!-- <style>

        iframe#\:1\.container {
    visibility: hidden !important;
}

/* Hide the Google Translate tooltip */
.goog-te-banner-frame.skiptranslate,
.goog-tooltip,
.goog-tooltip:hover,
.goog-tooltip-vertical {
    display: none !important;
}

/* Hide the feedback popup on selected text */
#goog-gt-tt {
    display: none !important;
}
    </style>

    <style>
  body {
    visibility: hidden;
  }
</style> -->
</head>

<body>

  
        <div class="login-header">
            <div class="des-logo">
                <a href="#"><img src="{{asset('admin/image/logo.svg')}}" class="img-fluid" /> </a>
            </div>
            <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                    <span id="currentLang">EN</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                    <li>
                                        <a class="dropdown-item" data-lang="ar">
                                            <span>AR</span> Arabic
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" data-lang="en">
                                            <span>EN</span> English
                                        </a>
                                    </li>

                                </ul>
            </div>
        </div>
        </div>





    <div class="container-fluid p-0">
        <div class="login-grid-bg">

            <div class="row g-0">
                <div class="col-lg-6 bg-logo-wapper">
                    <div class="login-img">
                        <img src="/admin/image/Desynat-logo-2.svg" alt="image" class="img-fluid logo-login">
                    </div>
                    <img src="/admin/image/Vector-left.svg" alt="image" class="vector-left">
                    <img src="/admin/image/Vector-right.svg" alt="image" class="vector-right">
                </div>
                <div class="col-lg-6">
                    <!-- RIGHT SIDE -->
                    <div class="login-content pt-40">
                        <div class="login-grid-2">
                            <div class="login">
                                <div class="loginBackgroundeffect text">
                                    <div class="row">
                                        <!-- HEADER BACK NAV -->
                                        <div class="col-lg-12">
                                            <div class="d-flex align-items-center gap-3 mb-4">
                                                <div class="arrow">
                                                    <a class="table-button" href="{{ route('forgotPassword') }}">
                                                        <i class="fas fa-angle-left"></i>
                                                    </a>
                                                </div>
                                                <h4 class="m-0">OTP</h4>
                                            </div>
                                        </div>

                                        <!-- <div class="login">
                                <div class="loginBackgroundeffect"> -->
                                        <h5 class="text-start" id="otpSentMessage">
                                            6 digit OTP has been sent to: <span
                                                id="adminEmail">{{ $email ?? '' }}</span>
                                        </h5>



                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="otp-container">
                                                        @for ($i = 1; $i <= 6; $i++) <input type="text" maxlength="1"
                                                            class="otp-input" id="otp-{{ $i }}" required>
                                                            @endfor
                                                    </div>
                                                    <span class="text-danger" id="otpError"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="#" id="resendOtp">Resend OTP</a>
                                                </div>
                                            </div>

                                            <div class=" text-center">
                                                <div id="timerOtp">Resend OTP in <span id="seconds">30</span> Secs</div>
                                            </div>

                                            <div class="button d-flex align-items-center justify-content-center">
                                                <button class="btn custom-btn" id="submitOtp"
                                                    style="max-width: 100% !important;">Submit</button>
                                            </div>

                                        </div>
                                        <!-- </div>
                            </div> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- <div id="google_translate_element" style="display:none;"></div>
<div id="loaderTrans"
        style="display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:#ffffff; 
        z-index:999999;   
        /* display:flex;    */
        align-items:center;
        justify-content:center;">

        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"
                style="border:none; width:200px; height:200px;">
        </iframe>
    </div> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>

    <script>
    $(document).ready(function() {
        let timer = 60;
        let interval;

        // Hide resend button initially
        $('#resendOtp').prop('disabled', true);
        $('#resendOtp').hide();
        $('#timerOtp').show(); // Show timer at start

        function startTimer() {
            clearInterval(interval); // prevent multiple intervals
            $('#timerOtp').show(); // show timer whenever countdown starts
            $('#seconds').text(formatTime(timer));

            interval = setInterval(() => {
                timer--;
                $('#seconds').text(formatTime(timer));

                if (timer <= 0) {
                    clearInterval(interval);
                    $('#resendOtp').prop('disabled', false);
                    $('#resendOtp').show(); // show resend button after timer ends
                    $('#timerOtp').hide(); // hide timer text
                }
            }, 1000);
        }

        function formatTime(seconds) {
            let min = Math.floor(seconds / 60);
            let sec = seconds % 60;
            return `${min.toString().padStart(2,'0')}:${sec.toString().padStart(2,'0')}`;
        }

        startTimer();

        // OTP input auto-focus
        $('.otp-input').on('input', function() {
            let next = $(this).next('.otp-input');
            if (next.length && $(this).val()) next.focus();
            $('#otpError').text('');
        });

        // Submit OTP
        $('#submitOtp').click(function(e) {
            e.preventDefault();
            let otp = '';
            $('.otp-input').each(function() {
                otp += $(this).val();
            });

            if (otp.length === 0) {
                $('#otpError').text('Please Enter OTP');
                return;
            } else if (otp.length > 0 && otp.length < 6) {
                $('#otpError').text('Please Enter Full 6-digit OTP');
                return;
            }

            $.ajax({
                url: '{{ route("optVerify") }}',
                type: 'POST',
                data: {
                    otp: otp,
                    email: $('#adminEmail').text(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('admin.changePassword') }}";
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.otp) $('#otpError').text(errors.otp[0]);
                    }
                }
            });
        });

        // Resend OTP
        $('#resendOtp').click(function(e) {
            e.preventDefault();

            if ($(this).prop('disabled')) return;

            $.ajax({
                url: '{{ route("resendOtp") }}',
                type: 'POST',
                data: {
                    email: $('#adminEmail').text(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Reset timer and message
                        timer = 60;
                        $('#resendOtp').prop('disabled', true).hide();

                        let email = $('#adminEmail').text();
                        $('#otpSentMessage').html(
                            '6 digit OTP has been resent to: <span id="adminEmail">' +
                            email + '</span>');

                        toastr.success(response.message);

                        startTimer(); // restart timer display
                    }
                }
            });
        });
    });
    </script>


<!-- translator -->
<!-- <script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        autoDisplay: false
    }, 'google_translate_element');
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>

let currentLang = localStorage.getItem("selectedLang") || "en";
let translateReady = false;

/* WAIT FOR GOOGLE DROPDOWN (ROBUST VERSION) */
function waitForCombo(callback) {

    let attempts = 0;

    const timer = setInterval(() => {

        const combo = document.querySelector(".goog-te-combo");

        if (combo && combo.options.length > 1) {
            clearInterval(timer);
            translateReady = true;
            callback(combo);
        }

        attempts++;

        if (attempts > 30) {
            clearInterval(timer);
            console.warn("Google Translate not ready");
        }

    }, 200);
}


/* APPLY TRANSLATION (FIXED FIRST TIME ISSUE) */
function applyTranslation(lang) {

    const loader = document.getElementById("loaderTrans");
    if (loader) loader.style.display = "flex";

    currentLang = lang;
    localStorage.setItem("selectedLang", lang);

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // STEP 1: RESET
        trigger("en");

        setTimeout(() => {

            // STEP 2: APPLY LANGUAGE
            trigger(lang);

            // STEP 3: RETRY (VERY IMPORTANT FIX)
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                if (loader) loader.style.display = "none";

            }, 500);

        }, 300);

    });
}


/* UPDATE UI */
function updateUI(lang) {

    const current = document.getElementById("currentLang");
    if (current) current.innerText = lang.toUpperCase();

    document.querySelectorAll(".langu .dropdown-item")
        .forEach(el => el.style.background = "");

    const active = document.querySelector(`.langu .dropdown-item[data-lang="${lang}"]`);

    if (active) {
        active.style.background =
            "linear-gradient(73.47deg, #F9DBAB 0%, #7D532F 132.99%)";
    }
}


/* CLICK EVENTS */
document.querySelectorAll(".langu .dropdown-item").forEach(item => {

    item.addEventListener("click", function () {

        const lang = this.getAttribute("data-lang");

        // PREVENT CLICK BEFORE READY
        if (!translateReady) {
            console.log("Translate still loading...");
            return;
        }

        applyTranslation(lang);

    });

});


/* INITIAL LOAD */
function initLanguage() {

    const lang = localStorage.getItem("selectedLang") || "en";
    const loader = document.getElementById("loaderTrans");

    if (loader) loader.style.display = "flex";

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // RESET FIRST
        trigger("en");

        setTimeout(() => {

            trigger(lang);

            // RETRY FIX
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                // SHOW PAGE ONLY AFTER TRANSLATION
                document.body.style.visibility = "visible";

                if (loader) loader.style.display = "none";

            }, 600);

        }, 300);

    });

}

window.addEventListener("load", initLanguage);


/* BACK/FORWARD CACHE FIX */
window.addEventListener("pageshow", function (event) {

    if (event.persisted ||
        performance.getEntriesByType("navigation")[0]?.type === "back_forward") {

        setTimeout(() => {
            initLanguage();
        }, 200);
    }

});


/* HIDE GOOGLE TOOLTIP */
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.id === 'goog-gt-tt') {
                node.style.display = 'none';
            }
        });
    });
});

observer.observe(document.body, { childList: true, subtree: true });

</script> -->

</body>

</html>
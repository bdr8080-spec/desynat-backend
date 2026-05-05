<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">

    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />


</head>

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

<body>

    <div>

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

        <!-- <div class="auth-wrapper"> -->
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
                                    <div class="loginBackgroundeffect">
                                        <h4 class="login-text "> <span>Sign In </span></h4>
                                        <h6 class="welcome-text"> <span>Welcome Back !</span></h6>

                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email">Enter Email Id</label>
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Enter Email id" required />
                                                    <small id="emailError" style="color: red;"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" id="password"
                                                        class="form-control custom-password" name="password"
                                                        placeholder="Enter password" required />
                                                    <i toggle="#password" class="fas fa-eye toggle-password"></i>
                                                </div>
                                            </div>
                                            <small id="passwordError" style="color: red;"></small>
                                            <div id="loginError" style="color: red; display:none;"></div>
                                            <div class="col-lg-12">
                                                <div class="mt-2 d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('forgotPassword') }}">Forgot Password?</a>
                                                </div>
                                            </div>
                                            <div class="button d-flex align-items-center justify-content-center">
                                                <button id="loginBtn" class="btn custom-btn w-100">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- LEFT SIDE -->
        <!-- <div class="auth-left">
                <div class="brand-header">
                    <img src="assets/logo.png" class="brand-logo" alt="logo">
                       <span class="brand-name">Desynat</span>
                </div>
            </div> -->




        <!-- </div> -->

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
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script>
    // Toggle password visibility
    document.querySelectorAll(".toggle-password").forEach((toggle) => {
        toggle.addEventListener("click", function() {
            const input = document.querySelector(this.getAttribute("toggle"));
            const type =
                input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", type);

            // Toggle icon between eye (fa-eye) and eye-slash (fa-eye-slash)
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });
    </script>
    <!-- <script>
    $(document).ready(function() {
        $('#email, #password').on('input', function() {
            const field = $(this).attr('id');

            if (field === 'email') {
                $('#emailError').text('');
            }
            if (field === 'password') {
                $('#passwordError').text('');
            }

            $('#loginError').hide().text('');
        });
        // AJAX login form submission
        $('#loginBtn').click(function(e) {
            e.preventDefault();

            $('#emailError').text('');
            $('#passwordError').text('');
            $('#loginError').hide().text('');

            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                url: '{{ route("adminLogin") }}',
                type: 'POST',
                data: {
                    email: email,
                    password: password,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = "{{ route('admin.dashboard') }}";
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.email && errors.password) {
                        $('#emailError').text(errors.email[0]);
                        $('#passwordError').text(errors.password[0]);
                    } else if (errors.email) {
                        if (errors.email[0] === 'Invalid credentials') {
                            $('#loginError').text(errors.email[0]).show();
                        } else {
                            $('#emailError').text(errors.email[0]);
                        }
                    }
                    if (errors.password) {
                        $('#passwordError').text(errors.password[0]);
                    }
                }
            });
        });
    });
    </script> -->
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
$(document).ready(function() {

    // =========================
    // CLEAR ERRORS ON INPUT
    // =========================
    $('#email, #password').on('input', function() {
        $('#emailError').text('');
        $('#passwordError').text('');
    });

    // =========================
    // LOGIN AJAX
    // =========================
    $('#loginBtn').click(function(e) {
        e.preventDefault();

        // reset errors
        $('#emailError').text('');
        $('#passwordError').text('');

        $.ajax({
            url: '{{ route("adminLogin") }}',
            type: 'POST',
            data: {
                email: $('#email').val(),
                password: $('#password').val(),
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {

                if (response.success) {
                    toastr.success(response.message ?? 'Login Successful');

                    setTimeout(function() {
                        window.location.href = "{{ route('admin.dashboard') }}";
                    }, 800);
                }
            },

            error: function(xhr) {

                if (xhr.status === 422) {

                    const res = xhr.responseJSON;

                    // =========================
                    // FIELD VALIDATION ERRORS
                    // =========================
                    if (res.type === 'validation') {

                        if (res.errors.email) {
                            $('#emailError').text(res.errors.email[0]);
                        }

                        if (res.errors.password) {
                            $('#passwordError').text(res.errors.password[0]);
                        }
                    }

                    // =========================
                    // AUTH / BUSINESS ERRORS
                    // =========================
                    if (res.type === 'auth') {
                        toastr.error(res.message);
                    }

                } else {
                    toastr.error('Something went wrong. Please try again.');
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
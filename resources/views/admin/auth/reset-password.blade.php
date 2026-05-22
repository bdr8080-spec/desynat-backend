<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin_messages.desynat_admin') }}</title>
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">

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

  
        <div class="login-header">
            <div class="des-logo">
                <a href="#"><img src="{{asset('admin/image/logo.svg')}}" class="img-fluid" /> </a>
            </div>
            <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                    <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                    <li>
                                        <a class="dropdown-item" data-lang="ar" href="{{route('adminLanguage','ar')}}">
                                            <span>{{ __('admin_messages.ar') }}</span> {{ __('admin_messages.arabic') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" data-lang="en" href="{{route('adminLanguage','en')}}">
                                            <span>{{ __('admin_messages.en') }}</span> {{ __('admin_messages.english') }}
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

                            <!-- HEADER -->
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center gap-3 mt-2">
                                    <div class="arrow">
                                        <a class="table-button" type="button" href="{{ route('forgotPassword') }}">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                    </div>
                                    <h6 class="m-0">{{ __('admin_messages.reset_password') }}</h6>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="newPassword" >{{ __('admin_messages.create_new_password') }}</label>
                                    <input type="password" class="form-control" id="newPassword"
                                        placeholder="{{ __('admin_messages.enter_new_password') }}" required>
                                    <i toggle="#newPassword" class="fas fa-eye toggle-password"></i>
                                </div>
                                <span id="passwordError" class="text-danger"></span>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="confirmPassword" >{{ __('admin_messages.confirm_password') }}</label>
                                    <input type="password" id="confirmPassword" class="form-control"
                                        placeholder="{{ __('admin_messages.enter_confirm_password') }}" required>
                                    <i toggle="#confirmPassword" class="fas fa-eye toggle-password"></i>
                                </div>
                                <span id="confirmPasswordError" class="text-danger"></span>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <div class="button d-flex align-items-center justify-content-center">
                                    <button class="btn custom-btn" id="submitPassword"
                                        style="max-width: 100% !important;">{{ __('admin_messages.submit') }}</button>
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

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <!-- <a href="login.html"><i class="fas fa-long-arrow-alt-left"></i></a> -->
                    <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body mb-5">
                    <div class="change-success text-center">
                        <img src="image/check.png" class="img-fluid" width="100px" />
                        <h2 class="mt-4">{{ __('admin_messages.password_reset_successfully') }}</h2>
                        <p>{{ __('admin_messages.use_the_new_password_during_logging_in_to_get_access_to_your_account') }}</p>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
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
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('toggle'));
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);

            // Toggle icon between eye (fa-eye) and eye-slash (fa-eye-slash)
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
    </script>

    <script>
    $(document).ready(function() {

        // Validation criteria function
        const passwordHintText = "{{ __('admin_messages.password_should_be_combination_of_at_least_8_characters_1_uppercase_letter_1_lowercase_letter_1_number_and_1_special_character') }}";
        function passwordHint(password) {
            return passwordHintText;
        }

        // Check if password meets criteria
        function meetsCriteria(password) {
            return password.length >= 8 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[!@#$%^&*(),.?\":{}|<>]/.test(password);
        }

        // On input in newPassword field
        $('#newPassword').on('input', function() {
            let pwd = $(this).val();
            $('#passwordError').text('');
            if (pwd && !meetsCriteria(pwd)) {
                $('#passwordError').text(passwordHint(pwd));
            }
        });

        // On input in confirmPassword field
        $('#confirmPassword').on('input', function() {
            $('#confirmPasswordError').text('');
        });

        // On submit
        $('#submitPassword').click(function(e) {
            e.preventDefault();
            $('#passwordError').text('');
            $('#confirmPasswordError').text('');

            let newPassword = $('#newPassword').val();
            let confirmPassword = $('#confirmPassword').val();
            let email = "{{ $email ?? '' }}";

            // Check fields empty
            if (!newPassword) {
                $('#passwordError').text("{{ __('admin_messages.please_enter_password') }}");

            }
            if (!confirmPassword) {
                $('#confirmPasswordError').text("{{ __('admin_messages.please_enter_confirm_password') }}");
                return;
            }

            // Check criteria
            if (!meetsCriteria(newPassword)) {
                $('#passwordError').text(passwordHint(newPassword));
                return;
            }

            // Check match
            if (newPassword !== confirmPassword) {
                $('#confirmPasswordError').text("{{ __('admin_messages.password_do_not_match') }}");
                return;
            }

            // Now do AJAX call
            $.ajax({
                url: '{{ route("admin.changePassword") }}',
                type: 'POST',
                data: {
                    email: email,
                    password: newPassword,
                    confirm_password: confirmPassword,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#exampleModal').modal('show');
                        setTimeout(function() {
                            window.location.href = "{{ route('adminLogin') }}";
                        }, 5000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.password) $('#passwordError').text(errors.password[0]);
                        if (errors.confirm_password) $('#confirmPasswordError').text(errors
                            .confirm_password[0]);
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
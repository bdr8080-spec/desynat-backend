@extends('user.auth.layout.app')



@section('content')

   <style>


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
</style>


<div class="login_contenar">
    <header class="inner-header">
        <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
        <div class="d-flex align-items-center becomSeller">
            <div class="dropdown ms-3">
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
    </header>
    <div class="login_content login_content_left">
        <img src="assets/images/left-img.svg" class="left-imgone" />
        <img src="assets/images/logoone.svg" class="left-img" />
        <img src="assets/images/right-img.svg" class="left-imgtwo" />
    </div>
    <div class="login_content login_content_right">
        <div class="login_content_content align-self-center">
            <div class="otp-page">
                <h3 class="h3-heading">
                    <span><a href="{{ url()->previous() }}"><i class="fa-solid fa-chevron-left"></i></a></span> OTP
                    Verification
                </h3>
                @php

                use Illuminate\Support\Facades\Crypt;
                use App\Models\AffilatedUser;

                try {
                $id = Crypt::decryptString(request()->temp_user_id);
                $user = AffilatedUser::where('id', $id)->first();
                } catch (\Exception $e) {
                return response()->json(
                [
                'status' => false,
                'message' => 'Invalid user reference.',
                ],
                400,
                );
                }

                @endphp

                @if ($user)
                <h5 class="otp_sent">
                    6 digit OTP has been sent to your registered
                    @if (request()->type == '2')
                    Email Address: <span>{{ $user->email }}</span>
                    @else
                    Mobile Number: <span>{{ $user->country_code }} {{ $user->mobile }}</span>
                    @endif
                </h5>
                @endif

                <form id="otpVerify">
                    @csrf
                    <input type="hidden" name="id" value="{{ request()->temp_user_id }}">
                    <input type="hidden" name="forget_password" value="{{ request()->forget_password }}">
                    <input type="hidden" name="type" value="{{request()->type}}">
                    <div class="otp-container mt-3">
                        <input type="text" maxlength="1" class="otp-input" id="otp1" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp2" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp3" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp4" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp5" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp6" name="otp[]" />

                    </div>
                    <div class="resend-otp-container"
                        style="display: flex;justify-content: center;margin-top:20px !important;xmargin:0 auto; align-items: center; gap: 10px;">
                        <button type="button" class="customBtnresend" id="resendOtpBtn" onclick="resendOtp()">Resend
                            OTP</button>
                        <span id="otpTimer" style="color: red;"></span>
                    </div>
                    <button type="submit" class="customBtn customBtn5 mt-5" id="otpVerifyBtn">Verify OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="google_translate_element" style="display:none;"></div>
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
    </div>

<script>
$(document).on('submit', '#otpVerify', function(e) {
    e.preventDefault();

    let data = new FormData(this);

    $('#otpVerifyBtn').prop('disabled', true);

    $.ajax({
        url: "{{ route('affiliate.affiliate_otpVerify') }}",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(resp) {
            if (resp.status == true) {
                toastr.success(resp.message);
                setTimeout(() => {
                    location.href = resp.redirect_url
                }, 1000);
            } else {
                toastr.error(resp.error);
            }
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON.message)
        },
        complete: function() {
            $('#otpVerifyBtn').prop('disabled', false);
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    startOtpTimer(); // Start automatically on page load
});

function startOtpTimer() {
    let button = document.getElementById('resendOtpBtn');
    let timerDisplay = document.getElementById('otpTimer');
    let timer = 50; // seconds

    button.disabled = true;
    timerDisplay.innerText = `${timer}s`;

    let countdown = setInterval(() => {
        timer--;
        timerDisplay.innerText = `${timer}s`;

        if (timer <= 0) {
            clearInterval(countdown);
            button.disabled = false;
            timerDisplay.innerText = ""; // Hide timer after completion
        }
    }, 1000);
}

function resendOtp() {
    let id = "{{ request()->temp_user_id }}";

    // Restart the timer
    startOtpTimer();

    $.ajax({
        url: "{{ route('affiliate_signupResendOtp') }}",
        type: "POST",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },
        success: function(resp) {
            toastr.success(resp.message);
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON?.message || 'Something went wrong');
        }
    });
}
</script>




<script>
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
</script>

<!-- translator -->
<script>
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

</script>

@endsection
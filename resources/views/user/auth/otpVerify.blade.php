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

@php
if (Session::get('verify-password') != '1') {
header('Location: ' . route('userRegister'));
exit();
}
@endphp


<div class="login_contenar">
    <header class="inner-header">
        <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
        <div class="d-flex align-items-center becomSeller">
            <div class="dropdown-center mobileLang">
                    <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img id="selectedFlag" src="{{asset('user/assets/images/flags/kuwait.svg')}}"
                            class="img-fluid" />
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu"
                        aria-labelledby="countryDropdownBtn">
                        <li class="topDropdonw">
                            <p>Change Country
                                <i class="fa-solid fa-xmark"></i>
                            </p>
                        </li>
                        <li class="dropdown-item" data-country="United States"
                            data-flag="{{asset('user/assets/images/flags/kuwait.svg')}}">
                            <div class="d-flex align-self-center justify-content-between">
                                <div class="radio-group">
                                    <label class="custom-radio">
                                        <input type="radio" name="country_language" value="United States"/>
                                        <span class="radio-mark"></span>
                                        <span class="label-text">United States</span>
                                    </label>
                                </div>
                                <img src="{{asset('user/assets/images/flags/kuwait.svg')}}" />
                            </div>
                        </li>
                        <li class="dropdown-item" data-country="Kuwait"
                            data-flag="{{asset('user/assets/images/flags/kuwait.svg')}}">
                            <div class="d-flex align-self-center justify-content-between">
                                <div class="radio-group">
                                    <label class="custom-radio">
                                        <input type="radio" name="country_language" value="Kuwait"/>
                                        <span class="radio-mark"></span>
                                        <span class="label-text">Kuwait</span>
                                    </label>
                                </div>
                                <img src="{{asset('user/assets/images/flags/kuwait.svg')}}" />
                            </div>
                        </li>
                        <li class="dropdown-item" data-country="Bahrain"
                            data-flag="{{asset('user/assets/images/flags/bahrain.svg')}}">
                            <div class="d-flex align-self-center justify-content-between">

                                <div class="radio-group">
                                    <label class="custom-radio">
                                        <input type="radio" name="country_language" value="Bahrain" />
                                        <span class="radio-mark"></span>
                                        <span class="label-text">Bahrain</span>
                                    </label>
                                </div>
                                <img src="{{asset('user/assets/images/flags/bahrain.svg')}}" />
                            </div>
                        </li>
                        <li class="dropdown-item" data-country="Qatar"
                            data-flag="{{asset('user/assets/images/flags/qatar.svg')}}">
                            <div class="d-flex align-self-center justify-content-between">

                                <div class="radio-group">
                                    <label class="custom-radio">
                                        <input type="radio" name="country_language" value="Qatar" />
                                        <span class="radio-mark"></span>
                                        <span class="label-text">Qatar</span>
                                    </label>
                                </div>
                                <img src="{{asset('user/assets/images/flags/qatar.svg')}}" />
                            </div>
                        </li>
                        <li class="dropdown-item" data-country="Saudi Arabia"
                            data-flag="{{asset('user/assets/images/flags/saudi-arabia.svg')}}">
                            <div class="d-flex align-self-center justify-content-between">

                                <div class="radio-group">
                                    <label class="custom-radio">
                                        <input type="radio" name="country_language" value="Saudi Arabia" />
                                        <span class="radio-mark"></span>
                                        <span class="label-text">Saudi Arabia</span>
                                    </label>
                                </div>
                                <img src="{{asset('user/assets/images/flags/saudi-arabia.svg')}}" />
                            </div>
                        </li>
                        <li class="dropdown-item" data-country="UAE"
                            data-flag="{{asset('user/assets/images/flags/uae.svg')}}">
                            <div class="d-flex align-self-center justify-content-between">

                                <div class="radio-group">
                                    <label class="custom-radio">
                                        <input type="radio" name="country_language" value="UAE" />
                                        <span class="radio-mark"></span>
                                        <span class="label-text">UAE</span>
                                    </label>
                                </div>
                                <img src="{{asset('user/assets/images/flags/uae.svg')}}" />
                            </div>
                        </li>
                        <li class="dropdown-item" data-country="Oman"
                            data-flag="{{asset('user/assets/images/flags/oman.svg')}}">
                            <div class="d-flex align-self-center justify-content-between">

                                <div class="radio-group">
                                    <label class="custom-radio">
                                        <input type="radio" name="country_language" value="Oman" />
                                        <span class="radio-mark"></span>
                                        <span class="label-text">Oman</span>
                                    </label>
                                </div>
                                <img src="{{asset('user/assets/images/flags/oman.svg')}}" />
                            </div>
                        </li>
                        <!-- <li>
                            <button id="saveCountry" class="customBtn customBtn5 mt-lg-5 mt-md-3 mt-3">Save</button>
                        </li> -->
                    </ul>
                </div>
            <a href="{{url('/seller/login')}}" class="customBtn1">Become a seller</a>
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
                </h3>
                @php

                use Illuminate\Support\Facades\Crypt;
                use App\Models\User;

                try {
                $id = Crypt::decryptString(request()->temp_user_id);
                $user = User::where('id', $id)->first();
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
        url: "{{ route('userVerifyOtp') }}",
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
        url: "{{ route('userResendOtp') }}",
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

<!-- google translator code -->
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

const countryLangMap = {
    "Kuwait": "ar",
    "Bahrain": "ar",
    "Qatar": "ar",
    "Saudi Arabia": "ar",
    "UAE": "ar",
    "Oman": "ar",
    "United States": "en"
};

function waitForComboReady(callback) {

    const timer = setInterval(() => {

        const combo = document.querySelector(".goog-te-combo");

        if (combo && combo.options && combo.options.length > 0) {
            clearInterval(timer);
            callback(combo);
        }

    }, 200);
}

function applyTranslation(lang) {

    const loader = document.getElementById("loaderTrans");
    if (loader) loader.style.display = "flex";

    waitForComboReady(function(combo) {

        combo.selectedIndex = 0;
        combo.dispatchEvent(new Event("change"));

        setTimeout(() => {

            combo.value = lang;
            combo.dispatchEvent(new Event("change"));

            setTimeout(() => {
                if (loader) loader.style.display = "none";
            }, 800);

        }, 200);

    });

}

document.querySelectorAll('input[name="country_language"]').forEach(radio => {

    radio.addEventListener("change", function () {

        const country = this.value;
        const lang = countryLangMap[country] || "en";

        localStorage.setItem("selectedCountry", country);

        applyTranslation(lang);

        const dropdownBtn = document.getElementById("countryDropdownBtn");

        if (dropdownBtn && window.bootstrap) {
            const instance = bootstrap.Dropdown.getInstance(dropdownBtn);
            if (instance) instance.hide();
        }

    });

});

window.addEventListener("load", function () {

    let saved = localStorage.getItem("selectedCountry");

    if (!saved) {
        saved = "United States";
        localStorage.setItem("selectedCountry", saved);
    }

    const lang = countryLangMap[saved] || "en";

    const radio = document.querySelector(
        `input[name="country_language"][value="${saved}"]`
    );

    if (radio) radio.checked = true;

    // extra delay = fixes FIRST LOAD issue (critical)
    setTimeout(() => {
        applyTranslation(lang);
    }, 1500);

});

</script>

@endsection
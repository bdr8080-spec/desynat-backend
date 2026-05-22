<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> desynat seller </title>
    <!-- Favicons -->
    <link href="{{ asset('/dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" />
    <link href="{{ asset('dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
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
            <a href="#"><img src="{{ asset('/dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                     <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.en') }} @endif </span>


                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                     <li>
                                        <a class="dropdown-item" data-lang="ar" href="{{route('sellerLanguage','ar')}}" >
                                            <span>{{ __('admin_messages.ar') }}</span> {{ __('seller_messages.Arabic') }} 
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" data-lang="en"  href="{{route('sellerLanguage','en')}}" >
                                            <span>{{ __('admin_messages.en') }}</span> {{ __('seller_messages.English') }} 
                                        </a>
                                    </li>

                                </ul>
            </div>
        </div>
    </div>

    <div class="login-wapper">
        <div class="container-fluid p-0">
            <div class="login-grid-bg">
                <div class="row g-0">
                    <div class="col-lg-6 bg-logo-wapper">
                        <div class="login-img">
                            <img src="{{ asset('dealer') }}/assets/img/Desynat-logo-2.svg" alt="image"
                                class="img-fluid logo-login">
                        </div>
                        <img src="{{ asset('dealer') }}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{ asset('dealer') }}/assets/img/Vector-right.svg" alt="image"
                            class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2">
                                <form action="{{ route('seller.forgot') }}" method="Post">
                                    <div class="cmn-header">
                                        <h1><a href="{{ route('seller.login') }}"><i class="bi bi-chevron-left"></i></a>
                                            {{ __('seller_messages.forgot_password') }}

                                        </h1>
                                    </div>

                                    <div class="group-radio-btn d-flex gap-4 py-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="r1"
                                                value="0" {{ old('type') == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="r1"> {{ __('seller_messages.mobile_number') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="r2"
                                                value="1" {{ old('type') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="r2">  {{ __('seller_messages.email_address') }}</label>
                                        </div>
                                    </div>

                                    @csrf


                                    <div class="form-group mt-4" id="mobileDiv">
                                        <label for=""> {{ __('seller_messages.mobile_number') }}</label>

                                        <div class="d-flex align-items-center gap-3">
                                            <div class="LoginCountryCode">
                                                {{-- <select name="country_code" id=""
                                                    class="country form-control form-select" style="width:100px">
                                                    @foreach ($country as $item)
                                                        <option value="{{ $item->dial_code }}">
                                                            {{ $item->dial_code }}</option>
                                                    @endforeach
                                                </select> --}}

                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                        type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">

                                                        <span id="selected-flag">
                                                            <img src="{{ old('country_flag', $country[0]->flag1) }}"
                                                                alt="flag" width="25" height="16">

                                                        </span>

                                                        <span id="selected-code" class="ms-2">
                                                            {{ old('country_code', $country[0]->dial_code) }}
                                                        </span>
                                                    </button>

                                                    <ul class="dropdown-menu p-2" aria-labelledby="countryDropdown">

                                                        @foreach ($country as $index => $item)
                                                            <li>
                                                                <label
                                                                    class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                                    style="cursor: pointer;">
                                                                    <input type="radio" name="country_code"
                                                                        value="{{ $item->dial_code }}"
                                                                        data-flag="{{ $item->flag }}"
                                                                        data-name="@if(App::getlocale()=='en'){{ $item->name }} @else {{ $item->name_ar }} @endif"
                                                                        class="country-radio"
                                                                        {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                                        hidden>
                                                                  
                                                                    <div width="25" height="16">
                                                                            <span>{{ $item->flag }} {{ $item->dial_code }}
                                                                                (@if(App::getlocale()=='en'){{ $item->name }} @else {{ $item->name_ar }} @endif )
                                                                            </span>
                                                                        </div>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            </div>
                                            <div class="w-100 LoginMobileDesign">


                                                <input type="text" class="form-control notapplyspace"
                                                    value="" placeholder="{{ __('seller_messages.enter_mobile_number') }}" name="mobile"
                                                    id="LoginMobile">

                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group mt-3 " id="emailDiv">

                                        <label for="">{{ __('seller_messages.enter_email_address') }}</label>

                                        <div class="w-100 LoginMobileDesign">
                                            <input type="text" class="form-control notapplyspace" value=""
                                                placeholder="{{ __('seller_messages.enter_email_address') }}" name="email" id="LoginMobile">
                                        </div>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @error('error')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="login-btn padding-top-60">
                                        <input type="submit" class="btn btn-success w-100" value="{{ __('seller_messages.continue') }}">
                                        {{-- <a href="otp_verify.php" class="btn btn-success w-100">{{ __('seller_messages.continue') }}</a> --}}
                                    </div>

                                </form>
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


</body>


<!-- Vendor JS Files -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js"></script>

<!--Main JS File -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/main.js"></script>


<script>
    $('#LoginMobile').on('keyup change', function() {
        let value = $(this).val().trim();

        if (value === '') return;

        if (!isNaN(value.charAt(0))) {
            $('.LoginCountryCode').addClass('d-block').removeClass('d-none');
            $('.LoginMobileDesign').addClass('').removeClass('col-12');
        } else {
            $('.LoginCountryCode').addClass('d-none').removeClass('d-block');
            $('.LoginMobileDesign').addClass('col-12').removeClass('col-9');
        }
    });


    $(document).ready(function() {
        // When a user selects a country (clicks a label)
        $(document).on('click', '.country-option', function() {
            let radio = $(this).find('.country-radio');
            let flag = radio.data('flag');
            let code = radio.val();
            let name = radio.data('name');

            // Update the flag and code shown on the button
            $('#selected-flag').html(flag);
            $('#selected-code').text(code);

            // Set the radio input as checked
            radio.prop('checked', true);

            // Close the dropdown (Bootstrap 5)
            $('#countryDropdown').dropdown('hide');
        });

    });


    $(document).ready(function() {
        $('input[name="type"]').on('change', function() {
            if ($(this).val() == '0') {
                // Show mobile input
                $('#mobileDiv').removeClass('d-none');
                $('#emailDiv').addClass('d-none');
            } else {
                // Show email input
                $('#emailDiv').removeClass('d-none');
                $('#mobileDiv').addClass('d-none');
            }
        });
    });

    $(document).ready(function() {
        const selectedType = $('input[name="type"]:checked').val();

        if (selectedType == '1') {
            $('#emailDiv').removeClass('d-none');
            $('#mobileDiv').addClass('d-none');
        }

        if (selectedType == '0') {
            $('#mobileDiv').removeClass('d-none');
            $('#emailDiv').addClass('d-none');
        }



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



@include('dealer.layout.custom_code')


</html>

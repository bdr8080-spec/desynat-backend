@extends('user.auth.layout.app')

@section('content')

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
<div class="login_contenar">
    <header class="inner-header">
        <a href=""><img src="assets/images/logo.svg" class="img-fluid" /></a>
        <div class="d-flex align-items-center becomSeller">
            <div class="dropdown ms-3">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                        data-bs-toggle="dropdown">

                        <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                        <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif</span>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end langu">

                        <li>
                            <a class="dropdown-item" data-lang="ar" href="{{route('userLanguage','ar')}}">
                                <span>{{ __('admin_messages.ar') }}</span> {{ __('affiliate_messages.arabic') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" data-lang="en" href="{{route('userLanguage','en')}}">
                                <span>{{ __('admin_messages.en') }}</span> {{ __('affiliate_messages.english') }}
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
            <div>
                <h3 class="h3-heading"><span><a href="{{ route('affiliate.affiliate_login') }}"><i
                                class="fa-solid fa-chevron-left"></i></a></span>{{ __('affiliate_messages.forgot_password') }}</h3>
                <form id="forgetPassword">
                    @csrf
                    <div class="radio-group my-4">
                        <label class="custom-radio">
                            <input type="radio" name="forgetPassword" class="emailandmobile notapplyspace" value="1"
                                checked />
                            <span class="radio-mark"></span>
                            <span class="label-text">{{ __('affiliate_messages.mobile_number') }}</span>
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="forgetPassword" class="emailandmobile" value="2" />
                            <span class="radio-mark"></span>
                            <span class="label-text">{{ __('affiliate_messages.email_address') }}</span>
                        </label>
                    </div>

                    <div class="form-group position-relative mt-3 mobileInput">
                        <label for="">{{ __('affiliate_messages.mobile_number') }}</label>
                        <div class="d-flex align-items-center">
                            <div class="">
                                {{-- <select name="country_code" id="" class="country" class="form-control">
                                    @foreach ($country as $item)                       
                                        <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                                @endforeach
                                </select> --}}

                                <!-- <div class="dropdown">
                                    <button class="btn btn-light border dropdown-toggle d-flex align-items-center" type="button"
                                            id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selected-flag">
                                            <img src="{{ $country[0]->flag }}" alt="flag" width="25" height="16">
                                        </span>
                                        <span id="selected-code" class="ms-2">{{ $country[0]->dial_code }}</span>
                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="countryDropdown" style="max-height: 250px; overflow-y: auto;">
                                        @foreach ($country as $index => $item)
                                            <li>
                                                <label class="dropdown-item d-flex align-items-center gap-2 country-option" style="cursor: pointer;">
                                                    <input type="radio" name="country_code"
                                                        value="{{ $item->dial_code }}"
                                                        data-flag="{{ $item->flag }}"
                                                        class="country-radio"
                                                        {{ $index === 0 ? 'checked' : '' }} hidden>
                                                    <img src="{{ $item->flag }}" alt="Flag of {{ $item->name }}" width="25" height="16">
                                                    <span>{{ $item->dial_code }} ({{ $item->name }})</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div> -->

                                <div class="dropdown">
                                    <button
                                        class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                        type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                        <span id="selected-flag">
                                            <!-- {{ old('country_flag', $country[0]->flag) }} -->
                                              <img src="{{ old('country_flag', $country[0]->flag1) }}" width="20" height="14">


                                        </span>

                                        <span id="selected-code" class="ms-2">
                                            {{ old('country_code', $country[0]->dial_code) }}
                                        </span>
                                    </button>

                                    <ul class="dropdown-menu p-2 newcountrybox" aria-labelledby="countryDropdown">

                                        @foreach ($country as $index => $item)
                                        <li>
                                            <label class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                style="cursor: pointer;">
                                                <input type="radio" name="country_code" value="{{ $item->dial_code }}"
                                                    data-flag="{{ $item->flag1 }}" data-name="{{ App::getLocale() == 'en' ? $item->name : $item->name_ar }}"
                                                    class="country-radio"
                                                    {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                    hidden>

                                                <!-- <img src="{{ $item->flag1 }}"
                                                        alt="Flag of {{ $item->name }}"
                                                        width="25" height="16">

                                                    <span>{{ $item->dial_code }}
                                                        ({{ $item->name }})
                                                    </span> -->

                                                <div width="25" height="16">
                                                    <span><img src="{{ $item->flag1 }}" width="25" height="16">
                                                        {{ $item->dial_code }}
                                                        ({{ App::getLocale() == 'en' ? $item->name : $item->name_ar }})
                                                    </span>
                                                </div>

                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                            <div class="w-100">
                                <input type="number" class="form-control" value="" placeholder="{{ __('affiliate_messages.enter_mobile_number') }}"
                                    name="mobile" maxlength="15"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)">
                            </div>
                        </div>
                        <p class="text-danger" id="error-mobile"></p>
                    </div>
            </div>

            <div class="form-group position-relative password_icon mt-3 d-none emailInput">
                <label for="">{{ __('affiliate_messages.email_address') }}</label>
                <input class="form-control notapplyspace" type="email" placeholder="{{ __('affiliate_messages.enter_email_address') }}" name="email">
                <p class="text-danger" id="error-email"></p>
            </div>
            <button type="submit" class="customBtn customBtn5 mt-4">{{ __('affiliate_messages.continue') }}</button>
            </form>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('.country-radio');
                const selectedFlag = document.getElementById('selected-flag');
                const selectedCode = document.getElementById('selected-code');

                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        const parent = this.closest('label');
                        const flagImg = parent.querySelector('img').src;
                        const dialCode = this.value;

                        selectedFlag.innerHTML = `<img src="${flagImg}" width="25" height="16">`;
                        selectedCode.textContent = dialCode;
                    });
                });
            });

// $(document).ready(function() {
//     // When a user selects a country (clicks a label)
//     $(document).on('click', '.country-option', function() {
//         let radio = $(this).find('.country-radio');
//         let flag = radio.data('flag');
//         let code = radio.val();
//         let name = radio.data('name');

//         // Update the flag and code shown on the button
//         $('#selected-flag').html(flag);
//         $('#selected-code').text(code);

//         // Set the radio input as checked
//         radio.prop('checked', true);

//         // Close the dropdown (Bootstrap 5)
//         $('#countryDropdown').dropdown('hide');
//     });
// });



$('.emailandmobile').on('click', function(e) {

    let id = $(this).val();

    if (id == '2') {
        $('.emailInput').addClass('d-block').removeClass('d-none');
        $('.mobileInput').addClass('d-none').removeClass('d-block');
    } else {
        $('.emailInput').addClass('d-none').removeClass('d-block');
        $('.mobileInput').addClass('d-block').removeClass('d-none');
    }

})


$(document).on('submit', '#forgetPassword', function(e) {
    e.preventDefault();

    let data = new FormData(this);

    $('#loginButtom').prop('disabled', true);

    $.ajax({
        url: "{{ route('affiliate_forgotpassword') }}",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(resp) {
            if (resp.status == true) {
                location.href =
                    `affiliate-verify-otp?temp_user_id=${resp.id}&forget_password=one&type=${resp.type}`;
            }

            if (resp.status == false) {
                for (const key in resp.errors) {
                    console.log(resp.errors[key])
                    $(`#error-${key}`).html(resp.errors[key]);
                }
            }

        },
        error: function(xhr) {
            if (xhr.responseJSON.status == false) {
                toastr.error(xhr.responseJSON.message);
            }

        },
        complete: function() {
            $('#loginButtom').prop('disabled', false);
        }
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

@endsection
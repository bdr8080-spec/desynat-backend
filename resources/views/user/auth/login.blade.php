
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
            <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
            <div class="d-flex align-items-center becomSeller">
                
                <!-- <div class="dropdown" >
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/images/global.svg" class="img-fluid" /> EN
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                        <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                    </ul>
                </div> -->
                <div class="dropdown-center mobileLang">
                                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                    <span id="currentLang">@if(app()->getLocale()=='en') En @else AR @endif</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                    <li>
                                        <a class="dropdown-item" data-lang="ar" href="{{route('userLanguage','ar')}}">
                                            <span>AR</span> {{ __('user_messages.arabic') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" data-lang="en" href="{{route('userLanguage','en')}}">
                                            <span>EN</span> {{ __('user_messages.english') }}
                                        </a>
                                    </li>

                                </ul>

                            </div>
                <a href="{{url('/seller/login')}}" class="customBtn1">{{ __('user_messages.become_a_seller') }}</a>
            </div>
        </header>
        <div class="login_content login_content_left">
            <img src="assets/images/left-img.svg" class="left-imgone" />
            <img src="assets/images/logoone.svg" class="left-img" />
            <img src="assets/images/right-img.svg" class="left-imgtwo" />
        </div>
        <div class="login_content login_content_right">
            <div class="login_content_content">
            <form id="userLogin">
                @csrf
                <div class="d-flex align-items-center justify-content-between">
                    <h4>{{ __('user_messages.sign_in_small') }}</h4>
                <p class="guest"><a href="{{route('dashboard')}}">{{ __('user_messages.continue_as_a_guest') }}</a></p>
                </div>
                <h3>{{ __('user_messages.welcome_back') }} !</h3>
                <div class="form-group mt-lg-4 mt-md-3 mt-2">
                    <label for="">{{ __('user_messages.mobile_number_or_email_address') }}</label>
                   
                    <div class="d-flex align-items-center">
                        <div class=" d-none LoginCountryCode">
                                {{-- <select name="country_code" id="" class="country form-control">
                                    @foreach ($country as $item)                       
                                        <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                                    @endforeach
                                </select> --}}

                                <div class="dropdown">
                                    <button
                                        class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                        type="button" id="countryDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">

                                        <span id="selected-flag">
                                            {{ old('country_flag', $country[0]->flag1) }}
                                            

                                        </span>

                                        <span id="selected-code" class="ms-2">
                                            {{ old('country_code', $country[0]->dial_code) }}
                                        </span>
                                    </button>

                                    <ul class="dropdown-menu p-2 newcountrybox" aria-labelledby="countryDropdown">

                                        @foreach ($country as $index => $item)
                                            <li>
                                                <label
                                                    class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                    style="cursor: pointer;">
                                                    <input type="radio" name="country_code"
                                                        value="{{ $item->dial_code }}"
                                                        data-flag="{{ $item->flag1 }}"
                                                        data-name="{{ $item->name }}"
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
                                                        <span>{{ $item->flag1 }} {{ $item->dial_code }}
                                                            ({{ $item->name }})
                                                        </span>
                                                    </div>

                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                         </div> 
                         <div class="w-100 LoginMobileDesign">
                           <input type="text" class="form-control notapplyspace"  value="" placeholder="{{ __('user_messages.please_enter_mobile_number_or_email_address') }}" name="mobileOrEmail" id="LoginMobile"
                           />
                        </div>
                    </div>
                </div>
                <span class="text-danger" id="error-mobileOrEmail"></span>
                <div class="form-group position-relative password_icon mt-lg-3 mt-md-2 mt-1">
                    <label for="">{{ __('user_messages.password') }}</label>
                    <input type="password" name="password"  id="login-password" class="form-control custom-password notapplyspace"
                        placeholder="{{ __('user_messages.please_enter_password') }}" style="padding-right: 40px;"/>
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                  <span class="text-danger" id="error-password"></span>
                <p class=" mt-3 mb-4"><a href="{{route('userForgetPassword')}}">{{ __('user_messages.forgot_password') }}</a></p>
                <button type="submit" class="customBtn mb-3" id="loginButtom">{{ __('user_messages.login') }}</button>
            </form>
                <a class="customBtn2" style="text-decoration: none;" href="{{route('loginWithOtp')}}">{{ __('user_messages.login_via_otp') }}</a>
                <div class="accounts signUp">
                    <a class="text-center sign">{{ __('user_messages.or_sign_in_with') }}</a>
                </div>

                <div class="social-icon">
                    <a class="apple">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a class="facebook">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a class="google">
                        <i class="fa-brands fa-apple"></i>
                    </a>

                </div>
                 <p class="mt-3 dontAccount">{{ __('user_messages.do_not_have_an_account') }} <a href="{{route('userRegister')}}">{{ __('user_messages.sign_up_small') }}</a></p>
                 
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
            

            // document.addEventListener('DOMContentLoaded', function () {
            //     const radios = document.querySelectorAll('.country-radio');
            //     const selectedFlag = document.getElementById('selected-flag');
            //     const selectedCode = document.getElementById('selected-code');

            //     radios.forEach(radio => {
            //         radio.addEventListener('change', function () {
            //             const parent = this.closest('label');

            //             let flagImg = radio.data('flag');
           

            //             const flagImg = parent.querySelector('img').src;
            //             const dialCode = this.value;

            //             selectedFlag.innerHTML = `${flagImg}`;
            //             selectedCode.textContent = dialCode;
            //         });
            //     });
            // });

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



        $('#LoginMobile').on('keyup change', function () {
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



        $(document).on('submit', '#userLogin', function (e) {
            e.preventDefault();

            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('userLogin') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                             toastr.success(resp.message);
                        setTimeout(() => {
                             location.href = "/";
                        }, 1000);
                    }

                    if(resp.status == false){
                        for (const key in resp.errors) {
                            console.log(resp.errors[key])
                            $(`#error-${key}`).html(resp.errors[key]);
                        }   
                    }

                },
                error: function (xhr) {
                   toastr.error(xhr.responseJSON.message);
                },
                complete: function () {
                   $('#loginButtom').prop('disabled', false);
                }
            });
        });

     </script>

<!-- google translator code -->
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


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
            <div class="login_content_content">
            <form id="userLogin">
                @csrf
                <div class="d-flex align-items-center justify-content-between">
                    <h4>Sign In</h4>
                <p class="guest"><a href="{{route('dashboard')}}">Continue As a Guest</a></p>
                </div>
                <h3>Welcome back !</h3>
                <div class="form-group mt-lg-4 mt-md-3 mt-2">
                    <label for="">Mobile Number or Email Address</label>
                   
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
                           <input type="text" class="form-control notapplyspace"  value="" placeholder="Please enter mobile number or email address" name="mobileOrEmail" id="LoginMobile"
                           />
                        </div>
                    </div>
                </div>
                <span class="text-danger" id="error-mobileOrEmail"></span>
                <div class="form-group position-relative password_icon mt-lg-3 mt-md-2 mt-1">
                    <label for="">Password</label>
                    <input type="password" name="password"  id="login-password" class="form-control custom-password notapplyspace"
                        placeholder="Please enter password" style="padding-right: 40px;"/>
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                  <span class="text-danger" id="error-password"></span>
                <p class=" mt-3 mb-4"><a href="{{route('userForgetPassword')}}">Forgot password</a></p>
                <button type="submit" class="customBtn mb-3" id="loginButtom">Login</button>
            </form>
                <a class="customBtn2" style="text-decoration: none;" href="{{route('loginWithOtp')}}">Login Via OTP</a>
                <div class="accounts signUp">
                    <a class="text-center sign">Or Sign in with</a>
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
                 <p class="mt-3 dontAccount">Don’t have an account? <a href="{{route('userRegister')}}">Sign up</a></p>
                 
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

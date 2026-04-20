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
                <form id="resetPassword">
                    @csrf
                <input type="hidden" name="id" value="{{request()->temp_user_id}}">
                <div>
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> Reset Password</h3>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="createPassword">Create New Password</label>
                        <input type="password" id="createPassword" class="form-control custom-password notapplyspace"
                            placeholder="Enter New Password" style="padding-right: 40px;" name="password" />
                        <i class="fa-solid fa-eye toggle-passwordtwo" id="toggleCreate"></i>
                    </div>
                     <span class="text-danger" id="error-password"></span>


                    <div class="form-group position-relative password_icon mt-3">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-control custom-password notapplyspace"
                            placeholder="Enter confirm password" style="padding-right: 40px;" name="confirm_password" />
                        <i class="fa-solid fa-eye toggle-passwordtwo" id="toggleConfirm"></i>
                        {{-- <span class="text-danger" id="error-confirm_password"></span> --}}
                    </div>
                    <span class="text-danger" id="error-confirm_password"></span>

                    <button type="submit" class="customBtn customBtn5 mt-4">Done</a>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="passwordSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/images/success.svg" class="img-fluid" />
                    <p>Password Reset Successfully !</p>
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




        $(document).on('submit', '#resetPassword', function (e) {
            e.preventDefault();

            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('userCreatePassword') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                        $('#passwordSuccess').modal('show');
                        setTimeout(() => {
                            location.href = 'login'
                        },3000);
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


    <script>
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            const isPassword = input.getAttribute('type') === 'password';

            // Toggle between text/password
            input.setAttribute('type', isPassword ? 'text' : 'password');

            // Toggle the icon style
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
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
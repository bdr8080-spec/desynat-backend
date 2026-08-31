<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
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
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
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

    <div class="login-header des-language">
        <div class="des-logo">
            <a href="#">
                <!-- <img src="{{ asset('/dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login">  -->
                    <img src="{{ asset(app()->getLocale() == 'ar' ? 'dealer/assets/img/arabic-logo.svg' : 'dealer/assets/img/desynat-logo.svg') }}" class="img-fluid login" alt="Logo">
            </a>
        </div>
                                 <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                                        data-bs-toggle="dropdown">

                                                        <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                                        <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif </span>


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
                            <img src="{{ asset('/dealer') }}/assets/img/Desynat-logo-2.svg" alt="image"
                                class="img-fluid logo-login">
                        </div>
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-right.svg" alt="image"
                            class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2 signup-scroll pagescroll p-3">
                                <form action="{{ route('seller.register') }}" method="post" id="sellerRegisterForm">
                                    <h1>{{ __('seller_messages.sign_up') }} <br><span class="gold-color">{{ __('seller_messages.create_your_account') }}</span></h1>
                                    <div class="step-progress py-4">
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>

                                    <div class="upload-image w-100">
                                        <label id="uploadLabel" style="cursor:pointer;text-align:center;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                            <div>{{ __('seller_messages.upload_profile_photo') }}</div>
                                            <input type="file" accept="image/*" hidden onchange="showPreviewAndUpload(event)"
                                                id="edit_imageUpload">
                                        </label>
                                        <div class="imgshow">
                                            <img id="preview"
                                                style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                            <span id="remove" class="remove-ic"
                                                style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                onclick="removeImg()">&times;</span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="profile_pic" id="Profile_image" value="{{ old('profile_pic') }}">

                                    @error('profile_pic')
                                        <span class="text-danger" id="remove_error_message1">{{ $message }}</span>
                                    @enderror

                                    @csrf

                                    <div class="form-group">
                                        <label for="name">{{ __('seller_messages.first_name') }}</label>
                                        <input type="text" class="form-control notapplyspace"
                                            placeholder="{{ __('seller_messages.enter_first_name') }}" name="first_name"
                                            value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ __('seller_messages.last_name') }}</label>
                                        <input type="text" class="form-control notapplyspace"
                                            placeholder="{{ __('seller_messages.enter_last_name') }}" name="last_name"
                                            value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ __('seller_messages.email_address') }} </label>
                                        <input type="text" class="form-control notapplyspace"
                                            placeholder="{{ __('seller_messages.enter_email_address') }} " name="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group phone-pnl">
                                        <label for="name">{{ __('seller_messages.mobile_number') }} </label>

                                        <div class="form-group d-flex gap-2 w-100">
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                    type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">

                                                    <span id="selected-flag">{{ old('country_flag', $country[0]->flag) }}
                                                        <!-- <img src="{{ old('country_flag', $country[0]->flag1) }}"
                                                            alt="flag" width="25" height="16"> -->

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
                                                                <!-- <img src="{{ $item->flag }}"
                                                                    alt="Flag of {{ $item->name }}" width="25"
                                                                    height="16"> -->
                                                                    <div width="25" height="16">
                                                                        <span>
                                                                            <!-- <img src="{{ $item->flag1 }}" width="25" height="16">  -->
                                                                            {{ $item->flag }} {{ $item->dial_code }}
                                                                            (@if(App::getlocale()=='en'){{ $item->name }} @else {{ $item->name_ar }} @endif )
                                                                        </span>
                                                                    </div>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="w-100">
                                                <input class="form-control notapplyspace" type="number"
                                                    id="phone" placeholder="{{ __('seller_messages.enter_mobile_number') }}" name="mobile"
                                                    value="{{ old('mobile') }}"
                                                    oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">

                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            @error('country_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>


                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password">{{ __('seller_messages.create_password') }}</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="{{ __('seller_messages.enter_password') }}" name="password"
                                            value="{{ old('password') }}">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group position-relative">
                                        <label for="password">{{ __('seller_messages.confirm_password') }}</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="{{ __('seller_messages.enter_confirm_password') }}" name="confirm_password"
                                            value="{{ old('confirm_password') }}">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-check py-4">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="checkChecked" name="accept_terms"
                                            {{ old('accept_terms') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkChecked">
                                              {{ __('seller_messages.accept_terms_text') }} <span class="title-color">  {{ __('seller_messages.terms_conditions') }} </span>  {{ __('seller_messages.and') }} <span
                                                class="title-color">  {{ __('seller_messages.policies') }}</span>
                                        </label>

                                    </div>
                                    @error('accept_terms')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="login-btn">
                                        <input type="submit" name="submit" class="btn btn-success w-100 submit"
                                            value="{{ __('seller_messages.continue') }}">
                                    </div>
                                </form>

                                <div class="sign-new mt-2 text-center">
                                    <div>{{ __('seller_messages.already_have_account') }} <a href="{{ route('seller.login') }}"
                                            class="link-color"> {{ __('seller_messages.sign_in') }}</a></div>
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


</body>


<!-- Vendor JS Files -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>


<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>


<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("bi-eye bi-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>

<script>
    $(document).on('submit', '#sellerRegisterForm', function() {
        const submitButton = $(this).find('.submit');

        if (submitButton.data('locked')) {
            return false;
        }

        submitButton.data('locked', true).prop('disabled', true);
    });
</script>

<script>
    function removeImg() {
        preview.src = '';
        preview.style.display = 'none';
        remove.style.display = 'none';
        uploadLabel.style.display = 'block';
        $('#Profile_image').val('');

    }

    function showPreviewAndUpload(e) {
        const file = e.target.files[0],
            p = document.getElementById('preview'),
            r = document.getElementById('remove'),
            u = document.getElementById('uploadLabel');

        if (file) {
            // --- Preview the image ---
            const reader = new FileReader();
            reader.onload = x => {
                p.src = x.target.result;
                p.style.display = 'block';
                r.style.display = 'inline';
                u.style.display = 'none';
            };
            reader.readAsDataURL(file);

            // --- Upload via AJAX ---
            let formData = new FormData();
            formData.append('image', file);

            let name = file.name;
            sessionStorage.setItem('uploadedFileName', name);
            $("#fileName").text(name);

            $('#remove_error_message1').empty(); // remove error message


            $.ajax({
                method: 'POST',
                url: "/api/upload",
                headers: {
                    'Accept-Language': 'en'
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    window.setTimeout(function() {
                        $('.submit').attr('disabled', false);
                        $('.form-control').attr('readonly', false);
                        $('.form-control').removeClass('disabled-link');
                        $('.error-control').removeClass('disabled-link');
                        $('.submit').html('Add');
                    }, 2000);

                    if (resp.status === 'success') {
                        sessionStorage.setItem('FileUrl', resp.data);
                        $('#Profile_image').val(resp.data.url);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // ✅ Reset input so same image can be selected again
        e.target.value = '';
    }

    // Attach event listener
    $(document).on('change', '#edit_imageUpload', showPreviewAndUpload);

    // Optional: remove button logic
    $(document).on('click', '#remove', function() {
        $('#preview').hide().attr('src', '');
        $('#remove').hide();
        $('#uploadLabel').show();
        $('#fileName').text('');
        $('#Profile_image').val('');
    });


    $(document).ready(function() {

        let oldImage = $('#Profile_image').val();

        if (oldImage) {

            $('#preview').attr('src', oldImage).show();

            $('#remove').show();

            $('#uploadLabel').hide();
        }
        // When user types in any input or textarea
        $(document).on('input', '.form-control, .form-check-input', function() {
            // Check if input has a value (not empty)
            if ($(this).val().trim() !== '') {
                // Remove the nearby error message
                $(this).closest('.form-group').find('.text-danger').fadeOut(200, function() {
                    $(this).remove();
                });
            }
        });
    });
</script>

<script>
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

    document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('.country-radio');
                const selectedFlag = document.getElementById('selected-flag');
                const selectedCode = document.getElementById('selected-code');

                // radios.forEach(radio => {
                //     radio.addEventListener('change', function () {
                //         const parent = this.closest('label');
                //         const flagImg = parent.querySelector('img').src;
                //         const dialCode = this.value;

                //         selectedFlag.innerHTML = `<img src="${flagImg}" width="25" height="16">`;
                //         selectedCode.textContent = dialCode;
                //     });
                // });

                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        const parent = this.closest('label');
                        const text = parent.querySelector('span').innerText.trim();
                        const flag = text.split(' ')[0];
                        selectedFlag.textContent = flag;
                        selectedCode.textContent = this.value;
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


{{-- @include('dealer.custom_code'); --}}

@include('dealer.layout.custom_code')



</html>

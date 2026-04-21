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
        <div class="dropdown-center mobileLang">
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
    </header>
    <div class="login_content login_content_left">
        <img src="assets/images/left-img.svg" class="left-imgone" />
        <img src="assets/images/logoone.svg" class="left-img" />
        <img src="assets/images/right-img.svg" class="left-imgtwo" />
    </div>
    <div class="login_content login_content_right">

        <div class="login_content_content">
            <form id="signup">
                @csrf
                <h4>Sign Up</h4>
                <h3>Create your account !</h3>

                <div class="upload-image w-100">
                    <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                        <img src="{{ asset('user/assets/images/upload-icon.svg') }}">
                        <div class="text-color-upload">Upload profile image</div>
                        <input type="file" accept="image/*" name="image" enctype="multipart/form-data" hidden
                            onchange="showPreview(event)">
                    </label>
                    <div class="imgshow">
                        <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                        <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;"
                            onclick="removeImg()">&times;</span>
                    </div>
                </div>

                <!-- <input type="file" name="image" enctype="multipart/form-data"> -->
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">Full Name</label>
                    <input type="text" name="full_name" class="form-control custom-password blockFirstTime"
                        placeholder="Enter Full Name" style="padding-right: 40px;" />
                </div>
                <span class="text-danger" id="error-full_name"></span>

                <div class="form-group mt-3">
                    <label class="d-block" for="">Mobile Number</label>
                    <div class="d-flex align-items-center">
                        <div class="">
                            {{-- <select name="country_code" id="" class="country" class="form-control">
                                @foreach ($country as $item)                       
                                    <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                            @endforeach
                            </select> --}}

                            <div class="dropdown">
                                <button
                                    class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                    type="button" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">

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
                                        <label class="dropdown-item d-flex align-items-center gap-2 country-option"
                                            style="cursor: pointer;">
                                            <input type="radio" name="country_code" value="{{ $item->dial_code }}"
                                                data-flag="{{ $item->flag1 }}" data-name="{{ $item->name }}"
                                                class="country-radio"
                                                {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                hidden>

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
                        <div class="w-100">
                            <input type="number" class="form-control" value="" placeholder="Enter Mobile Number"
                                name="mobile"
                                oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">
                        </div>
                    </div>
                    {{-- <input type="hidden" value="+91" name="country_code" id="country_code"> --}}
                </div>
                <span class="text-danger" id="error-mobile"></span>
                <div class="form-group position-relative verify mt-3">
                    <label class="d-block" for="">Email Address</label>
                    <input type="text" class="form-control custom-password notapplyspace"
                        placeholder="Please enter email address" style="padding-right: 40px;" name="email" />
                </div>
                <span class="text-danger" id="error-email"></span>
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">Create Password</label>
                    <input type="password" id="login-password" class="form-control custom-password notapplyspace"
                        placeholder="Please enter password" style="padding-right: 40px;" name="password" />
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                <span class="text-danger" id="error-password"></span>
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">Confirm Password</label>
                    <input type="password" id="login-password" class="form-control custom-password notapplyspace"
                        placeholder="Please enter confirm password" style="padding-right: 40px;"
                        name="confirm_password" />
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                <span class="text-danger" id="error-confirm_password"></span>
                <div class="form-check term_policy my-3">
                    <input class="form-check-input" type="checkbox" value="1" id="checkIndeterminate"
                        name="accept_terms">
                    <label class="form-check-label" for="checkIndeterminate">
                        I accept the <a href="">Terms & Conditions</a> and <a href="">Policies</a>
                    </label>
                </div>
                <span class="text-danger" id="error-accept_terms"></span>
                <button type="submit" class="customBtn" id="signBtn">Sign Up</button>
            </form>
            <p class="mt-3 dontAccount">Don’t have an account? <a href="{{ route('userLogin') }}">Sign In</a></p>
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
$(document).on('submit', '#signup', function(e) {
    e.preventDefault();

    let data = new FormData(this);

    $('#signBtn').prop('disabled', true);


    $.ajax({
        url: "{{ route('userRegister') }}",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(resp) {

            if (resp.status == true) {
                toastr.success(resp.message);
                setTimeout(() => {
                    location.href = `verify-otp?temp_user_id=${resp.id}`;
                }, 1000);

            }

            if (resp.status == false) {
                for (const key in resp.errors) {
                    $(`#error-${key}`).html(resp.errors[key]);
                }
            }

        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        },
        complete: function() {
            $('#signBtn').prop('disabled', false);
        }
    });
});


function showPreview(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(x) {
            $('.preview').attr('src', x.target.result).show();
            $('.removeIcon').show();
            $('.uploadLabel').hide();
        };
        reader.readAsDataURL(file);
    }
}

function removeImg() {
    $('.preview').attr('src', '').hide();
    $('.removeIcon').hide();
    $('.uploadLabel').show();
}



// document.addEventListener('DOMContentLoaded', function() {
//     const radios = document.querySelectorAll('.country-radio');
//     const selectedFlag = document.getElementById('selected-flag');
//     const selectedCode = document.getElementById('selected-code');

//     radios.forEach(radio => {
//         radio.addEventListener('change', function() {
//             const parent = this.closest('label');
//             const flagImg = parent.querySelector('img').src;
//             const dialCode = this.value;

//             selectedFlag.innerHTML = `<img src="${flagImg}" width="25" height="16">`;
//             selectedCode.textContent = dialCode;
//         });
//     });
// });

$(document).ready(function() {
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const restrictedInputs = document.querySelectorAll('.blockFirstTime');

    restrictedInputs.forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === ' ' && this.value.length === 0) {
                e.preventDefault();
            }
        });

        input.addEventListener('input', function() {
            if (this.value.startsWith(' ')) {
                this.value = this.value.trimStart();
            }
        });
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
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
    <div class="login-header des-language">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
                                 <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                                        data-bs-toggle="dropdown">

                                                        <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                                        <span id="currentLang">@if(app()->getLocale()=='en') En @else AR @endif </span>


                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end langu">

                                                        <li>
                                                            <a class="dropdown-item" data-lang="ar" href="{{route('sellerLanguage','ar')}}" >
                                                                <span>AR</span> {{ __('seller_messages.Arabic') }} 
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" data-lang="en"  href="{{route('sellerLanguage','en')}}" >
                                                                <span>EN</span> {{ __('seller_messages.English') }} 
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
                                <form method="POST" action="{{ route('seller.create_password', Request()->id) }}">
                                    <div class="cmn-header mb-3">
                                        <h1><a href="otp_verify.php"><i class="bi bi-chevron-left"></i></a> {{ __('seller_messages.Reset_Password') }}</h1>
                                    </div>
                                    @csrf

                                    @error('error')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group position-relative">
                                        <label for="password">{{ __('seller_messages.Create_New_Password') }}</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="{{ __('seller_messages.Enter_new_password') }}" name="password">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password">{{ __('seller_messages.Confirm_Password') }}</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="{{ __('seller_messages.Enter_confirm_password') }}" name="confirm_password">
                                        <i class="toggle-password  bi bi-eye-slash "></i>

                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="login-btn padding-top-60">
                                        {{-- <a href="#" class="btn btn-success w-100" data-bs-toggle="modal"
                                            data-bs-target="#alertModal">{{ __('seller_messages.Done') }}</a> --}}
                                        <input type="submit" value="{{ __('seller_messages.Done') }}" class="btn btn-success w-100">

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-radious-20 w-75">
                <div class="modal-body  p-3">
                    <div class="alertbody text-center">
                        <img src="{{ asset('dealer') }}/assets/img/success.svg" alt="image" class="img-fluid py-4">
                        <h3>{{ __('seller_messages.Password_Reset_Successfully') }}</h3>
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



@include('dealer.layout.footer');

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



</html>

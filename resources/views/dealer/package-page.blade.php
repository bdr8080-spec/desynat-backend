<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> desynat seller </title>
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/favicon.png" rel="icon">
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
    <div class="login-header">
        <div class="des-logo">
            <a href="{{ route('seller.dashboard') }}"><img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg"
                    alt="image" class="img-fluid logo-login"> </a>
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
        <div class="login-grid-bg2 planheight"></div>
        <div class="container">
            <div class="plan-wapper">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="plan-card plan-shadow plan-circle">
                            <div class="plan-circle plan-shadow p-3">
                                <div class="pkg-list">
                                     <h6>{{ __('seller_messages.Package_Name') }}</h6>
                                    <h6 class="font-600">
                                    @if(App::getlocale()=='en')    
                                        {{ $plans->plan_name_english }}
                                    @else
                                        {{ $plans->plan_name_arabic }}
                                    @endif
                                </h6>
                            
                                </div>
                                
                                <!-- <div class="pkg-list">
                                    <h6>Price</h6>
                                    <h6 class="font-600">{{ $plans->price }}  KD  </h6>
                                </div>
                                <div class="pkg-list">
                                    <h6>Duration</h6>
                                    <h6 class="font-600">{{ $plans->duration }} @if ($plans->duration_type == '1')
                                            Month
                                        @else
                                            Year
                                        @endif
                                    </h6>
                                </div> -->
                                @php
                                if ($plans->duration_type == '1') {
                                    $amount = $plans->price;
                                } else {
                                    if (!empty($plans->no_of_free_months) && $plans->no_of_free_months > 0) {
                                        $paidMonths = 12 - $plans->no_of_free_months;
                                        $amount = $paidMonths * $plans->price;
                                    } else {
                                        $amount = 12 * $plans->price;
                                    }
                                }

                                $amount = round($amount, 2);
                            @endphp

                            <div class="pkg-list">
                                <h6>{{ __('seller_messages.Price') }}</h6>
                                <h6 class="font-600">{{ number_format($amount, 2) }} {{ __('seller_messages.KD') }}</h6>
                            </div>

                            <div class="pkg-list">
                                <h6>{{ __('seller_messages.Duration') }}</h6>
                                <h6 class="font-600">
                                    {{ $plans->duration }}
                                    @if ($plans->duration_type == '1')
                                        {{ __('seller_messages.Month') }}
                                    @else
                                          {{ __('seller_messages.Year') }}
                                    @endif
                                </h6>
                            </div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg"> {{ __('seller_messages.Number_of_Products') }}:
                                        <span class="font-600">{{ $plans->no_of_products }}</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">  {{ __('seller_messages.Number_of_Videos_Reels') }}:
                                       <span class="font-600">{{ $plans->no_of_videos }}</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">{{ __('seller_messages.Number_of_Highlights') }}:
                                        <span class="font-600">{{ $plans->no_of_highlights }}</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">{{ __('seller_messages.No_of_Stories') }}:

                                    <span class="font-600">{{ __('seller_messages.Unlimited') }}</span
                                        </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">{{ __('seller_messages.No_of_Employees') }}:
                                    <span class="font-600">{{ $plans->no_of_employee }}</span
                                    </li>
                                    @if ($plans->commission == '1')
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">{{ __('seller_messages.Commission') }}:
                                        <span class="font-600">{{ $plans->commission_percentage }}%</span>
                                    </li>
                                    @endif
                                    @if (!empty($plans->no_of_free_months))
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg"> {{ __('seller_messages.No_Of_Free_Months') }}:
                                            <span class="font-600">{{ $plans->no_of_free_months }} </span>
                                        </li>
                                    @endif
                                    
                                </ul>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-5 col-md-6">

                        <form action="{{ route('seller.create_subcription') }}" method="post">

                            <input type="hidden" name="plan_id" value="{{ $plans->id }}">
                            @csrf
                            <div class="plan-card plan-shadow plan-circle">
                                <div class="plan-body p-3 pt-4">
                                    <div class="cmn-header">
                                        <h1><a href="#"><i class="bi bi-chevron-left"></i></a>  {{ __('seller_messages.Payment_method') }}</h1>
                                    </div>
                                    <div class="payment py-3"> {{ __('seller_messages.SELECT_PAYMENT_METHOD') }}</div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            value="Myfatoorah" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            {{ __('seller_messages.Myfatoorah') }}
                                        </label>
                                    </div>

                                    @error('payment_method')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @php
                                        if ($plans->duration_type == '1') {
                                            $amount = $plans->price;
                                        } else {
                                            if (!empty($plans->no_of_free_months) && $plans->no_of_free_months > 0) {
                                                $paidMonths = 12 - $plans->no_of_free_months;
                                                $amount = $paidMonths * $plans->price;
                                            } else {
                                                $amount = 12 * $plans->price;
                                            }
                                        }

                                        $amount = round($amount, 2);
                                    @endphp

                                    <div class="total-pnl mt-4">
                                        <div class="tamount">{{ __('seller_messages.Total_Amount') }}</div>
                                        <div class="price-kd"> {{ $amount }} {{ __('seller_messages.KD') }}</div>
                                    </div>


                                    <div class="py-3 mt-3">

                                        <input type="submit" name="submit" value="{{ __('seller_messages.Pay_Now') }}"
                                            class="btn btn-success w-100">

                                        {{-- <a href="package-page.php" class="btn btn-success w-100">{{ __('seller_messages.Pay_Now') }}</a> --}}
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{ asset('dealer') }}/assets/img/success.svg" alt="icon" class="img-fluid">
                        <div class="title24 py-3"> {{ __('seller_messages.Plan_Purchased_Successfully') }}</div>
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


<!--Main JS File -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/main.js"></script>

@include('dealer.layout.custom_code');


<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success1'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            setTimeout(function () {
                window.location.href = "{{ route('seller.subscriptionPlan') }}";
            }, 1500);
            
        @endif
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

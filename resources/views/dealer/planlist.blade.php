<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> desynat seller </title>
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
    <div class="login-header">
        <div class="des-logo">
            <a href="{{ route('seller.dashboard') }}">
                <!-- <img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg"
                    alt="image" class="img-fluid logo-login">  -->
                    <img src="{{ asset(app()->getLocale() == 'ar' ? 'dealer/assets/img/arabic-logo.svg' : 'dealer/assets/img/desynat-logo.svg') }}" class="img-fluid login" alt="Logo">
            </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
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
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="login-wapper">
        <div class="login-grid-bg2 planheight"></div>
        <div class="container-fluid custom-container">
            <div class="plan-wapper">
                <div class="row">

                    @php
                        // Define your color set
                        $back_color = [
                            '#ffc107',
                            '#fd7e14',
                            '#d63384',
                            '#212529',
                            '#6610f2',
                            '#198754',
                            '#dc3545',
                            '#dc3545',
                            '#664d03',
                            '#0a3622',
                            '#198754',
                            '#20c997',
                        ];

                        // Shuffle the colors once so they appear in random order
                        shuffle($back_color);
                    @endphp


                    @foreach ($plans as $key => $item)
                        @php
                            // Pick a random color for each plan
                            $color = $back_color[$key % count($back_color)];

                        @endphp

                        <div class="col-lg-3 col-md-4 d-flex justify-items-stretch mb-4">
                            <div class="plan-card plan-shadow w-100 position-relative h-100">
                                <div class="plan-header  text-center " style="background-color: {{ $color }}">

                                    {{ $item->plan_name_english }}

                                </div>
                                <!-- <div class="plan-content text-center plan-shadow">
                                    <h4> {{ $item->price }} KD </h4>
                                    <div>for {{ $item->duration }} @if ($item->duration_type == '1')
                                            Month
                                        @else
                                            Year
                                        @endif
                                    </div>
                                </div> -->
                                @php
                                    if ($item->duration_type == '1') {
                                        // Monthly
                                        $amount = $item->price;
                                    } else {
                                        // Yearly
                                        if (!empty($item->no_of_free_months) && $item->no_of_free_months > 0) {
                                            $paidMonths = 12 - $item->no_of_free_months;
                                            $amount = $paidMonths * $item->price;
                                        } else {
                                            $amount = 12 * $item->price;
                                        }
                                    }

                                    $amount = round($amount, 2);
                                @endphp

                                <div class="plan-content text-center plan-shadow">
                                    <h4>{{ number_format($amount, 2) }} KD</h4>

                                    <div>
                                        for {{ $item->duration }}
                                        @if ($item->duration_type == '1')
                                            Month
                                        @else
                                            Year
                                        @endif
                                    </div>
                                </div>

                                <div class="plan-body p-3">
                                    <ul class="list-inline">
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Products:
                                            <span class="font-600">{{ $item->no_of_products }}</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Videos
                                            (Reels)
                                            : <span class="font-600">{{ $item->no_of_videos }}</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Highlights:
                                            <span class="font-600">{{ $item->no_of_highlights }} </span>
                                        </li>

                                        @if ($item->stories == '1')
                                            <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">
                                                15 stories
                                                within
                                                24
                                                hours</li>
                                        @endif

                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store
                                            Employees
                                        </li>

                                        @if ($item->commission == '1')
                                            <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                                <span class="font-600">{{ $item->commission_percentage }} %</span>
                                            </li>
                                        @endif

                                        @if (!empty($item->no_of_free_months))
                                            <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">No Of free Months :
                                                <span class="font-600">{{ $item->no_of_free_months }} </span>
                                            </li>
                                        @endif

                                    </ul>
                                    <div class="py-3 btn-purchase">
                                        <a href="{{ route('seller.single_plans', $item->id) }}" class="btn btn-success w-100">Purchase</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    {{-- <div class="col-lg-3 col-md-4">
                        <div class="plan-card plan-shadow">
                            <div class="plan-header bg-yellow-2 text-center">Pro Package</div>
                            <div class="plan-content text-center plan-shadow">
                                <h4>KD 250.00</h4>
                                <div>for 1 Month</div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Products:
                                        <span>120</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                        (Reels): <span>60</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                        Highlights: <span>10</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within 24
                                        hours</li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store Employees
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                        <span>2.5%</span>
                                    </li>
                                </ul>
                                <div class="py-3">
                                    <a href="#" class="btn btn-success w-100">Purchase</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="plan-card plan-shadow">
                            <div class="plan-header bg-yellow-3 text-center">Plus Package</div>
                            <div class="plan-content text-center plan-shadow">
                                <h4>KD 250.00</h4>
                                <div>for 1 Month</div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Products:
                                        <span>120</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                        (Reels): <span>60</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                        Highlights: <span>10</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within 24
                                        hours</li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store Employees
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                        <span>2.5%</span>
                                    </li>
                                </ul>
                                <div class="py-3">
                                    <a href="#" class="btn btn-success w-100">Purchase</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="plan-card plan-shadow">
                            <div class="plan-header bg-yellow-4 text-center">Growth Package</div>
                            <div class="plan-content text-center plan-shadow">
                                <h4>KD 250.00</h4>
                                <div>for 1 Month</div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Products:
                                        <span>120</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                        (Reels): <span>60</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                        Highlights: <span>10</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within 24
                                        hours</li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store Employees
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                        <span>2.5%</span>
                                    </li>
                                </ul>
                                <div class="py-3">
                                    <a href="#" class="btn btn-success w-100">Purchase</a>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('seller.skip_plan') }}" class="link-color">Skip</a>
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
                        <div class="title24 py-3">Your Payment is failed</div>
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



<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success1'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
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

@include('dealer.layout.custom_code');

</html>

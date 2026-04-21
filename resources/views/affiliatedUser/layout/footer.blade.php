</main>
     <style>
.notification-pnl.read {
    opacity: 0.7;
}

.notification-pnl.not-clickable {
    pointer-events: none;
    cursor: default;
}

/* Optional: keep unread visually distinct */
.notification-pnl.unread {
    background-color: #f1f7ff;
    border-left: 4px solid #0d6efd;
    cursor: pointer;
}
</style>

<!-- app story -->
<!-- <div class="storywapper" style="display:none;">
    <div class="container">
        <div class="modal-content-2 pt-5">
            <div class="story-header d-flex justify-content-between">
                <h3>Story </h3>
                <button type="button" id="btnclose"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <div class="status-panel">
                    <div class="owl-carousel owl-theme storeBanner">
                        <div class="item">
                            <div class="sellerstatus">
                                <img src="{{ asset('dealer') }}/assets/img/reel-1.svg" alt="banner" class="img-fluid" />
                            </div>
                        </div>
                        <div class="item">
                            <div class="sellerstatus">
                                <img src="{{ asset('dealer') }}/assets/img/reel-3.svg" alt="banner" class="img-fluid" />
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div> -->

 <!-- WhatsApp Status Viewer -->
  
 <div class="status-viewer bgwhite" id="statusViewer">
 <span class="status-close mt-3" onclick="closeStatus()">Skip</span>
    <div class="logostatus">
        <div id="progressContainer" class="progress-container"></div>
        <div class="status-img">
            <img id="statusImage" class="img-fluid" alt="status" />
        </div>
    </div>    
    <div class="status-left" onclick="showPrev()">
        <span> <i class="fa-solid fa-chevron-left"></i></span>
    </div>
    <div class="status-right" onclick="showNext()">
        <span><i class="fa-solid fa-chevron-right"></i> </span>
    </div>
   
</div>

    <!-- Notification Management -->

@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Notification;

    $notifications = [];

    if (Auth::guard('affilated_user')->check()) {
        $userId =Auth::guard('affilated_user')->user()->id;

        $notifications = Notification::where('receiver_id', $userId)
            ->where('receiver_type', '4')
            ->orderBy('id', 'desc')
            ->get();
    }
@endphp

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="notificationDialogAffiliateUser">
    
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Notifications</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">

        @forelse($notifications as $notification)

            <div class="notification-pnl d-flex gap-3 mb-3 
                {{ $notification->is_read == 0 ? 'unread clickable' : 'read not-clickable' }}"
                
                data-id="{{ $notification->id }}"
            >

                <!-- ICON -->
                <div>
                    <div class="bell-icon-1">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="noti-content w-100">

                    <div class="noti-header d-flex justify-content-between">
                        <div class="noti-title">
                            {{ $notification->title_english ?? 'Notification' }}
                        </div>

                        <div class="post-date">
                            {{ \Carbon\Carbon::parse($notification->created_at)->format('M d, h:i A') }}
                        </div>
                    </div>

                    <p>
                        {{ $notification->description_english }}
                    </p>

                </div>

            </div>

            @empty
            <div class="text-center text-muted">
                No notifications found
            </div>
            @endforelse

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


<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>
<!--Main JS File -->
<script src="{{ asset('dealer') }}/assets/custom-file/table-lib/table-data.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/main.js"></script>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- jQuery (required by Toastr) -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- <script>
    
$(document).on('click', '#storyModal', function(e) {
    e.preventDefault();
    $('.storywapper').toggle();
});

$(document).on('click', '#btnclose', function() {
    $('.storywapper').hide();
});

$('.storeBanner').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    dots: true,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
        }
    }
})
</script> -->

<script>
var images = [
    "{{asset('user')}}/assets/images/store1.jpg",
    "{{asset('user')}}/assets/images/item-1.svg",
    "{{asset('user')}}/assets/images/item-2.svg",
    "{{asset('user')}}/assets/images/store1.jpg",
    "{{asset('user')}}/assets/images/store1.jpg",
    "{{asset('user')}}/assets/images/store1.jpg"
];

var currentIndex = 0;
var timer = null;
var duration = 3000;

function openGallery(index) {
    currentIndex = index;
    document.getElementById("statusViewer").style.display = "flex";
    generateProgressBars();
    showImage();
}

function generateProgressBars() {
    const container = document.getElementById("progressContainer");
    container.innerHTML = "";
    images.forEach((img, i) => {
        container.innerHTML += `
            <div class="progress-bar">
                <div class="progress-fill" id="bar${i}"></div>
            </div>
        `;
    });
}

function showImage() {
    document.getElementById("statusImage").src = images[currentIndex];
    startProgress();
}

function startProgress() {
    clearTimeout(timer);
    // Reset all bars
    document.querySelectorAll(".progress-fill").forEach(bar => {
        bar.style.width = "0%";
        bar.style.transition = "none";
    });
    setTimeout(() => {
        let bar = document.getElementById("bar" + currentIndex);
        bar.style.transition = `${duration}ms linear`;
        bar.style.width = "100%";
    }, 10);

    timer = setTimeout(() => {
        showNext();
    }, duration);
}

function showNext() {
    if (currentIndex < images.length - 1) {
        currentIndex++;
        showImage();
    } else {
        closeStatus(); 
    }
}

function showPrev() {
    if (currentIndex > 0) {
        currentIndex--;
        showImage();
    }
}

function closeStatus() {
    clearTimeout(timer);
    document.getElementById("statusViewer").style.display = "none";
}

</script>


<script>
@if(session('success'))
toastr.success("{{ session('success') }}");
@endif

@if(session('error'))
toastr.error("{{ session('error') }}");
@endif

@if(session('warning'))
toastr.warning("{{ session('warning') }}");
@endif

@if(session('info'))
toastr.info("{{ session('info') }}");
@endif
</script>

<!-- mark notification as read -->
<script>
$(document).ready(function () {

    $(".notification-pnl.unread").on("click", function () {

        let notificationId = $(this).data("id");
        let element = $(this);

        if (!notificationId) return;

        $.ajax({
            url: "{{ route('affiliate.mark_notification_as_read') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                notification_id: [notificationId]
            },
            success: function (res) {

                if (res.status === "success") {

                    toastr.success(res.message || "Marked as read");
                    element.removeClass("unread clickable")
                           .addClass("read not-clickable");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else {
                    toastr.error(res.message || "Something went wrong");
                }

            },
            error: function () {
                toastr.error("Something went wrong");
            }
        });

    });

});
</script>

         <!-- Firebase geberate Token and Save token Code  -->




     <script type="module">
import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js";
import {
    getMessaging,
    getToken,
    onMessage
} from "https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyCYQyk6P8Gpp6YA7HgLE_Gf_aXDxze_big",
    authDomain: "desynat.firebaseapp.com",
    databaseURL: "https://desynat-default-rtdb.firebaseio.com",
    projectId: "desynat",
    storageBucket: "desynat.firebasestorage.app",
    messagingSenderId: "89320198276",
    appId: "1:89320198276:web:1d3c84f812a338529d32d1",
    measurementId: "G-7MVP5BHENE"
};


const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Ask user for notification permission
Notification.requestPermission().then((permission) => {
    if (permission === 'granted') {
        console.log('Notification permission granted.');

        getToken(messaging, {
            vapidKey: "BBPk2muPnGI7gfY99rJLaHaUyQhB2HqWS_87X3VtjU_EzQFymAd742YmWH6SkApA-3javZ5JqIRfr9ERqS5FSiU"
        }).then((currentToken) => {
            if (currentToken) {
                console.log("Device Token:", currentToken);

                // save Token Code
                $.ajax({
                    url: "{{ url('affiliate-save-token') }}",
                    type: "get",
                    dataType: 'json',
                    data: {
                        token: currentToken,
                    },
                    success: function(response) {
                        $('#user_loder').hide();
                        if (response.success) {

                            console.log(response);

                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#user_loder').hide();
                        // toastr.error("Error occurred: " + xhr.responseText);
                    }
                });

                // save Token Code end Here



                // send to server
            } else {
                console.log('No registration token available.');
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
        });

    } else {
        console.log('Notification permission not granted.');
    }
});


onMessage(messaging, (payload) => {
    console.log('Foreground message:', payload);
    const {
        title,
        body
    } = payload.notification;

    new Notification(title, {
        body: body,
        icon: '/icon.png',
    });
});
     </script>

<!-- translator -->
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

</body>

</html>
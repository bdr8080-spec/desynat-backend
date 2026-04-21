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
<!-- Notification Management -->

@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Notification;

    $notifications = [];

    if (Auth::guard('seller')->check()) {
        $sellerId = Auth::guard('seller')->user()->id;

        $notifications = Notification::where('receiver_id', $sellerId)
            ->where('receiver_type', '3')
            ->orderBy('created_at', 'desc')
            ->get();
    }
@endphp

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="notificationDialog">
    
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

<!-- Seller story section
<div class="status-viewer bgwhite" id="statusViewer">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <h3>Story </h3>
            <button type="button" class="btn btn-light" onclick="closeStatus()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <div id="progressContainer" class="progress-container"></div>
            <div class="status-img">
                <img id="statusImage" class="img-fluid" alt="status" />
            </div>
        </div>    
    </div>
</div> -->

  <!-- Admin logo story section -->
<div class="status-viewer bgwhite" id="statusAdmin">
    <div class="container adminstatus">
        <div class="story-header d-flex justify-content-between">
            <div></div>
            <button type="button" class="btn btn-light" onclick="closeStatus()"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="logostatus">
            <div id="progressContainer" class="progress-container"></div>
            
            <div class="status-img">
                <img id="statusImage" class="img-fluid" alt="status" />
                <video id="statusVideo" style="max-width: 100%; max-height: 400px; display: none;" controls></video>
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


<script>
var stories = null;   
var currentIndex = 0;
var timer = null;
var duration = 3000;
var redirected = false;  


function loadAdminStories(openIndex = 0, callback) {

    if (stories !== null || redirected) {
        if (callback) callback();
        return;
    }

    // Ensure jQuery is loaded
    if (typeof $ === "undefined") {
        return;
    }

    $.ajax({
        url: "{{ route('seller.get_admin_story') }}",  // Blade route
        type: "GET",
        dataType: "json",
        success: function (res) {

            if (res.status === "success" && Array.isArray(res.data.data)) {
                stories = res.data.data;
            } else {
                stories = [];
            }

            // var profileDiv = document.querySelector('.storeClient_profile_img');

            // if (sellerStories.length > 0) {
            //     if(profileDiv){
            //         profileDiv.classList.add('story-active');
            //     }
            // } else {
            //     if(profileDiv){
            //         profileDiv.classList.remove('story-active');
            //     }
            // }

            var areaEl = document.getElementById('adminStoryArea');
            if (areaEl) {
                areaEl.classList.toggle('story-active', stories.length > 0);
            }

            if (stories.length === 0) {
                redirected = true;
                //window.location.href = "{{ route('dashboard') }}";
                return;  
            }

            if (callback) callback();
        },
        error: function (err) {
            stories = [];  
            if (callback) callback();
        }
    });
}

function onAdminIconClick(index = 0) {

    if (redirected) {
        return;
    }

    if (stories === null) {
        loadAdminStories(index, function() {
            if (!redirected && stories.length > 0) {
                openGallery(index);
            }
        });
    } else if (stories.length > 0) {
        openGallery(index);
    } else {
        redirected = true;
        //window.location.href = "{{ route('dashboard') }}";
    }
}

// OPEN VIEWER
function openGallery(index) {
    currentIndex = index;

    if (!stories || stories.length === 0) {
        //window.location.href = "{{ route('dashboard') }}";
        return;
    }

    var statusAdmin = document.getElementById("statusAdmin");
    if (!statusAdmin) {
        return;
    }

    statusAdmin.style.display = "block";

    generateProgressBars();
    showStory();
}

//  GENERATE PROGRESS BARS
function generateProgressBars() {
    const container = document.getElementById("progressContainer");
    if (!container) {
        console.error("[ERROR] #progressContainer element not found!");
        return;
    }

    container.innerHTML = "";

    stories.forEach((s, i) => {
        container.innerHTML += `
            <div class="progress-bar">
                <div class="progress-fill" id="bar${i}"></div>
            </div>
        `;
    });
}

//  SHOW STORY
function showStory() {
    let story = stories[currentIndex];

    if (!story) {
        closeStatus();
        return;
    }

    let img = document.getElementById("statusImage");
    let video = document.getElementById("statusVideo");

    if (!img || !video) {
        return;
    }

    img.style.display = "none";
    video.style.display = "none";
    video.pause();
    video.currentTime = 0;

    let file = story.file;

    if (!file) {
        showNext();
        return;
    }

    if (file.match(/\.(mp4|webm|ogg)$/i)) {
        video.src = file;
        video.style.display = "block";

        video.onloadedmetadata = function () {
            duration = (video.duration * 1000) || 3000;
            startProgress();
            video.play();
        };
    } else {
        img.src = file;
        img.style.display = "block";
        duration = 3000;
        startProgress();
    }
}

// START PROGRESS
function startProgress() {
    clearTimeout(timer);

    document.querySelectorAll(".progress-fill").forEach(bar => {
        bar.style.width = "0%";
        bar.style.transition = "none";
    });

    setTimeout(() => {
        let bar = document.getElementById("bar" + currentIndex);
        if (bar) {
            bar.style.transition = `${duration}ms linear`;
            bar.style.width = "100%";
        }
    }, 10);

    timer = setTimeout(() => {
        showNext();
    }, duration);
}

//  NEXT STORY
function showNext() {
    if (currentIndex < stories.length - 1) {
        currentIndex++;
        showStory();
    } else {
        closeStatus();
    }
}

//  PREVIOUS STORY
function showPrev() {
    if (currentIndex > 0) {
        currentIndex--;
        showStory();
    }
}

// CLOSE VIEWER
function closeStatus() {
    clearTimeout(timer);

    let video = document.getElementById("statusVideo");
    if (video) {
        video.pause();
        video.currentTime = 0;
    }

    let statusAdmin = document.getElementById("statusAdmin");
    if (statusAdmin) {
        statusAdmin.style.display = "none";
    }
}
</script>



<script>
    document.querySelectorAll('.notapplyspace').forEach(function(input) {
        input.addEventListener('keydown', function(e) {
            if (e.key === ' ') {
                e.preventDefault();
            }
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



    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if (session('info'))
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
            url: "{{ route('seller.mark_notification_as_read') }}",
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
                    url: "{{ url('seller-save-token') }}",
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

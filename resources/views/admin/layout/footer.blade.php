<footer>
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Models\Notification;

        $adminNotifications = [];
        $adminNotificationCount = 0;

        if (Auth::guard('admin')->check()) {
            $adminId = Auth::guard('admin')->user()->id;

            $adminNotifications = Notification::where('receiver_id', $adminId)
                ->where('receiver_type', '1')
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get();

            $adminNotificationCount = Notification::where('receiver_id', $adminId)
                ->where('receiver_type', '1')
                ->where('is_read', '0')
                ->count();
        }
    @endphp

    <style>
        .admin-notification-link {
            color: #000;
            text-decoration: none;
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .admin-bell-icon {
            font-size: 22px;
        }

        .admin-notification-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            font-size: 11px;
            line-height: 18px;
            border-radius: 999px;
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .admin-notification-badge.is-visible {
            opacity: 1;
            transform: scale(1);
        }

        .admin-notification-badge.is-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .admin-notification-pnl.read {
            opacity: 0.7;
        }

        .admin-notification-pnl.not-clickable {
            pointer-events: none;
            cursor: default;
        }

        .admin-notification-pnl.unread {
            background-color: #f1f7ff;
            border-left: 4px solid #0d6efd;
            cursor: pointer;
        }
    </style>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="adminNotificationDialog">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Notifications</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            @forelse($adminNotifications as $notification)
                <div class="notification-pnl admin-notification-pnl d-flex gap-3 mb-3 {{ $notification->is_read == 0 ? 'unread clickable' : 'read not-clickable' }}" data-id="{{ $notification->id }}">
                    <div>
                        <div class="bell-icon-1">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                    </div>

                    <div class="noti-content w-100">
                        <div class="noti-header d-flex justify-content-between">
                            <div class="noti-title">
                                @if(App::getLocale() == 'en')
                                    {{ $notification->title_english ?? 'Notification' }}
                                @else
                                    {{ $notification->title_arabic ?? 'Notification' }}
                                @endif
                            </div>

                            <div class="post-date">
                                {{ formatDateTimeByLocale(\Carbon\Carbon::parse($notification->created_at)->format('M d, h:i A')) }}
                            </div>
                        </div>

                        <p>
                            @if(App::getLocale() == 'en')
                                {{ $notification->description_english }}
                            @else
                                {{ $notification->description_arabic }}
                            @endif
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

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script> -->
     <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/ar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
    // $(document).ready(function () {

    //     // Initial State
    //     if ($(window).width() <= 991) {
    //         $(".customSidebar").removeClass("toggle");
    //         $(".inner-content").removeClass("toggle");
    //         $(".asideTitle").show();

    //     }
    //     // Menu Click
    //     $(".menu").on("click", function () {
    //         $(".customSidebar").toggleClass("toggle");
    //         $(".inner-content").toggleClass("toggle");
    //         $(".asideTitle").toggle();
    //     });

    //     // Window Resize
    //     $(window).on("resize", function () {
    //         if ($(window).width() <= 991) {
    //             $(".customSidebar").removeClass("toggle");
    //             $(".inner-content").removeClass("toggle");
    //             $(".asideTitle").show();
    //         }
    //     });

    // });

    $(document).ready(function () {

    const isRTL = $('html').attr('dir') === 'rtl';

    // Direction class
    if (isRTL) {
        $('body').addClass('rtl-layout');
    } else {
        $('body').addClass('ltr-layout');
    }

    function resetSidebar() {
        if ($(window).width() <= 991) {
            $(".customSidebar").removeClass("toggle");
            $(".inner-content").removeClass("toggle");
            $(".asideTitle").show();
        }
    }

    // Initial State
    resetSidebar();
    // Menu Click
    $(".menu").on("click", function () {
        $(".customSidebar").toggleClass("toggle");
        $(".inner-content").toggleClass("toggle");
        $(".asideTitle").toggle();
    });
    // Window Resize
    $(window).on("resize", function () {
        resetSidebar();
    });

    });
    
    </script>

    <!-- Data Table -->
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "ordering": true, // Enable column sorting
            "pageLength": 10, // Set number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Pagination options
            "language": {
                "search": "Search:", // Customize the search label
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            }

        });

        $(document).on('input', '.dataTables_filter input', function () {
            this.value = this.value.replace(/^\s+/, '');
        });

       
        $('#myTable1').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "ordering": true, // Enable column sorting
            "pageLength": 10, // Set number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Pagination options
            "language": {
                "search": "Search:", // Customize the search label
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
        $('#myTable2').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "ordering": true, // Enable column sorting
            "pageLength": 10, // Set number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Pagination options
            "language": {
                "search": "Search:", // Customize the search label
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
        $('#myTable3').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "ordering": true, // Enable column sorting
            "pageLength": 10, // Set number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Pagination options
            "language": {
                "search": "Search:", // Customize the search label
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });

        $('.comyTable3').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "ordering": true, // Enable column sorting
            "pageLength": 10, // Set number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Pagination options
            "language": {
                "search": "Search:", // Customize the search label
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });

        // $('.allTable').DataTable({
        //     "paging": true,           // Enable pagination
        //     "searching": true,        // Enable searching
        //     "ordering": true,         // Enable column sorting
        //     "pageLength": 10,         // Set number of rows per page
        //     "lengthMenu": [10, 25, 50, 100],  // Pagination options
        //     "language": {
        //         "search": "Search:", // Customize the search label
        //         "paginate": {
        //             "next": "Next",
        //             "previous": "Previous"
        //         }
        //     }
        // });
    });
    </script>
    
    <script>
            const appLocale = "{{ App::getLocale() }}";

    $(document).ready(function() {
        const languageOptions = {
            lengthMenu: appLocale === 'ar' ? 'عدد العناصر لكل صفحة: _MENU_' : 'Entries per page: _MENU_',
            zeroRecords: "", // empty to override manually in drawCallback
            info: appLocale === 'ar' ?
                'عرض _START_ إلى _END_ من أصل _TOTAL_ عنصر' : 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: appLocale === 'ar' ? 'لا توجد عناصر متاحة' : 'No entries available',
            infoFiltered: appLocale === 'ar' ?
                '(تمت التصفية من إجمالي _MAX_ من العناصر)' : '(filtered from _MAX_ total entries)',
            emptyTable: appLocale === 'ar' ? 'لا توجد بيانات متاحة في الجدول' :
                'No data available in table',
            search: appLocale === 'ar' ? 'بحث:' : 'Search:',
            paginate: {
                first: appLocale === 'ar' ? 'الأول' : 'First',
                last: appLocale === 'ar' ? 'الأخير' : 'Last',
                next: appLocale === 'ar' ? 'التالي' : 'Next',
                previous: appLocale === 'ar' ? 'السابق' : 'Previous'
            }
        };

        const tables = [
           '#myTable', '#myTable1', '#myTable2', '#myTable3', '#comyTable3'
        ];

        tables.forEach(function(selector) {
            const $table = $(selector);
            if ($table.length) {
                if ($.fn.DataTable.isDataTable($table)) {
                    $table.DataTable().destroy();
                }

                $table.DataTable({
                    language: languageOptions,
                    drawCallback: function() {
                        const api = this.api();
                        const info = api.page.info();

                        // Manual override for "No matching records found"
                        const $emptyCell = $table.find('td.dataTables_empty');
                        if (info.recordsDisplay === 0 && $emptyCell.length > 0) {
                            const message = appLocale === 'ar' ?
                                'لا توجد نتائج مطابقة للفلترة الحالية' :
                                'No matching records found for the applied filter.';
                            $emptyCell.text(message);
                        }

                        // Clean up "filtered from _MAX_ entries"
                        const infoBox = $table.closest('.dataTables_wrapper').find(
                            '.dataTables_info');
                        const cleanText = infoBox.text().replace(/\(.*?filtered.*?\)/gi, '')
                            .trim();
                        infoBox.text(cleanText);
                    }
                });
            }
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
    let adminLastNotificationCount = Number(@json($adminNotificationCount));
    let adminAudioContext = null;
    let adminAudioUnlocked = false;

    const adminNotificationEndpoint = "{{ route('admin.get_admin_notifications_count') }}";
    const adminMarkAllReadEndpoint = "{{ route('admin.mark_all_notification_as_read') }}";
    const adminNotificationBadge = document.getElementById('adminNotificationBadge');
    const adminNotificationDialog = document.getElementById('adminNotificationDialog');
    const adminRingtoneSrc = "https://raw.githubusercontent.com/TaterTotterson/microWakeWords/main/wakeSounds/phone-chime.wav";

    function playAdminNotificationSound() {
        try {
            const audio = new Audio(adminRingtoneSrc);
            audio.volume = 0.35;
            audio.play().catch(() => {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;

                if (!AudioContextClass) {
                    return;
                }

                if (!adminAudioContext) {
                    adminAudioContext = new AudioContextClass();
                }

                if (adminAudioContext.state === 'suspended') {
                    adminAudioContext.resume().catch(() => {});
                }

                const oscillator = adminAudioContext.createOscillator();
                const gain = adminAudioContext.createGain();

                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(1046.5, adminAudioContext.currentTime);

                gain.gain.setValueAtTime(0.0001, adminAudioContext.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.16, adminAudioContext.currentTime + 0.01);
                gain.gain.exponentialRampToValueAtTime(0.0001, adminAudioContext.currentTime + 0.14);

                oscillator.connect(gain);
                gain.connect(adminAudioContext.destination);

                oscillator.start();
                oscillator.stop(adminAudioContext.currentTime + 0.16);
            });
        } catch (error) {
            console.log('Notification sound error:', error);
        }
    }

    function unlockAdminAudio() {
        if (adminAudioUnlocked) {
            return;
        }

        try {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;

            if (!AudioContextClass) {
                return;
            }

            if (!adminAudioContext) {
                adminAudioContext = new AudioContextClass();
            }

            if (adminAudioContext.state === 'suspended') {
                adminAudioContext.resume().then(() => {
                    adminAudioUnlocked = true;
                }).catch(() => {});
            } else {
                adminAudioUnlocked = true;
            }
        } catch (error) {
            console.log('Failed to unlock admin audio:', error);
        }
    }

    function setAdminBadge(count) {
        if (!adminNotificationBadge) {
            return;
        }

        adminNotificationBadge.textContent = count;

        if (count > 0) {
            adminNotificationBadge.classList.remove('is-hidden');
            adminNotificationBadge.classList.add('is-visible');
        } else {
            adminNotificationBadge.classList.add('is-hidden');
            adminNotificationBadge.classList.remove('is-visible', 'blink');
        }
    }

    async function refreshAdminNotificationCount(shouldAlert = false) {
        try {
            const response = await fetch(adminNotificationEndpoint, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const payload = await response.json();
            const count = Number(payload?.data ?? 0) || 0;

            if (count !== adminLastNotificationCount) {
                setAdminBadge(count);

                if (shouldAlert && count > adminLastNotificationCount) {
                    playAdminNotificationSound();
                }

                adminLastNotificationCount = count;
            } else {
                setAdminBadge(count);
            }
        } catch (error) {
            console.log('Failed to refresh admin notifications:', error);
        }
    }

    async function markAdminNotificationsRead() {
        try {
            await fetch(adminMarkAllReadEndpoint, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: new URLSearchParams({
                    receiver_type: '1'
                })
            });

            adminLastNotificationCount = 0;
            setAdminBadge(0);
        } catch (error) {
            console.log('Failed to mark admin notifications read:', error);
        }
    }

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
                    url: "{{ url('admin-save-token') }}",
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
    const notification = payload?.notification || {};
    const title = notification.title || 'Notification';
    const body = notification.body || '';

    playAdminNotificationSound();
    refreshAdminNotificationCount(true);

    if (window.Notification && Notification.permission === 'granted') {
        new Notification(title, {
            body: body,
            icon: '/icon.png',
        });
    }
});

    document.addEventListener('DOMContentLoaded', function () {
        setAdminBadge(adminLastNotificationCount);
        refreshAdminNotificationCount(false);

        if (adminNotificationDialog) {
            adminNotificationDialog.addEventListener('shown.bs.offcanvas', function () {
                markAdminNotificationsRead();
            });
        }

        document.addEventListener('click', unlockAdminAudio, { once: true });
        document.addEventListener('keydown', unlockAdminAudio, { once: true });
        document.addEventListener('touchstart', unlockAdminAudio, { once: true, passive: true });

        if (adminNotificationBadge) {
            adminNotificationBadge.addEventListener('click', unlockAdminAudio);
        }
        if (adminNotificationDialog) {
            adminNotificationDialog.addEventListener('click', unlockAdminAudio);
        }

        setInterval(function () {
            refreshAdminNotificationCount(true);
        }, 10000);
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

@if (App::getlocale() == 'ar')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ar.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const appLocale = "{{ App::getLocale() }}";

        const options = {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            allowInput: true,
            altInputClass: "form-control",

            onReady: function(selectedDates, dateStr, instance) {
                instance.altInput.setAttribute(
                    "placeholder",
                    appLocale === 'ar' ? "اختر التاريخ" : "Select Date"
                );
            }
        };

        if (appLocale === 'ar') {
            options.locale = "ar";
        }

        flatpickr(".datepicker", options);
    });
</script>
@endif


</footer>

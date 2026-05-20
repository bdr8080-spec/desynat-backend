<footer>
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
    $(document).ready(function() {
        $(".inner-content").removeClass("innerToggle");
        $(".menu").click(function() {
            $(".customSidebar").toggleClass("toggle");
            $(".inner-content").toggleClass("toggle");
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
           '#myTable', '#myTable1', '#myTable3', '#myTable3', '#comyTable3'
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


</footer>
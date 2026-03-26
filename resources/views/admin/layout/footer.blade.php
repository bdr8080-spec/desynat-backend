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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
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


</footer>
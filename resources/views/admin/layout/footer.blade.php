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


</footer>
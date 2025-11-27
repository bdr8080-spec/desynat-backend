<style>
    .dataTables_filter {
    display: none !important;
}
    </style>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function () {

    // init datatables for multiple tables
    var tableInstances = {};

  

    // apply search for each table
    $('.tableSearch').on('keyup', function () {
        var tableId = $(this).data('table');
        // alert(tableId);
        tableInstances[tableId].search(this.value).draw();
    });


      $('.datatable').each(function () {
        var tableId = $(this).attr('id');
        tableInstances[tableId] = $(this).DataTable({
            searching: true,
            paging: true,
            info: true,
            ordering: true,
            columnDefs: [
                { orderable: false, targets: "no-sort" }
            ]
        });
    });

});


</script>



<script>

const appLocale = "{{ App::getLocale() }}";

$(document).ready(function() {

    const languageOptions = {

        lengthMenu: appLocale === 'ar'
            ? 'عدد العناصر لكل صفحة: _MENU_'
            : 'Entries per page: _MENU_',

        zeroRecords: "",

        // ✅ Dynamic Showing Text
        info: appLocale === 'ar'
            ? 'عرض _START_ إلى _END_ من أصل _TOTAL_ عنصر'
            : 'Showing _START_ to _END_ of _TOTAL_ entries',

        infoEmpty: appLocale === 'ar'
            ? 'لا توجد عناصر متاحة'
            : 'No entries available',

        infoFiltered: appLocale === 'ar'
            ? '(تمت التصفية من إجمالي _MAX_ من العناصر)'
            : '(filtered from _MAX_ total entries)',

        emptyTable: appLocale === 'ar'
            ? 'لا توجد بيانات متاحة في الجدول'
            : 'No data available in table',

        search: appLocale === 'ar'
            ? 'بحث:'
            : 'Search:',

        paginate: {
            first: appLocale === 'ar' ? 'الأول' : 'First',
            last: appLocale === 'ar' ? 'الأخير' : 'Last',
            next: appLocale === 'ar' ? 'التالي' : 'Next',
            previous: appLocale === 'ar' ? 'السابق' : 'Previous'
        }
    };

    const tables = [
        '#table1',
        '#table2',
        '#table3',
        '#DataTables_Table_1',
        '#DataTables_Table_2',
        '#DataTables_Table_0',
        '#datatable_search'
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

                    // No matching records text
                    const $emptyCell = $table.find('td.dataTables_empty');

                    if (info.recordsDisplay === 0 && $emptyCell.length > 0) {

                        const message = appLocale === 'ar'
                            ? 'لا توجد نتائج مطابقة للفلترة الحالية'
                            : 'No matching records found for the applied filter.';

                        $emptyCell.text(message);
                    }

                    // ✅ Dynamic info text
                    const infoBox = $table.closest('.dataTables_wrapper')
                        .find('.dataTables_info');

                    let customInfo = '';

                    if (info.recordsTotal > 0) {

                        customInfo = appLocale === 'ar'
                            ? `عرض ${info.start + 1} إلى ${info.end} من أصل ${info.recordsTotal} عنصر`
                            : `Showing ${info.start + 1} to ${info.end} of ${info.recordsTotal} entries`;

                    } else {

                        customInfo = appLocale === 'ar'
                            ? 'لا توجد عناصر متاحة'
                            : 'No entries available';
                    }

                    infoBox.text(customInfo);

                }

            });

        }

    });

});


// search Box Code 

    $(document).ready(function() {

        let dataTables = {};

        $('.tableSearch').each(function() {

            let tableId = $(this).data('table');

            // Initialize table only once
            if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                dataTables[tableId] = $('#' + tableId).DataTable({
                    paging: false,
                    ordering: true,
                    info: false,
                    searching: true
                });
            } else {
                dataTables[tableId] = $('#' + tableId).DataTable();
            }
        });

        // Search handler
        $('.tableSearch').on('keyup', function() {
            let tableId = $(this).data('table');
            let value = $(this).val();

            dataTables[tableId].search(value).draw();
        });

    });

</script>
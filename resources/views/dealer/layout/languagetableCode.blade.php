
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
        emptyTable: appLocale === 'ar' ? 'لا توجد بيانات متاحة في الجدول' : 'No data available in table',
        search: appLocale === 'ar' ? 'بحث:' : 'Search:',
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
        "#datatable_search"
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
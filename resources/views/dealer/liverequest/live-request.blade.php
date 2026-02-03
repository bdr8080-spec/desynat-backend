@include('dealer.layout.header')


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Live Coverage Requests</div>
        <a href="#" class="btn btn-success">Export</a>

    </div>
    <div class="datatable-wapper mt-4">
        <div class="table-header">
            <div class="search-field">
                <div class="from-group position-relative">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                    <input type="search" class="dt-input tableSearch form-control" id="customTableSearch"
                        placeholder="Search" aria-controls="table1">
                </div>
            </div>

            <form method="GET" action="">

                <div class="search-filter">
                    <div class="from-group">
                        <div class="show-date d-flex gap-2  flex-wrap">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="from" id="fromDate"
                                    value="{{request()->from }}">
                                <p class="text-danger" id="error-start_date"></p>
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="to" id="toDate"
                                    value="{{request()->to }}">

                                <p class="text-danger" id="error-end_date"></p>
                            </div>
                        </div>
                    </div>
                    <div class="from-group">
                        <select class="form-select form-control width-50" aria-label="Default select example">
                            <option value="">Filter by status</option>

                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="choose-date">
            <div class="date-card">
                <div class="date-header">
                    <span>Select Date</span>
                    <h3 id="selectedDate"></h3>
                </div>
                <div class="month-row date-form-pnl">
                    <!-- <button id="prevMonth">‹</button> -->
                    <select id="monthSelect" class="form-select form-control"></select>
                    <select id="yearSelect" class="form-select form-control"></select>
                    <!-- <button id="nextMonth">›</button> -->
                </div>
                <div class="days-row" id="daysContainer"></div>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered datatable tablesearch" id="table1">
                <thead>
                    <tr>
                        <th class="no-sort">S.No</th>
                        <th class="no-sort">Request ID</th>
                        <th class="no-sort">Requested On </th>
                        <th class="no-sort">Live Request </th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>#5558566</td>
                        <td>03/02/2026 at 07:30pm</td>
                        <td>03/02/2026 at 07:30pm</td>
                        <td>Pending </td>
                        <td>Remove</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>








</section>


@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    let m = new Date().getMonth();
    let y = new Date().getFullYear();

    function render() {
    $('#daysContainer').html('');
    $('#monthSelect').val(m);
    $('#yearSelect').val(y);

    const today = new Date();

    for (let d = 1; d <= new Date(y, m + 1, 0).getDate(); d++) {

        const dateObj = new Date(y, m, d);
        const day = dateObj.toLocaleDateString('en-US', { weekday: 'short' });

        const active =
            d === today.getDate() &&
            m === today.getMonth() &&
            y === today.getFullYear()
            ? 'active' : '';

        $('#daysContainer').append(
            `<div class="day ${active}">
                <span>${day}</span>
                <b>${d}</b>
             </div>`
        );
        
    }
}

    // init
    months.forEach((x, i) => $('#monthSelect').append(`<option value="${i}">${x}</option>`));
    for (let i = y - 0; i <= y + 0; i++) $('#yearSelect').append(`<option>${i}</option>`);
    render();

    // events
    $('#monthSelect,#yearSelect').change(() => {
        m = +$('#monthSelect').val();
        y = +$('#yearSelect').val();
        render();
    });

    $('#prevMonth').click(() => {
        m--;
        if (m < 0) {
            m = 11;
            y--
        }
        render();
    });
    $('#nextMonth').click(() => {
        m++;
        if (m > 11) {
            m = 0;
            y++
        }
        render();
    });

    $(document).on('click', '.day', function() {
        $('.day').removeClass('active');
        $(this).addClass('active');
        $('#selectedDate').text(
            `${$(this).find('span').text()}, ${months[m]} ${y}`
        );
    });
</script>
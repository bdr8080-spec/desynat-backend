@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Dashboard
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="bg-header mt-3 visitor-pnl">
                <form method="GET" action="{{ route('affiliate.affiliateDashboard') }}" id="filterForm">
                <div class="group-radio-btn d-flex gap-4 justify-content-between flex-wrap">

                    <!-- FILTER RADIO -->
                    <div class="d-flex gap-4 align-items-center flex-wrap">

                        <div class="check_radio">
                            <label class="radio-group">
                                <input class="form-check-input"
                                    type="radio"
                                    name="filter"
                                    value="1"
                                    {{ request()->filter == 1 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="custom-radio"></span>
                                <span class="radio-label">Today</span>
                            </label>
                        </div>

                        <div class="check_radio">
                            <label class="radio-group">
                                <input class="form-check-input"
                                    type="radio"
                                    name="filter"
                                    value="2"
                                    {{ request()->filter == 2 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="custom-radio"></span>
                                <span class="radio-label">This Week</span>
                            </label>
                        </div>

                        <div class="check_radio">
                            <label class="radio-group">
                                <input class="form-check-input"
                                    type="radio"
                                    name="filter"
                                    value="3"
                                    {{ request()->filter == 3 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="custom-radio"></span>
                                <span class="radio-label">This Month</span>
                            </label>
                        </div>

                    </div>

                    <!-- DATE FILTER -->
                    <div class="show-date d-flex gap-2 flex-wrap">
                        <div class="date-form-pnl">
                            <input type="date" id="from_date" name="from_date" class="form-control"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                        <div class="date-form-pnl">
                            <input type="date" id="to_date" name="to_date" class="form-control"
                            value="{{ request()->to_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>

<div id="dashboard-data">
    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="py-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5>Total Products Added</h5>
                        <div class="title30">{{$dashboardData['total_products']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class="total-revenu border20 shadow20 p20 mt-4">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content">
                        <h5>Total Revenue Generated</h5>
                        <h1 class="font-34 py-3">{{$dashboardData['total_revenue']}} KD</h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer') }}/assets/img/profit.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="title24">Total Orders <span class="gold-title">({{$dashboardData['total_orders']}})</span></div>
        <div class="row mt-3">
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-4">
                    <div class="dash-content">
                        <h5>Ongoing </h5>
                        <div class="title30">{{$dashboardData['total_ongoing_orders']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-3">
                    <div class="dash-content">
                        <h5>Completed</h5>
                        <div class="title30">{{$dashboardData['total_completed_orders']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5>Returned </h5>
                        <div class="title30">{{$dashboardData['total_returned_orders']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5 style="color:#CD0E26;">Cancelled</h5>
                        <div class="title30">{{$dashboardData['total_cancelled_orders']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</section>


<!-- Edit shipping Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-body text-center p-3">
                    <div class="trash-box">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h4 class="domestic-title"> Are you sure you want to delete this domestic cost?</h4>
                </div>
                <div class="login-btn mt-4 d-flex justify-content-between gap-3">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger-outline w-100">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('affiliatedUser.layout.footer');

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- <script>
$(document).ready(function () {

    function loadDashboardData() {
        let filter_type = $('input[name="filter_type"]:checked').val();
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();

        // Only fetch if user selects something
        if (!filter_type && !from_date && !to_date) return;

        $.ajax({
            url: "{{ route('affiliate.affiliateDashboard') }}",
            type: "GET",
            data: {
                filter_type: filter_type,
                from_date: from_date,
                to_date: to_date
            },
            success: function (response) {
                $('#dashboard-data').html(response);
            }
        });
    }

    // 🔁 Radio change
    $('input[name="filter_type"]').on('change', function () {
        $('#from_date').val('');
        $('#to_date').val('');
        loadDashboardData();
    });

    // 🔁 Date change
    $('#from_date, #to_date').on('change', function () {
        $('input[name="filter_type"]').prop('checked', false);
        loadDashboardData();
    });

});
</script> -->

<!-- <script>
function updateToDate() {
    const fromDate = document.getElementById('from_date').value;
    const toDateInput = document.getElementById('to_date');
    const toDateValue = toDateInput.value;

    if (fromDate) {
        toDateInput.setAttribute('min', fromDate);

        if (toDateValue && toDateValue < fromDate) {
            toDateInput.value = '';
        }
    } else {
        toDateInput.removeAttribute('min');
    }
}

document.getElementById('from_date').addEventListener('change', updateToDate);

document.addEventListener('DOMContentLoaded', updateToDate);
</script> -->

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from_date').value;
        const toDateInput = document.getElementById('to_date');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });

</script>

<!-- tidio chatbot -->
<script src="//code.tidio.co/{{ config('app.TIDIO_KEY') }}.js" async></script>

<script>
document.addEventListener("tidioChat-ready", function () {

    if (!window.tidioChatApi) return;

    @php
        $user = Auth::guard('affilated_user')->user();
        $fullName = $user ? $user->full_name : 'Guest';
        $email = $user ? $user->email : 'guest_'.uniqid();
        $role = $user ? 'affiliate' : 'guest';
    @endphp

    const email = "{{ $email }}";
    const role = "{{ $role }}";
    const fullName = "{{ $fullName }}";
    //console.log(fullName);

    const uniqueId = role + "_" + email;


    window.tidioChatApi.setVisitorData({
        name: fullName,
        email: email,
        distinct_id: uniqueId,
        role: role
    });

    window.tidioChatApi.on("messageFromVisitor", function (event) {
    });

    window.tidioChatApi.on("messageFromOperator", function (event) {
    });

});
</script>
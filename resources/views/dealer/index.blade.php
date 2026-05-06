@include('dealer.layout.header')

@php
$menu_permission=SellermenuPermission();

$can_view=$menu_permission['can_view'];
$can_action=$menu_permission['can_action'];

@endphp



<style>
#tidio-like-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #6a5cff, #46c2ff);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    cursor: pointer;
    z-index: 9999;
    transition: all 0.3s ease;
}

/* Hover effect */
#tidio-like-btn:hover {
    transform: scale(1.1);
}

/* Icon style */
.chat-icon {
    font-size: 26px;
    color: #fff;
}

/* Pulse animation (Tidio style) */
#tidio-like-btn::after {
    content: "";
    position: absolute;
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(106, 92, 255, 0.4);
    animation: pulse 1.8s infinite;
    z-index: -1;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 0.7;
    }

    70% {
        transform: scale(1.5);
        opacity: 0;
    }

    100% {
        transform: scale(1);
        opacity: 0;
    }
}
</style>

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">  {{ __('seller_messages.Dashboard') }}
        </div>
    </div>
    <div class=" col-lg-3">
        <div class="d-flex  gap-3 mt-5">
            <a href="{{route('seller.dashboard')}}" class="btn btn-success">
                <span>Reset</span>
            </a>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="bg-header d-flex justify-content-between mt-3 align-items-center">
                <div class="title24">{{ __('seller_messages.Store_availability') }}</div>
                <div class="d-flex gap-3">
                    <div class="buy">{{ __('seller_messages.Busy/On') }}</div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault"
                            onclick="store_availbilityfunction(this)"
                            @if(@$seller_details->store_info->Store_Availability == 1) checked @endif>
                        <label class="form-check-label" for="switchCheckDefault"></label>
                    </div>

                </div>
            </div>

            <div class="py-4">
                <div class="title24">{{ __('seller_messages.Total_Products') }}  <span class="gold-title">({{$data['total_products']}})</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.Active') }}  </h5>
                                <div class="title30">{{$data['total_active_products']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.In-Active') }} </h5>
                                <div class="title30">{{$data['total_inactive_products']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-2">
                <div class="title24"> {{ __('seller_messages.Total_Orders') }}   <span class="gold-title">({{$data['total_orders']}})</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex mb-4">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.New') }}</h5>
                                <div class="title30">{{$data['total_new_orders']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex mb-3">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.Ongoing') }} </h5>
                                <div class="title30">{{$data['total_ongoing_orders']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.Completed') }} </h5>
                                <div class="title30">{{$data['total_completed_orders']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.Cancelled') }} </h5>
                                <div class="title30">{{$data['total_cancelled_orders']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="title24">{{ __('seller_messages.Total_Staffs') }}  <span class="gold-title">({{$data['total_staff']}})</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex py-3">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.Active') }} </h5>
                                <div class="title30">{{$data['total_active_staff']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/female.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex py-3">
                            <div class="dash-content">
                                <h5>{{ __('seller_messages.In-Active') }} </h5>
                                <div class="title30">{{$data['total_inactive_staff']}}</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/female.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class="bg-header mt-3 visitor-pnl">
                <form method="GET" action="{{ route('seller.dashboard') }}" id="filterForm">
                    <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap">
                        <div class="check_radio">
                            <label class="radio-group">
                                <input class="form-check-input" type="radio" name="filter" value="1"
                                    {{ request()->filter == 1 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="custom-radio"></span>
                                <span class="radio-label">{{ __('seller_messages.Today') }} </span>
                            </label>
                        </div>
                        <div class="check_radio">
                            <label class="radio-group">
                                <input class="form-check-input" type="radio" name="filter" value="2"
                                    {{ request()->filter == 2 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="custom-radio"></span>
                                <span class="radio-label">{{ __('seller_messages.This_Week') }} </span>
                            </label>
                        </div>
                        <div class="check_radio">
                            <label class="radio-group">
                                <input class="form-check-input" type="radio" name="filter" value="3"
                                    {{ request()->filter == 3 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="custom-radio"></span>
                                <span class="radio-label">{{ __('seller_messages.This_Month') }} </span>
                            </label>
                        </div>
                        <div class="check_radio">
                            <label class="radio-group">
                                <input class="form-check-input" type="radio" name="filter" value="4"
                                    {{ request()->filter == 4 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="custom-radio"></span>
                                <span class="radio-label">{{ __('seller_messages.This_Year') }} </span>
                            </label>
                        </div>
                        <div class="show-date d-flex gap-2  flex-wrap">
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
            <div class="total-revenu border20 shadow20 p20 mt-5">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content">
                        <h5>{{ __('seller_messages.Total_Revenue_Generated') }} </h5>
                        <h1 class="font-34 py-3">{{$data['total_revenue']}} {{ __('seller_messages.KD') }} </h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer') }}/assets/img/profit.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="padding-top-40 visitor-pnl">
                <div class="title24">{{ __('seller_messages.Visitor_analytics') }} </div>
                <div class="bg-header-white mt-3">
                    <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap">
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="radio" value="orders" checked>
                                <span class="custom-radio"></span>
                                <span class="radio-label">{{ __('seller_messages.Total_Order_Conversion') }}  </span>
                            </label>
                        </div>
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="radio" value="visitors">
                                <span class="custom-radio"></span>
                                <span class="radio-label">{{ __('seller_messages.Total_Customer_visits') }}  </span>
                            </label>
                        </div>
                        <form method="GET" action="{{ route('seller.dashboard') }}" id="filterForm1">
                            <div class="show-date d-flex gap-2">
                                <div class="date-form-pnl">
                                    <input type="date" id="from_date_analytics" name="from_date_analytics"
                                        class="form-control" value="{{ request()->from_date_analytics }}"
                                        onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                                </div>
                                <div class="date-form-pnl">
                                    <input type="date" id="to_date_analytics" name="to_date_analytics"
                                        class="form-control" value="{{ request()->to_date_analytics }}"
                                        onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="show-chart padding-top-40">
                <div class="dash-box border20 shadow20 p20">
                    <canvas id="pointChart"></canvas>
                </div>
            </div>


        </div>

    </div>


</section>

<!-- support chat -->
<!-- <div class="support-chat-btn" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
    <button><img src="/dealer/assets/img/Frame.svg" width="50px" /></button>
</div> -->


<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop"
    aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header chat-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">{{ __('seller_messages.Support_Chat') }}  </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="support-chat">



        </div>

    </div>
</div>

<!-- <div id="tidio-like-btn">
</div> -->


<!-- Chat Box -->



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

@include('dealer.layout.footer');


<script>
// const ctx = document.getElementById('pointChart').getContext('2d');

// const pointChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
//         datasets: [{
//             label: 'Monthly Sales',
//             data: [12, 19, 8, 25, 18, 30, 50, 30],
//             borderColor: '#55000099',
//             borderWidth: 2,
//             tension: 0.3,
//             fill: false,
//             pointStyle: 'circle', // point shape
//             pointRadius: 6,
//             pointHoverRadius: 8,
//             backgroundColor: '#F3D1A2'
//         }]
//     },
//     options: {
//         responsive: true,

//     }
// });


function store_availbilityfunction(checkbox) {

    $.ajax({
        url: "{{ url('seller/web_store_on_off') }}",
        type: "get",
        data: {
            "_token": "{{ csrf_token() }}",
        },
        dataType: "json",
        beforeSend: function() {
            $('#loader').show()
        },
        success: function(data) {
            console.log(data.data)

            if (data.data.Store_Availability == 1) {
                toastr.success(data.message);
            }

            if (data.data.Store_Availability == 0) {
                toastr.error(data.message);
            }


        },
        error: function() {
            alert("Fail")
        },
        complete: function() {
            // Hide loader (after success or error)
            $('#loader').hide();
        }

    })


}
</script>

<!-- tidio chatbot -->
<script src="//code.tidio.co/{{ config('app.TIDIO_KEY') }}.js" async></script>

<script>
document.addEventListener("tidioChat-ready", function() {

    if (!window.tidioChatApi) return;

    @php
    $user = Auth::guard('seller') -> user();
    $fullName = $user ? $user -> first_name.
    ' '.$user -> last_name: 'Guest';
    $email = $user ? $user -> email : 'guest_'.uniqid();
    $role = $user ? 'seller' : 'guest';
    @endphp

    const email = "{{ $email }}";
    const role = "{{ $role }}";
    const fullName = "{{ $fullName }}";

    const uniqueId = role + "_" + email;


    window.tidioChatApi.setVisitorData({
        name: fullName,
        email: email,
        distinct_id: uniqueId,
        role: role
    });

    window.tidioChatApi.on("messageFromVisitor", function(event) {});

    window.tidioChatApi.on("messageFromOperator", function(event) {});

});
</script>

<script>
const dashboardData = @json($data);

function getOrderData() {
    return {
        labels: dashboardData.order_analytics.map(item => item.month),
        data: dashboardData.order_analytics.map(item => item.orders),
        label: 'Total Order Conversion',
        color: '#55000099'
    };
}

function getVisitorData() {
    return {
        labels: dashboardData.visitor_analytics.map(item => item.month),
        data: dashboardData.visitor_analytics.map(item => item.total_visitors),
        label: 'Total Customer Visits',
        color: '#007bff'
    };
}

const ctx = document.getElementById('pointChart').getContext('2d');

let initialData = getOrderData();

const pointChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: initialData.labels,
        datasets: [{
            label: initialData.label,
            data: initialData.data,
            borderColor: initialData.color,
            borderWidth: 2,
            tension: 0.3,
            fill: false,
            pointStyle: 'circle',
            pointRadius: 6,
            pointHoverRadius: 8,
            backgroundColor: '#F3D1A2'
        }]
    },
    options: {
        responsive: true
    }
});

document.querySelectorAll('input[name="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {

        let selectedData;

        if (this.value === 'orders') {
            selectedData = getOrderData();
        } else {
            selectedData = getVisitorData();
        }

        pointChart.data.labels = selectedData.labels;
        pointChart.data.datasets[0].data = selectedData.data;
        pointChart.data.datasets[0].label = selectedData.label;
        pointChart.data.datasets[0].borderColor = selectedData.color;

        pointChart.update();
    });
});
</script>

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

<script>
function updateToDate1() {
    const fromDate = document.getElementById('from_date_analytics').value;
    const toDateInput = document.getElementById('to_date_analytics');
    if (fromDate) {
        toDateInput.setAttribute('min', fromDate);
    } else {
        toDateInput.removeAttribute('min');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    updateToDate1();
});
</script>
@extends('admin.layout.app')
@section('content')

<style>
.spinner {
    border:6px solid #f3f3f3;
    border-top:6px solid #3498db;
    border-radius:50%;
    width:50px;
    height:50px;
    animation:spin 1s linear infinite;
    margin:auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>


<div class="inner-content management">
    <h2 class="h2">Withdrawal Request</h2>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="false">
                    New
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Approved
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Rejected
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <form method="GET" action="{{ route('admin.affiliateWithdrawRequestManagement') }}" id="filterForm">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from_date" name="from_date" class="form-control"
                                value="{{ request()->from_date }}"
                                onchange="document.getElementById('filterForm').submit();" />
                        </div>
                    </div>
                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to_date" name="to_date" class="form-control"
                                value="{{ request()->to_date }}"
                                onchange="document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country" id="country"
                                class="form-select form-select-lg "
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['name'] }}"
                                    {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start mt-5" style="text-align: start">
                            <a href="{{route('admin.affiliateWithdrawRequestManagement')}}" class="btn btn-dark customBtn mt-2">
                                <span>Reset</span>
                            </a>
                            <!-- <a class="btn btn-dark customBtn" style="margin-top: 60px">
                                <span>Export</span>
                            </a> -->
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Available Amount</th>
                                <th scope="col">Requested Amount</th>
                                <th scope="col">Bank Account Number</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newRequest as $index => $req)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $req['request_id'] }}</td>
                                <td>{{ $req['affiliate__details']['full_name'] }}</td>
                                <td>{{ $req['affiliate__details']['address_details']['country_details']['name'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($req['created_at'])->format('jS F Y | g:i A') }}</td>
                                <td>{{ rtrim(rtrim(number_format($req['total_earning'], 2, '.', ''), '0'), '.') }} KD</td>
                                <td>{{ $req['amount'] }} KD</td>
                                <td>{{ $req['bank_details']['account_no']??'N/A' }}</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button acceptUser" data-id="{{ $req['id'] }}" type="button">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </a>
                                        <a class="table-button rejectWithdraw"
                                        data-id="{{ $req['id'] }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#xcircle">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- approved -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.affiliateWithdrawRequestManagement') }}" id="filterForm1">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from_date1" name="from_date1" class="form-control"
                                value="{{ request()->from_date1 }}"
                                onchange="document.getElementById('filterForm1').submit();" />
                        </div>
                    </div>
                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to_date1" name="to_date1" class="form-control"
                                value="{{ request()->to_date1 }}"
                                onchange="document.getElementById('filterForm1').submit();" />
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country1" id="country1"
                                class="form-select form-select-lg "
                                onchange="document.getElementById('filterForm1').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['name'] }}"
                                    {{ request('country1') == $country['name'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Status</label>
                            <select name="status" id="status"
                                class="form-select form-select-lg "
                                onchange="document.getElementById('filterForm1').submit();">
                                <option value="">Select Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Complete</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start mt-5" style="text-align: start">
                            <a href="{{route('admin.affiliateWithdrawRequestManagement')}}" class="btn btn-dark customBtn mt-2">
                                <span>Reset</span>
                            </a>
                            <!-- <a class="btn btn-dark customBtn" style="margin-top: 60px">
                                <span>Export</span>
                            </a> -->
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Available Amount</th>
                                <th scope="col">Requested Amount</th>
                                <th scope="col">Bank Account Number</th>
                                <th scope="col">Transaction Id</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedRequest as $index => $req)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $req['request_id'] }}</td>
                                <td>{{ $req['affiliate__details']['full_name'] }}</td>
                                <td>{{ $req['affiliate__details']['address_details']['country_details']['name'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($req['created_at'])->format('jS F Y | g:i A') }}</td>
                                <td>{{ rtrim(rtrim(number_format($req['total_earning'], 2, '.', ''), '0'), '.') }} KD</td>
                                <td>{{ $req['amount'] }} KD</td>
                                <td>{{ $req['bank_details']['account_no']??'N/A' }}</td>
                                <td>{{ $req['transaction_id'] ?? 'N/A' }}</td>
                                <td>
                                    @if($req['admin_verify'] == '1')
                                        <span class="text-success">Complete</span>
                                    @else
                                        <span class="text-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- rejected -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.affiliateWithdrawRequestManagement') }}" id="filterForm2">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from_date2" name="from_date2" class="form-control"
                                value="{{ request()->from_date2 }}"
                                onchange="document.getElementById('filterForm2').submit();" />
                        </div>
                    </div>
                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to_date2" name="to_date2" class="form-control"
                                value="{{ request()->to_date2 }}"
                                onchange="document.getElementById('filterForm2').submit();" />
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country2" id="country2"
                                class="form-select form-select-lg "
                                onchange="document.getElementById('filterForm2').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['name'] }}"
                                    {{ request('country2') == $country['name'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start mt-5" style="text-align: start">
                            <a href="{{route('admin.affiliateWithdrawRequestManagement')}}" class="btn btn-dark customBtn mt-2">
                                <span>Reset</span>
                            </a>
                            <!-- <a class="btn btn-dark customBtn" style="margin-top: 60px">
                                <span>Export</span>
                            </a> -->
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable2" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Available Amount</th>
                                <th scope="col">Requested Amount</th>
                                <th scope="col">Bank Account Number</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedRequest as $index => $req)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $req['request_id'] }}</td>
                                <td>{{ $req['affiliate__details']['full_name'] }}</td>
                                <td>{{ $req['affiliate__details']['address_details']['country_details']['name'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($req['created_at'])->format('jS F Y | g:i A') }}</td>
                                <td>{{ rtrim(rtrim(number_format($req['total_earning'], 2, '.', ''), '0'), '.') }} KD</td>
                                <td>{{ $req['amount'] }} KD</td>
                                <td>{{ $req['bank_details']['account_no']??'N/A' }}</td>
                                <td>
                                    {{ $req['reject_reason'] }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="modal fade" id="xcircle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="div">
                            <div class="mb-3">
                                <textarea class="form-control" id="rejectReason" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-12 mt-3">
                    <div class="d-flex justify-content-center gap-3">
                        <a type="button" class="btn btn-dark customBtn">Cancle</a>
                        <a type="button" class="btn btn-dark customBtn gap-2">Submit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="modal fade" id="xcircle" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Reason For Rejection </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <textarea class="form-control" id="rejectReason" name="reject_reason" rows="3"></textarea>

                    <small id="reasonError" class="text-danger" style="display:none;">
                        Please enter reason for rejection
                    </small>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-3">
                    <button type="button" class="btn btn-dark customBtn" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" id="submitReject" class="btn btn-dark customBtn">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- loader -->
 <div id="paymentLoader" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    z-index:9999;
    align-items:center;
    justify-content:center;
">
    <!-- <div style="text-align:center;color:#fff;">
        <div class="spinner"></div>
        <p style="margin-top:10px;font-size:18px;">Redirecting to payment gateway...</p>
    </div> -->
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    //get active tab from local storage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }
    //save active tab to local storage
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
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
        const fromDate = document.getElementById('from_date1').value;
        const toDateInput = document.getElementById('to_date1');
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

<script>
    function updateToDate2() {
        const fromDate = document.getElementById('from_date2').value;
        const toDateInput = document.getElementById('to_date2');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate2();
    });
</script>

<!-- reject withdraw request -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    let withdrawId = null;

    document.querySelectorAll('.rejectWithdraw').forEach(btn => {
        btn.addEventListener('click', function () {
            withdrawId = this.getAttribute('data-id');
            document.getElementById('rejectReason').value = '';
            document.getElementById('reasonError').style.display = 'none';
        });
    });

    document.getElementById('submitReject').addEventListener('click', function () {

        let reason = document.getElementById('rejectReason').value.trim();
        let errorBox = document.getElementById('reasonError');

        if (reason === '') {
            errorBox.style.display = 'block';
            return;
        }

        fetch(`/admin/rejectWithdrawRequest/${withdrawId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                reject_reason: reason
            })
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === 'success') {

                toastr.success(data.message);

                setTimeout(() => {
                    $('#xcircle').modal('hide');
                    location.reload();
                }, 1500);

            } else {
                toastr.error(data.message);
            }

        })
        .catch(() => {
            toastr.error("Something went wrong.");
        });

    });

    document.getElementById('rejectReason').addEventListener('input', function () {
        document.getElementById('reasonError').style.display = 'none';
    });

});
</script>

<!-- <script>
document.addEventListener('DOMContentLoaded', function () {

    const loader = document.getElementById('paymentLoader');

    document.querySelectorAll('.acceptUser').forEach(button => {

        button.addEventListener('click', function () {

            let withdrawId = this.getAttribute('data-id');

            // Show loader
            //loader.style.display = "flex";

            fetch('/admin/transferWithdrawRequest', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    withdraw_request_id: withdrawId
                })
            })
            .then(res => res.json())
            .then(data => {

                if(data.status === 'success' && data.payment_url){

                    console.log("Redirecting to:", data.payment_url);

                   // window.location.href = data.payment_url;

                }else{

                   // loader.style.display = "none"; // hide loader
                    console.error(data.message);

                }

            })
            .catch(error => {

                loader.style.display = "none"; // hide loader
                console.error(error);

            });

        });

    });

});
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const loader = document.getElementById('paymentLoader');

    document.querySelectorAll('.acceptUser').forEach(button => {

        button.addEventListener('click', function () {

            let withdrawId = this.getAttribute('data-id');

            // SHOW LOADER
            // loader.style.display = "flex";

            // Send req_id in POST body
            fetch(`/admin/approveWithdrawRequest`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    req_id: withdrawId
                })
            })
            .then(res => res.json())
            .then(data => {

                // HIDE LOADER
                // loader.style.display = "none";

                if(data.status === 'success'){
                    toastr.success(data.message || "Withdraw processed successfully");
                } else {
                    toastr.error(data.message || "Payment failed");
                }

                // Reload page after toast message
                setTimeout(() => {
                    location.reload();
                }, 1200);

            })
            .catch(error => {

                // HIDE LOADER
                // loader.style.display = "none";

                toastr.error("Something went wrong. Please try again.");

                setTimeout(() => {
                    location.reload();
                }, 1200);
            });

        });

    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
});
</script>

@endsection
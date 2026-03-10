@extends('admin.layout.app')
@section('content')

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
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request()->from_date }}"
                                onchange="document.getElementById('filterForm').submit();" />
                        </div>
                    </div>
                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" class="form-control"
                                value="{{ request()->to_date }}"
                                onchange="document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg "
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['name'] }}"
                                    {{ request('country_name') == $country['name'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start" style="text-align: start">
                            <a href="{{route('admin.affiliateWithdrawRequestManagement')}}" class="btn btn-dark customBtn" style="margin-top: 60px">
                                <span>Reset</span>
                            </a>
                            <a class="btn btn-dark customBtn" style="margin-top: 60px">
                                <span>Export</span>
                            </a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Affiliate Name</th>
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
                                <td>{{ $req['affiliate__details']['country_details']['name'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($req['created_at'])->format('jS F Y | g A') }}</td>
                                <td>{{ rtrim(rtrim(number_format($req['total_earning'], 2, '.', ''), '0'), '.') }} KD</td>
                                <td>{{ $req['amount'] }} KD</td>
                                <td>{{ $req['bank_details']['account_no'] }}</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button acceptUser" type="button">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </a>
                                        <a class="table-button" data-bs-toggle="modal" data-bs-target="#xcircle">
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
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">All Countries</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">Country 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Status</label>
                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Completed</option>
                                <option value="">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start mt-5" style="text-align: start">
                            <a href="" class="btn btn-dark customBtn mt-1">
                                <span>Reset</span>
                            </a>
                            <a class="btn btn-dark customBtn mt-1">
                                <span>Export</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Driver Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Available Amount</th>
                                <th scope="col">Requested Amount</th>
                                <th scope="col">Bank Account Number</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>#2345</td>
                                <td>Lorem</td>
                                <td>UAE</td>
                                <td>2nd July 2025 | 11 Am</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>XXXXXX626262</td>
                                <td>lghwrgh</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- rejected -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">All Countries</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">Country 1</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start" style="text-align: start">
                            <a href="" class="btn btn-dark customBtn" style="margin-top: 60px">
                                <span>Reset</span>
                            </a>
                            <a class="btn btn-dark customBtn" style="margin-top: 60px">
                                <span>Export</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Driver Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Available Amount</th>
                                <th scope="col">Requested Amount</th>
                                <th scope="col">Bank Account Number</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>#2345</td>
                                <td>Lorem</td>
                                <td>UAE</td>
                                <td>2nd July 2025 | 11 Am</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>XXXXXX626262</td>
                                <td>efhwi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="xcircle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

@endsection
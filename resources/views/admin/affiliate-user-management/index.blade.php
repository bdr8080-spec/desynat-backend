@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <h2 class="h2">Affiliate User Management</h2>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    New
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="false">
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
            <div class="tab-pane fade show active" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <form method="GET" action="{{ route('admin.affiliateUserManagement') }}" id="filterForm">
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
                        <div class="col-lg-3 ">
                            <div class="d-flex gap-3 justify-content-end" >
                                <a href="{{route('admin.affiliateUserManagement')}}" class="btn btn-dark customBtn"
                                    style="margin-top: 60px">
                                    <span>Reset</span>
                                </a>
                        
                                <a class="btn btn-dark customBtn " style="margin-top: 60px">
                                    <span>Export</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Joining Date</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">Email ID</th>
                                <th scope="col">Country</th>
                                <th scope="col"> Address</th>
                                <th scope="col">Uploaded ID</th>
                                <th scope="col">Bank Account Details</th>
                                <!-- <th scope="col">Upload Account Proof</th> -->
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newUsers as $index => $user)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') }}</td>
                                <td>
                                    <img src="{{ $user['profile_image'] }}" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>{{ $user['full_name'] }}</td>
                                <td>{{ $user['country_code'] }}{{ $user['mobile'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['country_details']['name'] }}</td>
                                <td>
                                    @if(!empty($user['address_details']))
                                     {{$user['address_details']['address1']}}
                                     {{$user['address_details']['address2']}}
                                     {{$user['address_details']['town']}}
                                     {{$user['address_details']['city']}}
                                     {{$user['address_details']['pincode']}}
                                     {{$user['address_details']['state']}}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                    <td>
                                        @if(!empty($user['document1']) || !empty($user['document2']))
                                            <a class="table-button view-owner-btn"
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#sentModal4"
                                            data-documents='@json(array_values(array_filter([
                                                    !empty($user["document1"]) ? ["document_path" => $user["document1"]] : null,
                                                    !empty($user["document2"]) ? ["document_path" => $user["document2"]] : null,
                                            ])))'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                <td>
                                @if(!empty($user['bank_details']))
                                <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#bankModal" data-bank='@json($user['bank_details'])'>
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @else
                                N/A
                                @endif
                                </td>
                                <!-- <td>
                                    @if(!empty($user['bank_details']['upload_proof']))
                                    <a class="table-button view-account-proof-btn" type="button"
                                        data-bs-toggle="modal" data-bs-target="#sentModal3"
                                        data-proof='{{ $user['bank_details']['upload_proof'] }}'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @else
                                    N/A
                                    @endif
                                </td> -->
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button acceptUser" type="button"
                                                    data-id="{{ $user['id'] }}">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </a>
                                        <a class="table-button" data-bs-toggle="modal" data-bs-target="#xcircle"
                                            type="button" data-id="{{ $user['id'] }}">
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
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                        <form method="GET" action="{{ route('admin.affiliateUserManagement') }}" id="filterForm1">
                            <div class="row">
                                <!-- From Date Filter -->
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="form-group mt-4 w-100">
                                        <label for="from" class="form-label">From:</label>
                                        <input type="date" id="from" name="from_date1" class="form-control"
                                            value="{{ request()->from_date1 }}"
                                            onchange="document.getElementById('filterForm1').submit();" />
                                    </div>
                                </div>

                                <!-- To Date Filter -->
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="form-group mt-4 w-100">
                                        <label for="to" class="form-label">To:</label>
                                        <input type="date" id="to" name="to_date1" class="form-control"
                                            value="{{ request()->to_date1 }}"
                                            onchange="document.getElementById('filterForm1').submit();" />
                                    </div>
                                </div>

                                <!-- Country Filter -->
                                <div class="col-lg-3 col-md-12 col-12">
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
                                <div class="col-lg-3 col-md-12 col-12">
                                    <div class="d-flex gap-3 justify-content-end" >
                                        <a href="{{route('admin.affiliateUserManagement')}}" class="btn btn-dark customBtn "
                                            style="margin-top: 70px">
                                            <span>Reset</span>
                                        </a>
                                        <a class="btn btn-dark customBtn " style="margin-top: 70px">
                                            <span>Export</span>
                                        </a>
                                    </div>
                                </div>
                              
                            </div>
                        </form>

                <div class="table-responsive mt-3">
                    <table id="myTable1" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Joining Date</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">Email ID</th>
                                <th scope="col">Country</th>
                                <th scope="col"> Address</th>
                                <th scope="col">Uploaded ID</th>
                                <th scope="col">Bank Account Details</th>
                                <!-- <th scope="col">Upload Account Proof</th> -->
                                <th scope="col">Total Number of Orders</th>
                                <th scope="col">Total Earning</th>
                                <th scope="col">Block/Unblock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedUsers as $index => $user)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') }}</td>
                                <td>
                                    <img src="{{ $user['profile_image'] }}" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>{{ $user['full_name'] }}</td>
                                <td>{{ $user['country_code'] }}{{ $user['mobile'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['country_details']['name'] }}</td>
                                <td>
                                    @if(!empty($user['address_details']))
                                     {{$user['address_details']['address1']}}
                                     {{$user['address_details']['address2']}}
                                     {{$user['address_details']['town']}}
                                     {{$user['address_details']['city']}}
                                     {{$user['address_details']['pincode']}}
                                     {{$user['address_details']['state']}}
                                    @else
                                    N/A
                                    @endif
                                </td>

                                <td>
                                    @if(!empty($user['document1']) || !empty($user['document2']))
                                        <a class="table-button view-owner-btn"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sentModal4"
                                        data-documents='@json(array_values(array_filter([
                                                !empty($user["document1"]) ? ["document_path" => $user["document1"]] : null,
                                                !empty($user["document2"]) ? ["document_path" => $user["document2"]] : null,
                                        ])))'>
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td> 
                                    @if(!empty($user['bank_details']))
                                    <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#bankModal" data-bank='@json($user['bank_details'])'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <!-- <td>
                                    @if(!empty($user['bank_details']['upload_proof']))
                                    <a class="table-button view-account-proof-btn" type="button"
                                        data-bs-toggle="modal" data-bs-target="#sentModal3"
                                        data-proof='{{ $user['bank_details']['upload_proof'] }}'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @else
                                    N/A
                                    @endif
                                </td> -->
                                <td>0</td>
                                <td>0 KD</td>
                                 <td>
                                <div class="form-check form-switch" style="justify-content: center;">
                                    <input class="form-check-input toggleStatus" type="checkbox"
                                        id="flexSwitchCheckChecked" data-id="{{ $user['id'] }}"
                                        {{ $user['status'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <td>
            </div>

            <!-- rejected -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                       <form method="GET" action="{{ route('admin.affiliateUserManagement') }}" id="filterForm2">
                            <div class="row">
                                <!-- From Date Filter -->
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="form-group mt-4 w-100">
                                        <label for="from" class="form-label">From:</label>
                                        <input type="date" id="from" name="from_date2" class="form-control"
                                            value="{{ request()->from_date2 }}"
                                            onchange="document.getElementById('filterForm2').submit();" />
                                    </div>
                                </div>

                                <!-- To Date Filter -->
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="form-group mt-4 w-100">
                                        <label for="to" class="form-label">To:</label>
                                        <input type="date" id="to" name="to_date2" class="form-control"
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
                                    <div class="d-flex gap-3 justify-content-end" style="text-align: end">
                                        <a href="{{route('admin.affiliateUserManagement')}}" class="btn btn-dark customBtn"
                                            style="margin-top: 70px">
                                            <span>Reset</span>
                                        </a>
                                          <a class="btn btn-dark customBtn " style="margin-top: 70px">
                                            <span>Export</span>
                                        </a>
                                    </div>
                                </div>
                             
                            </div>
                        </form>

                <div class="table-responsive mt-3">
                    <table id="myTable2" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Joining Date</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">Email ID</th>
                                <th scope="col">Country</th>
                                <th scope="col"> Address</th>
                                <th scope="col">Uploaded ID</th>
                                <th scope="col">Bank Account Details</th>
                                <!-- <th scope="col">Upload Account Proof</th> -->
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedUsers as $index => $user)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') }}</td>
                                <td>
                                    <img src="{{ $user['profile_image'] }}" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>{{ $user['full_name'] }}</td>
                                <td>{{ $user['country_code'] }}{{ $user['mobile'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['country_details']['name'] }}</td>
                                <td>
                                    @if(!empty($user['address_details']))
                                     {{$user['address_details']['address1']}}
                                     {{$user['address_details']['address2']}}
                                     {{$user['address_details']['town']}}
                                     {{$user['address_details']['city']}}
                                     {{$user['address_details']['pincode']}}
                                     {{$user['address_details']['state']}}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($user['document1']) || !empty($user['document2']))
                                        <a class="table-button view-owner-btn"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sentModal4"
                                        data-documents='@json(array_values(array_filter([
                                                !empty($user["document1"]) ? ["document_path" => $user["document1"]] : null,
                                                !empty($user["document2"]) ? ["document_path" => $user["document2"]] : null,
                                        ])))'>
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td> 
                                    @if(!empty($user['bank_details']))
                                    <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#bankModal" data-bank='@json($user['bank_details'])'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <!-- <td>
                                    @if(!empty($user['bank_details']['upload_proof']))
                                    <a class="table-button view-account-proof-btn" type="button"
                                        data-bs-toggle="modal" data-bs-target="#sentModal3"
                                        data-proof='{{ $user['bank_details']['upload_proof'] }}'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @else
                                    N/A
                                    @endif
                                </td> -->
                                <td>{{ $user['reject_reason'] ?? 'N/A' }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>

<!-- reject modal -->
<div class="modal fade" id="xcircle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                     <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reject_type" id="rejectComplete" value="complete" checked>
                                <label class="form-check-label" for="rejectComplete">Complete Reject</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reject_type" id="rejectDocument" value="document">
                                <label class="form-check-label" for="rejectDocument">Document Reject</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="div">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Reason For Rejection</label>
                                <textarea class="form-control" id="rejectReason" rows="3"></textarea>
                                <div id="error-message" class="text-danger mt-2" style="display:none;">Please Enter Reason</div>
                            </div>
                        </div>
                    </div>
                </div>
             
                  <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center mt-3">
                                        <a type="button" class="btn btn-dark customBtn" id="submitReject">Reject Seller</a>
                                    </div>
            </div>
         
        </div>
    </div>
</div>

<div class="modal fade" id="sentModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Documents</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="documentContainer" class="appointment-container d-flex flex-wrap  justify-content-center">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- bank proof modal -->
<div class="modal fade" id="sentModal3" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Uploaded Account Proof</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <a id="accountProofLink" href="#" target="_blank">
                    <img id="accountProofImage" src="" alt="Account Proof" class="img-fluid rounded border"
                        style="cursor:pointer;width: 200px;height: 200px;">
                </a>
            </div>
        </div>
    </div>
</div>

<!-- bank details modal -->
<div class="modal fade" id="bankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5">Bank Details</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
         
                <table class="details-table">
                    <tr>
                        <th>IBAN</th>
                        <td id="modalIban">N/A</td>
                    </tr>
                    <tr>
                        <th>SWIFT</th>
                        <td id="modalSwift">N/A</td>
                    </tr>
                    <tr>
                        <th>Bank Name</th>
                        <td id="modalBankName">N/A</td>
                    </tr>
                    <tr>
                        <th>Account Holder Name</th>
                        <td id="modalHolderName">N/A</td>
                    </tr>
                    <tr>
                        <th>Account Number</th>
                        <td id="modalAccountNumber">N/A</td>
                    </tr>
                </table>

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

<!-- block unblock seller -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let userId = this.getAttribute('data-id');
            let isChecked = this.checked;

            fetch(`/admin/blockUnblockAffiliateUser/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: isChecked ? 1 : 0
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (isChecked) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                        this.checked = !isChecked;
                    }
                })
                .catch(error => {
                    toastr.error('Something went wrong while updating status.');
                    this.checked = !isChecked;
                });
        });
    });
});
</script>

<!-- bank details -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-bank-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bank = JSON.parse(this.getAttribute('data-bank') || '{}');
            document.getElementById('modalIban').textContent = bank.iban || 'N/A';
            document.getElementById('modalSwift').textContent = bank.swift || 'N/A';
            document.getElementById('modalBankName').textContent = bank.bank_name || 'N/A';
            document.getElementById('modalHolderName').textContent = bank.account_holder_name || 'N/A';
            document.getElementById('modalAccountNumber').textContent = bank.account_no || 'N/A';
        });
    });
});
</script>

<!-- bank proof -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-account-proof-btn').forEach(button => {
        button.addEventListener('click', function() {
            const proofUrl = this.getAttribute('data-proof') || '';
            const img = document.getElementById('accountProofImage');
            const link = document.getElementById('accountProofLink');

            img.src = proofUrl;
            link.href = proofUrl;
        });
    });
});
</script>

<!-- uploaded id -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const documentContainer = document.getElementById('documentContainer');
    const documentButtons = document.querySelectorAll('.view-owner-btn');

    if (!documentContainer || documentButtons.length === 0) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function () {

            // Clear previous images
            documentContainer.innerHTML = '';

            let documents = [];

            // Read documents JSON
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (error) {
                console.error('Invalid documents JSON', error);
                documentContainer.innerHTML =
                    '<p class="text-danger">Failed to load documents.</p>';
                return;
            }

            // No documents case
            if (!Array.isArray(documents) || documents.length === 0) {
                documentContainer.innerHTML =
                    '<p class="text-muted">No documents available.</p>';
                return;
            }

            // Loop through documents and render images
            documents.forEach(doc => {
                if (!doc.document_path) return;

                const img = document.createElement('img');
                img.src = doc.document_path;
                img.alt = 'Document';
                img.className = 'img-fluid rounded border m-2';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                img.style.cursor = 'pointer';

                // Open full image on click
                img.addEventListener('click', () => {
                    window.open(doc.document_path, '_blank');
                });

                documentContainer.appendChild(img);
            });
        });
    });

});
</script>

<!-- accept user -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.acceptUser').forEach(button => {
        button.addEventListener('click', function() {
            let userId = this.getAttribute('data-id');

            fetch(`/admin/acceptAffiliateUser/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: userId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        toastr.success(data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                })
                .catch(error => {
                    toastr.error('Something went wrong while accepting the seller.');
                });
        });
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    let sellerId = null;

    document.querySelectorAll('.table-button').forEach(button => {
        button.addEventListener('click', function() {
            userId = this.getAttribute('data-id');
        });
    });

    document.getElementById('submitReject').addEventListener('click', function() {
        var rejectReason = document.getElementById('rejectReason').value;
        var rejectType = document.querySelector('input[name="reject_type"]:checked').value;
        var errorMessage = document.getElementById('error-message');

        if (rejectReason.trim() === '') {
            errorMessage.style.display = 'block';
        } else {
            errorMessage.style.display = 'none';
            if (userId) {
                fetch(`/admin/rejectAffiliateUser/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            reject_reason: rejectReason,
                            reject_type: rejectType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            toastr.success(data.message);
                            setTimeout(() => {
                                $('#xcircle').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            toastr.error(data.message);
                        }
                    })
                    .catch(error => {
                        toastr.error('Something went wrong while rejecting the seller.');
                    });
            }
        }
    });

    // Remove error message when typing starts
    document.getElementById('rejectReason').addEventListener('input', function() {
        var errorMessage = document.getElementById('error-message');
        errorMessage.style.display = 'none'; // Hide error message when typing
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('xcircle');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
});
</script>


@endsection
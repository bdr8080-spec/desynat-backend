@extends('admin.layout.app')
@section('content')

<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <h2 class="h2">Seller management</h2>
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
                    <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab"
                        tabindex="0">

                        <form method="GET" action="{{ route('sellerManagement') }}" id="filterForm">
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
                                        <label for="to" class="form-label d-none">To:</label>
                                        <select name="country_id" id="country_id"
                                            class="form-select form-select-lg mt-4"
                                            onchange="document.getElementById('filterForm').submit();">
                                            <option value="">Select country</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country['id'] }}"
                                                {{ request('country_id') == $country['id'] ? 'selected' : '' }}>
                                                {{ $country['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 col-12">
                                    <div class="d-flex justify-content-end" style="text-align: end">
                                        <a href="{{route('sellerManagement')}}" class="btn btn-dark customBtn"
                                            style="margin-top: 56px">
                                            <span>Reset</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- Export Button -->
                                <div class="col-lg-1 col-md-12 col-12">
                                    <div class="d-flex justify-content-end" style="text-align: end">
                                        <a class="btn btn-dark customBtn " style="margin-top: 56px">
                                            <span>Export</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive mt-5">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr.No</th>
                                        <th scope="col">Joining Date</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Store Address</th>
                                        <th scope="col">Store Mail ID</th>
                                        <th scope="col">Bio</th>
                                        <th scope="col">Uploaded ID</th>
                                        <th scope="col">Uploaded Store Document</th>
                                        <th scope="col">Bank Account Details</th>
                                        <th scope="col">Upload Account Proof</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($newSellers as $index => $seller)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ \Carbon\Carbon::parse($seller['created_at'])->format('d-m-Y') }}</td>
                                        <td>
                                            <img src="{{ $seller['profile_pic'] }}" alt="Profile Image" width="40px"
                                                height="40px" class="square" />
                                        </td>
                                        <td>{{ $seller['first_name'] }}</td>
                                        <td>{{ $seller['last_name'] }}</td>
                                        <td>{{ $seller['country_code'] }}{{ $seller['mobile'] }}</td>
                                        <td>{{ $seller['email'] }}</td>
                                        @php
                                        if (!empty($seller['store_info']['country'])) {
                                        $country = \App\Models\Country::find($seller['store_info']['country']);
                                        $countryName = $country->name ?? 'N/A';
                                        }
                                        @endphp
                                        <td>{{ $countryName ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_name'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_address'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_mail_id'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['bio'] ?? 'N/A' }}</td>
                                        <td>
                                            @if(!empty($seller['owner_document']))
                                            <a class="table-button view-owner-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4" data-documents='@json($seller['owner_document'])'>                              
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <!-- <td>
                                            @if(!empty($seller['store_document']))
                                            <a class="table-button view-store-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal5" data-documents='@json($seller['store_document'])' data-doc-type="Owner Documents">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td> -->
                                        <td>
                                            @if(!empty($seller['store_document']) || !empty($seller['store_info']['store_image']))
                                            <a class="table-button view-store-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal5"
                                                data-documents='@json($seller['store_document'])'
                                                data-store-image="{{ $seller['store_info']['store_image'] ?? '' }}"
                                                data-doc-type="Owner Documents">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($seller['seller_bank_details']))
                                            <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#bankModal" data-bank='@json($seller['seller_bank_details'])'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($seller['seller_bank_details']['upload_proof']))
                                            <a class="table-button view-account-proof-btn" type="button"
                                                data-bs-toggle="modal" data-bs-target="#sentModal3"
                                                data-proof='{{ $seller['seller_bank_details']['upload_proof'] }}'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <a class="table-button acceptSeller" type="button"
                                                    data-id="{{ $seller['id'] }}">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </a>
                                                <a class="table-button" data-bs-toggle="modal" data-bs-target="#xcircle"
                                                    type="button" data-id="{{ $seller['id'] }}">
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
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab" tabindex="0">
                        <form method="GET" action="{{ route('sellerManagement') }}" id="filterForm1">
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
                                        <label for="to" class="form-label d-none">To:</label>
                                        <select name="country_id1" id="country_id"
                                            class="form-select form-select-lg mt-4"
                                            onchange="document.getElementById('filterForm1').submit();">
                                            <option value="">Select country</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country['id'] }}"
                                                {{ request('country_id1') == $country['id'] ? 'selected' : '' }}>
                                                {{ $country['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 col-12">
                                    <div class="d-flex justify-content-end" style="text-align: end">
                                        <a href="{{route('sellerManagement')}}" class="btn btn-dark customBtn "
                                            style="margin-top: 56px">
                                            <span>Reset</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- Export Button -->
                                <div class="col-lg-1 col-md-12 col-12">
                                    <div class="d-flex justify-content-end" style="text-align: end">
                                        <a class="btn btn-dark customBtn " style="margin-top: 56px">
                                            <span>Export</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-5">
                            <table id="myTable1" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr.No</th>
                                        <th scope="col">Joining Date</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Store Address</th>
                                        <th scope="col">Store Mail ID</th>
                                        <th scope="col">Bio</th>
                                        <th scope="col">Uploaded ID</th>
                                        <th scope="col">Uploaded Store Document</th>
                                        <th scope="col">Bank Account Details</th>
                                        <th scope="col">Upload Account Proof</th>
                                        <th scope="col">Active Plan</th>
                                        <th scope="col">Total Number of Completed</th>
                                        <th scope="col">Total Number of Cancelled Order</th>
                                        <th scope="col">Total Earning</th>
                                        <th scope="col">Total Commission Paid</th>
                                        <th scope="col">Average Rating</th>
                                        <th scope="col">View Reels</th>
                                        <th scope="col">View Highlights</th>
                                        <th scope="col">Unblock/Block</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvedSellers as $index => $seller)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ \Carbon\Carbon::parse($seller['created_at'])->format('d-m-Y') }}</td>
                                        <td>
                                            <img src="{{ $seller['profile_pic'] }}" alt="Profile Image" width="40px"
                                                height="40px" class="square" />
                                        </td>
                                        <td>{{ $seller['first_name'] }}</td>
                                        <td>{{ $seller['last_name'] }}</td>
                                        <td>{{ $seller['country_code'] }}{{ $seller['mobile'] }}</td>
                                        <td>{{ $seller['email'] }}</td>
                                        @php
                                        if (!empty($seller['store_info']['country'])) {
                                        $country = \App\Models\Country::find($seller['store_info']['country']);
                                        $countryName = $country->name ?? 'N/A';
                                        }
                                        @endphp
                                        <td>{{ $countryName ?? 'N/A'}}</td>
                                        <td>{{ $seller['store_info']['store_name'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_address'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_mail_id'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['bio'] ?? 'N/A' }}</td>
                                        <td>
                                            @if(!empty($seller['owner_document']))
                                            <a class="table-button view-owner-btn" type="button" data-bs-toggle="modal" data-bs-target="#sentModal4" data-documents='@json($seller['owner_document'])'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <!-- <td>
                                            @if(!empty($seller['store_document']))
                                            <a class="table-button view-store-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal5" data-documents='@json($seller['store_document'])' data-doc-type="Owner Documents">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td> -->
                                        <td>
                                            @if(!empty($seller['store_document']) || !empty($seller['store_info']['store_image']))
                                            <a class="table-button view-store-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal5"
                                                data-documents='@json($seller['store_document'])'
                                                data-store-image="{{ $seller['store_info']['store_image'] ?? '' }}"
                                                data-doc-type="Owner Documents">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($seller['seller_bank_details']))
                                            <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#bankModal" data-bank='@json($seller['seller_bank_details'])'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($seller['seller_bank_details']['upload_proof']))
                                            <a class="table-button view-account-proof-btn" type="button"
                                                data-bs-toggle="modal" data-bs-target="#sentModal3"
                                                data-proof='{{ $seller['seller_bank_details']['upload_proof'] }}'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        @php
                                        $planName = 'N/A';
                                        if (!empty($seller['subcription_plan'])) {
                                        $plan = \App\Models\Plan::find($seller['subcription_plan'][0]['plan_id']);
                                        if ($plan) {
                                        $planName = $plan->plan_name_english;
                                        }
                                        }
                                        @endphp
                                        <td>{{ $planName ?? 'N/A'}}</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>KD 0</td>
                                        <td>KD 0</td>
                                        <td>0
                                            <i class="bi bi-star-fill"></i>

                                        </td>
                                        <td> <a class="table-button" type="button">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>
                                            <div class="form-check form-switch" style="justify-content: center;">
                                                <input class="form-check-input toggleStatus" type="checkbox"
                                                    id="flexSwitchCheckChecked" data-id="{{ $seller['id'] }}"
                                                    {{ $seller['is_block'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>
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
                        <form method="GET" action="{{ route('sellerManagement') }}" id="filterForm2">
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
                                        <label for="to" class="form-label d-none">To:</label>
                                        <select name="country_id2" id="country_id"
                                            class="form-select form-select-lg mt-4"
                                            onchange="document.getElementById('filterForm2').submit();">
                                            <option value="">Select country</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country['id'] }}"
                                                {{ request('country_id2') == $country['id'] ? 'selected' : '' }}>
                                                {{ $country['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 col-12">
                                    <div class="d-flex justify-content-end" style="text-align: end">
                                        <a href="{{route('sellerManagement')}}" class="btn btn-dark customBtn"
                                            style="margin-top: 56px">
                                            <span>Reset</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- Export Button -->
                                <div class="col-lg-1 col-md-12 col-12">
                                    <div class="d-flex justify-content-end" style="text-align: end">
                                        <a class="btn btn-dark customBtn " style="margin-top: 56px">
                                            <span>Export</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-5">
                            <table id="myTable2" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr.No</th>
                                        <th scope="col">Joining Date</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Store Address</th>
                                        <th scope="col">Store Mail ID</th>
                                        <th scope="col">Bio</th>
                                        <th scope="col">Uploaded ID</th>
                                        <th scope="col">Uploaded Store Document</th>
                                        <th scope="col">Bank Account Details</th>
                                        <th scope="col">Upload Account Proof</th>
                                        <th scope="col">Rejection Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rejectedSellers as $index => $seller)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ \Carbon\Carbon::parse($seller['created_at'])->format('d-m-Y') }}</td>
                                        <td>
                                            <img src="{{ $seller['profile_pic'] }}" alt="Profile Image" width="40px"
                                                height="40px" class="square" />
                                        </td>
                                        <td>{{ $seller['first_name'] }}</td>
                                        <td>{{ $seller['last_name'] }}</td>
                                        <td>{{ $seller['country_code'] }}{{ $seller['mobile'] }}</td>
                                        <td>{{ $seller['email'] }}</td>
                                        @php
                                        if (!empty($seller['store_info']['country'])) {
                                        $country = \App\Models\Country::find($seller['store_info']['country']);
                                        $countryName = $country->name ?? 'N/A';
                                        }
                                        @endphp
                                        <td>{{ $countryName ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_name'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_address'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['store_mail_id'] ?? 'N/A' }}</td>
                                        <td>{{ $seller['store_info']['bio'] ?? 'N/A' }}</td>
                                        <td>
                                            @if(!empty($seller['owner_document']))
                                            <a class="table-button view-owner-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4" data-documents='@json($seller['owner_document'])'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <!-- <td>
                                            @if(!empty($seller['store_document']))
                                            <a class="table-button view-store-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal5" data-documents='@json($seller['store_document'])' data-doc-type="Owner Documents">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td> -->
                                        <td>
                                            @if(!empty($seller['store_document']) || !empty($seller['store_info']['store_image']))
                                            <a class="table-button view-store-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal5"
                                                data-documents='@json($seller['store_document'])'
                                                data-store-image="{{ $seller['store_info']['store_image'] ?? '' }}"
                                                data-doc-type="Owner Documents">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($seller['seller_bank_details']))
                                            <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                                data-bs-target="#bankModal" data-bank='@json($seller['seller_bank_details'])'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($seller['seller_bank_details']['upload_proof']))
                                            <a class="table-button view-account-proof-btn" type="button"
                                                data-bs-toggle="modal" data-bs-target="#sentModal3"
                                                data-proof='{{ $seller['seller_bank_details']['upload_proof'] }}'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>{{ $seller['reject_reason'] ?? 'N/A' }}</td>
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
    </div>
</div>


<!-- bank modal -->
<div class="modal fade" id="bankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5">Bank Details</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label class="form-label">IBAN</label>
                    <input type="text" class="form-control" id="modalIban" readonly>
                </div>
                <div class="form-group mb-2">
                    <label class="form-label">SWIFT</label>
                    <input type="text" class="form-control" id="modalSwift" readonly>
                </div>
                <div class="form-group mb-2">
                    <label class="form-label">Bank Name</label>
                    <input type="text" class="form-control" id="modalBankName" readonly>
                </div>
                <div class="form-group mb-2">
                    <label class="form-label">Account Holder Name</label>
                    <input type="text" class="form-control" id="modalHolderName" readonly>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- id-modal -->
<div class="modal fade" id="sentModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Documents</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="documentContainer" class="appointment-container d-flex flex-wrap gap-3 justify-content-center">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- store-modal -->
<!-- <div class="modal fade" id="sentModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Store Documents</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="documentContainer1"
                    class="appointment-container d-flex flex-wrap gap-3 justify-content-center">
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- store-modal -->
<div class="modal fade" id="sentModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Store Details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <!-- Store Image Section -->
                <div id="storeImageSection" class="text-center mb-4" style="display: none;">
                    <h5>Store Image</h5>
                    <img id="storeImage" src="" alt="Store Image"
                        class="img-fluid rounded border shadow-sm mt-2"
                        style="width: 250px;height: 177px;">
                </div>

                <!--  Store Documents Section -->
                <div class="text-center mb-3">
                    <h5>Store Documents</h5>
                </div>
                <div id="documentContainer1"
                    class="appointment-container d-flex flex-wrap gap-3 justify-content-center">
                </div>

            </div>
        </div>
    </div>
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
                        style="cursor:pointer;">
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- owner document -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-owner-btn');
    const documentContainer = document.getElementById('documentContainer');

    if (!documentContainer) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
            documentContainer.innerHTML = '';
            let documents = [];
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    '<p class="text-muted">No documents available.</p>';
                return;
            }
            documents.forEach(doc => {
                const imgPath = doc.document_path;

                const img = document.createElement('img');
                img.src = imgPath;
                img.alt = 'Document';
                img.classList.add('img-fluid', 'rounded', 'border', 'm-2');
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                img.style.cursor = 'pointer';

                // Optional: click to open full-size
                img.addEventListener('click', () => window.open(imgPath, '_blank'));

                documentContainer.appendChild(img);
            });
        });
    });
});
</script>

<!-- store document -->
<script>
// document.addEventListener('DOMContentLoaded', function() {
//     const documentButtons = document.querySelectorAll('.view-store-btn');
//     const documentContainer = document.getElementById('documentContainer1');

//     if (!documentContainer) return;

//     documentButtons.forEach(button => {
//         button.addEventListener('click', function() {
//             documentContainer.innerHTML = '';
//             let documents = [];
//             try {
//                 documents = JSON.parse(this.getAttribute('data-documents') || '[]');
//             } catch (e) {
//                 console.error('Failed to parse documents JSON', e);
//             }

//             if (documents.length === 0) {
//                 documentContainer.innerHTML =
//                     '<p class="text-muted">No documents available.</p>';
//                 return;
//             }
//             documents.forEach(doc => {
//                 const imgPath = doc.document_path;

//                 const img = document.createElement('img');
//                 img.src = imgPath;
//                 img.alt = 'Document';
//                 img.classList.add('img-fluid', 'rounded', 'border', 'm-2');
//                 img.style.maxWidth = '200px';
//                 img.style.maxHeight = '200px';
//                 img.style.cursor = 'pointer';

//                 img.addEventListener('click', () => window.open(imgPath, '_blank'));

//                 documentContainer.appendChild(img);
//             });
//         });
//     });
// });
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-store-btn');
    const documentContainer = document.getElementById('documentContainer1');
    const storeImageSection = document.getElementById('storeImageSection');
    const storeImage = document.getElementById('storeImage');

    if (!documentContainer) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
            documentContainer.innerHTML = '';
            storeImageSection.style.display = 'none';
            storeImage.src = '';

            const imageUrl = this.getAttribute('data-store-image');
            if (imageUrl && imageUrl !== 'null' && imageUrl !== '') {
                storeImage.src = imageUrl;
                storeImageSection.style.display = 'block';
                storeImage.onclick = () => window.open(imageUrl, '_blank');
            } else {
                storeImage.onclick = null; 
            }

            let documents = [];
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    '<p class="text-muted">No documents available.</p>';
                return;
            }

            documents.forEach(doc => {
                const imgPath = doc.document_path;

                const img = document.createElement('img');
                img.src = imgPath;
                img.alt = 'Document';
                img.classList.add('img-fluid', 'rounded', 'border', 'm-2');
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                img.style.cursor = 'pointer';

                img.addEventListener('click', () => window.open(imgPath, '_blank'));
                documentContainer.appendChild(img);
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
            document.getElementById('modalIban').value = bank.iban || '';
            document.getElementById('modalSwift').value = bank.swift || '';
            document.getElementById('modalBankName').value = bank.bank_name || '';
            document.getElementById('modalHolderName').value = bank.account_holder_name || '';
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
            let sellerId = this.getAttribute('data-id');
            let isChecked = this.checked;

            fetch(`/admin/blockUnblockSeller/${sellerId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_block: isChecked ? 1 : 0
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (isChecked) {
                            toastr.error(data.message);
                        } else {
                            toastr.success(data.message);
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

<!-- accept seller -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.acceptSeller').forEach(button => {
        button.addEventListener('click', function() {
            let sellerId = this.getAttribute('data-id');

            fetch(`/admin/acceptSeller/${sellerId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        seller_id: sellerId
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
            sellerId = this.getAttribute('data-id');
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
            if (sellerId) {
                fetch(`/admin/rejectSeller/${sellerId}`, {
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
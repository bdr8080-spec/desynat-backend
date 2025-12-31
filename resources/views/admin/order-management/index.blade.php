@extends('admin.layout.app')
@section('content')
<style>
    a.btn.btn-dark.customBtn {
    border: 1px solid rgba(168, 130, 79, 1);
    /* background: var(--bg-color); */
    background: linear-gradient(to bottom left, #F9DBAB, #7D532F);
    color: #fff;
    /* line-height: 18px; */
    font-size: 14px !important;
    padding: 9px !important;
}
</style>


<div class="inner-content management">
    <h2 class="h2">Order Management</h2>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    Active Orders
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="false">
                    Return & Exchange
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Completed
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-cancelled-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-cancelled" type="button" role="tab" aria-controls="pills-cancelled"
                    aria-selected="false">
                    Cancelled
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <form method="GET" action="{{ route('admin.orderManagement') }}" id="filterForm">
                    <input type="hidden" name="type" value="active" />
                <div class="row">
                    <!-- <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select Status</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'active' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" class="form-control"
                                value="{{ request('type') == 'active' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'active' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

               <div class="table-responsive mt-4">
                    <table id="myTable" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy Company Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Zone</th>
                                <th scope="col">Assign Driver</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($activeOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['order']['order_id'] }}</td>
                                <td>
                                    @php
                                        $firstOrderDetail = $data['product_details']->first();
                                    @endphp
                                    @if($firstOrderDetail && $firstOrderDetail['seller_details'])
                                        {{ $firstOrderDetail['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['seller_details']['last_name'] }}
                                    @else
                                        Seller not found
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <td>
                                    <a class="table-button view-products"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sentModal1"
                                    data-product='@json($data)'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td>{{ $data['order']['delivery_details']['address'] }}
                                    <!-- {{ $data['order']['delivery_details']['house_no'] }} -->
                                    {{ $data['order']['delivery_details']['postal_code'] }}
                                    <!-- {{ $data['order']['delivery_details']['city'] }} -->
                                    {{ $data['order']['delivery_details']['state'] }}
                                    <!-- {{ $data['order']['delivery_details']['country_name'] }} -->
                                </td>
                                <td>
                                    @if($data['amount'] == floor($data['amount']))
                                        {{ intval($data['amount']) }} KD
                                    @else
                                        {{ number_format($data['amount'], 2) }} KD
                                    @endif
                                </td>
                                <td>{{ $data['admin_commission'] ?? 'N/A' }} KD</td>
                                <td>Normal</td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        Not Assigned
                                    @else
                                        {{ $data['driver_details']['full_name_english'] }}
                                    @endif
                                </td>
                                <td>N/A</td>
                                @php
                                    $deliveryStatuses = [
                                        1 => 'Confirmed',
                                        2 => 'On The Way',
                                        3 => 'Delivered',
                                        4 => 'Cancelled',
                                        5 => 'Return',
                                        6 => 'Confirmed',
                                        7 => 'Picked',
                                        8 => 'Not Delivered',
                                    ];
                                @endphp
                                <td>{{ $deliveryStatuses[$data['delivery_status']] ?? 'Unknown' }}</td>
                                <td>
                                    <a href="{{ url('Invoice', ['order_id' => $data['order']['order_id']]) }}" target="_blank" class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>{{ $data['driver_details']['zone_info']['name_english'] ?? 'N/A' }}</td>
                                <td>
                                    @if($data['assign_status'] == 0 && $data['order']['delivery_details']['country_code'] === '+965')
                                    <a class="btn btn-dark customBtn assignDriverBtn"
                                    href="javascript:void(0)"
                                    data-order-id="{{ $data['id'] }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#assignModal">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>


            <!-- return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.orderManagement') }}" id="filterForm1">
                    <input type="hidden" name="type" value="return" />
                <div class="row">
                    <!-- <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select Status</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'return' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm1').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" class="form-control"
                                value="{{ request('type') == 'return' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm1').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm1').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'return' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable1" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>

                                <th scope="col">Order Amount</th>

                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy Company Name</th>
                                <th scope="col">Exchange or Return</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Status</th>
                                <th scope="col">Zone</th>
                                <th scope="col">Assign Driver</th>


                            </tr>
                        </thead>
                        <tbody>
                           @forelse($returnOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['order']['order_id'] }}</td>
                                <td>
                                    @php
                                        $firstOrderDetail = $data['product_details']->first();
                                    @endphp
                                    @if($firstOrderDetail && $firstOrderDetail['seller_details'])
                                        {{ $firstOrderDetail['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['seller_details']['last_name'] }}
                                    @else
                                        Seller not found
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <td>
                                    <a class="table-button view-products"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sentModal1"
                                    data-product='@json($data)'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td>{{ $data['order']['delivery_details']['address'] }}
                                    <!-- {{ $data['order']['delivery_details']['house_no'] }} -->
                                    {{ $data['order']['delivery_details']['postal_code'] }}
                                    <!-- {{ $data['order']['delivery_details']['city'] }} -->
                                    {{ $data['order']['delivery_details']['state'] }}
                                    <!-- {{ $data['order']['delivery_details']['country_name'] }} -->
                                </td>
                                <td>
                                    @if($data['amount'] == floor($data['amount']))
                                        {{ intval($data['amount']) }} KD
                                    @else
                                        {{ number_format($data['amount'], 2) }} KD
                                    @endif
                                </td>
                                <td>{{ $data['admin_commission'] ?? 'N/A' }} KD</td>
                                <td>Normal</td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        Not Assigned
                                    @else
                                        {{ $data['driver_details']['full_name_english'] }}
                                    @endif
                                </td>
                                <td>N/A</td>
                                @php
                                    $deliveryStatuses = [
                                        1 => 'Return',
                                        2 => 'Exchange',
                                    ];
                                @endphp
                                <td>{{ $deliveryStatuses[$data['return_type']] ?? 'Unknown' }}</td>
                                <td>
                                    @if($data['return_type'] == '1')
                                    {{ $data['return_reason'] ?? 'N/A' }}
                                    @elseif($data['return_type'] == '2')
                                    {{ $data['exchange_reason'] ?? 'N/A' }}
                                    @endif
                                </td>
                                @php
                                    $deliveryStatus = [
                                        1 => 'Pending',
                                        2 => 'On The Way',
                                        3 => 'Delivered',
                                        4 => 'Cancelled',
                                        5 => 'Return',
                                        6 => 'Confirmed',
                                        7 => 'Picked',
                                        8 => 'Not Delivered',
                                    ];
                                @endphp
                                <td>{{ $deliveryStatus[$data['delivery_status']] ?? 'Unknown' }}</td>
                                <td>{{ $data['driver_details']['zone_info']['name_english'] ?? 'N/A' }}</td>
                                <td>
                                    @if($data['assign_status'] == 0 && $data['order']['delivery_details']['country_code'] === '+965')
                                    <a class="btn btn-dark customBtn assignDriverBtn"
                                    href="javascript:void(0)"
                                    data-order-id="{{ $data['id'] }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#assignModal">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- completed -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.orderManagement') }}" id="filterForm2">
                    <input type="hidden" name="type" value="complete" />
                <div class="row">
                    <!-- <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select Status</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'complete' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm2').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" class="form-control"
                                value="{{ request('type') == 'complete' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm2').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm2').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'complete' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable2" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy Company Name</th>
                                <th scope="col">Rating & Review</th>
                                <th scope="col">Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completeOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['order']['order_id'] }}</td>
                                <td>
                                    @php
                                        $firstOrderDetail = $data['product_details']->first();
                                    @endphp
                                    @if($firstOrderDetail && $firstOrderDetail['seller_details'])
                                        {{ $firstOrderDetail['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['seller_details']['last_name'] }}
                                    @else
                                        Seller not found
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <td>
                                    <a class="table-button view-products"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sentModal1"
                                    data-product='@json($data)'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td>{{ $data['order']['delivery_details']['address'] }}
                                    <!-- {{ $data['order']['delivery_details']['house_no'] }} -->
                                    {{ $data['order']['delivery_details']['postal_code'] }}
                                    <!-- {{ $data['order']['delivery_details']['city'] }} -->
                                    {{ $data['order']['delivery_details']['state'] }}
                                    <!-- {{ $data['order']['delivery_details']['country_name'] }} -->
                                </td>
                                <td>
                                    @if($data['amount'] == floor($data['amount']))
                                        {{ intval($data['amount']) }} KD
                                    @else
                                        {{ number_format($data['amount'], 2) }} KD
                                    @endif
                                </td>

                                <td>{{ $data['admin_commission'] ?? 'N/A' }} KD</td>
                                <td>Normal</td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        Not Assigned
                                    @else
                                        {{ $data['driver_details']['full_name_english'] }}
                                    @endif
                                </td>
                                <td>N/A</td>
                                <td data-bs-toggle="modal" 
                                    data-bs-target="#sentModalrating" 
                                    style="cursor: pointer;"
                                    data-user='@json($data)'>
                                    <i class="bi bi-star-fill text-warning"></i> 
                                    <span class="rating-number">{{ $data['user_rating_review_provide']['product_rating'] ?? 'N/A' }} Rating</span>
                                </td>
                                <td>
                                    <a href="{{ url('Invoice', ['order_id' => $data['order']['order_id']]) }}" target="_blank" class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-cancelled" role="tabpanel" aria-labelledby="pills-cancelled-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.orderManagement') }}" id="filterForm3">
                    <input type="hidden" name="type" value="cancelled" />
                <div class="row">
                    <!-- <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select Status</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'cancelled' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm3').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" class="form-control"
                                value="{{ request('type') == 'cancelled' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm3').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm3').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'cancelled' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable3" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy Company Name</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cancelledOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['order']['order_id'] }}</td>
                                <td>
                                    @php
                                        $firstOrderDetail = $data['product_details']->first();
                                    @endphp
                                    @if($firstOrderDetail && $firstOrderDetail['seller_details'])
                                        {{ $firstOrderDetail['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['seller_details']['last_name'] }}
                                    @else
                                        Seller not found
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <td>
                                    <a class="table-button view-products"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sentModal1"
                                    data-product='@json($data)'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td>{{ $data['order']['delivery_details']['address'] }}
                                    <!-- {{ $data['order']['delivery_details']['house_no'] }} -->
                                    {{ $data['order']['delivery_details']['postal_code'] }}
                                    <!-- {{ $data['order']['delivery_details']['city'] }} -->
                                    {{ $data['order']['delivery_details']['state'] }}
                                    <!-- {{ $data['order']['delivery_details']['country_name'] }} -->
                                </td>
                                <td>
                                    @if($data['amount'] == floor($data['amount']))
                                        {{ intval($data['amount']) }} KD
                                    @else
                                        {{ number_format($data['amount'], 2) }} KD
                                    @endif
                                </td>
                                <td>{{ $data['admin_commission'] ?? 'N/A' }} KD</td>
                                <td>Normal</td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        Not Assigned
                                    @else
                                        {{ $data['driver_details']['full_name_english'] }}
                                    @endif
                                </td>
                                <td>N/A</td>
                                <td>{{ $data['cancel_reason'] ?? 'N/A' }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>


<!-- review model -->
<div class="modal fade" id="sentModalrating" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Seller rating & Review</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="overlay">
                <div class="review-modal">

                    <!-- Seller Review Box -->
                    <div class="review-box" id="sellerReviewBox">
                        <div class="stars" id="sellerStars"></div>
                        <p class="review-text" id="sellerReviewText"></p>

                        <div class="attached-images" id="sellerImagesContainer" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                    </div>

                    <h4 class="product-title" id="productTitle">Product Name</h4>

                    <!-- Product Review Box -->
                    <div class="review-box" id="productReviewBox">
                        <div class="stars center" id="productStars"></div>
                        <p class="review-text" id="productReviewText"></p>

                        <div class="attached-images" id="productImagesContainer" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




<!-- Product Details Modal -->
<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Product Details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="overlay">
                    <div class="product-modal" id="productModalBody">
                        <div class="product-card d-none" id="productCardTemplate">
                            <div class="product-img">
                                <img src="/admin/image/download.jpeg" alt="product" class="product-image">
                            </div>
                            <div class="product-info">
                                <div class="left">
                                    <p><strong class="product-name">Name</strong></p>
                                    <p class="product-category">Category</p>
                                    <p class="product-brand">Brand</p>
                                </div>
                                <div class="right">
                                    <p class="product-subcategory">Sub-Category</p>
                                    <p class="product-price">Price</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Assign Delivey Boy Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header management border-0">
                <h2 class="h2">Assign Delivery Boy</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body m-auto mb-4">
                <div class="row">
                    <div class="col-lg-12">

                        <!-- ORDER ID -->
                        <input type="hidden" id="orderId">

                        <div class="form-group w-100 m-auto">
                            <select class="form-select form-select-lg mt-4 " id="driverSelect">
                                <option value="">Loading...</option>
                            </select>
                        </div>

                        <div class="col-lg-12 d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-dark customBtn" id="assignDriverSubmit">
                                Submit
                            </button>
                        </div>

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

<script>
document.addEventListener('DOMContentLoaded', function () {

    const modalBody = document.getElementById('productModalBody');
    const templateCard = document.getElementById('productCardTemplate');

    //console.log('modalBody:', modalBody);
    //console.log('templateCard:', templateCard);

    if (!modalBody || !templateCard) {
        //console.error('Modal elements not found. Check IDs.');
        return;
    }

    const buttons = document.querySelectorAll('.view-products');
    //console.log('Found buttons:', buttons.length);

    buttons.forEach(button => {

        //console.log('Button element:', button);
        //console.log('data-product attribute:', button.dataset.product);

        button.addEventListener('click', function () {

            //console.log('Clicked button:', this);

            // Clear old cards
            modalBody.querySelectorAll('.product-card:not(#productCardTemplate)')
                .forEach(card => card.remove());

            const raw = this.dataset.product; 
            console.log('Raw data-product:', raw);

            if (!raw) {
                //console.error('data-product is empty!');
                return;
            }

            let item;
            try {
                item = JSON.parse(raw);
               // console.log('Parsed item:', item);
            } catch (e) {
                //console.error('JSON parse error:', e, raw);
                return;
            }

            const card = templateCard.cloneNode(true);
            card.classList.remove('d-none');
            card.removeAttribute('id');

            //console.log('Card cloned:', card);

            card.querySelector('.product-image').src =
                item.variation_details?.variant_image?.[0]
                || '/admin/image/download.jpeg';

            card.querySelector('.product-name').textContent =
                item.product_details?.product_name_en ?? 'N/A';

            card.querySelector('.product-category').textContent =
                'Category: ' + (item.product_details?.category?.name ?? 'N/A');

            card.querySelector('.product-brand').textContent =
                'Brand: ' + (item.product_details?.brand?.name_english ?? 'N/A');

            card.querySelector('.product-subcategory').textContent =
                'Sub-Category: ' +
                (item.product_details?.subcategory?.name_english ?? 'N/A');

            card.querySelector('.product-price').textContent =
                'Price: ' + (item.amount ?? '0') + ' KD';

            modalBody.appendChild(card);

           // console.log('Card appended to modal body');
        });

    });
});
</script>





<script>
document.addEventListener('click', function (e) {

    const button = e.target.closest('.assignDriverBtn');
    if (!button) return;

    const orderId = button.dataset.orderId;
    const driverSelect = document.getElementById('driverSelect');
    const orderIdInput = document.getElementById('orderId');

    orderIdInput.value = orderId;
    driverSelect.innerHTML = '<option>Loading...</option>';

    fetch(`{{ route('admin.getDriverListToAssign') }}?order_id=${orderId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(response => {

        if (response.status !== 'success') {
            driverSelect.innerHTML =
                `<option>${response.message}</option>`;
            return;
        }

        driverSelect.innerHTML =
            '<option value="">Select Delivery Boy</option>';

        response.data.forEach(driver => {
            const option = document.createElement('option');
            option.value = driver.id;
            option.textContent = driver.full_name_english;
            driverSelect.appendChild(option);
        });
    })
    .catch(err => {
        console.error(err);
        driverSelect.innerHTML =
            '<option>Error loading drivers</option>';
    });
});
</script>

<!-- assign driver -->
<script>
document.getElementById('assignDriverSubmit').addEventListener('click', function () {

    const orderId = document.getElementById('orderId').value;
    const driverId = document.getElementById('driverSelect').value;

    if (!driverId) {
        toastr.error('Please select a delivery boy');
        return;
    }

    fetch(`{{ route('admin.assignDriver') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            order_id: orderId,
            driver_id: driverId
        })
    })
    .then(res => res.json())
    .then(response => {

        if (response.status !== 'success') {
            toastr.error(response.message || 'Failed to assign driver');
            return;
        }

        toastr.success(response.message);

        // Close modal
        const modalEl = document.getElementById('assignModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();

        // Refresh page after 2 seconds
        setTimeout(() => {
            window.location.reload();
        }, 2000);

    })
    .catch(error => {
        console.error(error);
        toastr.error('Something went wrong');
    });
});
</script>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from').value;
        const toDateInput = document.getElementById('to');
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
document.addEventListener('DOMContentLoaded', function () {

    function generateStars(rating) {
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(rating)) {
                starsHtml += '<i class="bi bi-star-fill text-warning"></i>';
            } else if (i - rating < 1) {
                starsHtml += '<i class="bi bi-star-half text-warning"></i>';
            } else {
                starsHtml += '<i class="bi bi-star text-secondary"></i>';
            }
        }
        return starsHtml;
    }

    function renderImages(containerId, images) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';
        if (images && images.length > 0) {
            images.forEach(imgUrl => {
                const img = document.createElement('img');
                img.src = imgUrl;
                img.alt = 'Attached';
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '5px';
                img.style.marginRight = '5px';
                container.appendChild(img);
            });
            container.style.display = 'flex';
        } else {
            container.style.display = 'none';
        }
    }

    // Table cell stars dynamically
    document.querySelectorAll('td[data-bs-target="#sentModalrating"]').forEach(td => {
        const data = td.dataset.user ? JSON.parse(td.dataset.user) : null;
        if (!data) return;
        const rating = parseFloat(data.user_rating_review_provide?.product_rating || 0);
        td.querySelector('.bi-star-fill').outerHTML = generateStars(rating);
        td.querySelector('.rating-number').textContent = rating + ' Rating';
    });

    // Modal dynamic update
    const ratingModal = document.getElementById('sentModalrating');
    ratingModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button.dataset.user) return;

        const data = JSON.parse(button.dataset.user);
        const reviewData = data.user_rating_review_provide || {};

        // Product data
        const productRating = parseFloat(reviewData.product_rating || 0);
        const productReview = reviewData.product_review || "No review provided";
        const productName = data.product_details?.product_name_en || "N/A";
        const productImages = reviewData.product_image ? JSON.parse(reviewData.product_image) : [];

        // Seller data
        const sellerRating = parseFloat(reviewData.store_rating || 0);
        const sellerReview = reviewData.store_review || "No review provided";
        const sellerImages = reviewData.store_image ? JSON.parse(reviewData.store_image) : [];

        // Update product modal
        document.getElementById('productTitle').textContent = productName;
        document.getElementById('productStars').innerHTML = generateStars(productRating);
        document.getElementById('productReviewText').textContent = productReview;
        renderImages('productImagesContainer', productImages);

        // Update seller modal
        document.getElementById('sellerStars').innerHTML = generateStars(sellerRating);
        document.getElementById('sellerReviewText').textContent = sellerReview;
        renderImages('sellerImagesContainer', sellerImages);
    });
});
</script>


<script>
$(document).ready(function() {

    const tableIds = ['#myTable', '#myTable1', '#myTable2', '#myTable3'];

    tableIds.forEach(function(id) {
        // If already initialized, destroy first
        if ( $.fn.DataTable.isDataTable(id) ) {
            $(id).DataTable().clear().destroy();
        }

        // Initialize DataTable
        $(id).DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true
        });
    });

});

</script>










@endsection
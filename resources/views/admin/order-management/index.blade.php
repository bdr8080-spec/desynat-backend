@extends('admin.layout.app')
@section('content')


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
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'active' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 col-12">
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable" class="table">
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
                                <th scope="col">Delivery Boy/Company Name</th>
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
                                <td>{{ $data['order_id'] }}</td>
                                <@php
                                    $firstOrderDetail = $data['order_details']->first();
                                @endphp

                                @if($firstOrderDetail && $firstOrderDetail['product_details']['seller_details'])
                                    <td>
                                        {{ $firstOrderDetail['product_details']['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['product_details']['seller_details']['last_name'] }}
                                    </td>
                                @else
                                    <td>Seller not found</td>
                                @endif
                                <td>{{ $data['delivery_details']['name'] }}</td>
                                <td>{{ $data['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <!-- <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td> -->
                                    <td>
                                        <a class="table-button view-products"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sentModal1"
                                        data-products='@json($data["order_details"])'>
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                <td>{{ $data['delivery_details']['address'] }}</td>                               </td>
                                <td>{{ $data['total_amount'] }} KD</td>
                                <td>20 KD</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>{{ $data['driver_details']['full_name_english'] ?? 'N/A' }}</td>
                                @php
                                $deliveryStatuses = [
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

                            <td>
                                {{ $deliveryStatuses[$data['delivery_status']] ?? 'Unknown' }}
                            </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>{{ $data['driver_details']['zone_info']['name_english'] ?? 'N/A' }} </td>
                                <td>
                                    @if(
                                        ($data['assign_status']) == 0 &&
                                        ($data['delivery_details']['country_name']) === 'Kuwait'
                                    )
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
            <!-- approved -->
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
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'return' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm1').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 col-12">
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable1" class="table">
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
                                <th scope="col">Delivery B</th>
                                <th scope="col">Delivery Boy/Company</th>
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
                                <td>{{ $data['order_id'] }}</td>
                                @php
                                    $firstOrderDetail = $data['order_details']->first();
                                @endphp

                                @if($firstOrderDetail && $firstOrderDetail['product_details']['seller_details'])
                                    <td>
                                        {{ $firstOrderDetail['product_details']['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['product_details']['seller_details']['last_name'] }}
                                    </td>
                                @else
                                    <td>Seller not found</td>
                                @endif
                                <td>{{ $data['delivery_details']['name'] }}</td>
                                <td>{{ $data['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <!-- <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td> -->
                                    <td>
                                        <a class="table-button view-products"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sentModal1"
                                        data-products='@json($data["order_details"])'>
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                <td>{{ $data['delivery_details']['address'] }}</td>                               </td>
                                <td>{{ $data['total_amount'] }} KD</td>
                                <td>20 KD</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>{{ $data['driver_details']['full_name_english'] ?? 'N/A' }}</td>
                                <td>Pending</td>
                                <td>efwehgi</td>
                                <td>Lorem </td>
                                <td>{{ $data['driver_details']['zone_info']['name_english'] ?? 'N/A' }} </td>

                                <td>
                                        <a class="btn btn-dark customBtn assignDriverBtn"
                                        href="javascript:void(0)"
                                        data-order-id="{{ $data['id'] }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#assignModal">
                                            <span>Assign Delivery Boy</span>
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

            <!-- rejected -->

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
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'complete' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm2').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 col-12">
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable2" class="table">
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
                                <th scope="col">Delivery Boy/Company Name</th>
                                <th scope="col">Rating & Review</th>
                                <th scope="col">Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completeOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $data['order_id'] }}</td>
                                @php
                                    $firstOrderDetail = $data['order_details']->first();
                                @endphp

                                @if($firstOrderDetail && $firstOrderDetail['product_details']['seller_details'])
                                    <td>
                                        {{ $firstOrderDetail['product_details']['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['product_details']['seller_details']['last_name'] }}
                                    </td>
                                @else
                                    <td>Seller not found</td>
                                @endif
                                <td>{{ $data['delivery_details']['name'] }}</td>
                                <td>{{ $data['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <!-- <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td> -->
                                    <td>
                                        <a class="table-button view-products"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sentModal1"
                                        data-products='@json($data["order_details"])'>
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                <td>{{ $data['delivery_details']['address'] }}</td>                               </td>
                                <td>{{ $data['total_amount'] }} KD</td>
                                <td>20 KD</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>{{ $data['driver_details']['full_name_english'] ?? 'N/A' }}</td>
                                <td data-bs-toggle="modal" data-bs-target="#sentModalrating" style="cursor: pointer;">
                                    <i class="bi bi-star-fill text-warning"></i> 4.5 Rating
                                </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
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
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request('type') == 'cancelled' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm3').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 col-12">
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable3" class="table">
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
                                <th scope="col">Delivery Boy/Company Name</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cancelledOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $data['order_id'] }}</td>
                                @php
                                    $firstOrderDetail = $data['order_details']->first();
                                @endphp

                                @if($firstOrderDetail && $firstOrderDetail['product_details']['seller_details'])
                                    <td>
                                        {{ $firstOrderDetail['product_details']['seller_details']['first_name'] }}
                                        {{ $firstOrderDetail['product_details']['seller_details']['last_name'] }}
                                    </td>
                                @else
                                    <td>Seller not found</td>
                                @endif
                                <td>{{ $data['delivery_details']['name'] }}</td>
                                <td>{{ $data['delivery_details']['country_name'] ?? 'N/A' }}</td>
                                <!-- <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td> -->
                                    <td>
                                        <a class="table-button view-products"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sentModal1"
                                        data-products='@json($data["order_details"])'>
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                <td>{{ $data['delivery_details']['address'] }}</td>                               </td>
                                <td>{{ $data['total_amount'] }} KD</td>
                                <td>20 KD</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>{{ $data['driver_details']['full_name_english'] ?? 'N/A' }}</td>
                                <td>{{ $data['not_delivered_reason'] ?? 'N/A' }}</td>
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


<!-- add new model -->
<div class="modal fade" id="sentModalrating" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Seller rating & Review</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="overlay">
                <div class="review-modal">


                    <!-- Seller Review Box -->
                    <div class="review-box">
                        <div class="stars">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="review-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                            veniam.
                        </p>
                    </div>

                    <h4 class="product-title">Product Name</h4>

                    <!-- Product Review Box -->
                    <div class="review-box">
                        <div class="stars center">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>

                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="review-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.
                        </p>

                        <div class="attached">
                            <p>Attached Image</p>
                            <img src="/admin/image/download.jpeg" alt="attached">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- Product Details Modal -->
<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

                        <div class="form-group w-50 m-auto">
                            <select class="form-select form-select-lg mt-4" id="driverSelect">
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
    document.querySelectorAll('.view-products').forEach(button => {

        button.addEventListener('click', function () {
            modalBody.querySelectorAll('.product-card:not(#productCardTemplate)')
                .forEach(card => card.remove());
            let products = [];

            try {
                products = JSON.parse(this.dataset.products);
            } catch (error) {
                console.error('Invalid products data:', error);
                return;
            }
            if (!products || products.length === 0) {
                return;
            }
            products.forEach(item => {
                const card = templateCard.cloneNode(true);
                card.classList.remove('d-none');
                card.removeAttribute('id');
                const image =
                    item?.variation_details?.variant_image?.[0]
                    || '/admin/image/download.jpeg';

                card.querySelector('.product-image').src = image;
                card.querySelector('.product-name').textContent =
                    item?.product_details?.product_name_en || 'N/A';
                card.querySelector('.product-category').textContent =
                    'Category: ' +
                    (item?.product_details?.category?.name || 'N/A');
                card.querySelector('.product-brand').textContent =
                    'Brand: ' +
                    (item?.product_details?.brand?.name_english || 'N/A');
                card.querySelector('.product-subcategory').textContent =
                    'Sub-Category: ' +
                    (item?.product_details?.subcategory?.name_english || 'N/A');
                card.querySelector('.product-price').textContent =
                    'Price: ' + (item?.amount || '0') + ' KD';
                modalBody.appendChild(card);
            });
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








@endsection
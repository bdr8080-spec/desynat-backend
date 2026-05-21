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
    white-space: nowrap;
}
.table.dataTable thead .sorting {
   white-space: nowrap;
    font-size: 13px;
}
</style>
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp


<div class="inner-content management">
    <h2 class="h2">{{ __('admin_messages.order_management') }}</h2>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    {{ __('admin_messages.active_orders') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="false">
                    {{ __('admin_messages.return_&_exchange') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    {{ __('admin_messages.completed') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-cancelled-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-cancelled" type="button" role="tab" aria-controls="pills-cancelled"
                    aria-selected="false">
                    {{ __('admin_messages.cancelled') }}
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
                            <label for="from" class="form-label">{{ __('admin_messages.from') }}:</label>
                            <input type="date" id="from" name="from_date" class="form-control datepicker"
                                value="{{ request('type') == 'active' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.to') }}:</label>
                            <input type="date" id="to" name="to_date" class="form-control datepicker"
                                value="{{ request('type') == 'active' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">{{ __('admin_messages.select_country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'active' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        @if(app()->getLocale() == 'en')
                                            {{ $country->name }}
                                            @else
                                            {{ $country->name_ar }}
                                            @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        @if(in_array(15, $permissions) || $admin->type == 1)
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a href="{{ route('admin.export_active_orders_data', request()->all()) }}" class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        @endif
                    </div>
                </div>
                </form>

               <div class="table-responsive mt-4">
                    <table id="myTable" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.order_id') }}</th>
                                <!-- <th scope="col">Order Type</th> -->
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.customer_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.product_details') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_address') }}</th>
                                <th scope="col">{{ __('admin_messages.order_amount') }}</th>
                                <th scope="col">{{ __('admin_messages.admin_commission') }}</th>
                                <th scope="col">{{ __('admin_messages.order_type') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy_company_name') }}</th>
                                <th scope="col">{{ __('admin_messages.status') }}</th>
                                <th scope="col">{{ __('admin_messages.invoice') }}</th>
                                <th scope="col">{{ __('admin_messages.zone') }}</th>
                                @if(in_array(15, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.assign_driver') }}</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($activeOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['id'] }}</td>

                                <td>
                                    @php
                                        $product = $data['product_details'] ?? null;
                                        $seller = $product->seller_details ?? null;
                                    @endphp

                                    @if($seller)
                                        {{ $seller->first_name ?? '' }} {{ $seller->last_name ?? '' }}
                                    @else
                                        {{ __('admin_messages.n/a') }}
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? __('admin_messages.n/a') }}</td>
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
                                    @if($data['order']['order_type'] == '1')
                                        @if($data['amount_with_charges'] == floor($data['amount_with_charges']))
                                            {{ intval($data['amount_with_charges']) }} {{ __('admin_messages.kd') }}
                                        @else
                                            {{ number_format($data['amount_with_charges'], 2) }} {{ __('admin_messages.kd') }}
                                        @endif
                                    @else
                                        {{ intval($data['order']['total_amount']) }} {{ __('admin_messages.kd') }}
                                    @endif
                                </td>
                                <td>
                                    {{ isset($data['admin_commission']) && $data['admin_commission'] !== null 
                                    ? $data['admin_commission'] . ' ' . __('admin_messages.kd')
                                    : __('admin_messages.na') }}
                                </td>
                                <td>
                                    @if($data['order']['order_type']=='1')
                                    {{__('admin_messages.normal')}}
                                    @else
                                    {{__('admin_messages.custom')}}
                                    @endif
                                </td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        {{__('admin_messages.not_assigned')}}
                                    @else
                                        @if(app()->getLocale() == 'en')
                                        {{ $data['driver_details']['full_name_english'] }}
                                        @else
                                        {{ $data['driver_details']['full_name_arabic'] }}
                                        @endif
                                    @endif
                                </td>
                                <td>{{__('admin_messages.na')}}</td>
                                @php
                                    $deliveryStatuses = [
                                        '1' => __('admin_messages.confirmed'),
                                        '2.1' => __('admin_messages.shipped'),
                                        '2.2' => __('admin_messages.on_the_way'),
                                        '3' => __('admin_messages.delivered'),
                                        '4' => __('admin_messages.cancelled'),
                                        '5' => __('admin_messages.return'),
                                        '6' => __('admin_messages.confirmed'),
                                        '7' => __('admin_messages.picked'),
                                        '8' => __('admin_messages.not_delivered'),
                                    ];
                                @endphp
                                <td>{{ $deliveryStatuses[$data['delivery_status']] ?? __('admin_messages.na') }}</td>
                                <td>
                                    <a href="{{ url('Invoice', ['order_id' => $data['order']['order_id']]) }}" target="_blank" class="btn btn-dark customBtn">
                                        <span>{{__('admin_messages.download_invoice')}}</span>
                                    </a>
                                </td>
                                <td>{{ $data['driver_details']['zone_info']['name_english'] ?? 'N/A' }}</td>
                                @if(in_array(15, $permissions) || $admin->type == 1)
                                <td>
                                    @if($data['assign_status'] == 0 && $data['order']['delivery_details']['country_code'] === '+965')
                                    <a class="btn btn-dark customBtn assignDriverBtn"
                                    href="javascript:void(0)"
                                    data-order-id="{{ $data['id'] }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#assignModal">
                                        <span>{{__('admin_messages.assign_delivery_boy')}}</span>
                                    </a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @empty
 
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
                            <label for="from" class="form-label">{{ __('admin_messages.from') }}:</label>
                            <input type="date" id="from" name="from_date" class="form-control datepicker"
                                value="{{ request('type') == 'return' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm1').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.to') }}:</label>
                            <input type="date" id="to" name="to_date" class="form-control datepicker"
                                value="{{ request('type') == 'return' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm1').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm1').submit();">
                                <option value="">{{ __('admin_messages.select_country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'return' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        @if(app()->getLocale() == 'en')
                                            {{ $country->name }}
                                            @else
                                            {{ $country->name_ar }}
                                            @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        @if(in_array(15, $permissions) || $admin->type == 1)
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a href="{{ route('admin.export_return_exchange_orders_data', request()->all()) }}" class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        @endif
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable1" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.order_id') }}</th>
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.customer_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.product_details') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_address') }}</th>
                                <th scope="col">{{ __('admin_messages.order_amount') }}</th>
                                <th scope="col">{{ __('admin_messages.admin_commission') }}</th>
                                <th scope="col">{{ __('admin_messages.order_type') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy_company_name') }}</th>
                                <th scope="col">{{ __('admin_messages.exchange_or_return') }}</th>
                                <th scope="col">{{ __('admin_messages.reason') }}</th>
                                <th scope="col">{{ __('admin_messages.status') }}</th>
                                <th scope="col">{{ __('admin_messages.zone') }}</th>
                                @if(in_array(15, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.assign_driver') }}</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>
                           @forelse($returnOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['id'] }}</td>
                                <td>
                                    @php
                                        $product = $data['product_details'] ?? null;
                                        $seller = $product->seller_details ?? null;
                                    @endphp

                                    @if($seller)
                                        {{ $seller->first_name ?? '' }} {{ $seller->last_name ?? '' }}
                                    @else
                                        {{ __('admin_messages.na') }}
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? __('admin_messages.na') }}</td>
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
                                    @if($data['order']['order_type'] == '1')
                                        @if($data['amount_with_charges'] == floor($data['amount_with_charges']))
                                            {{ intval($data['amount_with_charges']) }} {{ __('admin_messages.kd') }}
                                        @else
                                            {{ number_format($data['amount_with_charges'], 2) }} {{ __('admin_messages.kd') }}
                                        @endif
                                    @else
                                        {{ intval($data['order']['total_amount']) }} {{ __('admin_messages.kd') }}
                                    @endif
                                </td>
                                <td>
                                    {{ isset($data['admin_commission']) && $data['admin_commission'] !== null 
                                    ? $data['admin_commission'] . ' ' . __('admin_messages.kd')
                                    : __('admin_messages.na') }}
                                </td>
                                <td>
                                    @if($data['order']['order_type']=='1')
                                    {{ __('admin_messages.normal') }}
                                    @else
                                    {{ __('admin_messages.custom') }}
                                    @endif
                                </td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        {{ __('admin_messages.not_assigned') }}
                                    @else
                                        @if(app()->getLocale() == 'en')
                                        {{ $data['driver_details']['full_name_english'] }}
                                        @else
                                        {{ $data['driver_details']['full_name_arabic'] }}
                                        @endif
                                    @endif
                                </td>
                                <td>{{ __('admin_messages.na') }}</td>
                                @php
                                    $deliveryStatuses = [
                                        '1' => __('admin_messages.return'),
                                        '2' => __('admin_messages.exchange'),
                                    ];
                                @endphp
                                <td>{{ $deliveryStatuses[$data['return_type']] ??  __('admin_messages.na')  }}</td>
                                <td>
                                    @if($data['return_type'] == '1')
                                    {{ $data['return_reason'] ?? 'N/A' }}
                                    @elseif($data['return_type'] == '2')
                                    {{ $data['exchange_reason'] ?? 'N/A' }}
                                    @endif
                                </td>
                                 @php
                                    $deliveryStatuses = [
                                        '1' => __('admin_messages.confirmed'),
                                        '2.1' => __('admin_messages.shipped'),
                                        '2.2' => __('admin_messages.on_the_way'),
                                        '3' => __('admin_messages.delivered'),
                                        '4' => __('admin_messages.cancelled'),
                                        '5' => __('admin_messages.return'),
                                        '6' => __('admin_messages.confirmed'),
                                        '7' => __('admin_messages.picked'),
                                        '8' => __('admin_messages.not_delivered'),
                                    ];
                                @endphp
                                <!-- <td>{{ $deliveryStatuses[$data['delivery_status']] ?? 'Unknown' }}</td> -->
                                 <td>
                                    @if($data['delivery_status']=='1')
                                    {{ __('admin_messages.confirmed') }}
                                    @elseif($data['delivery_status']=='2.1')
                                    {{ __('admin_messages.shipped') }}
                                    @elseif($data['delivery_status']=='2.2')
                                    {{ __('admin_messages.on_the_way') }}
                                    @elseif($data['delivery_status']=='3' && $data['r_e_approve']=='0' && $data['return_type']=='0')
                                    {{ __('admin_messages.completed') }}
                                    @elseif($data['delivery_status']=='3' && $data['r_e_approve']=='1' && $data['return_type']=='1')
                                    {{ __('admin_messages.return_request') }}
                                    @elseif($data['delivery_status']=='3' && $data['r_e_approve']=='2' && $data['return_type']=='1')
                                    {{ __('admin_messages.return_rejected') }}
                                    @elseif($data['delivery_status']=='3' && $data['r_e_approve']=='1' && $data['return_type']=='2')
                                    {{ __('admin_messages.exchange_request') }}
                                    @elseif($data['delivery_status']=='3' && $data['r_e_approve']=='2' && $data['return_type']=='2')
                                    {{ __('admin_messages.exchange_rejected') }}
                                    @elseif($data['delivery_status']=='7' && $data['is_picked']=='1')
                                    {{ __('admin_messages.picked') }}
                                    @elseif($data['delivery_status']=='8')
                                    {{ __('admin_messages.not_delivered') }}
                                    @else
                                    @endif

                                 </td>
                                 
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $data['driver_details']['zone_info']['name_english'] ?? __('admin_messages.na') }}
                                    @else
                                    {{ $data['driver_details']['zone_info']['name_arabic'] ?? __('admin_messages.na') }}
                                    @endif
                                </td>
                                @if(in_array(15, $permissions) || $admin->type == 1)
                                <td>
                                    @if($data['assign_status'] == 0 && $data['order']['delivery_details']['country_code'] === '+965')
                                    <a class="btn btn-dark customBtn assignDriverBtn"
                                    href="javascript:void(0)"
                                    data-order-id="{{ $data['id'] }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#assignModal">
                                        <span>{{ __('admin_messages.assign_delivery_boy') }}</span>
                                    </a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @empty

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
                            <label for="from" class="form-label">{{ __('admin_messages.from') }}:</label>
                            <input type="date" id="from" name="from_date" class="form-control datepicker"
                                value="{{ request('type') == 'complete' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm2').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.to') }}:</label>
                            <input type="date" id="to" name="to_date" class="form-control datepicker"
                                value="{{ request('type') == 'complete' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm2').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm2').submit();">
                                <option value="">{{ __('admin_messages.select_country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'complete' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        @if(app()->getLocale() == 'en')
                                            {{ $country->name }}
                                            @else
                                            {{ $country->name_ar }}
                                            @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        @if(in_array(15, $permissions) || $admin->type == 1)
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a href="{{ route('admin.export_completed_orders_data', request()->all()) }}" class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        @endif
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable2" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.order_id') }}</th>
                                <!-- <th scope="col">Order Type</th> -->
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.customer_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.product_details') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_address') }}</th>
                                <th scope="col">{{ __('admin_messages.order_amount') }}</th>
                                <th scope="col">{{ __('admin_messages.admin_commission') }}</th>
                                <th scope="col">{{ __('admin_messages.order_type') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy_company_name') }}</th>
                                <th scope="col">{{ __('admin_messages.rating_&_review') }}</th>
                                <th scope="col">{{ __('admin_messages.invoice') }}{{ __('admin_messages.invoice') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completeOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['id'] }}</td>
                                <td>
                                    @php
                                        $product = $data['product_details'] ?? null;
                                        $seller = $product->seller_details ?? null;
                                    @endphp

                                    @if($seller)
                                        {{ $seller->first_name ?? '' }} {{ $seller->last_name ?? '' }}
                                    @else
                                        {{ __('admin_messages.na') }}
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? __('admin_messages.na') }}</td>
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
                                    @if($data['order']['order_type'] == '1')
                                        @if($data['amount_with_charges'] == floor($data['amount_with_charges']))
                                            {{ intval($data['amount_with_charges']) }} {{ __('admin_messages.kd') }}
                                        @else
                                            {{ number_format($data['amount_with_charges'], 2) }} {{ __('admin_messages.kd') }}
                                        @endif
                                    @else
                                        {{ intval($data['order']['total_amount']) }} {{ __('admin_messages.kd') }}
                                    @endif
                                </td>

                                <td>
                                    {{ isset($data['admin_commission']) && $data['admin_commission'] !== null 
                                    ? $data['admin_commission'] . ' ' . __('admin_messages.kd')
                                    : __('admin_messages.na') }}
                                </td>
                                <td>
                                    @if($data['order']['order_type']=='1')
                                    {{ __('admin_messages.normal') }}
                                    @else
                                    {{ __('admin_messages.custom') }}
                                    @endif
                                </td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        {{ __('admin_messages.not_assigned') }}
                                    @else
                                       @if(app()->getLocale() == 'en')
                                        {{ $data['driver_details']['full_name_english'] }}
                                        @else
                                        {{ $data['driver_details']['full_name_arabic'] }}
                                        @endif
                                    @endif
                                </td>
                                <td>{{ __('admin_messages.na') }}</td>
                                <td data-bs-toggle="modal" 
                                    data-bs-target="#sentModalrating" 
                                    style="cursor: pointer;"
                                    data-user='@json($data)'>
                                    <i class="bi bi-star-fill text-warning"></i> 
                                    <span class="rating-number">{{ $data['user_rating_review_provide']['product_rating'] ?? __('admin_messages.na') }} {{ __('admin_messages.rating') }}</span>
                                </td>
                                <td>
                                    <a href="{{ url('Invoice', ['order_id' => $data['order']['order_id']]) }}" target="_blank" class="btn btn-dark customBtn">
                                        <span>{{ __('admin_messages.download_invoice') }}</span>
                                    </a>
                                </td>
                            </tr>
                            @empty

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
                            <label for="from" class="form-label">{{ __('admin_messages.from') }}:</label>
                            <input type="date" id="from" name="from_date" class="form-control datepicker"
                                value="{{ request('type') == 'cancelled' ? request()->from_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm3').submit();" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.to') }}:</label>
                            <input type="date" id="to" name="to_date" class="form-control datepicker"
                                value="{{ request('type') == 'cancelled' ? request()->to_date : '' }}"
                                onchange="updateToDate(); document.getElementById('filterForm3').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>
                            <select name="country_name" id="country_name"
                                class="form-select form-select-lg"
                                onchange="document.getElementById('filterForm3').submit();">
                                <option value="">{{ __('admin_messages.select_country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'cancelled' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        @if(app()->getLocale() == 'en')
                                            {{ $country->name }}
                                            @else
                                            {{ $country->name_ar }}
                                            @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        @if(in_array(15, $permissions) || $admin->type == 1)
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a href="{{ route('admin.export_cancelled_orders_data', request()->all()) }}" class="btn btn-dark customBtn w-50" style="margin-top: 63px">
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        @endif
                    </div>
                </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable3" class="table allTable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.order_id') }}</th>
                                <!-- <th scope="col">Order Type</th> -->
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.customer_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.product_details') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_address') }}</th>
                                <th scope="col">{{ __('admin_messages.order_amount') }}</th>
                                <th scope="col">{{ __('admin_messages.admin_commission') }}</th>
                                <th scope="col">{{ __('admin_messages.order_type') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy') }}</th>
                                <th scope="col">{{ __('admin_messages.delivery_boy_company_name') }}</th>
                                <th scope="col">{{ __('admin_messages.reason') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cancelledOrders as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['id'] }}</td>
                                <td>
                                    @php
                                        $product = $data['product_details'] ?? null;
                                        $seller = $product->seller_details ?? null;
                                    @endphp

                                    @if($seller)
                                        {{ $seller->first_name ?? '' }} {{ $seller->last_name ?? '' }}
                                    @else
                                        {{ __('admin_messages.na') }}
                                    @endif
                                </td>
                                <td>{{ $data['order']['delivery_details']['name'] }}</td>
                                <td>{{ $data['order']['delivery_details']['country_name'] ?? __('admin_messages.na') }}</td>
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
                                    @if($data['order']['order_type'] == '1')
                                        @if($data['amount_with_charges'] == floor($data['amount_with_charges']))
                                            {{ intval($data['amount_with_charges']) }} {{ __('admin_messages.kd') }}
                                        @else
                                            {{ number_format($data['amount_with_charges'], 2) }} {{ __('admin_messages.kd') }}
                                        @endif
                                    @else
                                        {{ intval($data['order']['total_amount']) }} {{ __('admin_messages.kd') }}
                                    @endif
                                </td>
                                <td>
                                    {{ isset($data['admin_commission']) && $data['admin_commission'] !== null 
                                    ? $data['admin_commission'] . ' ' . __('admin_messages.kd')
                                    : __('admin_messages.na') }}
                                </td>
                                <td>
                                    @if($data['order']['order_type']=='1')
                                    {{ __('admin_messages.normal') }}
                                    @else
                                    {{ __('admin_messages.custom') }}
                                    @endif
                                </td>
                                <td>
                                    @if(empty($data['driver_details']['full_name_english']))
                                        {{ __('admin_messages.not_assigned') }}
                                    @else
                                        @if(app()->getLocale() == 'en')
                                        {{ $data['driver_details']['full_name_english'] }}
                                        @else
                                        {{ $data['driver_details']['full_name_arabic'] }}
                                        @endif
                                    @endif
                                </td>
                                <td>{{ __('admin_messages.na') }}</td>
                                <td>{{ $data['cancel_reason'] ?? __('admin_messages.na') }}</td>
                            </tr>
                            @empty

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
                <h2 class="h2">{{ __('admin_messages.seller_rating_&_review') }}</h2>
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

                    <h4 class="product-title" id="productTitle">{{ __('admin_messages.product_name') }}</h4>

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
            <div class="modal-header management border-0 mb-0">
                <h2 class="h2">{{ __('admin_messages.product_details') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="overlay">
                    <div class="product-modal" id="productModalBody">
                        <div class="product-card d-none" id="productCardTemplate">
                            <div class="product-img">
                                <img src="/admin/image/download.jpeg" alt="product" class="product-image">
                            </div>
                            <div class="product-info">
                                <div class="left">
                                    <p><strong class="product-name">{{ __('admin_messages.name') }}</strong></p>
                                    <p class="product-category">{{ __('admin_messages.category') }}</p>
                                    <p class="product-brand">{{ __('admin_messages.brand') }}</p>
                                </div>
                                <div class="right">
                                    <p class="product-subcategory">{{ __('admin_messages.sub_category') }}</p>
                                    <p class="product-price">{{ __('admin_messages.price') }}</p>
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
                <h2 class="h2">{{ __('admin_messages.assign_delivery_boy') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body mb-4">
                <div class="row">
                    <div class="col-lg-12">

                        <!-- ORDER ID -->
                        <input type="hidden" id="orderId">

                        <div class="form-group w-100 m-auto">
                            <select class="form-select form-select-lg mt-4 " id="driverSelect">
                                <option value="">{{ __('admin_messages.loading') }}</option>
                            </select>
                        </div>

                        <div class="col-lg-12 d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-dark customBtn" id="assignDriverSubmit">
                                {{ __('admin_messages.submit') }}
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

    if (!modalBody || !templateCard) {
       // console.error('Modal elements not found. Check IDs.');
        return;
    }

    const buttons = document.querySelectorAll('.view-products');

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            // Clear old cards
            modalBody.querySelectorAll('.product-card:not(#productCardTemplate)')
                .forEach(card => card.remove());

            const raw = this.dataset.product;

            if (!raw) return;

            let item;
            try {
                item = JSON.parse(raw);
            } catch (e) {
                //console.error('JSON parse error:', e, raw);
                return;
            }

            const card = templateCard.cloneNode(true);
            card.classList.remove('d-none');
            card.removeAttribute('id');
            

            // Product Image
            card.querySelector('.product-image').src =
                item.variation_details?.variant_image?.[0] ?? '/admin/image/download.jpeg';

            // Product Name
            const locale = "{{ app()->getLocale() }}";

            card.querySelector('.product-name').textContent =
                locale === 'ar'
                    ? (item.product_details?.product_name_ar ?? "{{ __('admin_messages.na') }}")
                    : (item.product_details?.product_name_en ?? "{{ __('admin_messages.na') }}");

            // Category
            card.querySelector('.product-category').textContent =
                "{{ __('admin_messages.category') }}: " +
                (locale === 'ar'
                    ? (item.product_details?.category?.name_ar ?? "{{ __('admin_messages.na') }}")
                    : (item.product_details?.category?.name ?? "{{ __('admin_messages.na') }}"));

            // Brand

            card.querySelector('.product-brand').textContent =
                "{{ __('admin_messages.brand') }}: " +
                (locale === 'ar'
                    ? (item.product_details?.brand?.name_arabic ?? "{{ __('admin_messages.na') }}")
                    : (item.product_details?.brand?.name_english ?? "{{ __('admin_messages.na') }}"));

            // Sub-Category

            card.querySelector('.product-subcategory').textContent =
                "{{ __('admin_messages.sub_category') }}: " +
                (locale === 'ar'
                    ? (item.product_details?.subcategory?.name_arabic ?? "{{ __('admin_messages.na') }}")
                    : (item.product_details?.subcategory?.name_english ?? "{{ __('admin_messages.na') }}"));

            // Price
            let finalPrice = 0;
            const orderType = item.order?.order_type ?? '1';

            if (orderType == '1') {
                // Type 1: show item.amount
                finalPrice = parseFloat(item.amount ?? 0);
            } else if (orderType == '2') {
                // Type 2: show total_amount from order
                finalPrice = parseFloat(item.order?.total_amount ?? 0);
            }

            card.querySelector('.product-price').textContent =
                "{{ __('admin_messages.price') }}: " +
                finalPrice.toFixed(2) + " " +
                "{{ __('admin_messages.kd') }}";

            // Append card to modal
            modalBody.appendChild(card);

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
    driverSelect.innerHTML = '<option>{{ __("admin_messages.loading") }}</option>';

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
            driverSelect.innerHTML = '<option value="">{{ __("admin_messages.select_delivery_boy") }}</option>';

        response.data.forEach(driver => {
            const option = document.createElement('option');
            option.value = driver.id;
            option.textContent = driver.full_name_english;
            driverSelect.appendChild(option);
        });
    })
    .catch(err => {
        console.error(err);
        driverSelect.innerHTML = '<option>{{ __("admin_messages.error_loading_drivers") }}</option>';
    });
});
</script>

<!-- assign driver -->
<script>
document.getElementById('assignDriverSubmit').addEventListener('click', function () {

    const orderId = document.getElementById('orderId').value;
    const driverId = document.getElementById('driverSelect').value;

    if (!driverId) {
       toastr.error("{{ __('admin_messages.please_select_delivery_boy') }}");
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
        const productReview = reviewData.product_review || "{{ __('admin_messages.no_review_provided') }}";
        const locale = "{{ app()->getLocale() }}";
        const productName = (locale === 'ar'
                ? data.product_details?.product_name_ar
                : data.product_details?.product_name_en
            ) || "{{ __('admin_messages.na') }}";
        const productImages = reviewData.product_image ? JSON.parse(reviewData.product_image) : [];

        // Seller data
        const sellerRating = parseFloat(reviewData.store_rating || 0);
        const sellerReview = reviewData.store_review || "{{ __('admin_messages.no_review_provided') }}";
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












@endsection
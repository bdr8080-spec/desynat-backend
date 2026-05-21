@extends('admin.layout.app')
@section('content')

@php
$admin = auth('admin')->user();

$permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
->where('can_action', 1)
->pluck('module_id')
->toArray();
@endphp

<div class="inner-content management">

    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">{{ __('admin_messages.payment_management') }}</h2>
        </div>


    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="false">
                    {{ __('admin_messages.by_order') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    {{ __('admin_messages.by_subscription_plan') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    {{ __('admin_messages.by_gift_card') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-Banner-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-Banner" type="button" role="tab" aria-controls="pills-Banner"
                    aria-selected="false">
                    {{ __('admin_messages.by_banner') }}
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <form method="GET" action="{{ route('admin.paymentManagement') }}" id="filterForm">
                    <div class="row mt-4">
                        <!-- From Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date" class="form-label">{{ __('admin_messages.from') }}:</label>
                                <input type="date" id="from_date" name="from_date" class="form-control datepicker"
                                    value="{{ request()->from_date }}"
                                    onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                            </div>
                        </div>

                        <!-- To Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date" class="form-label">{{ __('admin_messages.to') }}:</label>
                                <input type="date" id="to_date" name="to_date" class="form-control datepicker"
                                    value="{{ request()->to_date }}"
                                    onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>

                                <select name="country_id" id="country_id"
                                    onchange="document.getElementById('filterForm').submit();"
                                    class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>

                                    @foreach($userCountry as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request('country_id') == $country->id ? 'selected' : '' }}>
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
                        <div class="col-lg-1">
                            <div style="
    margin-top: 48px;
">
                                <a href="{{route('admin.paymentManagement')}}"
                                    class="btn btn-dark customBtn w-100 mt-2">
                                    <span>{{ __('admin_messages.reset') }}</span></a>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            @if(in_array(27, $permissions) || $admin->type == 1)
                            <div style="
    margin-top: 48px;
">
                                <a href="{{ route('admin.export_order_payment_data', request()->all()) }}"
                                    class="btn btn-dark customBtn w-100 mt-2">
                                    <span>{{ __('admin_messages.export') }}</span></a>
                            </div>
                            @endif
                        </div>

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class=" mt-2">

                                <a class="btn btn-dark customBtn">
                                    <span>{{ __('admin_messages.total_revenue') }}:- {{ number_format($orderPayment['total_revenue'], 2) }}
                                        {{ __('admin_messages.kd') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.transaction_id') }}</th>
                                <th scope="col">{{ __('admin_messages.order_date_time') }}</th>
                                <th scope="col">{{ __('admin_messages.transaction_date_time') }}</th>
                                <th scope="col">{{ __('admin_messages.customer_name') }}</th>
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.order_id') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.total_charges') }}</th>
                                <th scope="col">{{ __('admin_messages.applied_promo_code') }}</th>
                                <th scope="col">{{ __('admin_messages.applied_gift_card') }}</th>
                                <th scope="col">{{ __('admin_messages.discount') }}</th>
                                <th scope="col">{{ __('admin_messages.commission') }}</th>
                                <th scope="col">{{ __('admin_messages.payment_mode') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orderPayment['data'] as $payment)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>#{{$payment->order->order_id}}</td>
                                <td>{{ $payment->created_at->format('jS F Y | g:i A') }}</td>
                                <td>{{ $payment->updated_at->format('jS F Y | g:i A') }}</td>
                                <td>{{$payment->user_details->full_name ?? __('admin_messages.na')}}</td>
                                <td>{{$payment->product_details->seller_details->first_name?? __('admin_messages.na')}}
                                    {{$payment->product_details->seller_details->last_name??''}}</td>
                                <td>#{{$payment->id}}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{$payment->user_details->country_info->name ?? __('admin_messages.na')}}
                                    @else
                                    {{$payment->user_details->country_info->name_ar ?? __('admin_messages.na')}}
                                    @endif
                                </td>
                                <td>{{$payment->total_paid_amount}} {{__('admin_messages.kd')}}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $payment->promocode_details->name_english ?? __('admin_messages.no') }}
                                    @else
                                    {{ $payment->promocode_details->name_arabic ?? __('admin_messages.no') }}
                                    @endif
                                </td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $payment->gift_card_details->name_english ?? __('admin_messages.no') }}
                                    @else
                                    {{ $payment->gift_card_details->name_arabic ?? __('admin_messages.no') }}
                                    @endif
                                </td>
                                <td>{{$payment->total_discount}} {{__('admin_messages.kd')}}</td>
                                <td>{{$payment->affiliate_admin_commission ?? '0'}} {{__('admin_messages.kd')}}</td>
                                <td>
                                    @if($payment->order?->payment_method == 1)
                                    {{__('admin_messages.online')}}
                                    @elseif($payment->order?->payment_method == 2)
                                    {{__('admin_messages.wallet')}}
                                    @elseif($payment->order?->payment_method == 3)
                                    {{__('admin_messages.cod')}}
                                    @else
                                    {{__('admin_messages.na')}}
                                    @endif
                                </td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- approved -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.paymentManagement') }}" id="filterForm1">
                    <div class="row mb-4">
                        <!-- From Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date" class="form-label">{{ __('admin_messages.from') }}:</label>
                                <input type="date" id="from_date1" name="from_date1" class="form-control datepicker"
                                    value="{{ request()->from_date1 }}"
                                    onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                            </div>
                        </div>

                        <!-- To Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date" class="form-label">{{ __('admin_messages.to') }}:</label>
                                <input type="date" id="to_date1" name="to_date1" class="form-control datepicker"
                                    value="{{ request()->to_date1 }}"
                                    onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>

                                <select name="country_id1" id="country_id1"
                                    onchange="document.getElementById('filterForm1').submit();"
                                    class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>

                                    @foreach($sellerCountry as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request('country_id1') == $country->id ? 'selected' : '' }}>
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
                        <div class="col-lg-1 col-md-12 col-12">
                            <div class="">
                                <a href="{{route('admin.paymentManagement')}}" class="btn btn-dark customBtn w-100 " style="margin-top: 63px">
                                    <span>{{ __('admin_messages.reset') }}</span></a>
                            </div>
                        </div>
                        @if(in_array(27, $permissions) || $admin->type == 1)
                        <div  class="col-lg-1 col-md-12 col-12" >
                            <div class="">

                            <a href="{{ route('admin.export_plan_payment_data', request()->all()) }}"
                                class="btn btn-dark customBtn w-100" style="margin-top: 63px">
                                <span>{{ __('admin_messages.export') }}</span></a>
</div>
                        </div>
                        @endif

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class=" mt-2">

                                <a class="btn btn-dark customBtn">
                                    <span>{{ __('admin_messages.total_revenue') }}:- {{ number_format($planPayment['total_revenue'], 2) }}
                                        {{ __('admin_messages.kd') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.transaction_id') }}</th>
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.amount') }}</th>
                                <th scope="col">{{ __('admin_messages.plan_name') }}</th>
                                <th scope="col">{{ __('admin_messages.order_date_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($planPayment['data'] as $payment)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>#{{ $payment->transaction_id }}</td>
                                <td>{{ $payment->seller_details->first_name ?? __('admin_messages.na') }} {{ $payment->seller_details->last_name ?? '' }}
                                </td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $payment->seller_details->store_info->country_info->name ?? __('admin_messages.na')}}
                                    @else
                                    {{ $payment->seller_details->store_info->country_info->name_ar ?? __('admin_messages.na')}}
                                    @endif
                                </td>
                                <td>{{ $payment->amount }} {{__('admin_messages.kd')}}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $payment->plan_info->plan_name_english }}
                                    @else
                                    {{ $payment->plan_info->plan_name_arabic }}
                                    @endif
                                </td>
                                <td>{{ $payment->created_at->format('jS F Y | g:i A') }}</td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- rejected -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.paymentManagement') }}" id="filterForm2">
                    <div class="row mb-4">
                        <!-- From Date Filter -->
                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date" class="form-label">{{ __('admin_messages.from') }}:</label>
                                <input type="date" id="from_date2" name="from_date2" class="form-control datepicker"
                                    value="{{ request()->from_date2 }}"
                                    onchange="updateToDate2(); document.getElementById('filterForm2').submit();" />
                            </div>
                        </div>

                        <!-- To Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date" class="form-label">{{ __('admin_messages.to') }}:</label>
                                <input type="date" id="to_date2" name="to_date2" class="form-control datepicker"
                                    value="{{ request()->to_date2 }}"
                                    onchange="updateToDate2(); document.getElementById('filterForm2').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>

                                <select name="country_id2" id="country_id2"
                                    onchange="document.getElementById('filterForm2').submit();"
                                    class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>

                                    @foreach($userCountry as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request('country_id2') == $country->id ? 'selected' : '' }}>
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
                        <div class="col-lg-1 col-md-12 col-12">
                            <div class="">
                                <a href="{{route('admin.paymentManagement')}}" class="btn btn-dark customBtn w-100 " style="margin-top: 63px">
                                    <span>{{ __('admin_messages.reset') }}</span></a>
                            </div>
                        </div>
                        @if(in_array(27, $permissions) || $admin->type == 1)
                        <div class="col-lg-1">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a href="{{ route('admin.export_giftcard_payment_data', request()->all()) }}"
                                class="btn btn-dark customBtn w-100" style="margin-top: 63px">
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
</div>
                        @endif

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class=" mt-2">

                                <a class="btn btn-dark customBtn">
                                    <span>{{ __('admin_messages.total_revenue') }}:- {{ number_format($giftCardPayment['total_revenue'], 2) }}
                                        {{ __('admin_messages.kd') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table id="myTable2" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.transaction_id') }}</th>
                                <th scope="col">{{ __('admin_messages.gift_card_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.purchased_by') }}</th>
                                <th scope="col">{{ __('admin_messages.amount') }}</th>
                                <th scope="col">{{ __('admin_messages.order_date_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($giftCardPayment['data'] as $payment)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>#{{ $payment->transaction_id }}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $payment->gift_details->name_english ?? __('admin_messages.na') }}
                                    @else
                                    {{ $payment->gift_details->name_arabic ?? __('admin_messages.na') }}
                                    @endif
                                </td>
                                <td>{{ $payment->user_details->full_name ?? __('admin_messages.order_date_time') }}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $payment->user_details->country_info->name ?? __('admin_messages.order_date_time') }}
                                    @else
                                    {{ $payment->user_details->country_info->name_ar ?? __('admin_messages.order_date_time') }}
                                    @endif
                                </td>
                                <td>{{ $payment->amount }} {{__('admin_messages.kd')}}</td>
                                <td>{{ $payment->created_at->format('jS F Y | g:i A') }}</td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-Banner" role="tabpanel" aria-labelledby="pills-Banner-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.paymentManagement') }}" id="filterForm3">
                    <div class="row mb-4">
                        <!-- From Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date" class="form-label">{{ __('admin_messages.from') }}:</label>
                                <input type="date" id="from_date3" name="from_date3" class="form-control datepicker"
                                    value="{{ request()->from_date3 }}"
                                    onchange="updateToDate3(); document.getElementById('filterForm3').submit();" />
                            </div>
                        </div>

                        <!-- To Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date" class="form-label">{{ __('admin_messages.to') }}:</label>
                                <input type="date" id="to_date3" name="to_date3" class="form-control datepicker"
                                    value="{{ request()->to_date3 }}"
                                    onchange="updateToDate3(); document.getElementById('filterForm3').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>

                                <select name="country_id3" id="country_id3"
                                    onchange="document.getElementById('filterForm3').submit();"
                                    class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>

                                    @foreach($sellerCountry as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request('country_id3') == $country->id ? 'selected' : '' }}>
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
                        <div class="col-lg-1 col-md-12 col-12">
                            <div class="">
                                <a href="{{route('admin.paymentManagement')}}" class="btn btn-dark customBtn w-100 " style="margin-top: 63px">
                                    <span>{{ __('admin_messages.reset') }}</span></a>
                            </div>
                        </div>
                        @if(in_array(27, $permissions) || $admin->type == 1)
                        <div class="col-lg-1">
                        <div class="">
                            <a href="{{ route('admin.export_banner_payment_data', request()->all()) }}"
                                class="btn btn-dark customBtn w-100" style="margin-top: 63px">
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        </div>
                        @endif

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class=" mt-2">

                                <a class="btn btn-dark customBtn">
                                    <span>{{ __('admin_messages.total_revenue') }}:- {{ number_format($bannerPayment['total_revenue'], 2) }}
                                        {{ __('admin_messages.kd') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table id="myTable3" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.transaction_id') }}</th>
                                <th scope="col">{{ __('admin_messages.request_id') }}</th>
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.amount') }}</th>
                                <th scope="col">{{ __('admin_messages.order_date_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bannerPayment['data'] as $payment)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>#{{ $payment->transaction_id }}</td>
                                <td>#{{ $payment->order_id }}</td>
                                <td>{{ $payment->seller_details->first_name ?? __('admin_messages.na') }}
                                    {{ $payment->seller_details->last_name ?? '' }}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $payment->seller_details->store_info->country_info->name ?? __('admin_messages.na') }}
                                    @else
                                    {{ $payment->seller_details->store_info->country_info->name_ar ?? __('admin_messages.na') }}
                                    @endif
                                </td>
                                <td>{{ $payment->price }} {{__('admin_messages.kd')}}</td>
                                <td>{{ $payment->created_at->format('jS F Y | g:i A') }}</td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabContentContainer = document.getElementById('tabContentContainer');

    // 1️⃣ Restore last active tab on page load
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show(); // Show the saved tab immediately
        }
    }

    // 2️⃣ Show tab container after activating the saved tab
    if (tabContentContainer) {
        tabContentContainer.classList.add('active-shown');
    }

    // 3️⃣ Reload page when user clicks a different tab
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            const currentTab = localStorage.getItem("activeTab");
            if (currentTab !== this.id) {
                e.preventDefault(); // Stop Bootstrap from switching tab immediately
                localStorage.setItem("activeTab", this.id);
                //location.reload(); // reload before tab content shows
            }
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
    updateToDate();
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
    updateToDate();
});
</script>

<script>
function updateToDate3() {
    const fromDate = document.getElementById('from_date3').value;
    const toDateInput = document.getElementById('to_date3');
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
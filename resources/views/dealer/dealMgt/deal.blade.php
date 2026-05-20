@include('dealer.layout.header')

@php
$menu_permission=SellermenuPermission();

$can_view=$menu_permission['can_view'];
$can_action=$menu_permission['can_action'];

@endphp
<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">{{ __('seller_messages.deal_management') }}</div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100"
                    id="pills-allproduct-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-allproduct"
                    type="button"
                    role="tab"
                    aria-controls="pills-allproduct"
                    aria-selected="true">

                    {{ __('seller_messages.listed_deals') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link w-100"
                    id="pills-active-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-active"
                    type="button"
                    role="tab"
                    aria-controls="pills-active"
                    aria-selected="false">

                    {{ __('seller_messages.enrolled') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link w-100"
                    id="pills-inactive-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-inactive"
                    type="button"
                    role="tab"
                    aria-controls="pills-inactive"
                    aria-selected="false">

                    {{ __('seller_messages.expired') }}
                </button>
            </li>

        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">

            {{-- Listed Deals --}}
            <div class="tab-pane fade show active"
                id="pills-allproduct"
                role="tabpanel"
                aria-labelledby="pills-allproduct-tab"
                tabindex="0">

                <div class="datatable-wapper">

                    <div class="table-header mb-1">
                        <div class="search-field">
                            <div class="from-group position-relative">

                                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg"
                                    alt="search"
                                    class="search-icon">

                                <input type="search"
                                    class="form-control @if(count($deal_record['listed_deal']) > 0) tableSearch @endif"
                                    placeholder="{{ __('seller_messages.search') }}"
                                    data-table="table1">

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="table1">

                            <thead>
                                <tr>
                                    <th class="no-sort">{{ __('seller_messages.s_no') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.banner_image') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.date') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.duration') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.discount') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.add_products') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($deal_record['listed_deal'] as $key => $val)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <div class="deal-img">
                                            <img src="{{ $val->image }}"
                                                alt="image"
                                                class="img-fluid">
                                        </div>
                                    </td>

                                    <td>{{ $val->from }}</td>

                                    <td>
                                        {{ formatDateTimeByLocale($val->from) }} - {{ formatDateTimeByLocale($val->to) }}
                                    </td>

                                    <td>{{ $val->discount }} %</td>

                                    <td>
                                        @if($can_action == '1')
                                        <a href="{{ route('seller.add-single-deal-management',$val->id) }}"
                                            class="addPlus-btn btn-success">

                                            <i class="bi bi-plus-lg"></i>
                                        </a>
                                        @endif
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            {{-- Enrolled Deals --}}
            <div class="tab-pane fade"
                id="pills-active"
                role="tabpanel"
                aria-labelledby="pills-active-tab"
                tabindex="0">

                <div class="datatable-wapper">

                    <div class="table-header mb-1">
                        <div class="search-field">
                            <div class="from-group position-relative">

                                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg"
                                    alt="search"
                                    class="search-icon">

                                <input type="search"
                                    class="form-control @if(count($deal_record['enrolled']) > 0) tableSearch @endif"
                                    placeholder="{{ __('seller_messages.search') }}"
                                    data-table="table2">

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="table2">

                            <thead>
                                <tr>
                                    <th class="no-sort">{{ __('seller_messages.s_no') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.banner_image') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.date') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.duration') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.discount') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.products_added') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.status') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.view_details') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.add_more_products') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($deal_record['enrolled'] as $key => $val)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <div class="deal-img">
                                            <img src="{{ $val->image }}"
                                                alt="image"
                                                class="img-fluid">
                                        </div>
                                    </td>

                                    <td>{{ $val->from }}</td>

                                    <td>
                                        {{ $val->from }} - {{ $val->to }}
                                    </td>

                                    <td>{{ $val->discount }} %</td>

                                    <td>{{ $val->seller_deal_count }}</td>

                                    <td>

                                        @if($val->from <= Date('Y-m-d') && $val->to >= Date('Y-m-d'))

                                            <div style="color:#48DB8F;">
                                                {{ __('seller_messages.active') }}
                                            </div>

                                        @elseif($val->from > Date('Y-m-d'))

                                            <div style="color:#dcaf15;">
                                                {{ __('seller_messages.upcoming') }}
                                            </div>

                                        @endif

                                    </td>

                                    <td>
                                        <a href="{{ route('seller.View-single-deal-management',$val->id) }}"
                                            class="eyebtn">

                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>

                                    <td>
                                        @if($can_action == '1')

                                        <a href="{{ route('seller.add-single-deal-management',$val->id) }}"
                                            class="addPlus-btn btn-success">

                                            <i class="bi bi-plus-lg"></i>
                                        </a>

                                        @endif
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            {{-- Expired Deals --}}
            <div class="tab-pane fade"
                id="pills-inactive"
                role="tabpanel"
                aria-labelledby="pills-inactive-tab"
                tabindex="0">

                <div class="datatable-wapper">

                    <div class="table-header mb-1">
                        <div class="search-field">
                            <div class="from-group position-relative">

                                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg"
                                    alt="search"
                                    class="search-icon">

                                <input type="search"
                                    class="form-control @if(count($deal_record['expired_deal']) > 0) tableSearch @endif"
                                    placeholder="{{ __('seller_messages.search') }}"
                                    data-table="table3">

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="table3">

                            <thead>
                                <tr>
                                    <th class="no-sort">{{ __('seller_messages.s_no') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.banner_image') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.date') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.duration') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.discount') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.products_added') }}</th>
                                    <th class="no-sort">{{ __('seller_messages.status') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($deal_record['expired_deal'] as $key => $val)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <div class="deal-img">
                                            <img src="{{ $val->image }}"
                                                alt="image"
                                                class="img-fluid">
                                        </div>
                                    </td>

                                    <td>{{ $val->from }}</td>

                                    <td>
                                        {{ $val->from }} - {{ $val->to }}
                                    </td>

                                    <td>{{ $val->discount }} %</td>

                                    <td>{{ $val->seller_deal_count }}</td>

                                    <td>

                                        @if($can_action == '1')

                                        <a href="{{ route('seller.expire-single-deal-management',$val->id) }}"
                                            class="btn btn-expired">

                                            {{ __('seller_messages.expired_status') }}
                                        </a>

                                        @endif

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

</section>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        // 1️⃣ Restore last active tab
        let activeTab = localStorage.getItem("active_product_tab");
        if (activeTab) {
            let tabEl = document.querySelector(`[data-bs-target="${activeTab}"]`);
            if (tabEl) {
                new bootstrap.Tab(tabEl).show();
            }
        }

        // 2️⃣ Save clicked tab
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tabBtn => {
            tabBtn.addEventListener("shown.bs.tab", function(e) {
                localStorage.setItem("active_product_tab", e.target.getAttribute(
                    "data-bs-target"));
            });
        });

    });


    // Data Table search Code 


    $(document).ready(function() {

        let dataTables = {};

        $('.tableSearch').each(function() {

            let tableId = $(this).data('table');

            // Initialize table only once
            if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                dataTables[tableId] = $('#' + tableId).DataTable({
                    paging: false,
                    ordering: true,
                    info: false,
                    searching: true
                });
            } else {
                dataTables[tableId] = $('#' + tableId).DataTable();
            }
        });

        // Search handler
        $('.tableSearch').on('keyup', function() {
            let tableId = $(this).data('table');
            let value = $(this).val();

            dataTables[tableId].search(value).draw();
        });

    });
    </script>

    @include('dealer.layout.footer');
    @include('dealer.product.ajax.datatablejs'); 



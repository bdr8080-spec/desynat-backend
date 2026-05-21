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
    <h2 class="h2">{{ __('admin_messages.banner_request_management') }}</h2>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    {{ __('admin_messages.new') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="false">
                    {{ __('admin_messages.approved') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    {{ __('admin_messages.rejected') }}
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <form method="GET" action="{{ route('admin.bannerRequestManagement') }}" id="filterForm">
                    <input type="hidden" name="type" value="new" />
                    <div class="row">
                        <!-- <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div> -->
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>
                                <select name="country_name" id="country_name" class="form-select form-select-lg"
                                    onchange="document.getElementById('filterForm').submit();">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'new' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        @if(app()->getLocale() == 'en')
                                        {{ $country['name'] }}
                                        @else
                                        {{ $country['name_ar'] }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="table-responsive mt-5">
                    <!-- <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Seller Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Banner Image</th>
                                <th scope="col">Banner Place</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">No. of Days</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($newRequest as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['order_id'] }}</td>

                                <td>{{ $data['seller_details']['first_name'] }}
                                    {{ $data['seller_details']['last_name'] }}</td>
                                <td>
                                    {{
                                        \App\Models\Country::where(
                                            'dial_code',
                                            $data['seller_details']['country_code']
                                        )->value('name') ?? 'N/A'
                                    }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($data['created_at'])->timezone('Asia/Kuwait')->format('jS F Y | h:i A') }}
                                </td>
                                <td>
                                    <a href="{{ $data['upload_banner'] }}" target="blank"> <img
                                            src="{{ $data['upload_banner'] }}" alt="" width="40px" height="40px"
                                            class="square" /> </a>
                                </td>
                                <td>
                                    {{
                                        [
                                            1 => 'Home Top',
                                            2 => 'Home Bottom',
                                            3 => 'Sub Category',
                                        ][$data['banner_position']] ?? 'N/A'
                                    }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($data['start_date'])->format('d F Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($data['end_date'])->format('d F Y') }}
                                </td>

                                <td>{{ $data['total_days'] }} days</td>

                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button approveBannerBtn" data-id="{{ $data['id'] }}"
                                            type="button">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </a>

                                        <a class="table-button rejectBannerBtn" data-id="{{ $data['id'] }}"
                                            data-bs-toggle="modal" data-bs-target="#rejectmodel" type="button">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">No data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table> -->
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('admin_messages.s_no') }}</th>
                                <th>{{ __('admin_messages.request_id') }}</th>
                                <th>{{ __('admin_messages.seller_name') }}</th>
                                <th>{{ __('admin_messages.seller_country') }}</th>
                                <th>{{ __('admin_messages.request_on') }}</th>
                                <th>{{ __('admin_messages.banner_image') }}</th>
                                <th>{{ __('admin_messages.banner_place') }}</th>
                                <th>{{ __('admin_messages.start_date') }}</th>
                                <th>{{ __('admin_messages.end_date') }}</th>
                                <th>{{ __('admin_messages.no_of_days') }}</th>
                                @if(in_array(17, $permissions) || $admin->type == 1)
                                <th>{{ __('admin_messages.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newRequest as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>#{{ $data['order_id'] ?? '' }}</td>
                                <td>{{ optional($data['seller_details'])->first_name ?? '' }} {{ optional($data['seller_details'])->last_name ?? '' }}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ \App\Models\Country::where('dial_code', optional($data['seller_details'])->country_code)->value('name') ?? '' }}
                                    @else
                                    {{ \App\Models\Country::where('dial_code', optional($data['seller_details'])->country_code)->value('name_ar') ?? '' }}
                                    @endif
                                </td>
                                <td>{{ !empty($data['created_at']) ? formatDateTimeByLocale($data['created_at']) : '' }}</td>
                                <td>
                                    @if(!empty($data['upload_banner']))
                                        <a href="{{ $data['upload_banner'] }}" target="_blank">
                                            <img src="{{ $data['upload_banner'] }}" width="40" height="40"/>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{
                                        [
                                            1 => __('admin_messages.home_top'),
                                            2 => __('admin_messages.home_bottom'),
                                            3 => __('admin_messages.sub_category')
                                        ][$data['banner_position']] ?? ''
                                    }}
                                </td>
                                <td>{{ !empty($data['start_date']) ? formatDateTimeByLocale($data['start_date']) : '' }}</td>
                                <td>{{ !empty($data['end_date']) ? formatDateTimeByLocale($data['end_date']) : '' }}</td>
                                <td>{{ $data['total_days'] ?? '' }} {{__('admin_messages.days')}}</td>
                                @if(in_array(17, $permissions) || $admin->type == 1)
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button approveBannerBtn" data-id="{{ $data['id'] }}"><i class="bi bi-check-circle-fill"></i></a>
                                        <a class="table-button rejectBannerBtn" data-id="{{ $data['id'] }}" data-bs-toggle="modal" data-bs-target="#rejectmodel"><i class="bi bi-x-circle-fill"></i></a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- approved -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.bannerRequestManagement') }}" id="filterForm1">
                    <input type="hidden" name="type" value="approved" />
                    <div class="row">
                        <!-- <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div> -->
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>
                                <select name="country_name" id="country_name" class="form-select form-select-lg"
                                    onchange="document.getElementById('filterForm1').submit();">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'approved' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        @if(app()->getLocale() == 'en')
                                        {{ $country['name'] }}
                                        @else
                                        {{ $country['name_ar'] }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="table-responsive mt-5">
                    <table id="myTable1" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('admin_messages.s_no') }}</th>
                                <th>{{ __('admin_messages.request_id') }}</th>
                                <th>{{ __('admin_messages.seller_name') }}</th>
                                <th>{{ __('admin_messages.seller_country') }}</th>
                                <th>{{ __('admin_messages.request_on') }}</th>
                                <th>{{ __('admin_messages.banner_image') }}</th>
                                <th>{{ __('admin_messages.banner_place') }}</th>
                                <th>{{ __('admin_messages.start_date') }}</th>
                                <th>{{ __('admin_messages.end_date') }}</th>
                                <th>{{ __('admin_messages.no_of_days') }}</th>
                                <th scope="col">{{ __('admin_messages.seller_posted') }}</th>
                                <th scope="col">{{ __('admin_messages.amount_paid') }}</th>
                                @if(in_array(17, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($approvedRequest as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['order_id'] }}</td>

                                <td>{{ $data['seller_details']['first_name'] ?? 'N/A' }}
                                    {{ $data['seller_details']['last_name'] ?? '' }}</td>
                               <td>
                                    @if(app()->getLocale() == 'en')
                                    {{
                                        \App\Models\Country::where(
                                            'dial_code',
                                            optional($data['seller_details'])->country_code
                                        )->value('name') ?? __('admin_messages.na')
                                    }}
                                    @else
                                    {{
                                        \App\Models\Country::where(
                                            'dial_code',
                                            optional($data['seller_details'])->country_code
                                        )->value('name_ar') ?? __('admin_messages.na')
                                    }}
                                    @endif
                                </td>
                                <td>
                                    <td>{{ !empty($data['created_at']) ? formatDateTimeByLocale($data['created_at']) : '' }}</td>
                                </td>
                                <td>
                                    <a href="{{ $data['upload_banner'] }}" target="blank"> <img
                                            src="{{ $data['upload_banner'] }}" alt="" width="40px" height="40px"
                                            class="square" /> </a>
                                </td>
                                <td>
                                    {{
                                        [
                                            1 => __('admin_messages.home_top'),
                                            2 => __('admin_messages.home_bottom'),
                                            3 => __('admin_messages.sub_category')
                                        ][$data['banner_position']] ?? ''
                                    }}
                                </td>
                                <td>
                                    {{ formatDateTimeByLocale($data['start_date']) }}
                                </td>
                                <td>
                                    {{ formatDateTimeByLocale($data['end_date']) }}
                                </td>

                                <td>{{ $data['total_days'] }} {{__('admin_messages.days')}}</td>

                                <td>
                                    {{ $data['payment_status'] == 1 ? __('admin_messages.yes') : __('admin_messages.no') }}
                                </td>
                                <td>
                                    @if($data['payment_status'] == 1)
                                    @php
                                    $price = (float) $data['price'];
                                    $formattedPrice = ($price == floor($price)) ? intval($price) : number_format($price,
                                    2, '.', '');
                                    @endphp
                                    {{ $formattedPrice }} {{__('admin_messages.kd')}}
                                    @else
                                    {{__('admin_messages.na')}}
                                    @endif
                                </td>
                                @if(in_array(17, $permissions) || $admin->type == 1)
                                <td>
                                <div class="form-check form-switch d-flex justify-content-center align-items-center"">
                                        <input
                                            class="form-check-input toggleStatus"
                                            type="checkbox"
                                            role="switch"
                                            id="switch{{ $data['id'] }}"
                                            data-id="{{ $data['id'] }}"
                                            {{ $data['status'] == 1 ? 'checked' : '' }}
                                        />
                                    </div>
                                </td>
                                @endif

                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">{{ __('admin_messages.no_data_found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- rejected -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.bannerRequestManagement') }}" id="filterForm2">
                    <input type="hidden" name="type" value="rejected" />
                    <div class="row">
                        <!-- <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div> -->
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.select_country') }}</label>
                                <select name="country_name" id="country_name" class="form-select form-select-lg"
                                    onchange="document.getElementById('filterForm2').submit();">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country['name'] }}"
                                        {{ request('type') == 'rejected' && request('country_name') == $country['name'] ? 'selected' : '' }}>
                                        @if(app()->getLocale() == 'en')
                                        {{ $country['name'] }}
                                        @else
                                        {{ $country['name_ar'] }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="table-responsive mt-5 mt-5">
                    <table id="myTable2" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('admin_messages.s_no') }}</th>
                                <th>{{ __('admin_messages.request_id') }}</th>
                                <th>{{ __('admin_messages.seller_name') }}</th>
                                <th>{{ __('admin_messages.seller_country') }}</th>
                                <th>{{ __('admin_messages.request_on') }}</th>
                                <th>{{ __('admin_messages.banner_image') }}</th>
                                <th>{{ __('admin_messages.banner_place') }}</th>
                                <th>{{ __('admin_messages.start_date') }}</th>
                                <th>{{ __('admin_messages.end_date') }}</th>
                                <th>{{ __('admin_messages.no_of_days') }}</th>
                                <th scope="col">{{ __('admin_messages.reason') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rejectedRequest as $index => $data)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>#{{ $data['order_id'] }}</td>

                                <td>{{ $data['seller_details']['first_name'] }}
                                    {{ $data['seller_details']['last_name'] }}</td>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{
                                        \App\Models\Country::where(
                                            'dial_code',
                                            optional($data['seller_details'])->country_code
                                        )->value('name') ?? __('admin_messages.na')
                                    }}
                                    @else
                                    {{
                                        \App\Models\Country::where(
                                            'dial_code',
                                            optional($data['seller_details'])->country_code
                                        )->value('name_ar') ?? __('admin_messages.na')
                                    }}
                                    @endif
                                </td>
                                <td>
                                    {{ formatDateTimeByLocale($data['created_at']) }}
                                </td>
                                <td>
                                    <a href="{{ $data['upload_banner'] }}" target="blank"> <img
                                            src="{{ $data['upload_banner'] }}" alt="" width="40px" height="40px"
                                            class="square" /> </a>
                                </td>
                                <td>
                                    {{
                                        [
                                            1 => __('admin_messages.home_top'),
                                            2 => __('admin_messages.home_bottom'),
                                            3 => __('admin_messages.sub_category')
                                        ][$data['banner_position']] ?? ''
                                    }}
                                </td>
                                <td>
                                    {{ formatDateTimeByLocale($data['start_date']) }}
                                </td>
                                <td>
                                    {{ formatDateTimeByLocale($data['end_date']) }}
                                </td>

                                <td>{{ $data['total_days'] }} {{__('admin_messages.days')}}</td>

                                <td style="white-space: pre-wrap; word-break: break-word;">
                                    {{ $data['cancelled_reason'] ?? __('admin_messages.na') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">{{ __('admin_messages.no_data_found') }}</td>
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

<div class="modal fade" id="rejectmodel" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">{{ __('admin_messages.reject_banner_request') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="rejectReason" class="form-label">{{ __('admin_messages.reason_for_rejection') }}</label>
                    <textarea class="form-control" id="rejectReason" rows="3" placeholder="{{ __('admin_messages.please_enter_reason') }}"></textarea>
                    <div id="error-message" class="text-danger mt-2" style="display:none;">{{ __('admin_messages.please_enter_reason') }}</div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button type="button" class="btn btn-dark customBtn" id="submitReject">{{ __('admin_messages.submit') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.approveBannerBtn').forEach(button => {
        button.addEventListener('click', function() {
            let bannerId = this.getAttribute('data-id');

            fetch("{{ route('admin.approveBannerRequest') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        banner_id: bannerId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message || 'Failed to approve banner.');
                    }
                    setTimeout(() => location.reload(), 2000);
                })
                .catch(error => {
                    //console.error(error);
                    toastr.error('Something went wrong while approving the banner.');
                });
        });
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    let currentBannerId = null;

    document.querySelectorAll('.rejectBannerBtn').forEach(button => {
        button.addEventListener('click', function() {
            currentBannerId = this.getAttribute('data-id');

            document.getElementById('rejectReason').value = '';
            document.getElementById('error-message').style.display = 'none';
        });
    });

    const rejectReasonInput = document.getElementById('rejectReason');
    const errorMessage = document.getElementById('error-message');
    const submitRejectBtn = document.getElementById('submitReject');

    rejectReasonInput.addEventListener('input', function() {
        errorMessage.style.display = 'none';
    });

    submitRejectBtn.addEventListener('click', function() {
        const reason = rejectReasonInput.value.trim();

        if (!reason) {
            errorMessage.style.display = 'block';
            return;
        }

        fetch("{{ route('admin.rejectBannerRequest') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    banner_id: currentBannerId,
                    reason: reason
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    toastr.success(data.message);

                    const modalEl = document.getElementById('rejectmodel');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(
                        modalEl);
                    modal.hide();

                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(data.message || 'Failed to reject banner.');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Something went wrong while rejecting the banner.');
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let Id = this.getAttribute('data-id');

            fetch(`/admin/updateBannerReqStatus/${Id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // toastr.success(data.message);
                     if(data.status == 1){
                        toastr.success(data.message); // Green for active
                    } else {
                        toastr.error(data.message);   // Red for deactivated
                    }
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                //console.error(error);
                toastr.error('Something went wrong while updating status.');
            });
        });
    });
});
</script>


@endsection
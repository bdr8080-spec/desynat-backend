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
            <h2 class="h2">{{ __('admin_messages.live_request_timeslot_management') }}</h2>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-4 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    {{ __('admin_messages.live_request_timeslot') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    {{ __('admin_messages.live_request') }}
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <form method="GET" action="{{ route('admin.liveRequestManagement') }}" id="filterForm">
            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab"
                    tabindex="0">
                    <div class="row">
                        <div class="align-items-end d-flex">

                            <div class="col-lg-6">
                                <div class="align-items-end d-flex">
                                    <div class="form-group mb-5 w-100">
                                        <select name="country_id" class="form-select form-select-lg w-50"
                                            onchange="document.getElementById('filterForm').submit();">
                                            <option value="">{{ __('admin_messages.select_country') }}</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country['id'] }}"
                                                {{ request('country_id') == $country['id'] ? 'selected' : '' }}>
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
                            <div class="col-lg-6 ">
                                @if(in_array(18, $permissions) || $admin->type == 1)
                                <div class="d-flex gap-3 justify-content-end">


                                    <a class="btn btn-dark customBtn " style="margin-top: 60px" data-bs-toggle="modal"
                                        data-bs-target="#sentModal3">
                                        <span>{{ __('admin_messages.add_timeslot') }}</span>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- full calender -->

                    <div class="container-2 mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-5">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Selected Date & Timeslot UI -->
                                <div id="timeslotSection" style="display:none; margin-top:40px">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 id="selectedDateText" class=""></h3>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Timeslot Card -->
                                        @forelse($timeslots as $index => $slot)
                                        <div class="col-md-5">
                                            <div class="timeslot-card d-flex">
                                                <div class="timeslot-card active">
                                                    <!-- <span>10 AM - 11 AM</span> -->
                                                    <span class="">{{$slot['from']}}- {{$slot['to']}}</span>
                                                </div>
                                               <div class="d-flex gap-3 justify-content-center">
                                                        <a class="table-button editTimeslotModal"
                                                            data-id="{{ $slot['id'] }}"
                                                            data-from="{{ $slot['from'] }}"
                                                            data-to="{{ $slot['to'] }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editTimeslotModal">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a class="table-button text-danger deleteTimeslot mb-1 mt-1" data-id="{{ $slot['id'] }}">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </a>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input toggleStatus" 
                                                                type="checkbox" 
                                                                id="flexSwitchCheckChecked{{ $slot['id'] }}" 
                                                                data-id="{{ $slot['id'] }}"
                                                                {{ $slot['status'] == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="flexSwitchCheckChecked{{ $slot['id'] }}"></label>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        @empty
                                        <tr>
                                            <span class="text-center">{{ __('admin_messages.no_timeslot_added') }}</span>
                                        </tr>
                                        @endforelse
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Return -->
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                    tabindex="0">
                    <div class="d-flex justify-content-center">
                        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
                            <li class="nav-item m-1" role="presentation">
                                <button class="nav-link customBtn2 m-0" id="pills-new-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-new" type="button" role="tab" aria-controls="pills-new"
                                    aria-selected="true">
                                    {{ __('admin_messages.new') }}
                                </button>
                            </li>
                            <li class="nav-item m-1" role="presentation">
                                <button class="nav-link  active customBtn2 m-0" id="pills-approved-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-approved" type="button" role="tab"
                                    aria-controls="pills-approved" aria-selected="true">
                                    {{ __('admin_messages.approved') }}
                                </button>
                            </li>

                            <li class="nav-item m-1" role="presentation">
                                <button class="nav-link  customBtn2 m-0" id="pills-reject-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-reject" type="button" role="tab" aria-controls="pills-reject"
                                    aria-selected="false">
                                    {{ __('admin_messages.rejected') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="userManagecontent">
                        <div class="tab-content" id="pills-tabContent">
                            <!-- new -->

                            <div class="tab-pane fade" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab"
                                tabindex="0">
                                <div class="row">
                                    <form method="GET" action="{{ route('admin.liveRequestManagement') }}" id="filterForm">
                                     <input type="hidden" name="type" value="new" />
                                    <div class="align-items-end d-flex gap-3">
                                        <!-- <div class="search-box" style="position: relative">
                                            <i class="bi bi-search" style="
                                            position: absolute;
                                            left: 10px;
                                            top: 50%;
                                            transform: translateY(-50%);
                                            font-size: 16px;
                                            color: #888;
                                            ">
                                                        </i>
                                                        <input type="text" class="form-control" placeholder="Search for..."
                                                            style="padding-left: 35px" />
                                        </div> -->
                                        <div class="col-lg-3 col-md-12 col-12">
                                            <div class="form-group mt-4 w-100">
                                                <!-- <label for="from" class="form-label">Country Name</label> -->
                                                <select name="country_name" id="country_name"
                                                    class="form-select form-select-lg"
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
                                </div>

                                <div class="table-responsive mt-3 w-100">
                                    <table id="myTable" class="table w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                                <th scope="col">{{ __('admin_messages.request_id') }}</th>
                                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                                <th scope="col">{{ __('admin_messages.seller_country') }}</th>
                                                <th scope="col">{{ __('admin_messages.request_on') }}</th>
                                                <th scope="col">{{ __('admin_messages.live_date_&_time') }}</th>
                                                @if(in_array(18, $permissions) || $admin->type == 1)
                                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($newRequest as $index => $data)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>#{{ $data['order_id'] }}</td>
                                                <td>{{ $data['seller_details']['first_name'] }} {{ $data['seller_details']['last_name'] }}</td>
                                                <td>
                                                    @if(app()->getLocale() == 'en')
                                                    {{ $data['seller_details']['store_info']['country_info']['name']??__('admin_messages.na') }}
                                                    @else
                                                    {{ $data['seller_details']['store_info']['country_info']['name_ar']??__('admin_messages.na') }}
                                                    @endif
                                                </td>
                                                <td>{{ $data['created_at']->format('jS F Y | h:i A') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data['timeslot_details']['date'])->format('jS F Y') }} | {{ $data['timeslot_details']['from'] }}-{{ $data['timeslot_details']['to'] }}</td>
                                                @if(in_array(18, $permissions) || $admin->type == 1)
                                                <td>
                                                    <div class="d-flex gap-3 justify-content-center">
                                                        <a class="table-button approveLiveRequest"
                                                            href="javascript:void(0)"
                                                            data-id="{{ $data['id'] }}">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                        </a>
                                                        <a class="table-button rejectBtn"
                                                            href="javascript:void(0)"
                                                            data-id="{{ $data['id'] }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#sentModal2">
                                                                <i class="bi bi-x-circle-fill"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @empty

                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- approved -->
                            <div class="tab-pane fade show active" id="pills-approved" role="tabpanel"
                                aria-labelledby="pills-approved-tab" tabindex="0">
                                <div class="row">
                                    <form method="GET" action="{{ route('admin.liveRequestManagement') }}" id="filterForm1">
                                     <input type="hidden" name="type" value="approved" />
                                    <div class="align-items-end d-flex gap-3">
                                        <!-- <div class="search-box" style="position: relative">
                                            <i class="bi bi-search" style="
                                            position: absolute;
                                            left: 10px;
                                            top: 50%;
                                            transform: translateY(-50%);
                                            font-size: 16px;
                                            color: #888;
                                            ">
                                                        </i>
                                                        <input type="text" class="form-control" placeholder="Search for..."
                                                            style="padding-left: 35px" />
                                        </div> -->
                                        <div class="col-lg-3 col-md-12 col-12">
                                            <div class="form-group mt-4 w-100">
                                                <!-- <label for="from" class="form-label">Country Name</label> -->
                                                <select name="country_name" id="country_name"
                                                    class="form-select form-select-lg"
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
                                </div>

                                <div class="table-responsive mt-3 w-100">
                                    <table id="myTable1" class="table w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                                <th scope="col">{{ __('admin_messages.request_id') }}</th>
                                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                                <th scope="col">{{ __('admin_messages.seller_country') }}</th>
                                                <th scope="col">{{ __('admin_messages.request_on') }}</th>
                                                <th scope="col">{{ __('admin_messages.live_date_&_time') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($approvedRequest as $index => $data)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>#{{ $data['order_id'] }}</td>
                                                <td>{{ $data['seller_details']['first_name'] }} {{ $data['seller_details']['last_name'] }}</td>
                                                <td>
                                                    @if(app()->getLocale() == 'en')
                                                    {{ $data['seller_details']['store_info']['country_info']['name']??__('admin_messages.na') }}
                                                    @else
                                                    {{ $data['seller_details']['store_info']['country_info']['name_ar']??__('admin_messages.na') }}
                                                    @endif
                                                </td>
                                                <td>{{ $data['created_at']->format('jS F Y | h:i A') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data['timeslot_details']['date'])->format('jS F Y') }} | {{ $data['timeslot_details']['from'] }}-{{ $data['timeslot_details']['to'] }}</td>
                                            </tr>
                                            @empty

                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- reject -->

                            <div class="tab-pane fade" id="pills-reject" role="tabpanel"
                                aria-labelledby="pills-reject-tab" tabindex="0">
                                <div class="row">
                                    <form method="GET" action="{{ route('admin.liveRequestManagement') }}" id="filterForm2">
                                     <input type="hidden" name="type" value="reject" />
                                    <div class="align-items-end d-flex gap-3">
                                        <!-- <div class="search-box" style="position: relative">
                                            <i class="bi bi-search" style="
                                            position: absolute;
                                            left: 10px;
                                            top: 50%;
                                            transform: translateY(-50%);
                                            font-size: 16px;
                                            color: #888;
                                            ">
                                                        </i>
                                                        <input type="text" class="form-control" placeholder="Search for..."
                                                            style="padding-left: 35px" />
                                        </div> -->
                                        <div class="col-lg-3 col-md-12 col-12">
                                            <div class="form-group mt-4 w-100">
                                                <!-- <label for="from" class="form-label">Country Name</label> -->
                                                <select name="country_name" id="country_name"
                                                    class="form-select form-select-lg"
                                                    onchange="document.getElementById('filterForm2').submit();">
                                                    <option value="">{{ __('admin_messages.select_country') }}</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country['name'] }}"
                                                            {{ request('type') == 'reject' && request('country_name') == $country['name'] ? 'selected' : '' }}>
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
                                </div>

                                <div class="table-responsive mt-3 w-100">
                                    <table id="myTable2" class="table w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                                <th scope="col">{{ __('admin_messages.request_id') }}</th>
                                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                                <th scope="col">{{ __('admin_messages.seller_country') }}</th>
                                                <th scope="col">{{ __('admin_messages.request_on') }}</th>
                                                <th scope="col">{{ __('admin_messages.live_date_&_time') }}</th>
                                                <th scope="col">{{ __('admin_messages.reason') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($rejectRequest as $index => $data)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>#{{ $data['order_id'] }}</td>
                                                <td>{{ $data['seller_details']['first_name'] }} {{ $data['seller_details']['last_name'] }}</td>
                                                <td>
                                                    @if(app()->getLocale() == 'en')
                                                    {{ $data['seller_details']['store_info']['country_info']['name']??__('admin_messages.na') }}
                                                    @else
                                                    {{ $data['seller_details']['store_info']['country_info']['name_ar']??__('admin_messages.na') }}
                                                    @endif
                                                </td>
                                                <td>{{ $data['created_at']->format('jS F Y | h:i A') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data['timeslot_details']['date'])->format('jS F Y') }} | {{ $data['timeslot_details']['from'] }}-{{ $data['timeslot_details']['to'] }}</td>
                                                <td>{{ $data['reject_reason'] }}</td>
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
            </div>
        </form>
    </div>

    <!-- End of Content Wrapper -->
</div>

<!-- reason model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.reason') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="form-label">{{ __('admin_messages.reason_for_rejection') }}
                                    </label>
                                    <textarea class="form-control" id="rejectReason" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                style="margin-top: 30px">
                                <a class="btn btn-dark customBtn" href=""> {{ __('admin_messages.submit') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add modal -->
<div class="modal fade" id="sentModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.add_timeslot') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="time-wrapper">
                        <div id="timeContainer">
                            <div class="time-row">
                                <div class="time-block from-block flex-wrap">
                                    <label>{{ __('admin_messages.from') }}</label>
                                    <div class="d-flex gap-2">
                                    <select class="hh form-select" data-error="{{ __('admin_messages.please_select_from_hour') }}"><option value="">{{ __('admin_messages.hh') }}</option></select>
                                    <select class="mm form-select" data-error="{{ __('admin_messages.please_select_from_minute') }}"><option value="">{{ __('admin_messages.mm') }}</option></select>
                                    <select class="ap form-select" data-error="{{ __('admin_messages.please_select_from_am_pm') }}"><option value="">{{ __('admin_messages.AM') }}/{{ __('admin_messages.PM') }}</option></select>
                                    </div>
                                    <small class="error-msg" style="color:red;"></small>
                                </div>

                                <div class="time-block to-block flex-wrap">
                                    <label>{{ __('admin_messages.to') }}</label>
                                     <div class="d-flex gap-2">
                                    <select class="hh form-select" data-error="{{ __('admin_messages.please_select_to_hour') }}"><option value="">{{ __('admin_messages.hh') }}</option></select>
                                    <select class="mm form-select" data-error="{{ __('admin_messages.please_select_to_minute') }}"><option value="">{{ __('admin_messages.mm') }}</option></select>
                                    <select class="ap form-select" data-error="{{ __('admin_messages.please_select_to_am_pm') }}"><option value="">{{ __('admin_messages.AM') }}/{{ __('admin_messages.PM') }}</option></select>
                                    </div>
                                    <small class="error-msg" style="color:red;"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                        <div class="d-flex align-items-center justify-content-center gap-3 mt-3" style="margin-top: 30px">
                            <button type="submit" class="btn btn-dark customBtn">{{ __('admin_messages.submit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="editTimeslotModal" tabindex="-1" aria-labelledby="editTimeslotLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit_timeslot') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="time-wrapper">
                        <div id="editTimeContainer">
                            <div class="time-row">
                                <div class="time-block from-block">
                                    <label>{{ __('admin_messages.from') }}</label>
                                    <select class="hh form-select" data-error="{{ __('admin_messages.please_select_from_hour') }}"><option value="">{{ __('admin_messages.hh') }}</option></select>
                                    <select class="mm form-select" data-error="{{ __('admin_messages.please_select_from_minute') }}"><option value="">{{ __('admin_messages.mm') }}</option></select>
                                    <select class="ap form-select" data-error="{{ __('admin_messages.please_select_from_am_pm') }}"><option value="">{{ __('admin_messages.AM') }}/{{ __('admin_messages.PM') }}</option></select>
                                    <small class="error-msg" style="color:red;"></small>
                                </div>
                                
                                <div class="time-block to-block">
                                    <label>{{ __('admin_messages.to') }}</label>
                                    <select class="hh form-select" data-error="{{ __('admin_messages.please_select_to_hour') }}"><option value="">{{ __('admin_messages.hh') }}</option></select>
                                    <select class="mm form-select" data-error="{{ __('admin_messages.please_select_to_minute') }}"><option value="">{{ __('admin_messages.mm') }}</option></select>
                                    <select class="ap form-select" data-error="{{ __('admin_messages.please_select_to_am_pm') }}"><option value="">{{ __('admin_messages.AM') }}/{{ __('admin_messages.PM') }}</option></select>
                                    <small class="error-msg" style="color:red;"></small>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                        <div class="d-flex align-items-center justify-content-center gap-3 mt-3" style="margin-top: 30px">
                            <button type="submit" class="btn btn-dark customBtn" id="editTimeslotSubmit">{{ __('admin_messages.update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get last active tab from localStorage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Save active tab to localStorage when switched
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>


<!-- <script>
document.addEventListener("DOMContentLoaded", function() {
    const url = new URL(window.location);
    const urlParams = url.searchParams;

    let reloadNeeded = false;

    if (!urlParams.has('country_id')) {
        urlParams.set('country_id', 1);
        reloadNeeded = true;
    }

    if (!urlParams.has('date')) {
        const today = new Date().toISOString().split('T')[0];
        urlParams.set('date', today);
        reloadNeeded = true;
    }

    if (reloadNeeded) {
        window.location.replace(url.toString()); 
        return;
    }

    const selectedDate = urlParams.get('date');

    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        selectable: true,
        height: "auto",
        initialDate: selectedDate,

        dateClick: function(info) {
            reloadWithDate(info.dateStr);
        }
    });

    calendar.render();

    calendar.select(selectedDate);

    showSelectedDate(selectedDate);
});

function showSelectedDate(dateStr) {
    const date = new Date(dateStr);
    const options = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };

    document.getElementById("selectedDateText").innerText =
        `Today, ${date.toLocaleDateString('en-GB', options)}`;

    document.getElementById("timeslotSection").style.display = "block";
}

function reloadWithDate(dateStr) {
    const url = new URL(window.location);
    url.searchParams.set('date', dateStr);

    if (!url.searchParams.has('country_id')) {
        url.searchParams.set('country_id', 1);
    }

    window.location.href = url.toString();
}
</script> -->


<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteTimeslot').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');

            Swal.fire({
                title: "{{ __('admin_messages.are_you_sure?') }}",
                text: "{{ __('admin_messages.you_wont_be_able_to_revert_this') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "{{ __('admin_messages.yes_delete_it') }}",
                cancelButtonText: "{{ __('admin_messages.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deleteTimeslot/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
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
                        .catch(() => {
                            toastr.error('Something went wrong.');
                        });
                }
            });
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let id = this.getAttribute('data-id');
            let isChecked = this.checked;

            fetch(`/admin/blockUnblockTimeslot/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_block: isChecked ? 0 : 1
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

<!-- add timeslot -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    const timeContainer = document.getElementById("timeContainer");
    const row = timeContainer.querySelector(".time-row");

    const urlParams = new URLSearchParams(window.location.search);
    const countryId = urlParams.get('country_id');
    const date = urlParams.get('date');

    // Populate dropdowns
    function populateDropdowns(row) {
        const hhs = row.querySelectorAll("select.hh");
        const mms = row.querySelectorAll("select.mm");
        const aps = row.querySelectorAll("select.ap");

        hhs.forEach(select => {
            select.innerHTML = '<option value="">{{ __("admin_messages.hh") }}</option>';
            for(let i=1;i<=12;i++){
                const val = i.toString().padStart(2,'0');
                select.innerHTML += `<option value="${val}">${val}</option>`;
            }
        });

        mms.forEach(select => {
            select.innerHTML = '<option value="">{{ __("admin_messages.mm") }}</option>';
            for(let i=0;i<=59;i++){
                const val = i.toString().padStart(2,'0');
                select.innerHTML += `<option value="${val}">${val}</option>`;
            }
        });

        aps.forEach(select => {
            select.innerHTML =
            '<option value="AM">{{ __("admin_messages.AM") }}</option>' +
            '<option value="PM">{{ __("admin_messages.PM") }}</option>';
        });
    }

    populateDropdowns(row);

    // ✅ Remove error only if HH, MM, and AP are all selected
    document.addEventListener('change', function(e){
        if(e.target.tagName === 'SELECT'){
            const block = e.target.closest('.time-block');
            if(block){
                const hh = block.querySelector('select.hh').value;
                const mm = block.querySelector('select.mm').value;
                const ap = block.querySelector('select.ap').value;

                if(hh && mm && ap){
                    const error = block.querySelector('.error-msg');
                    if(error) error.innerText = '';
                }
            }
        }
    });

    // Validate row with custom messages
    function validateRow(row){
        let valid = true;
        row.querySelectorAll('.time-block').forEach(block => {
            const hh = block.querySelector('select.hh').value;
            const mm = block.querySelector('select.mm').value;
            const ap = block.querySelector('select.ap').value;

            const errorEl = block.querySelector('.error-msg');
            if(errorEl) errorEl.innerText = '';

            if(!hh || !mm || !ap){
                if (errorEl) {
                    const label = block.querySelector('label')?.innerText || '';

                    errorEl.innerText = "{{ __('admin_messages.please_select_time_for') }}"
                        .replace(':field', label);
                }
                valid = false;
            }
        });
        return valid;
    }

    function timeToMinutes(hh, mm, ap){
        let hour = parseInt(hh);
        const minute = parseInt(mm);
        if(ap === 'PM' && hour !== 12) hour += 12;
        if(ap === 'AM' && hour === 12) hour = 0;
        return hour * 60 + minute;
    }

    document.querySelector("#sentModal3 .btn[type='submit']").addEventListener('click', function(e){
        e.preventDefault();

        if(!validateRow(row)) return;

        if(!countryId){
            toastr.error("{{ __('admin_messages.please_select_a_country') }}");
            return;
        }

        if(!date){
            toastr.error("{{ __('admin_messages.please_select_a_date') }}");
            return;
        }

        const fromHH = row.querySelector(".from-block select.hh").value;
        const fromMM = row.querySelector(".from-block select.mm").value;
        const fromAP = row.querySelector(".from-block select.ap").value;

        const toHH = row.querySelector(".to-block select.hh").value;
        const toMM = row.querySelector(".to-block select.mm").value;
        const toAP = row.querySelector(".to-block select.ap").value;

        const fromTotal = timeToMinutes(fromHH, fromMM, fromAP);
        const toTotal = timeToMinutes(toHH, toMM, toAP);

        if(toTotal <= fromTotal){
            toastr.error("{{ __('admin_messages.to_time_should_be_greater_than_from_time') }}");
            return;
        }

        const fromTime = `${fromHH}:${fromMM} ${fromAP}`;
        const toTime = `${toHH}:${toMM} ${toAP}`;

        fetch("{{ route('admin.addTimeslot') }}", {
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({
                country_id: countryId,
                date: date,
                from: fromTime,
                to: toTime
            })
        })
        .then(res => res.json())
        .then(res => {
            console.log(res);
            if(res.status === 'success'){
                toastr.success(res.message);
               setTimeout(() => {
                            location.reload();
                        }, 2000);
            } else {
                toastr.error(res.message || 'Something went wrong!');
            }
        })
        .catch(err => {
            console.error(err);
            toastr.error('Failed to create timeslot');
        });
    });

});
</script>








<!-- update timeslot -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    // Populate HH, MM, AP selects
    function populateDropdowns(container) {
        container.querySelectorAll("select.hh").forEach(select => {
            select.innerHTML = '<option value="">{{ __("admin_messages.hh") }}</option>';
            for(let i=1;i<=12;i++){
                const val = i.toString().padStart(2,'0');
                select.innerHTML += `<option value="${val}">${val}</option>`;
            }
        });

        container.querySelectorAll("select.mm").forEach(select => {
            select.innerHTML = '<option value="">{{ __("admin_messages.mm") }}</option>';
            for(let i=0;i<=59;i++){
                const val = i.toString().padStart(2,'0');
                select.innerHTML += `<option value="${val}">${val}</option>`;
            }
        });

        container.querySelectorAll("select.ap").forEach(select => {
            select.innerHTML =
            '<option value="AM">{{ __("admin_messages.AM") }}</option>' +
            '<option value="PM">{{ __("admin_messages.PM") }}</option>';
        });
    }

    // Validate a block (from/to) → show one error below the block if incomplete
    function validateBlock(block, prefix) {
        const hh = block.querySelector("select.hh").value;
        const mm = block.querySelector("select.mm").value;
        const ap = block.querySelector("select.ap").value;

        const errorEl = block.querySelector(".error-msg");
        if(errorEl) errorEl.innerText = '';

        if(!hh || !mm || !ap){
            if (errorEl) {
                errorEl.innerText = `{{ __('admin_messages.please_select_time') }}`.replace(':prefix', prefix);
            }
            return false;
        }
        return true;
    }

    // Remove error automatically when all fields selected
    document.addEventListener('change', function(e){
        if(e.target.tagName === 'SELECT'){
            const block = e.target.closest('.time-block');
            if(block){
                const hh = block.querySelector('select.hh').value;
                const mm = block.querySelector('select.mm').value;
                const ap = block.querySelector('select.ap').value;
                if(hh && mm && ap){
                    const errorEl = block.querySelector('.error-msg');
                    if(errorEl) errorEl.innerText = '';
                }
            }
        }
    });

    // Modal elements
    const editModalEl = document.getElementById('editTimeslotModal');
    const editRow = editModalEl.querySelector(".time-row");

    populateDropdowns(editRow);

    // When modal opens → populate fields
    editModalEl.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const slotId = button.getAttribute('data-id');
        const fromTime = button.getAttribute('data-from');
        const toTime = button.getAttribute('data-to');

        if(!slotId || !fromTime || !toTime){
            toastr.error('Invalid timeslot data');
            return;
        }

        const fromParts = fromTime.split(/[: ]/);
        const toParts = toTime.split(/[: ]/);

        editRow.querySelector(".from-block select.hh").value = fromParts[0];
        editRow.querySelector(".from-block select.mm").value = fromParts[1];
        editRow.querySelector(".from-block select.ap").value = fromParts[2];

        editRow.querySelector(".to-block select.hh").value = toParts[0];
        editRow.querySelector(".to-block select.mm").value = toParts[1];
        editRow.querySelector(".to-block select.ap").value = toParts[2];

        document.getElementById('editTimeslotSubmit').dataset.slotId = slotId;

        // Clear previous errors
        editRow.querySelectorAll('.error-msg').forEach(el => el.innerText = '');
    });

    // Submit update
    document.getElementById('editTimeslotSubmit')?.addEventListener('click', function(e){
        e.preventDefault();

        const fromValid = validateBlock(editRow.querySelector(".from-block"), "From");
        const toValid   = validateBlock(editRow.querySelector(".to-block"), "To");
        if(!fromValid || !toValid) return;

        const slotId = this.dataset.slotId;
        const urlParams = new URLSearchParams(window.location.search);
        const countryId = urlParams.get('country_id');
        const date = urlParams.get('date');

        if(!countryId){
            toastr.error("{{ __('admin_messages.please_select_a_country') }}");
            return;
        }
        if(!date){
            toastr.error("{{ __('admin_messages.please_select_a_date') }}");
            return;
        }

        const fromHour = editRow.querySelector(".from-block select.hh").value;
        const fromMinute = editRow.querySelector(".from-block select.mm").value;
        const fromAP = editRow.querySelector(".from-block select.ap").value;

        const toHour = editRow.querySelector(".to-block select.hh").value;
        const toMinute = editRow.querySelector(".to-block select.mm").value;
        const toAP = editRow.querySelector(".to-block select.ap").value;

        const from = `${fromHour}:${fromMinute} ${fromAP}`;
        const to   = `${toHour}:${toMinute} ${toAP}`;

        // Convert to minutes for comparison
        function timeTo24Hour(hh, mm, ap){
            let hour = parseInt(hh);
            const minute = parseInt(mm);
            if(ap === 'PM' && hour !== 12) hour += 12;
            if(ap === 'AM' && hour === 12) hour = 0;
            return hour*60 + minute;
        }

        const fromTotal = timeTo24Hour(fromHour, fromMinute, fromAP);
        const toTotal = timeTo24Hour(toHour, toMinute, toAP);

        if(toTotal <= fromTotal){
           toastr.error("{{ __('admin_messages.to_time_should_be_greater_than_from_time') }}");
            return;
        }

        fetch(`/admin/updateTimeslot/${slotId}`, {
            method: 'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({ country_id: countryId, date, from, to })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success'){
                toastr.success(res.message);
                bootstrap.Modal.getInstance(editModalEl).hide();
                setTimeout(() => {
                            location.reload();
                        }, 2000);
            } else {
                toastr.error(res.message);
            }
        })
        .catch(err => {
            console.error(err);
            toastr.error('Failed to create timeslot');
        });
    });

});
</script>


<!-- accept request -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.addEventListener('click', function(e){
        const btn = e.target.closest('.approveLiveRequest');
        if(!btn) return;

        e.preventDefault();

        const id = btn.getAttribute('data-id');

        fetch("{{ route('admin.approveLiveRequest') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ request_id: id })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success'){
                toastr.success(res.message);
                setTimeout(() => {
                    location.reload();
                }, 2000); 
            } else {
                toastr.error(res.message || 'Failed to approve request');
            }
        })
        .catch(err => {
            console.error(err);
            toastr.error('Something went wrong');
        });
    });

});
</script>

<!-- reject request -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    let rejectId = null;
    const modalEl = document.getElementById('sentModal2');
    const reasonInput = document.getElementById('rejectReason');

    // When reject modal opens
    modalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        rejectId = button.getAttribute('data-id');

        // Reset textarea & errors
        reasonInput.value = '';
        removeError();
    });

    // Remove error while typing
    reasonInput.addEventListener('input', function () {
        removeError();
    });

    function showError(message){
        removeError();
        const error = document.createElement('small');
        error.classList.add('error-msg');
        error.style.color = 'red';
        error.innerText = message;
        reasonInput.parentNode.appendChild(error);
    }

    function removeError(){
        const error = reasonInput.parentNode.querySelector('.error-msg');
        if(error) error.remove();
    }

    // Submit reject
    document.querySelector('#sentModal2 .customBtn').addEventListener('click', function (e) {
        e.preventDefault();

        const reason = reasonInput.value.trim();

        if(!reason){
            showError("{{ __('admin_messages.please_enter_reject_reason') }}");
            return;
        }

        fetch("{{ route('admin.rejectLiveRequest') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                request_id: rejectId,
                reject_reason: reason
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success'){
                toastr.success(res.message);

                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                toastr.error(res.message || 'Failed to reject request');
            }
        })
        .catch(err => {
            console.error(err);
            toastr.error('Something went wrong');
        });
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('sentModal3');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
});
</script>
















<!-- <script>
function addRow() {
    const container = document.getElementById('timeContainer');

    const row = document.createElement('div');
    row.className = 'time-row';

    row.innerHTML = `
    <div class="time-block">
      <label>From</label>
      <select><option>HH</option></select>
      <select><option>MM</option></select>
      <select><option>AM</option><option>PM</option></select>
    </div>

    <div class="time-block">
      <label>To</label>
      <select><option>HH</option></select>
      <select><option>MM</option></select>
      <select><option>AM</option><option>PM</option></select>
    </div>

    <span class="remove-btn" onclick="removeRow(this)">✖</span>
  `;

    container.appendChild(row);
}

function removeRow(el) {
    el.parentElement.remove();
}
</script> -->
<script>
// document.addEventListener("DOMContentLoaded", function() {
//     const url = new URL(window.location);
//     const urlParams = url.searchParams;
 
//     let reloadNeeded = false;
 
//     if (!urlParams.has('country_id')) {
//         urlParams.set('country_id', 1);
//         reloadNeeded = true;
//     }
 
//     if (!urlParams.has('date')) {
//         const today = new Date().toISOString().split('T')[0];
//         urlParams.set('date', today);
//         reloadNeeded = true;
//     }
 
//     if (reloadNeeded) {
//         window.location.replace(url.toString());
//         return;
//     }
 
//     const selectedDate = urlParams.get('date');
//     const calendarEl = document.getElementById("calendar");
 
//     const calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: "dayGridMonth",
//         selectable: true,
//         height: "auto",
//         initialDate: selectedDate,
 
//         headerToolbar: {
//             left: 'prev',
//             center: 'title',
//             right: 'next'
//         },
 
//         showNonCurrentDates: false,
//         fixedWeekCount: false,  
 
//         dateClick: function(info) {
//             reloadWithDate(info.dateStr);
//         }
//     });
 
//     calendar.render();
//     calendar.select(selectedDate);
//     showSelectedDate(selectedDate);
// });
 
// function showSelectedDate(dateStr) {
//     const date = new Date(dateStr);
//     const options = { day: 'numeric', month: 'long', year: 'numeric' };
 
//     document.getElementById("selectedDateText").innerText =
//         `Today, ${date.toLocaleDateString('en-GB', options)}`;
 
//     document.getElementById("timeslotSection").style.display = "block";
// }
 
// function reloadWithDate(dateStr) {
//     const url = new URL(window.location);
//     url.searchParams.set('date', dateStr);
 
//     if (!url.searchParams.has('country_id')) {
//         url.searchParams.set('country_id', 1);
//     }
 
//     window.location.href = url.toString();
// }

document.addEventListener("DOMContentLoaded", function() {
    const locale = "{{ app()->getLocale() }}";

    const url = new URL(window.location);
    const urlParams = url.searchParams;

    let reloadNeeded = false;

    if (!urlParams.has('country_id')) {
        urlParams.set('country_id', 1);
        reloadNeeded = true;
    }

    if (!urlParams.has('date')) {
        const today = new Date().toISOString().split('T')[0];
        urlParams.set('date', today);
        reloadNeeded = true;
    }

    if (reloadNeeded) {
        window.location.replace(url.toString());
        return;
    }

    const selectedDate = urlParams.get('date');
    const calendarEl = document.getElementById("calendar");

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        selectable: true,
        height: "auto",
        initialDate: selectedDate,

        // ✅ IMPORTANT: locale switch
        locale: locale,

        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },

        showNonCurrentDates: false,
        fixedWeekCount: false,

        dateClick: function(info) {
            reloadWithDate(info.dateStr);
        }
    });

    calendar.render();
    calendar.select(selectedDate);
    showSelectedDate(selectedDate, locale);
});

function showSelectedDate(dateStr, locale) {
    const date = new Date(dateStr);
    const options = { day: 'numeric', month: 'long', year: 'numeric' };

    const formattedDate = date.toLocaleDateString(locale === 'ar' ? 'ar-EG' : 'en-GB', options);

    document.getElementById("selectedDateText").innerText =
        locale === 'ar'
            ? `اليوم، ${formattedDate}`
            : `Today, ${formattedDate}`;

    document.getElementById("timeslotSection").style.display = "block";
}

function reloadWithDate(dateStr) {
    const url = new URL(window.location);
    url.searchParams.set('date', dateStr);

    if (!url.searchParams.has('country_id')) {
        url.searchParams.set('country_id', 1);
    }

    window.location.href = url.toString();
}
</script>
 

@endsection
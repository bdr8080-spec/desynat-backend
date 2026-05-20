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
            <h2 class="h2">{{ __('admin_messages.ticket_management') }} </h2>
        </div>


    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="false">
                    {{ __('admin_messages.new') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    {{ __('admin_messages.ongoing') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    {{ __('admin_messages.past') }}
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <form method="GET" action="{{ route('admin.ticketManagement') }}" id="filterForm">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date" class="form-label">{{ __('admin_messages.from') }}:</label>
                                <input type="date" id="from_date" name="from_date" class="form-control"
                                    value="{{ request()->from_date }}"
                                    onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date" class="form-label">{{ __('admin_messages.to') }}:</label>
                                <input type="date" id="to_date" name="to_date" class="form-control"
                                    value="{{ request()->to_date }}"
                                    onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.ticket_type') }}</label>

                                <select name="ticket_type_filter" id="ticket_type_filter" onchange="document.getElementById('filterForm').submit();" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_ticket_type') }}</option>
                                    @foreach($ticketTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('ticket_type_filter') == $type->id ? 'selected' : '' }}
                                            @if(app()->getLocale() == 'en')>
                                            {{ $type->name }}
                                            @else
                                            {{ $type->name_arabic }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.submitted_by') }}</label>

                                <select name="sender_type_filter" onchange="document.getElementById('filterForm').submit();" id="sender_type_filter" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_submitted_by') }}</option>

                                    <option value="1" {{ request('sender_type_filter') == 1 ? 'selected' : '' }}>{{ __('admin_messages.user') }}</option>
                                    <option value="2" {{ request('sender_type_filter') == 2 ? 'selected' : '' }}>{{ __('admin_messages.seller') }}</option>
                                    <option value="3" {{ request('sender_type_filter') == 3 ? 'selected' : '' }}>{{ __('admin_messages.affiliate_user') }}</option>
                                    <option value="4" {{ request('sender_type_filter') == 4 ? 'selected' : '' }}>{{ __('admin_messages.delivery_boy') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-12">
                            <div class="">
                                <a href="{{route('admin.ticketManagement')}}" class="btn btn-dark customBtn w-100 mt-2">
                                    <span>{{ __('admin_messages.reset') }}</span></a>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-12">
                        @if(in_array(26, $permissions) || $admin->type == 1)
                        <div >
                            <a href="{{ route('admin.export_new_tickets_data', request()->all()) }}" class="btn btn-dark customBtn w-100 mt-2" >
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        @endif
                    </div>
                    </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.ticket_id') }} </th>
                                <th scope="col"> {{ __('admin_messages.submitted_by') }}</th>
                                <th scope="col">{{ __('admin_messages.raise_date_and_time') }}</th>
                                <th scope="col"> {{ __('admin_messages.user_name') }}</th>
                                <th scope="col">{{ __('admin_messages.view_details_&_attachment') }}</th>
                                <th scope="col">{{ __('admin_messages.type') }}</th>
                                @if(in_array(26, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.update_status') }}</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($newTickets['data'] ?? [] as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>#{{ $ticket->ticket_id }}</td>
                                    <td>
                                        @if($ticket->sender_type == 1) {{ __('admin_messages.user') }}
                                        @elseif($ticket->sender_type == 2) {{ __('admin_messages.seller') }}
                                        @elseif($ticket->sender_type == 3) {{ __('admin_messages.affiliate_user') }}
                                        @else {{ __('admin_messages.delivery_boy') }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y | h:i A') }}</td>

                                    @php
                                        $name = $ticket->sender_details->full_name
                                            ?? (!empty($ticket->sender_details->first_name) || !empty($ticket->sender_details->last_name)
                                                ? trim(($ticket->sender_details->first_name ?? '') . ' ' . ($ticket->sender_details->last_name ?? ''))
                                                : null)
                                            ?? $ticket->sender_details->full_name_english
                                            ?? '-';
                                    @endphp

                                    <td>{{ $name }}</td>
                                    <td>
                                        <a class="table-button viewTicketBtn"
                                        href="javascript:void(0)"
                                        data-title="{{ $ticket->title }}"
                                        data-description="{{ $ticket->description }}"
                                        data-file="{{ $ticket->file }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>

                                    <td>
                                        @if(app()->getLocale() == 'en')
                                        {{ $ticket->ticket_type_details->name ?? __('admin_messages.na') }}
                                        @else
                                        {{ $ticket->ticket_type_details->name_arabic ?? __('admin_messages.na') }}
                                        @endif
                                    </td>
                                    @if(in_array(26, $permissions) || $admin->type == 1)
                                    <td>
                                        <select class="form-select  statusChange"
                                                data-id="{{ $ticket->id }}">
                                            <option value="0" {{ $ticket->status == 0 ? 'selected' : '' }}>{{ __('admin_messages.pending') }}</option>
                                            <option value="1" {{ $ticket->status == 1 ? 'selected' : '' }}>{{ __('admin_messages.resolved') }}</option>
                                        </select>
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
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <form method="GET" action="{{ route('admin.ticketManagement') }}" id="filterForm1">
                    <div class="row">
                    <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date1" class="form-label">{{ __('admin_messages.from') }}:</label>
                                <input type="date" id="from_date1" name="from_date1" class="form-control"
                                    value="{{ request()->from_date1 }}"
                                    onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date1" class="form-label">{{ __('admin_messages.to') }}:</label>
                                <input type="date" id="to_date1" name="to_date1" class="form-control"
                                    value="{{ request()->to_date1 }}"
                                    onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.ticket_type') }}</label>

                                <select name="ticket_type_filter1" id="ticket_type_filter1" onchange="document.getElementById('filterForm1').submit();" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_ticket_type') }}</option>
                                    @foreach($ticketTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('ticket_type_filter1') == $type->id ? 'selected' : '' }}>
                                            @if(app()->getLocale() == 'en')>
                                            {{ $type->name }}
                                            @else
                                            {{ $type->name_arabic }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.submitted_by') }}</label>

                                <select name="sender_type_filter1" onchange="document.getElementById('filterForm1').submit();" id="sender_type_filter1" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_submitted_by') }}</option>

                                    <option value="1" {{ request('sender_type_filter1') == 1 ? 'selected' : '' }}>{{ __('admin_messages.user') }}</option>
                                    <option value="2" {{ request('sender_type_filter1') == 2 ? 'selected' : '' }}>{{ __('admin_messages.seller') }}</option>
                                    <option value="3" {{ request('sender_type_filter1') == 3 ? 'selected' : '' }}>{{ __('admin_messages.affiliate_user') }}</option>
                                    <option value="4" {{ request('sender_type_filter1') == 4 ? 'selected' : '' }}>{{ __('admin_messages.delivery_boy') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-12">
                            <div>
                                <a href="{{route('admin.ticketManagement')}}" class="btn btn-dark customBtn w-100 mt-2">
                                    <span>{{ __('admin_messages.reset') }}</span></a>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-12">
                        @if(in_array(26, $permissions) || $admin->type == 1)
                        <div>
                            <a href="{{ route('admin.export_ongoing_tickets_data', request()->all()) }}" class="btn btn-dark customBtn w-100 mt-2">
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        @endif
                    </div>
                    </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.ticket_id') }} </th>
                                <th scope="col"> {{ __('admin_messages.submitted_by') }}</th>
                                <th scope="col">{{ __('admin_messages.raise_date_and_time') }}</th>
                                <th scope="col"> {{ __('admin_messages.user_name') }}</th>
                                <th scope="col">{{ __('admin_messages.view_details_&_attachment') }}</th>
                                <th scope="col">{{ __('admin_messages.type') }}</th>
                                @if(in_array(26, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.update_status') }}</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ongoingTickets['data'] ?? [] as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>#{{ $ticket->ticket_id }}</td>
                                    <td>
                                         @if($ticket->sender_type == 1) {{ __('admin_messages.user') }}
                                        @elseif($ticket->sender_type == 2) {{ __('admin_messages.seller') }}
                                        @elseif($ticket->sender_type == 3) {{ __('admin_messages.affiliate_user') }}
                                        @else {{ __('admin_messages.delivery_boy') }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y | h:i A') }}</td>

                                    @php
                                        $name = $ticket->sender_details->full_name
                                            ?? (!empty($ticket->sender_details->first_name) || !empty($ticket->sender_details->last_name)
                                                ? trim(($ticket->sender_details->first_name ?? '') . ' ' . ($ticket->sender_details->last_name ?? ''))
                                                : null)
                                            ?? $ticket->sender_details->full_name_english
                                            ?? '-';
                                    @endphp

                                    <td>{{ $name }}</td>
                                    <td>
                                        <a class="table-button viewTicketBtn"
                                        href="javascript:void(0)"
                                        data-title="{{ $ticket->title }}"
                                        data-description="{{ $ticket->description }}"
                                        data-file="{{ $ticket->file }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>

                                    <td>
                                        @if(app()->getLocale() == 'en')
                                        {{ $ticket->ticket_type_details->name ?? __('admin_messages.na') }}
                                        @else
                                        {{ $ticket->ticket_type_details->name_arabic ?? __('admin_messages.na') }}
                                        @endif
                                    </td>
                                    @if(in_array(26, $permissions) || $admin->type == 1)
                                    <td>
                                        <select class="form-select  statusChange"
                                                data-id="{{ $ticket->id }}">
                                            <option value="0" {{ $ticket->status == 0 ? 'selected' : '' }}>{{ __('admin_messages.pending') }}</option>
                                            <option value="1" {{ $ticket->status == 1 ? 'selected' : '' }}>{{ __('admin_messages.resolved') }}</option>
                                        </select>
                                    </td>
                                    @endif
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
                <form method="GET" action="{{ route('admin.ticketManagement') }}" id="filterForm2">
                    <div class="row">
                    <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date2" class="form-label">{{ __('admin_messages.from') }}:</label>
                                <input type="date" id="from_date2" name="from_date2" class="form-control"
                                    value="{{ request()->from_date2 }}"
                                    onchange="updateToDate2(); document.getElementById('filterForm2').submit();" />
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date2" class="form-label">{{ __('admin_messages.to') }}:</label>
                                <input type="date" id="to_date2" name="to_date2" class="form-control"
                                    value="{{ request()->to_date2 }}"
                                    onchange="updateToDate2(); document.getElementById('filterForm2').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.ticket_type') }}</label>

                                <select name="ticket_type_filter2" id="ticket_type_filter2" onchange="document.getElementById('filterForm2').submit();" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_ticket_type') }}</option>
                                    @foreach($ticketTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('ticket_type_filter2') == $type->id ? 'selected' : '' }}>
                                            @if(app()->getLocale() == 'en')>
                                            {{ $type->name }}
                                            @else
                                            {{ $type->name_arabic }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">{{ __('admin_messages.submitted_by') }}</label>

                                <select name="sender_type_filter2" onchange="document.getElementById('filterForm2').submit();" id="sender_type_filter2" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_submitted_by') }}</option>

                                    <option value="1" {{ request('sender_type_filter2') == 1 ? 'selected' : '' }}>{{ __('admin_messages.user') }}</option>
                                    <option value="2" {{ request('sender_type_filter2') == 2 ? 'selected' : '' }}>{{ __('admin_messages.seller') }}</option>
                                    <option value="3" {{ request('sender_type_filter2') == 3 ? 'selected' : '' }}>{{ __('admin_messages.affiliate_user') }}</option>
                                    <option value="4" {{ request('sender_type_filter2') == 4 ? 'selected' : '' }}>{{ __('admin_messages.delivery_boy') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-12">
                            <div class="">
                                <a href="{{route('admin.ticketManagement')}}" class="btn btn-dark customBtn w-100 mt-2">
                                    <span>{{ __('admin_messages.reset') }}</span></a>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-12">
                        @if(in_array(26, $permissions) || $admin->type == 1)
                        <div class="">
                            <a href="{{ route('admin.export_past_tickets_data', request()->all()) }}" class="btn btn-dark customBtn w-100 mt-2" >
                                <span>{{ __('admin_messages.export') }}</span></a>
                        </div>
                        @endif
                    </div>
                    </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="myTable2" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.ticket_id') }} </th>
                                <th scope="col"> {{ __('admin_messages.submitted_by') }}</th>
                                <th scope="col">{{ __('admin_messages.raise_date_and_time') }}</th>
                                <th scope="col"> {{ __('admin_messages.user_name') }}</th>
                                <th scope="col">{{ __('admin_messages.view_details_&_attachment') }}</th>
                                <th scope="col">{{ __('admin_messages.type') }}</th>
                                @if(in_array(26, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.update_status') }}</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resolvedTickets['data'] ?? [] as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>#{{ $ticket->ticket_id }}</td>
                                    <td>
                                         @if($ticket->sender_type == 1) {{ __('admin_messages.user') }}
                                        @elseif($ticket->sender_type == 2) {{ __('admin_messages.seller') }}
                                        @elseif($ticket->sender_type == 3) {{ __('admin_messages.affiliate_user') }}
                                        @else {{ __('admin_messages.delivery_boy') }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y | h:i A') }}</td>

                                    @php
                                        $name = $ticket->sender_details->full_name
                                            ?? (!empty($ticket->sender_details->first_name) || !empty($ticket->sender_details->last_name)
                                                ? trim(($ticket->sender_details->first_name ?? '') . ' ' . ($ticket->sender_details->last_name ?? ''))
                                                : null)
                                            ?? $ticket->sender_details->full_name_english
                                            ?? '-';
                                    @endphp

                                    <td>{{ $name }}</td>
                                    <td>
                                        <a class="table-button viewTicketBtn"
                                        href="javascript:void(0)"
                                        data-title="{{ $ticket->title }}"
                                        data-description="{{ $ticket->description }}"
                                        data-file="{{ $ticket->file }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>

                                    <td>
                                        @if(app()->getLocale() == 'en')
                                        {{ $ticket->ticket_type_details->name ?? __('admin_messages.na') }}
                                        @else
                                        {{ $ticket->ticket_type_details->name_arabic ?? __('admin_messages.na') }}
                                        @endif
                                    </td>
                                    @if(in_array(26, $permissions) || $admin->type == 1)
                                    <td>
                                        <select class="form-select  statusChange"
                                                data-id="{{ $ticket->id }}">
                                            <option value="0" {{ $ticket->status == 0 ? 'selected' : '' }}>{{ __('admin_messages.pending') }}</option>
                                            <option value="1" {{ $ticket->status == 1 ? 'selected' : '' }}>{{ __('admin_messages.resolved') }}</option>
                                        </select>
                                    </td>
                                    @endif
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

<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <!-- Title -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-group">{{ __('admin_messages.title') }}</label>
                                <input type="text" id="modal_title" class="form-control" readonly />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('admin_messages.description') }}</label>
                                <textarea id="modal_description" class="form-control" rows="3" readonly></textarea>
                            </div>
                        </div>

                        <!-- Image preview (if file exists) -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <img id="modal_image" 
                                     style="max-width:30%; display:none; border-radius:8px;" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('click', function(e){
        const viewBtn = e.target.closest('.viewTicketBtn');
        if(!viewBtn) return;

        const title = viewBtn.dataset.title || '';
        const description = viewBtn.dataset.description || '';
        const file = viewBtn.dataset.file || '';

        const modal = document.getElementById('sentModal1');

        const titleInput = modal.querySelector('#modal_title');
        const descTextarea = modal.querySelector('#modal_description');
        const imgPreview = modal.querySelector('#modal_image');

        titleInput.value = title;
        descTextarea.value = description;

        if(file && file.trim() !== ''){
            imgPreview.src = file;
            imgPreview.style.display = 'block';
        } else {
            imgPreview.src = '';
            imgPreview.style.display = 'none';
        }

        // Show the modal
        new bootstrap.Modal(modal).show();
    });

});
</script>

<!-- update status -->
 <script>
$(document).ready(function() {

    $(document).on('change', '.statusChange', function() {
        var ticketId = $(this).data('id');
        var status = $(this).val(); // 0 = Pending, 1 = Resolved
        var selectEl = $(this);

        $.ajax({
            url: "{{ route('admin.update_ticket_status') }}",
            type: "POST",
            data: {
                ticket_id: ticketId,
                status: status,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    // Keep selected value
                    selectEl.val(status);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(res.message || 'Failed to update status');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Server error occurred');
                console.error(error);
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





@endsection
@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Tickets Management </h2>
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="#" role="button">
                    <span>Export</span>
                </a>
            </div>
        </div>


    </div>
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
                    Ongoing
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Past
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <form method="GET" action="{{ route('admin.ticketManagement') }}" id="filterForm">
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date" class="form-label">From:</label>
                                <input type="date" id="from_date" name="from_date" class="form-control"
                                    value="{{ request()->from_date }}"
                                    onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date" class="form-label">To:</label>
                                <input type="date" id="to_date" name="to_date" class="form-control"
                                    value="{{ request()->to_date }}"
                                    onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">Ticket type</label>

                                <select name="ticket_type_filter" id="ticket_type_filter" onchange="document.getElementById('filterForm').submit();" class="form-select form-select-lg">
                                    <option value="">Select Ticket Type</option>
                                    @foreach($ticketTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('ticket_type_filter') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">Submitted by</label>

                                <select name="sender_type_filter" onchange="document.getElementById('filterForm').submit();" id="sender_type_filter" class="form-select form-select-lg">
                                    <option value="">Select Submitted Type</option>

                                    <option value="1" {{ request('sender_type_filter') == 1 ? 'selected' : '' }}>User</option>
                                    <option value="2" {{ request('sender_type_filter') == 2 ? 'selected' : '' }}>Seller</option>
                                    <option value="3" {{ request('sender_type_filter') == 3 ? 'selected' : '' }}>Affiliate User</option>
                                    <option value="4" {{ request('sender_type_filter') == 4 ? 'selected' : '' }}>Delivery Boy</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="d-dlex justify-content-end mt-5">
                                <a href="{{route('admin.ticketManagement')}}" class="btn btn-dark customBtn w-50 mt-2">
                                    <span>Reset</span></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Ticket Id </th>
                                <th scope="col"> Submitted by</th>
                                <th scope="col">Raised Date & Time</th>
                                <th scope="col"> User name</th>
                                <th scope="col">View Details & Attachment</th>
                                <th scope="col">Type</th>
                                <th scope="col">Update Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($newTickets['data'] ?? [] as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>#{{ $ticket->ticket_id }}</td>
                                    <td>
                                        @if($ticket->sender_type == 1) User
                                        @elseif($ticket->sender_type == 2) Seller
                                        @elseif($ticket->sender_type == 3) Affiliate User
                                        @else Delivery Boy
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

                                    <td>{{ $ticket->ticket_type_details->name ?? '-' }}</td>

                                    <td>
                                        <select class="form-select form-select-lg statusChange"
                                                data-id="{{ $ticket->id }}">
                                            <option value="0" {{ $ticket->status == 0 ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ $ticket->status == 1 ? 'selected' : '' }}>Resolved</option>
                                        </select>
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
                <form method="GET" action="{{ route('admin.ticketManagement') }}" id="filterForm1">
                    <div class="row">
                    <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date1" class="form-label">From:</label>
                                <input type="date" id="from_date1" name="from_date1" class="form-control"
                                    value="{{ request()->from_date1 }}"
                                    onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date1" class="form-label">To:</label>
                                <input type="date" id="to_date1" name="to_date1" class="form-control"
                                    value="{{ request()->to_date1 }}"
                                    onchange="updateToDate1(); document.getElementById('filterForm1').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">Ticket type</label>

                                <select name="ticket_type_filter1" id="ticket_type_filter1" onchange="document.getElementById('filterForm1').submit();" class="form-select form-select-lg">
                                    <option value="">Select Ticket Type</option>
                                    @foreach($ticketTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('ticket_type_filter1') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">Submitted by</label>

                                <select name="sender_type_filter1" onchange="document.getElementById('filterForm1').submit();" id="sender_type_filter1" class="form-select form-select-lg">
                                    <option value="">Select Submitted Type</option>

                                    <option value="1" {{ request('sender_type_filter1') == 1 ? 'selected' : '' }}>User</option>
                                    <option value="2" {{ request('sender_type_filter1') == 2 ? 'selected' : '' }}>Seller</option>
                                    <option value="3" {{ request('sender_type_filter1') == 3 ? 'selected' : '' }}>Affiliate User</option>
                                    <option value="4" {{ request('sender_type_filter1') == 4 ? 'selected' : '' }}>Delivery Boy</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="d-dlex justify-content-end mt-5">
                                <a href="{{route('admin.ticketManagement')}}" class="btn btn-dark customBtn w-50 mt-2">
                                    <span>Reset</span></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Ticket Id </th>
                                <th scope="col"> Submitted by</th>
                                <th scope="col">Raised Date & Time</th>
                                <th scope="col"> User name</th>
                                <th scope="col">View Details & Attachment</th>
                                <th scope="col">Type</th>
                                <th scope="col">Update Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ongoingTickets['data'] ?? [] as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>#{{ $ticket->ticket_id }}</td>
                                    <td>
                                        @if($ticket->sender_type == 1) User
                                        @elseif($ticket->sender_type == 2) Seller
                                        @elseif($ticket->sender_type == 3) Affiliate User
                                        @else Delivery Boy
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

                                    <td>{{ $ticket->ticket_type_details->name ?? '-' }}</td>

                                    <td>
                                        <select class="form-select form-select-lg statusChange"
                                                data-id="{{ $ticket->id }}">
                                            <option value="0" {{ $ticket->status == 0 ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ $ticket->status == 1 ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                    </td>
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
                    <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from_date2" class="form-label">From:</label>
                                <input type="date" id="from_date2" name="from_date2" class="form-control"
                                    value="{{ request()->from_date2 }}"
                                    onchange="updateToDate2(); document.getElementById('filterForm2').submit();" />
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to_date2" class="form-label">To:</label>
                                <input type="date" id="to_date2" name="to_date2" class="form-control"
                                    value="{{ request()->to_date2 }}"
                                    onchange="updateToDate2(); document.getElementById('filterForm2').submit();" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">Ticket type</label>

                                <select name="ticket_type_filter2" id="ticket_type_filter2" onchange="document.getElementById('filterForm2').submit();" class="form-select form-select-lg">
                                    <option value="">Select Ticket Type</option>
                                    @foreach($ticketTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('ticket_type_filter2') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">Submitted by</label>

                                <select name="sender_type_filter2" onchange="document.getElementById('filterForm2').submit();" id="sender_type_filter2" class="form-select form-select-lg">
                                    <option value="">Select Submitted Type</option>

                                    <option value="1" {{ request('sender_type_filter2') == 1 ? 'selected' : '' }}>User</option>
                                    <option value="2" {{ request('sender_type_filter2') == 2 ? 'selected' : '' }}>Seller</option>
                                    <option value="3" {{ request('sender_type_filter2') == 3 ? 'selected' : '' }}>Affiliate User</option>
                                    <option value="4" {{ request('sender_type_filter2') == 4 ? 'selected' : '' }}>Delivery Boy</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="d-dlex justify-content-end mt-5">
                                <a href="{{route('admin.ticketManagement')}}" class="btn btn-dark customBtn w-50 mt-2">
                                    <span>Reset</span></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="myTable2" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Ticket Id </th>
                                <th scope="col"> Submitted by</th>
                                <th scope="col">Raised Date & Time</th>
                                <th scope="col"> User name</th>
                                <th scope="col">View Details & Attachment</th>
                                <th scope="col">Type</th>
                                <th scope="col">Update Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resolvedTickets['data'] ?? [] as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>#{{ $ticket->ticket_id }}</td>
                                    <td>
                                        @if($ticket->sender_type == 1) User
                                        @elseif($ticket->sender_type == 2) Seller
                                        @elseif($ticket->sender_type == 3) Affiliate User
                                        @else Delivery Boy
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

                                    <td>{{ $ticket->ticket_type_details->name ?? '-' }}</td>

                                    <td>
                                        <select class="form-select form-select-lg statusChange"
                                                data-id="{{ $ticket->id }}">
                                            <option value="0" {{ $ticket->status == 0 ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ $ticket->status == 1 ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                    </td>
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
                                <label class="form-group">Title</label>
                                <input type="text" id="modal_title" class="form-control" readonly />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
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
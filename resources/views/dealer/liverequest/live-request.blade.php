@include('dealer.layout.header')


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">{{ __('seller_messages.Live_Coverage_Requests') }}</div>
        <a href="{{ route('seller.liveRequests') }}" class="btn btn-success exportbtn"> {{ __('seller_messages.Reset') }}</a>
        <a href="{{ route('seller.export_live_request_data', request()->all()) }}"" class="btn btn-success exportbtn"> {{ __('seller_messages.Export') }}</a>

    </div>
    <div class="datatable-wapper mt-4">
        <div class="table-header">
            <div class="search-field">
                <div class="from-group position-relative">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                    <input type="search"
                        class="dt-input tableSearch form-control  tableSearch"
                        id="customTableSearch" data-table="table1" placeholder=" {{ __('seller_messages.search') }}" aria-controls="table1">
                </div>
            </div>

          
            <form method="GET" action="{{ route('seller.liveRequests') }}" id="liveRequestFilterForm">
                <div class="search-filter d-flex flex-wrap align-items-center gap-3">

                    <div class="from-group d-flex gap-2 flex-wrap align-items-center">
                        <div class="datefilter">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="from" id="fromDate"
                                    value="{{ request('from') }}" onchange="updateToDate();">
                            </div>
                            <p class="text-danger" id="error-start_date"></p>
                        </div>
                        <div class="datefilter">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="to" id="toDate"
                                    value="{{ request('to') }}" onchange="updateToDate();">
                                </div>
                            <p class="text-danger" id="error-end_date"></p>
                        </div>
                    </div>

                    <div class="from-group">
                        <select name="filter" id="filterStatus" class="form-select form-control width-50" 
                            onchange="document.getElementById('liveRequestFilterForm').submit();">
                            <option value="">{{ __('seller_messages.Filter_By_Status') }}</option>
                            <option value="1" {{ request('filter') == '1' ? 'selected' : '' }}>  {{ __('seller_messages.Pending') }}</option>
                            <option value="2" {{ request('filter') == '2' ? 'selected' : '' }}>  {{ __('seller_messages.Completed') }}</option>
                            <option value="3" {{ request('filter') == '3' ? 'selected' : '' }}>  {{ __('seller_messages.Cancelled') }}</option>
                            <option value="4" {{ request('filter') == '4' ? 'selected' : '' }}> {{ __('seller_messages.Rejected') }}</option>
                        </select>
                    </div>

                </div>
            </form>
        </div>

        <div class="choose-date">
            <div class="date-card">
                <!-- <div class="date-header" data-bs-toggle="modal" data-bs-target="#sendlives"> -->
                    <div class="date-header">
                    <span>{{ __('seller_messages.Select_Date') }}</span>
                    <h3 id="selectedDate"></h3>
                </div>
                <div class="month-row date-form-pnl">
                    <!-- <button id="prevMonth">‹</button> -->
                    <select id="monthSelect" class="form-select form-control"></select>
                    <select id="yearSelect" class="form-select form-control"></select>
                    <!-- <button id="nextMonth">›</button> -->
                </div>
                <div class="days-row" id="daysContainer"></div>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered datatable tablesearch" id="table1">
                <thead>
                    <tr>
                       <th>{{ __('seller_messages.S_No') }}</th>
                        <th>{{ __('seller_messages.Request_ID') }}</th>
                        <th>{{ __('seller_messages.Requested_On') }}</th>
                        <th>{{ __('seller_messages.Live_Request') }}</th>
                        <th>{{ __('seller_messages.Status') }}</th>
                        <th>{{ __('seller_messages.Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $req)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>#{{ $req['order_id'] }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($req['created_at'])
                                ->setTimezone(config('app.timezone'))
                                ->format('Y/m/d \a\t h:i A') }}
                        </td>
                        <td>{{ str_replace('-', '/', $req['timeslot_details']['date']) }} at {{ $req['timeslot_details']['from'] }}</td>
                        <td>
                            @php
                            $now = \Carbon\Carbon::now();

                            $timeslotDate = $req['timeslot_details']['date'] ?? null;
                            $timeslotTo = $req['timeslot_details']['to'] ?? null;

                            $timeslotDateTime = null;

                            if ($timeslotDate && $timeslotTo) {
                            // Combine date and time into a single Carbon object
                            $timeslotDateTime = \Carbon\Carbon::parse($timeslotDate . ' ' . $timeslotTo);
                            }
                            @endphp

                            @if($req['admin_verify'] == '0')
                            <span style="color: #f97316;"> {{ __('seller_messages.Pending') }}</span>
                            @elseif($req['admin_verify'] == '2')
                            <span style="color: #ef4444;"> {{ __('seller_messages.Rejected') }}</span>
                            @elseif($req['admin_verify'] == '3')
                            <span style="color: #ef4444;"> {{ __('seller_messages.Cancelled') }}</span>
                            @elseif($timeslotDateTime && $timeslotDateTime->lessThanOrEqualTo($now))
                            <span style="color: #22c55e;">  {{ __('seller_messages.complete') }}</span>
                            @else
                            <span style="color: #22c55e;">  {{ __('seller_messages.Confirmed') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($req['admin_verify'] == '2' || $req['admin_verify'] == '3')
                            <a href="javascript:void(0)" class="eyebtn view-reason-btn" data-bs-toggle="modal"
                                data-bs-target="#Addreason"
                                data-status="{{ $req['admin_verify'] == '2' ? 'Rejected' : 'Cancelled' }}"
                                data-date="{{ \Carbon\Carbon::parse($req['updated_at'])->format('d/m/Y') }}"
                                data-reason="{{ $req['admin_verify'] == '2' ? ($req['reject_reason'] ?? '-') : ($req['cancel_reason'] ?? '-') }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif
                            @if($req['admin_verify'] == '0')
                            <!-- <a href="javascript:void(0)" class="eyebtn deleteReq" data-id="{{ $req['id'] }}">
                                    <i class="bi bi-trash3"></i>
                                </a> -->
                            <a href="javascript:void(0)" class="eyebtn open-cancel-modal" data-id="{{ $req['id'] }}"
                                data-bs-toggle="modal" data-bs-target="#reasonDialog">
                                <i class="bi bi-trash3"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</section>



<!-- Send New live request -->
<div class="modal fade" id="sendlives" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h3>{{ __('seller_messages.Send_New_Live_Request') }} </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="from-group py-3">
                    <label>   {{ __('seller_messages.Total_Coverages') }} - <span id="totalSlots">0</span></label>
                    <!-- <input type="date" class="form-control" id="live_requestDate"> -->
                     <div class="form-control" id="modalSelectedDate" readonly></div>
                    <input type="hidden" id="live_requestDate">
                </div>
                <div class="from-group mb-4">
                    <label for="time">{{ __('seller_messages.Select_Time') }}</label>
                    <div class="time-slot mt-2">
                        <!-- <button class="btn btn-time-outline">10:00 AM To 11:30 AM</button>
                        <button class="btn btn-time-outline">10:00 AM To 11:30 AM</button> -->
                    </div>
                    <small id="slotError" class="text-danger"></small>
                    <input type="hidden" id="selectedTimeslotId">
                </div>

                <div class="py-3">
                    <button type="submit" class="btn add-fillbtn w-100"> {{ __('seller_messages.Send_Request') }} </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add Reason -->
<div class="modal fade" id="Addreason" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                  <h3>{{ __('seller_messages.Reason') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-red text-end mb-1" id="reason-status-date"></div>
                <div class="reason-lists py-3" style="border: 1px solid #ddd; border-radius: 10px; padding: 10px;">
                    <p id="reason-text"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Select Reason Dialog -->
<!-- <div class="modal fade" id="reasonDialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h3>Reason </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="reason-lists">
                    <div class="check_radio mb-2">
                        <label class="radio-group">
                            <input type="radio" value="reason" name="reason">
                            <span class="custom-radio"></span>
                            <span class="radio-label font-thin">Reason 1</span>
                        </label>
                    </div>
                    <div class="check_radio mb-2">
                        <label class="radio-group">
                            <input type="radio" value="reason" name="reason">
                            <span class="custom-radio"></span>
                            <span class="radio-label font-thin">Reason 1</span>
                        </label>
                    </div>
                    <div class="form-group mt-4">
                        <textarea class="form-control" rows="4" placeholder="Write Here" name="cancel_reason"></textarea>
                    </div>
                    <div class="py-3">
                        <button type="submit" class="btn add-fillbtn w-100">Submit</button>
                    </div>
                </div>    

            </div>
        </div>
    </div>
</div> -->
<div class="modal fade" id="reasonDialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h3>Cancel Reason </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="reason-lists">
                    <input type="hidden" id="requestId" value="">
                    <div class="form-group mt-4">
                        <textarea class="form-control" rows="4" placeholder="Write Here" name="cancel_reason"
                            id="cancel_reason"></textarea>
                        <small id="cancelReasonError" class="text-danger" style="display:none;"></small>
                    </div>
                    <div class="py-3">
                        <button type="button" class="btn add-fillbtn w-100" id="submitCancelReason">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Success Modal -->
    <div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="p-4 text-center">
                        <img alt="image" src="{{ asset('/dealer') }}/assets/img/success.svg">
                        <h5 class="mt-3">Request Sent Successfully!</h5>
                    </div>
                </div>

            </div>
        </div>
    </div>





@include('dealer.layout.custom_code');
@include('dealer.layout.footer');




<script>

const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

let m = new Date().getMonth(); // current month
let y = new Date().getFullYear(); // current year
let selectedSlotId = null; // selected timeslot id

/* ================= RENDER CALENDAR ================= */
function render() {

    $('#daysContainer').html('');
    $('#monthSelect').val(m);
    $('#yearSelect').val(y);

    const today = new Date();

    for (let d = 1; d <= new Date(y, m + 1, 0).getDate(); d++) {

        const dateObj = new Date(y, m, d);
        const day = dateObj.toLocaleDateString('en-US', { weekday: 'short' });

        const active =
            d === today.getDate() &&
            m === today.getMonth() &&
            y === today.getFullYear()
                ? 'active'
                : '';

        $('#daysContainer').append(`
            <div class="day ${active}">
                <span>${day}</span>
                <b>${d}</b>
            </div>
        `);

        // Set selected date text if it's today
        if (active) {
            let dayStr = String(d).padStart(2, '0');
            let monthStr = String(m + 1).padStart(2, '0');
            let formattedDate = `${y}-${monthStr}-${dayStr}`;

            $('#selectedDate').text(`${dayStr}, ${months[m]} ${y}`); // main page
            $('#live_requestDate').val(formattedDate); // hidden input
            $('#modalSelectedDate').text(formattedDate); // modal display
        }
    }

    // Disable submit button initially
    $('.add-fillbtn').prop('disabled', true);
}

/* ================= INIT MONTH & YEAR ================= */
months.forEach((month, index) => {
    $('#monthSelect').append(`<option value="${index}">${month}</option>`);
});

for (let i = y; i <= y + 14; i++) {
    $('#yearSelect').append(`<option value="${i}">${i}</option>`);
}

// Initial render
render();

/* ================= MONTH / YEAR CHANGE ================= */
$('#monthSelect, #yearSelect').change(function () {
    m = +$('#monthSelect').val();
    y = +$('#yearSelect').val();
    render();
});

/* ================= LOAD TIMESLOTS ================= */
function loadTimeslots(date) {

    if (!date) {
        $('.time-slot').html('<p class="text-danger">Please select date</p>');
        $('#totalSlots').text(0);
        $('.add-fillbtn').prop('disabled', true); // disable button
        return;
    }

    // $('.time-slot').html('<p>Loading...</p>');
    $('#totalSlots').text(0);
    $('#slotError').text('');
    selectedSlotId = null;
    $('#selectedTimeslotId').val('');
    $('.add-fillbtn').prop('disabled', true); // disable until a slot is selected

    fetch("{{ route('seller.getTimeslots') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({ date: date })
    })
    .then(response => {
        if (!response.ok) throw new Error("Network error");
        return response.json();
    })
    .then(data => {

        let html = '';

        if (data.data && data.data.length > 0) {

            $('#totalSlots').text(data.data.length);

            data.data.forEach(function (slot) {
                html += `
                    <button type="button"
                        class="btn btn-time-outline m-1 timeslot-btn"
                        data-id="${slot.id}">
                        ${slot.from} To ${slot.to}
                    </button>
                `;
            });

        } else {
            html = `<p class="text-danger">No Timeslot Available</p>`;
            $('#totalSlots').text(0);
        }

        $('.time-slot').html(html);

        // Disable submit if no slots
        if (!data.data || data.data.length === 0) {
            $('.add-fillbtn').prop('disabled', true);
        }

    })
    .catch(() => {
        $('.time-slot').html('<p class="text-danger">Something went wrong</p>');
        $('#totalSlots').text(0);
        $('.add-fillbtn').prop('disabled', true);
    });
}

/* ================= DATE CLICK FROM CALENDAR ================= */
$(document).on('click', '.day', function () {

    $('.day').removeClass('active');
    $(this).addClass('active');

    let day = $(this).find('b').text().padStart(2, '0');
    let monthNumber = String(m + 1).padStart(2, '0');
    let year = y;

    let formattedDate = `${year}-${monthNumber}-${day}`;

    $('#selectedDate').text(`${day}, ${months[m]} ${year}`); // main page
    $('#live_requestDate').val(formattedDate); // hidden input
    $('#modalSelectedDate').text(formattedDate); // modal display

    // Open modal programmatically
    var myModal = new bootstrap.Modal(document.getElementById('sendlives'));
    myModal.show();

    loadTimeslots(formattedDate);
});

/* ================= MODAL OPEN ================= */
$('#sendlives').on('shown.bs.modal', function () {
    loadTimeslots($('#live_requestDate').val());
});

/* ================= SELECT TIMESLOT ================= */
$(document).on('click', '.timeslot-btn', function () {

    $('.timeslot-btn').removeClass('active');
    $(this).addClass('active');

    selectedSlotId = $(this).data('id');
    $('#selectedTimeslotId').val(selectedSlotId);
    $('#slotError').text('');

    // Enable submit button
    $('.add-fillbtn').prop('disabled', false);
});

/* ================= SUBMIT LIVE REQUEST ================= */
$('.add-fillbtn').on('click', function (e) {

    e.preventDefault();

    let timeslotId = $('#selectedTimeslotId').val();

    if (!timeslotId) {
        $('#slotError').text('Please select a timeslot');
        return;
    }

    fetch("{{ route('seller.sendLiveRequest') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            timeslot_id: timeslotId,
            seller_id: {{ auth()->guard('seller')->id() }}
        })
    })
    .then(response => response.json())
    .then(data => {

        if (data.status === 'success') {

            $('#sendlives').modal('hide');

            // Show success modal
            $('#modalSuccess').modal('show');

            // Hide success modal after 3s and reload timeslots
            setTimeout(() => {
                $('#modalSuccess').modal('hide');
                location.reload(); // reloads the entire page
            }, 3000);

        } else {
            toastr.error(data.message);
        }

    })
    .catch(() => {
        toastr.error('Something went wrong');
    });

});

/* ================= SET INITIAL MODAL DATE ON PAGE LOAD ================= */
$(document).ready(function() {
    let today = new Date();
    let day = String(today.getDate()).padStart(2, '0');
    let month = String(today.getMonth() + 1).padStart(2, '0');
    let year = today.getFullYear();
    let formattedDate = `${year}-${month}-${day}`;

    $('#live_requestDate').val(formattedDate);
    $('#modalSelectedDate').text(formattedDate);
    $('.add-fillbtn').prop('disabled', true);
});
</script>

<!-- view details -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('Addreason');
    const statusDate = document.getElementById('reason-status-date');
    const reasonText = document.getElementById('reason-text');

    modal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const status = button.getAttribute('data-status');
        const date = button.getAttribute('data-date');
        const reason = button.getAttribute('data-reason');

        statusDate.textContent = `${status} on - ${date}`;
        reasonText.textContent = reason;
    });
});
</script>

<!-- delete live request -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteReq').forEach(button => {
        button.addEventListener('click', function() {
            let reqId = this.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/seller/deleteLiveRequest/${reqId}`, {
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
                                this.closest('tr').remove();
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

<!-- search -->
<script>
$(document).ready(function() {
    let table = $('#table1').DataTable({
        paging: false,
        ordering: true,
        info: false,
        searching: true,
        destroy: true
    });

    $('#customTableSearch').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>

<script>
$(document).ready(function() {

    // Set request ID when modal opens
    $('.open-cancel-modal').on('click', function() {
        let id = $(this).data('id');
        $('#requestId').val(id);
        $('#cancel_reason').val('');
        $('#cancelReasonError').hide().text('');
    });

    // Hide error when typing
    $('#cancel_reason').on('input', function() {
        if ($(this).val().trim() !== '') {
            $('#cancelReasonError').hide().text('');
        }
    });

    // Submit handler
    $('#submitCancelReason').on('click', function() {
        let cancelReason = $('#cancel_reason').val().trim();
        let id = $('#requestId').val();

        if (!cancelReason) {
            $('#cancelReasonError').text('Please enter reason').show();
            return;
        }

        $.ajax({
            url: '/seller/cancelLiveRequest',
            method: 'POST',
            data: {
                id: id,
                cancel_reason: cancelReason,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#reasonDialog').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.message || 'Something went wrong');
                }
            },
            error: function(xhr) {
                let errMsg = 'Something went wrong';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                toastr.error(errMsg);
            }
        });
    });

});
</script>

<script>
    $('#fromDate, #toDate').change(function() {
    $('#liveRequestFilterForm').submit();
});
</script>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('fromDate').value;
        const toDateInput = document.getElementById('toDate');
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

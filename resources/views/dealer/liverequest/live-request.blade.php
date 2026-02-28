@include('dealer.layout.header')


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Live Coverage Requests</div>
        <a href="#" class="btn btn-success exportbtn">Export</a>

    </div>
    <div class="datatable-wapper mt-4">
        <div class="table-header">
            <div class="search-field">
                <div class="from-group position-relative">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                    <input type="search"
                        class="dt-input tableSearch form-control @if(count($data) > 0)) tableSearch @endif"
                        id="customTableSearch" data-table="table1" placeholder="Search" aria-controls="table1">
                </div>
            </div>

            <form method="GET" action="">

                <div class="search-filter">
                    <div class="from-group">
                        <div class="show-date d-flex gap-2  flex-wrap">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="from" id="fromDate"
                                    value="{{request()->from }}">
                                <p class="text-danger" id="error-start_date"></p>
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="to" id="toDate"
                                    value="{{request()->to }}">

                                <p class="text-danger" id="error-end_date"></p>
                            </div>
                        </div>
                    </div>
                    <div class="from-group">
                        <select class="form-select form-control width-50" aria-label="Default select example">
                            <option value="">Filter by status</option>
                            <option value="1">Pending</option>
                            <option value="2">Completed</option>
                            <option value="3">Cancelled</option>
                            <option value="4">Rejected</option>

                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="choose-date">
            <div class="date-card">
                <div class="date-header" data-bs-toggle="modal" data-bs-target="#sendlives">
                    <span>Select Date</span>
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
                        <th class="no-sort">S.No</th>
                        <th class="no-sort">Request ID</th>
                        <th class="no-sort">Requested On </th>
                        <th class="no-sort">Live Request </th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $req)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>#{{ $req['order_id'] }}</td>
                        <td>{{ $req['created_at'] }}</td>
                        <td>{{ $req['timeslot_details']['date'] }} at {{ $req['timeslot_details']['from'] }}</td>
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
                            <span style="color: #f97316;">Pending</span>
                            @elseif($req['admin_verify'] == '2')
                            <span style="color: #ef4444;">Rejected</span>
                            @elseif($req['admin_verify'] == '3')
                            <span style="color: #ef4444;">Cancelled</span>
                            @elseif($timeslotDateTime && $timeslotDateTime->lessThanOrEqualTo($now))
                            <span style="color: #22c55e;">Completed</span>
                            @else
                            <span>Accepted</span>
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
                <h3>Send new live request </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="from-group py-3">
                    <label for="">Total Coverages - 03</label>
                    <input type="date" class="form-control" id="live_requestDate">
                </div>
                <div class="from-group mb-4">
                    <label for="time">Select Time</label>
                    <div class="time-slot mt-2">
                        <button class="btn btn-time-outline">10:00 AM To 11:30 AM</button>
                        <button class="btn btn-time-outline">10:00 AM To 11:30 AM</button>
                    </div>
                </div>

                <div class="py-3">
                    <button type="submit" class="btn add-fillbtn w-100">Send Request </button>
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
                <h3>Reason</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-red text-end" id="reason-status-date"></div>
                <div class="reason-lists py-3">
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





@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

let m = new Date().getMonth();
let y = new Date().getFullYear();

function render() {
    $('#daysContainer').html('');
    $('#monthSelect').val(m);
    $('#yearSelect').val(y);

    const today = new Date();

    for (let d = 1; d <= new Date(y, m + 1, 0).getDate(); d++) {

        const dateObj = new Date(y, m, d);
        const day = dateObj.toLocaleDateString('en-US', {
            weekday: 'short'
        });

        const active =
            d === today.getDate() &&
            m === today.getMonth() &&
            y === today.getFullYear() ?
            'active' : '';

        $('#daysContainer').append(
            `<div class="day ${active}">
                <span>${day}</span>
                <b>${d}</b>
             </div>`
        );

    }
}

// init
months.forEach((x, i) => $('#monthSelect').append(`<option value="${i}">${x}</option>`));
for (let i = y - 0; i <= y + 0; i++) $('#yearSelect').append(`<option>${i}</option>`);
render();

// events
$('#monthSelect,#yearSelect').change(() => {
    m = +$('#monthSelect').val();
    y = +$('#yearSelect').val();
    render();
});

$('#prevMonth').click(() => {
    m--;
    if (m < 0) {
        m = 11;
        y--
    }
    render();
});
$('#nextMonth').click(() => {
    m++;
    if (m > 11) {
        m = 0;
        y++
    }
    render();
});


$(document).on('click', '.day', function(e) {

    $('.day').removeClass('active');
    $(this).addClass('active');

    // Get day number from <b>
    let day = $(this).find('b').text().padStart(2, '0');

    // Fix month (m is 0-based index)
    let monthNumber = String(m + 1).padStart(2, '0');

    let year = y;

    // Display formatted text
    $('#selectedDate').text(`${day}, ${months[m]} ${year}`);

    // Set value in YYYY-MM-DD format (required for input type="date")
    $('#live_requestDate').val(`${year}-${monthNumber}-${day}`);

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
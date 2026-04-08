@include('affiliatedUser.layout.header')

<div class="my-profile-2 customContainer my-lg-5 my-2 mb-4">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Support </div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-listed-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-listed" type="button" role="tab" aria-controls="pills-listed"
                    aria-selected="true">Contact </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-plan-tab" data-bs-toggle="pill" data-bs-target="#pills-plan"
                    type="button" role="tab" aria-controls="pills-plan" aria-selected="false">Ticket Management</button>
            </li>
        </ul>
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-listed" role="tabpanel" aria-labelledby="pills-listed-tab" tabindex="0">
                <div class="support-wap border-1 p-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="border-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/email.svg') }}">
                                    </div>

                                    <div class="giftinfo-2">
                                        <p>Support Email Address</p>
                                        <a href="#">Loremipsum@gmail.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="border-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/call.svg') }}">
                                    </div>

                                    <div class="giftinfo-2">
                                        <p>Support Contact Number</p>
                                        <a href="#">+966 57689025</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="border-1 mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="giftinfo-2">
                                        <p>Chat on Whatsapp</p>
                                    </div>
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/whatsapp.svg') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="border-1 mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="giftinfo-2">
                                        <p>Chat with the Support Team</p>
                                    </div>
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/support-ic.svg') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>   
            </div>


            <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-plan-tab" tabindex="0">
                <form method="GET" action="{{ route('affiliate.ticket_management') }}">
                    <div class="search-field py-3 d-flex w-100 gap-0">
                        <form action="#" method="GET" class="w-100 d-flex gap-0">
                            <div class="form-group w-100 d-flex">
                                <div class="searchicon"><i class="bi bi-search"></i></div>
                                <input type="search" name="search"  class="form-control giftcontrol" placeholder="Search" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-success searchlin">Search</button>
                        </form>

                        <a href="javascript:void(0)" class="add-icon2" data-bs-toggle="modal" data-bs-target="#ticketModal">
                            <img src="{{ asset('user/assets/images/add-icon.svg') }}" alt="add" class="img-fluid">
                        </a>
                    </div>
                </form>
            
                <div class="ticket-pnl mt-5">
                    @forelse($tickets as $ticket)
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <div class="ticket">
                                    <p class="text-muted mb-1">Ticket Type</p>
                                </div>
                                <div class="ticket">
                                    <p class="text-muted mb-1">
                                        {{ $ticket->ticket_type_details->name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted mb-1">Ticket ID</p>
                                    <p class="fst-500">{{ $ticket->ticket_id }}</p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted mb-1">Raised on</p>
                                    <p class="fst-500">
                                        {{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y, h:i A') }}
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted mb-1">Status</p>
                                    <p class="fst-500">
                                        @php
                                            $createdDate = \Carbon\Carbon::parse($ticket->created_at)->toDateString();
                                            $todayDate = now()->toDateString();
                                        @endphp

                                        @if($ticket->status == 0 && $createdDate == $todayDate)
                                            <span class="text-warning">Pending</span>

                                        @elseif($ticket->status == 0 && $createdDate < $todayDate)
                                            <span class="text-danger">In Progress</span>

                                        @elseif($ticket->status == 1)
                                            <span class="text-success">Resolved</span>

                                        @else
                                            <span class="text-danger">Closed</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <p class="text-muted">No Ticket Found</p>
                        </div>
                    @endforelse

                        @if(!empty($tickets) && $tickets instanceof \Illuminate\Pagination\LengthAwarePaginator && $tickets->count() > 0)
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $tickets->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
            </div>

            </div>

        </div>
    </div>

</div>


<!-- Add ticket Modal -->

<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Ticket deatils </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <form id="ticketModalForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Ticket Type</label>
                        </div>
                        <select id="ticket_type_id" name="ticket_type_id" class="form-select form-control" aria-label="Default select example">
                            <option value="">Select Ticket Type</option>
                            @foreach($ticketTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger small d-none" id="ticket_type_error">Please select ticket type</span>
                    </div>

                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Title</label>
                        </div>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter Product name">
                        <span class="text-danger small d-none" id="title_error">Please enter title</span>
                    </div>

                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Description</label>
                        </div>
                        <textarea id="description" class="form-control" name="description" rows="4" placeholder="Enter description"></textarea>
                        <span class="text-danger small d-none" id="description_error">Please enter description</span>
                    </div>

                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Upload attachment (if any)</label>
                        </div>
                        <div class="upload-image w-100 mt-2">
                            <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                <img src="{{ asset('user/assets/images/upload-icon.svg') }}">
                                <div class="text-color-upload">Upload image</div>
                                <input type="file" accept="image/*" name="file" hidden onchange="showPreview(event)">
                            </label>
                            <div class="imgshow">
                                <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                            </div>
                        </div>
                    </div>

                    <div class="cmn-btn mt-4">
                        <button type="button" id="submitTicket" class="customBtn customBtn5 mt-5">Submit</button>
                    </div>
                </div>
            </form>
           
        </div>
    </div>
</div>


@include('affiliatedUser.layout.footer')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
    function showPreview(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(x) {
                $('.preview').attr('src', x.target.result).show();
                $('.removeIcon').show();
                $('.uploadLabel').hide();
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImg() {
        $('.preview').attr('src', '').hide();
        $('.removeIcon').hide();
        $('.uploadLabel').show();
    }

</script>

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
$(document).ready(function() {
    $('#submitTicket').on('click', function(e) {
        e.preventDefault();

        $('#ticket_type_error, #title_error, #description_error').addClass('d-none');

        var ticketType = $('#ticket_type_id').val();
        var title = $('#title').val().trim();
        var description = $('#description').val().trim();
        var file = $('input[name="file"]')[0].files[0];

        let isValid = true;
        if (!ticketType) { $('#ticket_type_error').removeClass('d-none'); isValid = false; }
        if (!title) { $('#title_error').removeClass('d-none'); isValid = false; }
        if (!description) { $('#description_error').removeClass('d-none'); isValid = false; }

        if (!isValid) return;

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('ticket_type_id', ticketType);
        formData.append('title', title);
        formData.append('description', description);
        if (file) formData.append('file', file);

        $.ajax({
            url: "{{ route('affiliate.raise_ticket') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message || 'Ticket submitted successfully');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(res.message || 'Something went wrong');
                }
            },
            error: function(err) {
                toastr.error('Server error occurred');
            }
        });
    });

    $('#ticket_type_id, #title, #description').on('change input', function() {
        $(this).next('.text-danger').addClass('d-none');
    });
});
</script>
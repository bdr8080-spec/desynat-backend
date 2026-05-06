@include('dealer.layout.header')


@php
$menu_permission=SellermenuPermission();

$can_view=$menu_permission['can_view'];
$can_action=$menu_permission['can_action'];

@endphp

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">  {{ __('seller_messages.Ticket_Management') }}</div>
    </div>
   
    <form method="GET" action="{{ route('seller.ticket_management') }}">
        <div class="search-field d-flex align-items-center py-4 gap-3">
            <div class="search-field d-flex align-items-center w-100">
                <div class="from-group position-relative w-100">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
                    <input type="search" name="search" class="form-control py-3" placeholder="{{ __('seller_messages.Search') }}"  value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-success searchlin"> {{ __('seller_messages.Search') }} </button>
            </div>    
               @if($can_action == '1')

            <a href="#" data-bs-toggle="modal" data-bs-target="#ticketModal"><img src="{{ asset('user') }}/assets/images/add-icon.svg" alt="add icon" class="add_ticket-btn"></a>
            @endif
        </div>
     </form>

 
    <div class="ticket-pnl mt-5">
            @forelse($tickets as $ticket)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <div class="ticket">
                            <p class="text-muted mb-1"> {{ __('seller_messages.Ticket_Type') }}</p>
                        </div>
                        <div class="ticket">
                            <p class="text-muted mb-1">
                                {{ $ticket->ticket_type_details->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1">  {{ __('seller_messages.Ticket_ID') }}</p>
                            <p class="fst-500">{{ $ticket->ticket_id }}</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> {{ __('seller_messages.Raised_On') }}</p>
                            <p class="fst-500">
                                {{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y, h:i A') }}
                            </p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1">  {{ __('seller_messages.Status') }}</p>
                            <p class="fst-500">
                                @php
                                    $createdDate = \Carbon\Carbon::parse($ticket->created_at)->toDateString();
                                    $todayDate = now()->toDateString();
                                @endphp

                                @if($ticket->status == 0 && $createdDate == $todayDate)
                                    <span class="text-warning">    {{ __('seller_messages.Pending') }}</span>

                                @elseif($ticket->status == 0 && $createdDate < $todayDate)
                                    <span class="text-danger"> {{ __('seller_messages.In_Progress') }}</span>

                                @elseif($ticket->status == 1)
                                    <span class="text-success">{{ __('seller_messages.Resolved') }}</span>

                                @else
                                    <span class="text-danger"> {{ __('seller_messages.Closed') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <p class="text-muted">   {{ __('seller_messages.No_Ticket_Found') }}</p>
                </div>
            @endforelse

                @if(!empty($tickets) && $tickets instanceof \Illuminate\Pagination\LengthAwarePaginator && $tickets->count() > 0)
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $tickets->links('pagination::bootstrap-5') }}
                    </div>
                @endif
    </div>





</section>


<!-- Success Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"> {{ __('seller_messages.Ticket_Details') }} </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <form id="ticketModalForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>{{ __('seller_messages.Ticket_Type') }}</label>
                        </div>
                        <select id="ticket_type_id" name="ticket_type_id" class="form-select form-control" aria-label="Default select example">
                            <option value=""> {{ __('seller_messages.Select_Ticket_Type') }}</option>
                            @foreach($ticketTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger small d-none" id="ticket_type_error"> {{ __('seller_messages.Please_Select_Ticket_Type') }}</span>
                    </div>

                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Title</label>
                        </div>
                        <input type="text" id="title" name="title" class="form-control" placeholder="{{ __('seller_messages.Enter_Title') }}">
                        <span class="text-danger small d-none" id="title_error"> {{ __('seller_messages.Please_Enter_Title') }}</span>
                    </div>

                    <div class="sub-form">
                        <div class="label-flex">
                              <label>{{ __('seller_messages.Description') }}</label>

                        </div>
                        <textarea id="description" class="form-control" name="description" rows="4" placeholder="{{ __('seller_messages.Enter_Description') }}"></textarea>
                        <span class="text-danger small d-none" id="description_error"> {{ __('seller_messages.Please_Enter_Description') }}</span>
                    </div>

                    <div class="sub-form">
                        <div class="label-flex">
                            <label> {{ __('seller_messages.Upload_Attachment') }}</label>
                        </div>
                        <div class="upload-image w-100 mt-2">
                            <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                <img src="{{ asset('user/assets/images/upload-icon.svg') }}">
                                <div class="text-color-upload">  {{ __('seller_messages.Upload_Image') }}</div>
                                <input type="file" accept="image/*" name="file" hidden onchange="showPreview(event)">
                            </label>
                            <div class="imgshow">
                                <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                            </div>
                        </div>
                    </div>

                    <div class="cmn-btn mt-4">
                        <button type="button" id="submitTicket" class="btn add-fillbtn w-100"> {{ __('seller_messages.Submit') }}</button>
                    </div>
                </div>
            </form>
           
        </div>
    </div>
</div>




@include('dealer.layout.footer');
@include('dealer.product.ajax.datatablejs');

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
            url: "{{ route('seller.raise_ticket') }}",
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
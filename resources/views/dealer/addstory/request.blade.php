@include('dealer.layout.header')


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24"> {{ __('seller_messages.story_req_managemnt') }} </div>

        <a href="#" data-bs-toggle="modal" data-bs-target="#storyAdd"><img
                src="{{ asset('user') }}/assets/images/add-icon.svg" alt="add icon" style="width:40px;"></a>
    </div>

@if (session('status') == 'success')
    <div class="alert alert-success">
        <!-- <script>
        $('#payModalSuccess').modal('show');
        </script> -->
        {{ session('message') }}
    </div>
    @elseif (session('status') == 'error')
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
    @endif

    <div class="ticket-pnl mt-0 storypnl">

        <div class="datatable-wapper mt-5">
            <div class="table-header mb-2">
                <!-- Search -->
                <div class="search-field">
                    <div class="from-group position-relative">
                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                        <input type="search" class="dt-input tableSearch form-control" id="customTableSearch"
                            placeholder="{{ __('seller_messages.Search') }}" aria-controls="datatable_search">
                    </div>
                </div>

                <!-- Filters -->
                <form method="GET" action="">
                    <div class="search-filter">

                        <!-- Date Filter -->
                        <div class="from-group">
                            <div class="show-date d-flex gap-2  flex-wrap">
                                <div class="date-form-pnl">
                                    <input type="date" class="form-control datepicker" name="from" id="fromDate"
                                        value="{{request()->from }}">
                                    <p class="text-danger" id="error-start_date"></p>
                                </div>
                                <div class="date-form-pnl">
                                    <input type="date" class="form-control datepicker" name="to" id="toDate"
                                        value="{{request()->to }}">

                                    <p class="text-danger" id="error-end_date"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="from-group">
                            <select class="form-select form-control width-50" aria-label="Default select example"
                                name="filter" onchange="this.form.submit()">
                            
                                <option value="">
                                    {{ __('seller_messages.Filter_By_Status') }}
                                </option>

                                <option value="1" @if(request()->filter==1) selected @endif>
                                    {{ __('seller_messages.Active') }}
                                </option>

                                <option value="2" @if(request()->filter==2) selected @endif>
                                    {{ __('seller_messages.Confirmed') }}
                                </option>

                                <option value="3" @if(request()->filter==3) selected @endif>
                                    {{ __('seller_messages.Pending') }}
                                </option>

                                <option value="4" @if(request()->filter==4) selected @endif>
                                    {{ __('seller_messages.Expired') }}
                                </option>

                                <option value="5" @if(request()->filter==5) selected @endif>
                                    {{ __('seller_messages.Rejected') }}
                                </option>

                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered datatable tablesearch" id="table1">
                    <thead>
                        <tr>
                            <th class="no-sort">{{ __('seller_messages.S_No') }}</th>
                            <th class="no-sort">{{ __('seller_messages.Image') }}</th>
                            <th class="no-sort">{{ __('seller_messages.Request_ID') }}</th>
                            <th class="no-sort">{{ __('seller_messages.Requested_On') }}</th>
                            <th class="no-sort">{{ __('seller_messages.Total_Amount') }}</th>
                            <th class="no-sort">{{ __('seller_messages.View_More_Details') }}</th>
                            <th class="no-sort">{{ __('seller_messages.Status') }}</th>
                            <th class="no-sort">{{ __('seller_messages.Action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data['data'] as $key => $story)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                <img src="{{ $story->file }}"
                                    class="img-fluid pro-image"
                                    alt="Story"
                                    style="width:105px;height:65px;border-radius:5%;object-fit:cover;">
                            </td>

                            <td>#{{ $story->id }}</td>

                            <td>{{ formatDateTimeByLocale($story->created_at) }}</td>

                            <td>{{ $story->amount }} {{ __('seller_messages.KD') }}</td>

                            <td>
                                <a href="#"
                                class="eyebtn viewStoryBtn"
                                data-bs-toggle="modal"
                                data-bs-target="#storyGrid"
                                data-id="{{ $story->id }}"
                                data-image="{{ $story->file }}"
                                data-request="{{ $story->id }}"
                                data-date="{{ formatDateTimeByLocale($story->created_at) }}"
                                data-start-date="{{ formatDateTimeByLocale($story->start_date) }}"
                                data-amount="{{ $story->amount }}"
                                data-admin-verify="{{ $story->Admin_verify }}"
                                data-payment-status="{{ $story->payment_status }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>

                            <td>
                            @php
                                $today = \Carbon\Carbon::today();
                                $startDate = \Carbon\Carbon::parse($story->start_date);
                            @endphp

                            @if($story->Admin_verify == 0)
                                <span class="badge bg-warning">{{ __('seller_messages.Pending') }}</span>

                            @elseif($story->Admin_verify == 2)
                                <span class="badge bg-danger">{{ __('seller_messages.Rejected') }}</span>

                            @elseif($story->Admin_verify == 1 && $story->payment_status == 1 && $startDate->isToday())
                                <span class="badge bg-success">{{ __('seller_messages.Active') }}</span>

                            @elseif($story->Admin_verify == 1 && $today->gt($startDate))
                                <span class="badge bg-secondary">{{ __('seller_messages.Expired') }}</span>

                            @elseif($story->Admin_verify == 1 && $story->payment_status == 0)
                                <span class="badge bg-info">{{ __('seller_messages.Confirmed') }}</span>

                            @elseif($story->Admin_verify == 1 && $story->payment_status == 1 && $today->lt($startDate))
                                <span class="badge bg-success">{{ __('seller_messages.Paid') }}</span>
                            @endif
                            </td>

                            @php
                                $today = \Carbon\Carbon::today()->toDateString();
                            @endphp

                           <td>
                                @if(
                                    $story->payment_status == 0 &&
                                    $story->Admin_verify == 1 &&
                                    $story->start_date >= $today
                                )
                                    <button
                                        type="button"
                                        class="btn add-fillbtn lh-25 payNowBtn"
                                        data-story-id="{{ $story->id }}"
                                        data-order-id="{{ $story->order_id }}"
                                        data-amount="{{ $story->amount }}">
                                        {{ __('seller_messages.Pay_Now') }}
                                    </button>
                                @endif
                            </td>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Add story Modal -->
<div class="modal fade" id="storyAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"> {{ __('seller_messages.add_promotional_story') }} </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="product-pnls2 mt-3 mb-3">
                    <div class="upload-image" style="height:250px;">
                        <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">
                            <div id="bannerPlaceholderImg">
                                <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                    style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                                <div class="py-2" style="color:#875C3A">
                                    {{ __('seller_messages.upload_image_video') }}
                                </div>
                            </div>
                            <img id="bannerUploadedImg" src="" alt="image" class="img-fluid uploadbnr"
                                style="display:none;">
                            <video id="bannerUploadedVideo" class="img-fluid uploadbnr" controls
                                style="display:none;"></video>
                        </label>
                        <input type="file" id="banner_image_upload" name="file" accept="image/*,video/*"
                            style="display:none;">
                    </div>
                    <small class="text-danger" id="file_error"></small>
                </div>

                <input type="hidden" id="country_id" value="{{ $country_id }}">

                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.select_date') }}</label>
                    </div>

                    <input type="date" class="form-control datepicker" id="story_date">

                    <small class="text-danger" id="date_error"></small>
                </div>

                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.total_price') }}</label>
                    </div>

                    <input type="text" class="form-control" id="story_price" readonly>

                    <small class="text-danger" id="price_error"></small>
                </div>


                <div class="cmn-btn mt-4">
                    <button type="button" class="btn add-fillbtn w-100" id="submitStory">
                        {{ __('seller_messages.send_request') }}
                    </button>
                </div>


            </div>

        </div>
    </div>
</div>

<!-- show story Modal -->
<div class="modal fade" id="sendStory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="verification-card">
                    <div class="icon">
                        <img src="{{ asset('/dealer') }}/assets/img/watch.png" alt="Verification" class="img-fluid">
                    </div>

                    <h3>{{ __('seller_messages.story_request_submitted_successfully') }}</h3>

                    <p>
                        {{ __('seller_messages.story_request_review_message_1') }}
                        {{ __('seller_messages.story_request_review_message_2') }}
                    </p>

                    <p>
                        {{ __('seller_messages.story_request_notification_message') }}
                    </p>

                    <div class="thank-pnl">
                        <p>{{ __('seller_messages.thank_you_for_your_patience') }}</p>
                        <strong>{{ __('seller_messages.team_desynat') }}</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- story Modal -->
<div class="modal fade" id="storyGrid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"> {{ __('seller_messages.details') }} </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-4 w-100">
                    <div class="story-figure">
                        <img id="modalStoryImage" src="" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> {{ __('seller_messages.Request_ID') }} </p>
                            <p class="fst-500" id="modalRequestId"></p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> {{ __('seller_messages.Requested_On') }} </p>
                            <p class="fst-500" id="modalRequestedOn"></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> {{ __('seller_messages.Status') }} </p>
                            <p class="fst-500" id="modalStatus"></p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1">{{ __('seller_messages.date_selected') }} </p>
                    <p class="fst-500" id="modalStartDate"></p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1"> {{ __('seller_messages.total_price') }} </p>
                    <p class="fst-500" id="modalAmount"> {{ __('seller_messages.KD') }}</p>
                </div>
            </div>

        </div>
    </div>
</div>

<input type="hidden" name="payment" id="onlinePayment" value="1">




@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
$(document).ready(function() {
    $("#bannerUploadLabel").on("click", function() {
        $("#banner_image_upload").click();
    });

    // Preview Image/Video
    $("#banner_image_upload").on("change", function(e) {
        $("#file_error").text(""); 
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        // Hide placeholder
        $("#bannerPlaceholderImg").hide();

        if (file.type.startsWith("image/")) {

            reader.onload = function(event) {
                $("#bannerUploadedVideo").hide().attr("src", "");
                $("#bannerUploadedImg")
                    .attr("src", event.target.result)
                    .show();
            };

            reader.readAsDataURL(file);

        } else if (file.type.startsWith("video/")) {
            const videoURL = URL.createObjectURL(file);
            $("#bannerUploadedImg").hide().attr("src", "");

            $("#bannerUploadedVideo")
                .attr("src", videoURL)
                .show();

        } else {
            alert("Please select a valid image or video.");
        }

    });

});
</script>

<script>
$(document).ready(function () {

    const storyPriceRoute = "{{ route('seller.getSellerStoryPrice') }}";
    const addStoryRoute = "{{ route('seller.add_promotional_story') }}";

    // Disable previous dates
    const today = new Date().toISOString().split("T")[0];
    $("#story_date").attr("min", today);

    //==============================
    // Get Story Price
    //==============================
    $("#story_date").change(function () {

        $("#date_error").text("");
        $("#price_error").text("");

        let date = $(this).val();

        if (date == "") {
            $("#date_error").text("{{ __('seller_messages.please_select_a_date') }}");
            return;
        }

        $.ajax({
            url: storyPriceRoute,
            type: "POST",
            data: {
                country_id: $("#country_id").val(),
                no_of_days: 1,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if (response.status == "success") {
                    $("#story_price").val(response.data.total_amount);
                } else {
                    toastr.error(response.message);
                }

            },
            error: function (xhr) {

                toastr.error(xhr.responseJSON.message);

            }

        });

    });


    //==========================================
    // Submit Story
    //==========================================
    $("#submitStory").click(function () {

        $("#file_error").text("");
        $("#date_error").text("");
        $("#price_error").text("");

        let file = $("#banner_image_upload")[0].files[0];
        let date = $("#story_date").val();
        let price = $("#story_price").val();

        let valid = true;

        if (!file) {
            $("#file_error").text("{{ __('seller_messages.please_select_an_image_or_video') }}");
            valid = false;
        }

        if (date == "") {
            $("#date_error").text("{{ __('seller_messages.please_select_a_date') }}");
            valid = false;
        }

        if (price == "") {
            $("#price_error").text("{{ __('seller_messages.Price_not_found') }}");
            valid = false;
        }

        if (!valid) {
            return;
        }

        let formData = new FormData();

        formData.append("image", file);
        formData.append("start_date", date);
        formData.append("end_date", date);
        formData.append("total_days", 1);
        formData.append("amount", price);

        $.ajax({

            url: addStoryRoute,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },

            beforeSend: function () {
                $("#submitStory").prop("disabled", true);
            },

            success: function (response) {

                $("#submitStory").prop("disabled", false);

                // Close Add Story modal
                $("#storyAdd").modal("hide");

                // Reset form
                $("#banner_image_upload").val('');
                $("#story_date").val('');
                $("#story_price").val('');

                $("#file_error").text("");
                $("#date_error").text("");
                $("#price_error").text("");

                $("#bannerUploadedImg").hide().attr("src", "");
                $("#bannerUploadedVideo").hide().attr("src", "");

                $("#bannerPlaceholderImg").show();

                // Wait until first modal is completely closed
                $('#storyAdd').one('hidden.bs.modal', function () {

                    // Show success modal
                    $("#sendStory").modal("show");

                    // Hide after 5 seconds
                    setTimeout(function () {

                        $("#sendStory").modal("hide");

                        // Reload after modal is fully hidden
                        $('#sendStory').one('hidden.bs.modal', function () {
                            location.reload();
                        });

                    }, 5000);

                });

            },

            error: function (xhr) {

                $("#submitStory").prop("disabled", false);

                if (xhr.status == 422) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {

                        if ($("#" + key + "_error").length) {
                            $("#" + key + "_error").text(value[0]);
                        }

                    });

                } else {

                    toastr.error(xhr.responseJSON.message);

                }

            }

        });

    });

});
</script>



<script>
$(document).ready(function() {
    $('#customTableSearch').on('keyup search', function() {
        let value = $(this).val().toLowerCase().trim();

        $('.tablesearch tbody tr').each(function() {
            let rowText = $(this).text().toLowerCase();

            if (value === "") {
                // input empty → show all rows
                $(this).show();
            } else {
                // match text
                $(this).toggle(rowText.indexOf(value) > -1);
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {

    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const form = fromDate.form;

    const today = new Date().toISOString().split('T')[0];

    fromDate.min = today;
    toDate.min = today;

    function canSubmit() {
        return (
            fromDate.value &&
            toDate.value &&
            fromDate.value >= today &&
            toDate.value >= fromDate.value
        );
    }

    // From date change
    fromDate.addEventListener('change', function() {
        if (this.value < today) {
            this.value = '';
            // document.getElementById('error-start_date').innerText =
            // 'Start date cannot be earlier than today';
            return;
        }

        document.getElementById('error-start_date').innerText = '';
        toDate.min = this.value;

        if (toDate.value && toDate.value < this.value) {
            toDate.value = '';
        }

        if (canSubmit()) {
            form.submit();
        }
    });

    // To date change
    toDate.addEventListener('change', function() {
        if (fromDate.value && this.value < fromDate.value) {
            this.value = '';
            // document.getElementById('error-end_date').innerText =
            // 'End date cannot be earlier than start date';
            return;
        }

        document.getElementById('error-end_date').innerText = '';

        if (canSubmit()) {
            form.submit();
        }
    });

});
</script>


<script>
$(document).on('click', '.viewStoryBtn', function () {

    let image = $(this).data('image');
    let requestId = $(this).data('request');
    let requestedOn = $(this).data('date');
    let startDate = $(this).data('start-date');
    let amount = $(this).data('amount');

    let adminVerify = $(this).data('admin-verify');
    let paymentStatus = $(this).data('payment-status');


    // Image
    $("#modalStoryImage").attr("src", image);


    // Currency
    const currencyKD = "{{ __('seller_messages.KD') }}";


    // Details
    $("#modalRequestId").text("#" + requestId);
    $("#modalRequestedOn").text(requestedOn);
    $("#modalStartDate").text(startDate);
    $("#modalAmount").text(amount + " " + currencyKD);



    // Status calculation same as Blade

    let today = new Date();
    today.setHours(0, 0, 0, 0);


    let storyStartDate = new Date(startDate);
    storyStartDate.setHours(0, 0, 0, 0);


    let status = "";


    if (adminVerify == 0) {

        status = "{{ __('seller_messages.Pending') }}";


    } else if (adminVerify == 2) {

        status = "{{ __('seller_messages.Rejected') }}";


    } else if (
        adminVerify == 1 &&
        paymentStatus == 1 &&
        startDate === today
    ) {

        status = "{{ __('seller_messages.Active') }}";


    } else if (
        adminVerify == 1 &&
        today > startDate
    ) {

        status = "{{ __('seller_messages.Expired') }}";


    } else if (adminVerify == 1) {

        status = "{{ __('seller_messages.Confirmed') }}";

    }


    $("#modalStatus").text(status);

});
</script>

<script>
$(document).on("click", ".payNowBtn", function (e) {

    e.preventDefault();

    let button = $(this);

    // Prevent multiple clicks
    button.prop("disabled", true);

    let orderId = button.data("order-id");

    // Redirect to MyFatoorah
    window.location.href = "{{ url('myfatoorah') }}/" + orderId + "?type=storyBuy";

});
</script>

<script>
$(document).ready(function () {

    @if(session()->has('message'))

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": 3000
        };

        @if(session('status') == 'success')
            toastr.success(@json(session('message')));
        @else
            toastr.error(@json(session('message')));
        @endif

    @endif

});
</script>

@include('dealer.layout.languagetableCode');

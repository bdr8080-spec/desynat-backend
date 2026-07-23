@include('dealer.layout.header')


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24"> Story Management </div>

        <a href="#" data-bs-toggle="modal" data-bs-target="#storyAdd"><img
                src="{{ asset('user') }}/assets/images/add-icon.svg" alt="add icon" style="width:40px;"></a>
    </div>



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
                            <div class="show-date d-flex gap-2 flex-wrap">
                                <div class="date-form-pnl">
                                    <input type="date" class="form-control datepicker" name="from" id="fromDate"
                                        value="{{ request()->from }}">
                                    <p class="text-danger" id="error-start_date"></p>
                                </div>

                                <div class="date-form-pnl">
                                    <input type="date" class="form-control datepicker" name="to" id="toDate"
                                        value="{{ request()->to }}">
                                    <p class="text-danger" id="error-end_date"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="from-group">
                            <select name="status_filter" class="form-select form-control width-50">
                                <option selected>Filter </option>

                                <option value="1">Active </option>
                                <option value="2">Pending </option>
                                <option value="3">Complete </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered datatable tablesearch" id="datatable_search">
                    <thead>
                        <tr>
                            <th class="no-sort">S.No</th>
                            <th class="no-sort">Images</th>
                            <th class="no-sort">Request ID</th>
                            <th class="no-sort">Requested on</th>
                            <th class="no-sort">Total Amount</th>
                            <th class="no-sort">Details</th>
                            <th class="no-sort">Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="{{ asset('dealer') }}/assets/img/reel-5.jpeg" class="img-fluid pro-image"
                                    alt="image" style="width:105px;height:65px;border-radius:5%;object-fit:cover;">
                            </td>

                            <td>#876868</td>
                            <td>21/07/2026 at 10:15 AM</td>
                            <td>400 KD</td>
                            <td><a href="#" class="eyebtn" data-bs-toggle="modal" data-bs-target="#storyGrid"><i
                                        class="bi bi-eye"></i></a></td>
                            <td>Pending</td>
                            <td> <button type="button" class="btn add-fillbtn lh-25">Pay Now</button></td>
                        </tr>
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
                <h1 class="modal-title fs-5"> Add Story </h1>
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
                                    Upload Image/Video
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
                </div>

                <div class="sub-form">
                    <div class="label-flex">
                        <label>Select Date</label>
                    </div>
                    <input type="date" class="form-control">
                </div>

                <div class="sub-form">
                    <div class="label-flex">
                        <label>Total Price</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter amount">
                </div>

                <div class="cmn-btn mt-4">
                    <button type="button" class="btn add-fillbtn w-100" data-bs-toggle="modal"
                        data-bs-target="#sendStory">Send Request</button>
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

                    <h3>Your Story request has been successfully submitted for verification !</h3>

                    <p>
                        Our team is currently reviewing your details please allow
                        3–4 hour for the verification process to be completed.
                    </p>

                    <p>
                        you will be notified once your Story is approved on the desynat
                        platform.
                    </p>

                    <div class="thank-pnl">
                        <p>Thank you for your patience</p>
                        <strong>TEAM DESNYAT</strong>
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
                <h1 class="modal-title fs-5"> Details </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-4 w-100">
                    <div class="story-figure">
                        <img src="{{ asset('dealer') }}/assets/img/reel-5.jpeg" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Request ID </p>
                            <p class="fst-500">#7677678</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Requested on </p>
                            <p class="fst-500">21/07/2026 at 10:15 AM</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Status </p>
                            <p class="fst-500">Pending</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1"> Date Selected </p>
                    <p class="fst-500">21/07/2026</p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1"> Total Amount </p>
                    <p class="fst-500">400 KD</p>
                </div>
            </div>

        </div>
    </div>
</div>




@include('dealer.layout.footer');

<script>
$(document).ready(function() {
    $("#bannerUploadLabel").on("click", function() {
        $("#banner_image_upload").click();
    });

    // Preview Image/Video
    $("#banner_image_upload").on("change", function(e) {
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

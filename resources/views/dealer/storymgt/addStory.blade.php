@include('dealer.layout.header')


@php
$menu_permission=SellermenuPermission();

$can_view=$menu_permission['can_view'];
$can_action=$menu_permission['can_action'];

@endphp

<section class="section dashboard">
    <div class="onepage-2">
        <div class=" position-relative">
            <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
                <div class="title24">
                    <a href="#" style="color:rgb(57, 55, 55)">
                        <i class="bi bi-chevron-left"></i> Add Story
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
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
                <button type="button" class="btn add-fillbtn w-100">Send Request</button>
            </div>
        </div>

    </div>

</section>


<!-- Pay now story Modal -->
<div class="modal fade" id="storyGrid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"> Details </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">



                <!-- <div class="cmn-btn mt-4">
                    <button type="button" class="btn add-fillbtn w-100">Pay Now</button>
                </div> -->
            </div>

        </div>
    </div>
</div>





@include('dealer.layout.footer');
@include('dealer.product.ajax.datatablejs');

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
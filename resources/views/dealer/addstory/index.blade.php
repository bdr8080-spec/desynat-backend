@include('dealer.layout.header')

<style>
.deleteStoryBtn {
    background: linear-gradient(135deg, #ff4d4d, #cc0000);
    color: #fff;
    border: none;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.deleteStoryBtn:hover {
    background: linear-gradient(135deg, #e60000, #990000);
    transform: scale(1.05);
}

button.deleteStoryBtn {
    margin-left: 90px;
    margin-bottom: 50px;
}

.profile-option {
    width: 100%;
    max-width: 100%;
    min-height: 64px;
    padding: 12px 14px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 10px;
}

.left-content h4 {
    font-size: 17px;
}
</style>

<div class="onepage-2">
    <div class="customContainer position-relative">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
            <div class="title24">
                <a href="{{route('seller.view_profile')}}" style="color:rgb(57, 55, 55)">
                    <i class="bi bi-chevron-left"></i> {{ __('seller_messages.Add_Story') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-6">

        <div class="product-pnls2 mt-3 mb-3">
            <div class="upload-image" style="height:250px;">
                <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">
                    <div id="bannerPlaceholderImg">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                            style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                        <div class="py-2" style="color:#875C3A">
                            {{ __('seller_messages.Upload_Image_Video') }}
                        </div>
                    </div>
                    <img id="bannerUploadedImg" src="" alt="image" class="img-fluid uploadbnr" style="display:none;">
                    <video id="bannerUploadedVideo" class="img-fluid uploadbnr" controls style="display:none;"></video>
                </label>
                <input type="file" id="banner_image_upload" name="file" accept="image/*,video/*" style="display:none;">
            </div>
        </div>

        <div class="postpanle">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-option active">
                        <div class="left-content d-flex gap-3">
                            <label class="radio-group">
                                <input class="form-check-input profile-radio" type="radio" name="filter" value="free"
                                    checked>
                                <span class="custom-radio"></span>
                            </label>

                            <div>
                                <h4 class="mb-0">Profile Story</h4>
                                <p class="mb-0">Visible on your profile</p>
                            </div>
                        </div>

                        <span class="status-text free">Free</span>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="profile-option">
                        <div class="left-content d-flex gap-3">
                            <label class="radio-group">
                                <input class="form-check-input profile-radio" type="radio" name="filter" value="paid">
                                <span class="custom-radio"></span>
                            </label>

                            <div>
                                <h4 class="mb-0">Featured on Desynat Home</h4>
                                <p class="mb-2">Reach more users</p>
                            </div>
                        </div>

                        <span class="status-text paid">Paid</span>
                    </div>

                    <div class="paidPnl" style="display: none;">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Select Date</label>
                            </div>
                            <input type="date" class="form-control datepicker">
                        </div>

                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Add Price</label>
                            </div>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="#" class="btn btn-success">Post On Profile</a>
        </div>

    </div>
</div> -->
<div class="row">
    <div class="col-lg-6">

        <div class="product-pnls2 mt-3 mb-3">
            <div class="upload-image" style="height:250px;">

                <label id="bannerUploadLabel"
                       style="cursor:pointer;text-align:center;display:block;">

                    <div id="bannerPlaceholderImg">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                             style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">

                        <div class="py-2" style="color:#875C3A">
                            {{ __('seller_messages.Upload_Image_Video') }}
                        </div>
                    </div>

                    <img id="bannerUploadedImg"
                         src=""
                         alt="image"
                         class="img-fluid uploadbnr"
                         style="display:none;">

                    <video id="bannerUploadedVideo"
                           class="img-fluid uploadbnr"
                           controls
                           style="display:none;">
                    </video>

                </label>

                <input type="file"
                       id="banner_image_upload"
                       name="file"
                       accept="image/*,video/*"
                       style="display:none;">
            </div>
        </div>


        <div class="postpanle">
            <div class="row">

                <div class="col-lg-12">
                    <div class="profile-option active">

                        <div class="left-content d-flex gap-3">

                            <label class="radio-group">
                                <input class="form-check-input profile-radio"
                                       type="radio"
                                       name="filter"
                                       value="free"
                                       checked>

                                <span class="custom-radio"></span>
                            </label>

                            <div>
                                <h4 class="mb-0">Profile Story</h4>
                                <p class="mb-0">Visible on your profile</p>
                            </div>

                        </div>

                        <span class="status-text free">Free</span>

                    </div>
                </div>


                <div class="col-lg-12">

                    <div class="profile-option">

                        <div class="left-content d-flex gap-3">

                            <label class="radio-group">
                                <input class="form-check-input profile-radio"
                                       type="radio"
                                       name="filter"
                                       value="paid">

                                <span class="custom-radio"></span>
                            </label>

                            <div>
                                <h4 class="mb-0">Featured on Desynat Home</h4>
                                <p class="mb-2">Reach more users</p>
                            </div>

                        </div>

                        <span class="status-text paid">Paid</span>

                    </div>


                    <div class="paidPnl" style="display:none;">

                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Select Date</label>
                            </div>

                            <input type="date"
                                   id="story_start_date"
                                   class="form-control datepicker"
                                   min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Add Price</label>
                            </div>

                            <input type="text"
                                   id="story_price"
                                   class="form-control"
                                   readonly>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="text-center mt-3">

            <a href="javascript:void(0);"
               id="postStoryBtn"
               class="btn btn-success">

                Post On Profile

            </a>

        </div>

    </div>
    <input type="hidden" id="country_id" value="{{ $country_id }}">
</div>

<div class="product_reels customContainer mt-4">
    <div class="title24">{{ __('seller_messages.Select_From_Gallery') }}</div>
    <div class="reels-wrapper mt-4">
        <div class="row">
            @foreach($sellerStories as $index => $story)
            <div class="col-lg-3 col-md-3">
                <div class="reels-grid" onclick="addSeller({{ $index }})">
                    <div class="reel-card">
                        @php
                        $extension = pathinfo($story->file, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                        <video class="img-fluid" muted loop playsinline preload="metadata">
                            <source src="{{ $story->file }}" type="video/{{ $extension }}">
                            {{ __('seller_messages.Browser_Not_Support_Video') }}
                        </video>
                        @else
                        <img src="{{ $story->file }}" alt="image" class="img-fluid">
                        @endif
                    </div>
                </div>
                <button class="deleteStoryBtn" data-id="{{ $story->id }}">
                    {{ __('seller_messages.Delete') }}
                </button>
            </div>
            @endforeach
        </div>

    </div>
</div>

<!-- Seller story section -->
<div class="status-viewer bgwhite" id="Addstory12">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <h3>{{ __('seller_messages.Add_Story') }}</h3>
            <button type="button" class="btn btn-light" onclick="closeStatus1()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <div class="status-img">
                <img id="storyimg12" class="img-fluid" alt="status" />
                <video id="storyvideo12" class="img-fluid" controls style="display:none;"></video>
            </div>
        </div>

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" data-bs-toggle="modal" data-bs-target="#showModule" class="btn add-fillbtn w-100">
                {{ __('seller_messages.Upload') }}</button>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="showModule" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title w-100 text-center fw-bold" id="showModuleLabel" style="color: #333;">Promote
                    Story</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body px-4" id="moduleData">

                <div class="card p-3 mb-3 option-card" id="cardProfile"
                    style="border: 1px solid #e0e0e0; border-radius: 12px; cursor: pointer;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-3 option-checkbox" type="checkbox" id="checkProfile"
                                checked style="width: 22px; height: 22px; accent-color: #a48464;">
                            <div>
                                <strong class="d-block" style="color: #222;">Profile Story</strong>
                                <small class="text-muted">Visible on your profile</small>
                            </div>
                        </div>
                        <span class="fw-bold" style="color: #222;">Free</span>
                    </div>
                </div>

                <div class="card p-3 mb-3 option-card" id="cardFeatured"
                    style="border: 1px solid #e0e0e0; border-radius: 12px; cursor: pointer;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-3 option-checkbox" type="checkbox" id="checkFeatured"
                                style="width: 22px; height: 22px; accent-color: #a48464;">
                            <div>
                                <strong class="d-block" style="color: #222;">Featured on Desyat Home</strong>
                                <small class="text-muted">Reach more users</small>
                            </div>
                        </div>
                        <span class="fw-bold text-success">Paid</span>
                    </div>
                </div>

                <div id="paidFields" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted mb-1">Select Date</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="21/09/2025"
                                style="border-radius: 8px; border: 1px solid #dcdcdc; height: 45px;">
                            <span class="input-group-text bg-white"
                                style="border-radius: 8px; border: 1px solid #dcdcdc; border-left: none;">
                                <i class="bi bi-calendar3"></i>
                            </span>
                        </div>
                    </div>

                    
                    <div class="d-flex justify-content-between align-items-center p-3 mb-4"
                        style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; height: 45px;">
                        <span class="fw-bold text-muted small">Total Price</span>
                        <span class="fw-bold" style="color: #222;">499 KD</span>
                    </div>
                </div>

            
                <button type="button" id="submitBtn" class="btn w-100 text-white fw-bold py-2 mt-2"
                    style="background: linear-gradient(to right, #bca085, #8a6d51); border-radius: 10px; height: 48px;">
                    Post on Profile
                </button>

            </div>
        </div>
    </div>
</div> -->

<script>
document.querySelectorAll('.profile-radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
        const paidPanel = document.querySelector('.paidPnl');

        if (this.value === 'paid') {
            paidPanel.style.display = 'block';
        } else {
            paidPanel.style.display = 'none';
        }

    });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const checkProfile = document.getElementById("checkProfile");
    const checkFeatured = document.getElementById("checkFeatured");

    const cardProfile = document.getElementById("cardProfile");
    const cardFeatured = document.getElementById("cardFeatured");

    const paidFields = document.getElementById("paidFields");
    const submitBtn = document.getElementById("submitBtn");


    const activeBorder = "1px solid #a48464";
    const normalBorder = "1px solid #e0e0e0";

    function updateUI() {
        cardProfile.style.border = checkProfile.checked ? activeBorder : normalBorder;
        cardFeatured.style.border = checkFeatured.checked ? activeBorder : normalBorder;

        if (checkFeatured.checked) {
            paidFields.style.display = "block";
            submitBtn.innerText = "Send Request";
        } else {
            paidFields.style.display = "none";
            submitBtn.innerText = "Post on Profile";
        }
    }

    checkProfile.addEventListener("change", function() {
        if (checkProfile.checked) checkFeatured.checked = false;
        updateUI();
    });

    checkFeatured.addEventListener("change", function() {
        if (checkFeatured.checked) checkProfile.checked = false;
        updateUI();
    });

    cardProfile.addEventListener("click", function(e) {
        if (e.target !== checkProfile) {
            checkProfile.checked = !checkProfile.checked;
            if (checkProfile.checked) checkFeatured.checked = false;
            updateUI();
        }
    });

    cardFeatured.addEventListener("click", function(e) {
        if (e.target !== checkFeatured) {
            checkFeatured.checked = !checkFeatured.checked;
            if (checkFeatured.checked) checkProfile.checked = false;
            updateUI();
        }
    });

    updateUI();
});
</script>

<script>
var sellerStories = @json($sellerStories);
//console.log(stories);
</script>

<script>
var currentIndex = 0;

function addSeller(index) {
    currentIndex = index;

    document.getElementById("Addstory12").style.display = "block";
    loadStory();
}

function loadStory() {
    var story = sellerStories[currentIndex];
    var file = story.file;

    var img = document.getElementById("storyimg12");
    var video = document.getElementById("storyvideo12");

    // Reset both
    img.style.display = "none";
    video.style.display = "none";
    video.pause();
    video.src = "";

    // Check file type
    if (file.match(/\.(mp4|webm|ogg)$/i)) {
        video.src = file;
        video.style.display = "block";
        video.play();
    } else {
        img.src = file;
        img.style.display = "block";
    }
}


function closeStatus1() {
    document.getElementById("Addstory12").style.display = "none";

    // Stop video on close
    var video = document.getElementById("storyvideo12");
    video.pause();
    video.src = "";
}
</script>


<!-- add story -->
<!-- <script>
document.getElementById('bannerUploadLabel').addEventListener('click', function(e) {
    e.preventDefault();

    // console.log('Label clicked');

    const fileInput = document.getElementById('banner_image_upload');
    //console.log(fileInput);

    fileInput.click();
});
document.getElementById('banner_image_upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const img = document.getElementById('bannerUploadedImg');
    const video = document.getElementById('bannerUploadedVideo');
    const placeholder = document.getElementById('bannerPlaceholderImg');
    const loader = document.getElementById('loader');

    // Reset preview
    img.style.display = 'none';
    video.style.display = 'none';
    placeholder.style.display = 'none';

    const fileType = file.type;

    //  Show preview
    if (fileType.startsWith('video/')) {
        const videoURL = URL.createObjectURL(file);
        video.src = videoURL;
        video.style.display = 'block';
    } else {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    //  Prepare form data
    let formData = new FormData();
    formData.append('file', file);

    //  Show loader
    if (loader) loader.style.display = 'block';

    //  AJAX upload
    fetch("{{ route('seller.upload_story') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(async res => {
            let data;
            try {
                data = await res.json();
            } catch (e) {
                throw new Error("Invalid JSON response");
            }

            return {
                statusCode: res.status,
                body: data
            };
        })
        .then(({
            statusCode,
            body
        }) => {
            if (loader) loader.style.display = 'none';

            //  Handle Laravel validation (422)
            if (statusCode === 422) {
                toastr.error(body.message || 'Validation error');
                return;
            }

            //  Handle API response
            if (body.status === 'success') {
                toastr.success(body.message || 'Uploaded successfully');

                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else if (body.status === 'failed') {
                toastr.error(body.message || 'Upload failed');

                setTimeout(() => {
                    window.location.href = "{{ route('seller.all_plans') }}";
                }, 1500);

            } else {
                toastr.error(body.message || 'Something went wrong');
            }
        })
        .catch(error => {
            if (loader) loader.style.display = 'none';
            toastr.error('Something went wrong');
            console.error(error);
        });
});
</script> -->

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    */

    // Change this route name if your actual add-story route has another name
    const addStoryRoute = "{{ route('seller.add_story') }}";

    const storyPriceRoute = "{{ route('seller.getSellerStoryPrice') }}";


    /*
    |--------------------------------------------------------------------------
    | Upload Label Click
    |--------------------------------------------------------------------------
    */

    $("#bannerUploadLabel").on("click", function (e) {

        e.preventDefault();

        $("#banner_image_upload").click();

    });


    /*
    |--------------------------------------------------------------------------
    | File Selection - ONLY PREVIEW
    |--------------------------------------------------------------------------
    */

    $("#banner_image_upload").on("change", function (event) {

        const file = event.target.files[0];

        if (!file) {
            return;
        }

        const img = $("#bannerUploadedImg");
        const video = $("#bannerUploadedVideo");
        const placeholder = $("#bannerPlaceholderImg");

        // Hide everything first
        img.hide();
        video.hide();
        placeholder.hide();


        /*
        |--------------------------------------------------------------------------
        | Video Preview
        |--------------------------------------------------------------------------
        */

        if (file.type.startsWith("video/")) {

            const videoURL = URL.createObjectURL(file);

            video.attr("src", videoURL);
            video.show();

        }


        /*
        |--------------------------------------------------------------------------
        | Image Preview
        |--------------------------------------------------------------------------
        */

        else if (file.type.startsWith("image/")) {

            const reader = new FileReader();

            reader.onload = function (e) {

                img.attr("src", e.target.result);
                img.show();

            };

            reader.readAsDataURL(file);

        }


        /*
        |--------------------------------------------------------------------------
        | Invalid File
        |--------------------------------------------------------------------------
        */

        else {

            toastr.error("Please select a valid image or video.");

            $("#banner_image_upload").val("");

            placeholder.show();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Free / Paid Selection
    |--------------------------------------------------------------------------
    */

    $(".profile-radio").on("change", function () {

        const selectedType = $(this).val();

        if (selectedType === "paid") {

            $(".paidPnl").slideDown();

        } else {

            $(".paidPnl").slideUp();

            // Clear paid fields
            $("#story_start_date").val("");
            $("#story_price").val("");

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Paid Date Change - Fetch Price
    |--------------------------------------------------------------------------
    */

    $("#story_start_date").on("change", function () {

        const selectedDate = $(this).val();

        if (!selectedDate) {
            return;
        }


        const countryId = $("#country_id").val();

        if (!countryId) {

            toastr.error("Country is required.");

            return;
        }


        // Clear old price while fetching
        $("#story_price").val("");


        $.ajax({

            url: storyPriceRoute,

            type: "POST",

            data: {

                country_id: countryId,

                no_of_days: 1,

                _token: "{{ csrf_token() }}"

            },

            beforeSend: function () {

                $("#story_price").val("Loading...");

            },

            success: function (response) {

                if (response.status == "success") {

                    $("#story_price").val(response.data.total_amount);

                } else {

                    $("#story_price").val("");

                    toastr.error(
                        response.message || "Unable to fetch story price."
                    );

                }

            },

            error: function (xhr) {

                $("#story_price").val("");

                let message = "Something went wrong.";

                if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {
                    message = xhr.responseJSON.message;
                }

                toastr.error(message);

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Post Story
    |--------------------------------------------------------------------------
    */

    $("#postStoryBtn").on("click", function () {

        const fileInput = $("#banner_image_upload")[0];

        const file = fileInput.files[0];

        const selectedType = $('input[name="filter"]:checked').val();


        /*
        |--------------------------------------------------------------------------
        | Validate File
        |--------------------------------------------------------------------------
        */

        if (!file) {

            toastr.error("Please select an image or video.");

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Type
        |--------------------------------------------------------------------------
        */

        if (!selectedType) {

            toastr.error("Please select story type.");

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Prepare FormData
        |--------------------------------------------------------------------------
        */

        let formData = new FormData();

        formData.append("file", file);


        /*
        |--------------------------------------------------------------------------
        | FREE STORY
        |--------------------------------------------------------------------------
        */

        if (selectedType === "free") {

            formData.append("is_promotional", "0");

        }


        /*
        |--------------------------------------------------------------------------
        | PAID STORY
        |--------------------------------------------------------------------------
        */

        if (selectedType === "paid") {

            const startDate = $("#story_start_date").val();

            const amount = $("#story_price").val();


            // Date validation
            if (!startDate) {

                toastr.error("Please select a date.");

                return;

            }


            // Price validation
            if (!amount || amount === "Loading...") {

                toastr.error("Please wait until the price is fetched.");

                return;

            }


            formData.append("is_promotional", "1");

            formData.append("start_date", startDate);

            formData.append("amount", amount);

        }


        /*
        |--------------------------------------------------------------------------
        | AJAX - ADD STORY
        |--------------------------------------------------------------------------
        */

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

                $("#postStoryBtn")
                    .prop("disabled", true)
                    .text("Posting...");

            },

            success: function (response) {

                if (response.status === "success") {

                    toastr.success(
                        response.message || "Story posted successfully."
                    );


                    setTimeout(function () {

                        location.reload();

                    }, 1500);

                } else {

                    toastr.error(
                        response.message || "Unable to post story."
                    );

                }

            },

            error: function (xhr) {

                let message = "Something went wrong.";

                if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {
                    message = xhr.responseJSON.message;
                }

                /*
                |--------------------------------------------------------------------------
                | Laravel Validation Errors
                |--------------------------------------------------------------------------
                */

                if (
                    xhr.status === 422 &&
                    xhr.responseJSON &&
                    xhr.responseJSON.errors
                ) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {

                        if (Array.isArray(value)) {

                            toastr.error(value[0]);

                        } else {

                            toastr.error(value);

                        }

                    });

                } else {

                    toastr.error(message);

                }

            },

            complete: function () {

                $("#postStoryBtn")
                    .prop("disabled", false)
                    .text("Post On Profile");

            }

        });

    });

});

</script>

<!-- upload from gallery -->
<script>
document.querySelector('.add-fillbtn').addEventListener('click', async function() {
    const img = document.getElementById('storyimg12');
    const video = document.getElementById('storyvideo12');
    const loader = document.getElementById('loader');

    let fileUrl = null;

    if (img.style.display !== 'none' && img.src) {
        fileUrl = img.src; // existing image URL
    } else if (video.style.display !== 'none' && video.src) {
        fileUrl = video.src; // existing video URL
    }

    if (!fileUrl) {
        toastr.error("No preview found to save.");
        return;
    }

    try {
        if (loader) loader.style.display = 'block';

        const formData = new FormData();
        formData.append('file', fileUrl);

        const response = await fetch("{{ route('seller.upload_story_from_gallery') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: formData
        });

        const data = await response.json();

        if (loader) loader.style.display = 'none';

        if (response.status === 422) {
            toastr.error(data.message || 'Validation error');
            return;
        }

        if (data.status === 'success') {
            toastr.success(data.message || 'Story added successfully');
            setTimeout(() => location.reload(), 1500);
        } else if (data.status === 'failed') {
            toastr.error(data.message || 'Upload failed');

            setTimeout(() => {
                window.location.href = "{{ route('seller.all_plans') }}";
            }, 1500);

        } else {
            toastr.error(data.message || 'Something went wrong');
        }

    } catch (error) {
        if (loader) loader.style.display = 'none';
        toastr.error('Something went wrong');
        console.error(error);
    }
});
</script>

<!-- delete story -->
<script>
document.body.addEventListener('click', function(e) {

    const deleteBtn = e.target.closest('.deleteStoryBtn');
    if (deleteBtn) {
        e.stopPropagation(); // 
        const storyId = deleteBtn.getAttribute('data-id');
        if (!storyId) return;

        // if (!confirm("Are you sure you want to delete this highlight?")) return;

        const originalHTML = deleteBtn.innerHTML;
        // deleteBtn.innerHTML = "Deleting...";
        deleteBtn.style.pointerEvents = "none";

        fetch(`/seller/delete_story/${storyId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                deleteBtn.innerHTML = originalHTML;
                deleteBtn.style.pointerEvents = "auto";

                if (data.status === "success") {
                    toastr.success(data.message || "Highlight deleted");
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(data.message || "Failed to delete highlight");
                }
            })
            .catch(err => {
                console.error(err);
                deleteBtn.innerHTML = originalHTML;
                deleteBtn.style.pointerEvents = "auto";
                toastr.error("Something went wrong");
            });

        return;
    }


});
</script>





@include('dealer.layout.footer');
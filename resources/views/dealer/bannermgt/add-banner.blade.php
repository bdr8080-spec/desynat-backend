@include('dealer.layout.header')

<section class="section dashboard">
    <!-- <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a class="title24 alink"> <i class="bi bi-chevron-left"></i>Details</a>
 
    </div> -->
    <div class="d-flex justify-content-between mt-4">
        <a class="title24 alink"> <i class="bi bi-chevron-left"></i>Add New Banner</a>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="col-md-6">

                <!-- Banner Position -->
                <label class="banner-text">Banner position</label>
                <div
                    class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 pe-3 justify-content-between">

                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="banner_position" value="home_top">
                            <span class="custom-radio"></span>
                            <span class="radio-label">Home Top</span>
                        </label>
                    </div>

                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="banner_position" value="home_bottom">
                            <span class="custom-radio"></span>
                            <span class="radio-label">Home Bottom</span>
                        </label>
                    </div>

                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="banner_position" value="category">
                            <span class="custom-radio"></span>
                            <span class="radio-label">Category</span>
                        </label>
                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <!-- Duration -->
                <div class="d-flex justify-content-between mt-4">
                    <h6 class="banner-texts">Select Duration</h6>
                    <span class="banner-texts">Total days - 07</span>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="banner-text">From</label>
                        <input type="date" class="form-control mb-4" />
                    </div>
                    <div class="col-md-6">
                        <label class="banner-text">To</label>
                        <input type="date" class="form-control" />
                    </div>
                </div>

            </div>
<div class="col-lg-12">
    <div class="product-pnls mt-3">
        <div class="upload-image" style="height:170px;width:270px;">
            <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">

                <!-- Placeholder -->
                <img id="bannerPlaceholderImg" src="assets/img/upload-icon.svg"
                    style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">

                <!-- Uploaded Image -->
                <img id="bannerUploadedImg" src=""
                    style="width:100px;display:none;object-fit:cover;border-radius:6px;height:110px;">

                <div class="py-2" style="color:#875C3A">
                    Upload Banner Image
                </div>

                <!-- SINGLE IMAGE -->
                <input type="file" accept="image/*" id="banner_image_upload" style="opacity:0;"
                    name="banner_image">

            </label>
        </div>
    </div>

</div>

        </div>
    </div>

    </div>
    <div class="mb-5">
        <div class="dashboard-button d-flex mt-5 gap-5">
            <button type="button" class="btn total-outline w-100">Total Price <strong>499KD</strong></button>
            <button type="submit" class="btn add-fillbtn w-100">Send Request</button>
        </div>


</section>
<script>
document.getElementById('banner_image_upload').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('bannerUploadedImg').src = e.target.result;
        document.getElementById('bannerUploadedImg').style.display = 'block';
        document.getElementById('bannerPlaceholderImg').style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>


@include('dealer.layout.custom_code');
@include('dealer.layout.footer');
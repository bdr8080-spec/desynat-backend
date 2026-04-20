@include('dealer.layout.header')

<section class="section dashboard">
  
    <div class="d-flex justify-content-between mt-4">
        <a href="#" class="title24 alink"> <i class="bi bi-chevron-left"></i>Add Staff </a>
    </div>

    <form id="addBanner" action="#" method="post">
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="product-pnls2 mt-3">
                    <div class="upload-image" style="height:250px;">
                        <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">
                            <!-- Placeholder -->
                            <div id="bannerPlaceholderImg">
                                <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                    style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                                <div class="py-2" style="color:#875C3A">
                                    Upload Banner
                                </div>
                            </div>
                            <!-- Uploaded Image -->
                            <img id="bannerUploadedImg" src="" alt="image" class="img-fluid uploadbnr"
                                style="display:none;">
                            <!-- SINGLE IMAGE -->
                            <input type="file" accept="image/*" id="banner_image_upload"
                                style="opacity:0;position: absolute;" name="upload_banner">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Full Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Full name">
                
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Full Name</label>
                        <span>In Arabic</span>
                    </div>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Full name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Phone Number</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Phone Number">
                
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Email</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Email">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="banner-text">Select Category</label>
                <div class="group-radio-btn d-flex gap-5 align-items-center flex-wrap py-3 pe-3">

                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="banner_position" value="1" checked>
                            <span class="custom-radio"></span>
                            <span class="radio-label">Manager</span>
                        </label>
                    </div>

                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="banner_position" value="2">
                            <span class="custom-radio"></span>
                            <span class="radio-label">Officer </span>
                        </label>
                    </div>

                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="banner_position" value="3">
                            <span class="custom-radio"></span>
                            <span class="radio-label">Sales employee</span>
                        </label>
                    </div>
                </div>
            </div>
          
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Password</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Password">
                
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Confirm Password</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Confirm Password">
                </div>
            </div>
        </div>


        <div class="mb-5">
            <div class="dashboard-button  mt-5 gap-5">
                <button type="submit" class="btn add-fillbtn w-100">Submit</button>
            </div>

        </div>

    </form>

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
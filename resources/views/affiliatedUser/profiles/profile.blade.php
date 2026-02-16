@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Profile Details </div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">Personal Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-address-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-address" type="button" role="tab" aria-controls="pills-active"
                    aria-selected="false">Address</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-inactive-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-bank" type="button" role="tab" aria-controls="pills-bank"
                    aria-selected="false">Bank information</button>
            </li>

        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                aria-labelledby="pills-allproduct-tab" tabindex="0">
                <div class="personl-wapper">
                    <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="showcircle">
                                <img id="profileShow" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                <img id="demoProfile" src="{{ asset('/dealer') }}/assets/img/profile-img.jpg" class="img-fluid">
                            </div>
                            <label class="change-title position-relative">
                                <h6>Change Image </h6>
                                <input type="file" accept="image/*" id="profileUpload" style="opacity:0;position: absolute;">
                            </label>
                        </div>
                        <a class="drop-profile" href="/change-password">
                            <span>Change Password</span>
                        </a>
                       
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>First Name</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter First Name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form position-relative">
                                <div class="label-flex">
                                    <label>Mobile No.</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Mobile Number">
                                <a class="drop-profile mob-change" href="#">
                                    <span>Change</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form position-relative">
                                <div class="label-flex">
                                    <label>Mobile No.</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Mobile Number">
                                <a class="drop-profile mob-change" href="#">
                                    <span>Change</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="product-pnls mt-4">
                                <div class="upload-image me-3" style="height:170px;width: 270px;">
                                    <label id="uploadLabel"
                                        style="cursor:pointer;text-align:center;display:block;">
                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                            style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                        <div class="py-2" style="color:#875C3A">Document 1</div>
                                        <input type="file" accept="image/*" id="imageUpload"
                                            style="opacity:0;" name="upload_proof">
                                    </label>
                                    <div class="removebtn1 topremove" style="display:none;">X</div>
                                    <img id="imagePreview" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                </div>

                                <div class="upload-image" style="height:170px;width: 270px;">
                                    <label id="uploadLabel2"
                                        style="cursor:pointer;text-align:center;display:block;">
                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                            style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                        <div class="py-2" style="color:#875C3A">Document 1</div>
                                        <input type="file" accept="image/*" id="imageUpload2"
                                            style="opacity:0;" name="upload_proof">
                                    </label>

                                    <div class="removebtn topremove" style="display:none;">X</div>
                                    <img id="imagePreview2" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="dashboard-button mt-5">
                        <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                    </div>

                </div>

            </div>

            <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab"
                tabindex="0">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Address</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter address">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Block/Street</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter Block/Street">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>House no./Building no/Area</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter House no./Building no/Area">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Postal Code(Optional)</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter Postal code">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>City/District</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter City/District">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>State</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter State">
                        </div>
                    </div>
                </div>
                <div class="dashboard-button mt-5">
                    <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                </div>


            </div>

            <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab" tabindex="0">

                <div class="p-2 rounded-4 desc-box bg-white">
                    <div class="bankpnl d-flex justify-content-between p-2 align-items-center">
                        <div class="account-no">AE6675656566</div>
                        <div class="banktool">
                            <a href="#">
                                <img src="{{ asset('/dealer') }}/assets/img/b-edit.svg" alt="edit icon" class="img-fluid"> 
                            </a>
                            <a href="#">
                                <img src="{{ asset('/dealer') }}/assets/img/b-delete.svg" alt="delete icon" class="img-fluid"> 
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</section>




@include('affiliatedUser.layout.footer')

<script>
$('#profileUpload').on('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        $('#profileShow').attr('src', e.target.result).show();
        $('#demoProfile').hide();
    };
    reader.readAsDataURL(file);
});



$('#imageUpload').on('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        $('#imagePreview').attr('src', e.target.result).show();
        $('#uploadLabel').hide();
        $('.removebtn1').show();
    };
    reader.readAsDataURL(file);
});

$('.removebtn1').on('click', function () {
    $('#imagePreview').attr('src', '').hide();   
    $('#imageUpload').val('');                   
    $('#uploadLabel').show();                    
    $(this).hide();                               
});

$('#imageUpload2').on('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        $('#imagePreview2').attr('src', e.target.result).show();
        $('#uploadLabel2').hide();
        $('.removebtn').show();
    };
    reader.readAsDataURL(file);
});

$('.removebtn').on('click', function () {
    $('#imagePreview2').attr('src', '').hide();   
    $('#imageUpload2').val('');                   
    $('#uploadLabel2').show();                    
    $(this).hide();                               
});

</script>
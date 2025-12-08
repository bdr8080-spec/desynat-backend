@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a href="{{route('seller.dashboard')}}" style="color:rgb(57, 55, 55)" class="title24">
            <i class="bi bi-chevron-left"></i> Edit
        </a> 

    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">Personal Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-active-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active"
                    aria-selected="false">Documents & Bank Details</button>
            </li>
        </ul>
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                aria-labelledby="pills-allproduct-tab" tabindex="0">

                <div class="personl-wapper">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                                <div class="showcircle">
                                    <img id="previewProfile" src="{{asset('dealer/assets/img/imagebnr.png')}}" class="img-fluid">
                                </div>
                                <label class="img_changes">
                                    <h6>Change Image</h6>
                                    <input type="file" id="uploadImage2" class="form-control" accept="image/*">
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Name</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Mobile No.</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Mobile number" >
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Email Id</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Email id" >
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                                <div class="store-img">
                                    <img id="previewImg" src="{{asset('dealer/assets/img/imagebnr.png')}}" class="img-fluid">
                                </div>
                                <label class="img_changes">
                                    <h6>Change Image</h6>
                                    <input type="file" id="uploadImage" class="form-control" accept="image/*">
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Store name</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter store name" >
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Choose Country</label>
                                </div>
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option value="1">India</option>
                                    <option value="2">Nepal</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Store Address</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter store address" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Address line 1</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter address line 1" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Address line 2</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter address line 2" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Store Phone Number</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Phone number" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Store mail id </label>
                                </div>
                                <input type="text" class="form-control" placeholder="store email" >
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Bio </label>
                                </div>
                                <textarea rows="3" class="form-control" placeholder="Write a text..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-button mt-4">
                        <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab"
                tabindex="0">
               
                <div class="personl-wapper">
                    <div class="pt-3">
                        <div class="title24">Bank details</div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 pe-3 justify-content-between">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="personal" checked>
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">Personal</span>
                                        </label>
                                    </div>
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="personal">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">Business</span>
                                        </label>
                                    </div>
                                   
                                </div>
                               
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>IBAN</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter IBAN">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>SWIFT/BIC</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter SWIFT/BIC" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Bank Name</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Bank Name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Account holder Name</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Account holder name">
                            </div>
                        </div>
                       

                        <div class="col-lg-12 col-md-12">
                            <div class="product-pnls mt-4">
                                <div class="upload-image" style="height:170px;width: 270px;">
                                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg" style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                        <div class="py-2" style="color:#875C3A">Upload Size Chart</div>
                                        <input type="file" accept="image/*" multiple id="edit_uploadChart" style="opacity:0;">
                                    </label>
                                </div>

                                <div class="upload-passbook" style="display:none;">
                                    <img id="placeholderImg">
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="dashboard-button mt-4">
                        <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                    </div>
                </div>

            </div>


        </div>


    </div>

</section>



@include('dealer.layout.footer');

<script>
    $("#uploadImage").change(function(event) {
        const file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $("#previewImg").attr("src", e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $("#uploadImage2").change(function(event) {
        const file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $("#previewProfile").attr("src", e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $("#edit_uploadChart").on("change", function(event) {
        let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $("#placeholderImg").attr("src", e.target.result);
                    $(".upload-passbook").show(); // show div
                }
                reader.readAsDataURL(file);
            }
    });


</script>
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

                <form id="editprofile" action="{{ route('seller.editprofile') }}" method="post">

                    @csrf
                    <div class="personl-wapper">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                                    <div class="showcircle">
                                        <input type="hidden" value="{{$seller_details->profile_pic}}"
                                            name="old_profile_pic">
                                        <img id="previewProfile" src="{{$seller_details->profile_pic}}"
                                            class="img-fluid">
                                    </div>
                                    <label class="img_changes">
                                        <h6>Change Image</h6>
                                        <input type="file" id="uploadImage2" class="form-control" accept="image/*"
                                            name="profile_pic">
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>First Name</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter name" name="first_name"
                                        value="{{$seller_details->first_name}}">

                                    <p class="text-danger" id="error-first_name"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Last Name</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter Last Name"
                                        name="last_name" value="{{$seller_details->last_name}}">
                                    <p class="text-danger" id="error-last_name"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Mobile No.</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Mobile number" readonly
                                        value="{{$seller_details->mobile}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Email Id</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Email id" readonly
                                        value="{{$seller_details->email}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                                    <div class="store-img">
                                        <img id="previewImg" src="{{ $seller_details->store_info->store_image }}"
                                            class="img-fluid">
                                    </div>
                                    <label class="img_changes">
                                        <h6>Change Image</h6>
                                        <input type="file" id="uploadImage" class="form-control" accept="image/*"
                                            name="store_image">

                                        <input type="hidden" value="{{$seller_details->store_info->store_image}}"
                                            name="old_store_image">


                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Store name</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter store name"
                                        value="{{ $seller_details->store_info->store_name }}" name="store_name">
                                    <p class="text-danger" id="error-store_name"></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Choose Country</label>
                                    </div>
                                    <select class="form-select form-control" aria-label="Default select example"
                                        name="country">

                                        @foreach($all_country as $key=>$value)
                                        <option value="{{$value->id}}" @if($seller_details->
                                            store_info->country==$value->id)
                                            selected @endif >{{$value->name}}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <p class="text-danger" id="error-country"></p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Store Address</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter store address"
                                        name="store_address" value="{{$seller_details->store_info->store_address}}">
                                </div>
                                <p class="text-danger" id="error-store_address"></p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Address line 1</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter address line 1"
                                        name="address_line1" value="{{$seller_details->store_info->address_line1}}">
                                    <p class="text-danger" id="error-address_line1"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Address line 2</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter address line 2"
                                        name="address_line2" value="{{$seller_details->store_info->address_line2}}">
                                    <p class="text-danger" id="error-address_line2"></p>
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Store Phone Number</label>
                                    </div>

                                    <select class="form-select form-control" aria-label="Default select example"
                                        name="country_code" @foreach($all_country as $key=>$value)
                                        <option value="{{$value->dial_code}}" @if($seller_details->
                                            store_info->country_code==$value->dial_code)
                                            selected @endif >{{$value->dial_code}}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" class="form-control" placeholder="Phone number"
                                        name="store_phone" value="{{$seller_details->store_info->store_phone}}">
                                    <p class="text-danger" id="error-store_phone"></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Store mail id </label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="store email"
                                        name="store_mail_id" value="{{$seller_details->store_info->store_mail_id}}">

                                    <p class="text-danger" id="error-store_mail_id"></p>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Bio </label>
                                    </div>
                                    <textarea rows="3" class="form-control" name="bio"
                                        placeholder="Write a text..."> {{$seller_details->store_info->bio}}</textarea>

                                    <p class="text-danger" id="error-store_mail_id"></p>
                                </div>
                            </div>
                        </div>

                        <div class="dashboard-button mt-4">
                            <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                        </div>
                    </div>

                </form>

            </div>


            <div class="tab-pane fade" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab"
                tabindex="0">

                <form id="editbankdetails" action="{{ route('seller.editbankdetails') }}" method="post"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="personl-wapper">
                        <div class="pt-3">
                            <div class="title24">Bank details</div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div
                                        class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 pe-3 justify-content-between">
                                        <div class="check_radio">
                                            <label class="radio-group">
                                                <input type="radio" name="account_type" value="0"
                                                    @if(@$seller_details->seller_bank_details->account_type=='0')
                                                checked
                                                @endif>
                                                <span class="custom-radio"></span>
                                                <span class="radio-label">Personal</span>
                                            </label>
                                        </div>
                                        <div class="check_radio">
                                            <label class="radio-group">
                                                <input type="radio" name="account_type" value="1"
                                                    @if(@$seller_details->seller_bank_details->account_type=='1')
                                                checked
                                                @endif>
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
                                    <input type="text" class="form-control" placeholder="Enter IBAN" name="iban"
                                        value="{{ @$seller_details->seller_bank_details->iban }}">
                                    <p class="text-danger" id="error-iban"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>SWIFT/BIC</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter SWIFT/BIC" name="swift"
                                        value="{{ @$seller_details->seller_bank_details->swift }}">
                                    <p class="text-danger" id="error-iban"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Bank Name</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter Bank Name"
                                        name="bank_name" value="{{ @$seller_details->seller_bank_details->bank_name }}">
                                    <p class="text-danger" id="error-bank_name"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Account holder Name</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Enter Account holder name"
                                        name="account_holder_name"
                                        value="{{ @$seller_details->seller_bank_details->account_holder_name }}">
                                    <p class="text-danger" id="error-account_holder_name"></p>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12">
                                <div class="product-pnls mt-4">
                                    <div class="upload-image" style="height:170px;width: 270px;">
                                        <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                                style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                            <div class="py-2" style="color:#875C3A">Upload Size Chart</div>
                                            <input type="file" accept="image/*" multiple id="edit_uploadChart"
                                                style="opacity:0;" name="upload_proof">
                                        </label>
                                    </div>


                                    <input type="hidden" class="form-control" name="old_upload_proof"
                                        id="old_upload_proof"
                                        value="{{ @$seller_details->seller_bank_details->upload_proof }}">


                                    <div class="upload-passbook" style="">
                                        <img id="placeholderImg"
                                            src="{{ @$seller_details->seller_bank_details->upload_proof }}">
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="dashboard-button mt-4">
                            <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                        </div>
                    </div>

                </form>

            </div>


        </div>


    </div>

</section>



@include('dealer.layout.custom_code');

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

// Update Profile Update Code

$(document).on('submit', 'form#editprofile', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $("#file-error").html("");

    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

    $('.submit').attr('disabled', true);
    // $('.form-control').attr('readonly', true).addClass('disabled-link');
    $('.error-control').addClass('disabled-link');

    if ($('.submit').html() !== loadingText) {
        $('.submit').html(loadingText);
    }

    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        // beforeSend: function() {
        //     // Show loader
        //     $('#loader').show();
        // },
        success: function(response) {
            console.log(response);

            window.setTimeout(function() {
                $('.customBtn, .form-control').attr('disabled', false).removeClass(
                    'disabled-link');
                $('.submit').html('Upload');
            }, 2000);

            if (response.status === 'success') {
                toastr.success(response.message);

                $('.submit').attr('disabled', true);
                window.setTimeout(function() {
                    window.location = "{{ route('seller.view_profile') }}";
                }, 2000);
            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

            $.each(errors, function(field, messages) {

                console.log(field);

                let errorId = "#error-" + field;

                $(errorId).html(messages[0]);


                // 1️⃣ Handle array fields with index → product_spe_en.0
                if (field.includes(".")) {

                    let parts = field.split(".");
                    let fieldName = parts[0];
                    let index = parts[1];
                    let index1 = parts[2];


                    // Example → #error-product_spe_en_0

                    let errorId = "#error-" + fieldName + "_" + index;

                    // If second index exists, append it
                    if (typeof index1 !== "undefined" && index1 !== "") {
                        errorId += "_" + index1;
                    }
                    $(errorId).html(messages[0]);


                } else {

                    // 2️⃣ File special case
                    if (field === "file") {
                        $("#file-error").html(messages[0]);
                    }

                    // 3️⃣ Handle whole array errors (custom rule)
                    $("#error-" + field).html(messages[0]);
                }
            });
        },
        // complete: function() {
        //     // Hide loader (after success or error)
        //     $('#loader').hide();
        // }


    });

    return false;
});

// upDate Bank details Code 

$(document).on('submit', 'form#editbankdetails', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $("#file-error").html("");

    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

    $('.submit').attr('disabled', true);
    // $('.form-control').attr('readonly', true).addClass('disabled-link');
    $('.error-control').addClass('disabled-link');

    if ($('.submit').html() !== loadingText) {
        $('.submit').html(loadingText);
    }

    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        // beforeSend: function() {
        //     // Show loader
        //     $('#loader').show();
        // },
        success: function(response) {
            console.log(response);

            window.setTimeout(function() {
                $('.customBtn, .form-control').attr('disabled', false).removeClass(
                    'disabled-link');
                $('.submit').html('Upload');
            }, 2000);

            if (response.status === 'success') {
                toastr.success(response.message);

                $('.submit').attr('disabled', true);
                window.setTimeout(function() {
                    window.location = "{{ route('seller.view_profile') }}";
                }, 2000);
            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

            $.each(errors, function(field, messages) {

                // 1️⃣ Handle array fields with index → product_spe_en.0
                if (field.includes(".")) {

                    let parts = field.split(".");
                    let fieldName = parts[0];
                    let index = parts[1];
                    let index1 = parts[2];


                    // Example → #error-product_spe_en_0

                    let errorId = "#error-" + fieldName + "_" + index;

                    // If second index exists, append it
                    if (typeof index1 !== "undefined" && index1 !== "") {
                        errorId += "_" + index1;
                    }
                    $(errorId).html(messages[0]);


                } else {

                    // 2️⃣ File special case
                    if (field === "file") {
                        $("#file-error").html(messages[0]);
                    }

                    // 3️⃣ Handle whole array errors (custom rule)
                    $("#error-" + field).html(messages[0]);
                }
            });
        },
        // complete: function() {
        //     // Hide loader (after success or error)
        //     $('#loader').hide();
        // }


    });

    return false;
});
</script>
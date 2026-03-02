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
                                <img id="profileShow"
                                    style="display:none;width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                <img id="demoProfile" src="{{ asset('/dealer') }}/assets/img/profile-img.jpg"
                                    class="img-fluid">
                            </div>
                            <label class="change-title position-relative">
                                <h6>Change Image </h6>
                                <input type="file" accept="image/*" id="profileUpload"
                                    style="opacity:0;position: absolute;">
                            </label>
                        </div>
                        <a class="drop-profile" href="{{route('affiliate.change-password')}}">
                            <span>Change Password</span>
                        </a>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>First Name</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter First Name"
                                    value="{{$affilatedUser->full_name }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form position-relative">
                                <div class="label-flex">
                                    <label>Mobile No.</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Mobile Number"
                                    value="{{$affilatedUser->mobile }}" readonly>
                                <a class="drop-profile mob-change" href="#">
                                    <span>Change</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form position-relative">
                                <div class="label-flex">
                                    <label>Email Address</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Email Address"
                                    value="{{$affilatedUser->email}}" readonly>
                                <a class="drop-profile mob-change" href="#">
                                    <span>Change</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="product-pnls mt-4">
                                <div class="upload-image me-3" style="height:170px;width: 270px;">
                                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:none">
                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                            style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                        <div class="py-2" style="color:#875C3A">Document 1</div>
                                        <input type="file" accept="image/*" id="imageUpload" style="opacity:0;"
                                            name="upload_proof">
                                    </label>
                                    <div class="removebtn1 topremove" style="">X</div>
                                    <img id="imagePreview"
                                        style="width:100%;height:100%;object-fit:cover;border-radius:6px;"
                                        src="{{$affilatedUser->document1 }}">
                                </div>

                                <input type="hidden" name="old_document1" value="{{$affilatedUser->document1 }}">
                                <input type="hidden" name="old_document2" value="{{$affilatedUser->document2 }}">

                                <div class="upload-image" style="height:170px;width: 270px;">
                                    <label id="uploadLabel2" style="cursor:pointer;text-align:center;display:none;">
                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                            style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                        <div class="py-2" style="color:#875C3A">Document 1</div>
                                        <input type="file" accept="image/*" id="imageUpload2" style="opacity:0;"
                                            name="upload_proof">
                                    </label>

                                    <div class="removebtn topremove" style="">X</div>
                                    <img id="imagePreview2"
                                        style="width:100%;height:100%;object-fit:cover;border-radius:6px;"
                                        src="{{$affilatedUser->document2 }}">
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


                    <div class="col-lg-12 col-md-12">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Country </label>
                            </div>
                            <select name="country" class="form-control">
                                @foreach($country as $val)
                                <option name="{{$val->id}}" @if($val->id== $affilatedUser->address_details->country)
                                    selected @endif > {{$val->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>location </label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter location"
                                value="{{$affilatedUser->address_details->locations }}">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Address 1</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter address"
                                value="{{$affilatedUser->address_details->address1 }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Address 2</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter Address 2"
                                value="{{$affilatedUser->address_details->address2 }}">
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>House no./Building no/Area</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter House no./Building no/Area">
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Postal Code(Optional)</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter Postal code" value="{{$affilatedUser->address_details->address2 }}">
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
                    </div> -->
                </div>
                <div class="dashboard-button mt-5">
                    <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                </div>


            </div>

            <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab" tabindex="0">

                @foreach($affilatedUser->bank_details as $key=>$val)
                <div class="rounded-4 desc-box bg-white mb-3">
                    <div class="bankpnl d-flex justify-content-between align-items-center line2">
                        <div class="account-no">{{$val->account_no}}</div>
                        <div class="banktool">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editbankDetails">
                                <img src="{{ asset('/dealer') }}/assets/img/b-edit.svg" alt="edit icon"
                                    class="img-fluid">
                            </a>
                            <a href="#">
                                <img src="{{ asset('/dealer') }}/assets/img/b-delete.svg" alt="delete icon"
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>

                @endforeach

                <div class="addanother d-flex gap-2" data-bs-toggle="modal" data-bs-target="#bankDetails">
                    <i class="bi bi-plus-lg"></i> <h5 class="mb-0">Add another account</h5>
                </div>


            </div>
        </div>
    </div>

</section>


<!-- Add bank details -->
<div class="modal fade" id="bankDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered w-75">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Add Account </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="account-form">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Bank name</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Bank name ">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Account Holder name</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Account Holder name">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Account Number</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Account Number">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Confirm Account Number</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Re-Enter Account Number">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>IBAN</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter IBAN">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>SWIFT/BIC</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Swift">
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-success w-100 lh-2"> Submit Request</button>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Edit bank details -->
<div class="modal fade" id="editbankDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered w-75">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Edit Account </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="account-form">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Bank name</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Bank name ">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Account Holder name</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Account Holder name">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Account Number</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Account Number">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Confirm Account Number</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Re-Enter Account Number">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>IBAN</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter IBAN">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>SWIFT/BIC</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Swift">
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-success w-100 lh-2"> Submit Request</button>
            </div>
        </div>
    </div>
  </div>
</div>

@include('affiliatedUser.layout.footer')

<script>
$('#profileUpload').on('change', function() {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        $('#profileShow').attr('src', e.target.result).show();
        $('#demoProfile').hide();
    };
    reader.readAsDataURL(file);
});



$('#imageUpload').on('change', function() {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result).show();
        $('#uploadLabel').hide();
        $('.removebtn1').show();
    };
    reader.readAsDataURL(file);
});

$('.removebtn1').on('click', function() {
    $('#imagePreview').attr('src', '').hide();
    $('#imageUpload').val('');
    $('#uploadLabel').show();
    $(this).hide();
});

$('#imageUpload2').on('change', function() {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        $('#imagePreview2').attr('src', e.target.result).show();
        $('#uploadLabel2').hide();
        $('.removebtn').show();
    };
    reader.readAsDataURL(file);
});

$('.removebtn').on('click', function() {
    $('#imagePreview2').attr('src', '').hide();
    $('#imageUpload2').val('');
    $('#uploadLabel2').show();
    $(this).hide();
});
</script>
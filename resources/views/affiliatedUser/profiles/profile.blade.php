@include('affiliatedUser.layout.header')

 <style>
    .country-option:hover {
        background-color: #f8f9fa;
    }

    .country-option img {
        border-radius: 2px;
    }

    .dropdown-menu {
        min-width: 250px;
    }

    #countrySearch {
        border-radius: 6px;
    }

    .pac-container {
        z-index: 9999;
    }
    </style>


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
               
               <form id="SaveProfileForm" action="{{route('affiliate.affiliatesaveprofile')}}" method="post" enctype="multipart/form-data">
               
                @csrf

                <div class="personl-wapper">
                    <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="showcircle">
                                <img id="profileShow"
                                    style="display:none;width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                <img id="demoProfile" src="{{$affilatedUser->profile_image }}"
                                    class="img-fluid">
                            </div>
                            <label class="change-title position-relative">
                                <h6>Change Image </h6>
                                <input type="file" accept="image/*" id="profileUpload"
                                    style="opacity:0;position: absolute;" name="profile_image">
                              
                                <input type="hidden" accept="image/*" name="old_profile_image" value="{{$affilatedUser->profile_image }}"
                                    style="opacity:0;position: absolute;">
                              
                            </label>
                        </div>
                        <a class="drop-profile change-length" href="{{route('affiliate.change-password')}}">
                            <span> <i class="bi bi-lock"></i> Change Password </span>
                        </a>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Full Name</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Full Name"
                                    value="{{$affilatedUser->full_name }}" name="full_name">
                                <p class="text-danger" id="error-full_name"></p>
                                       
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form position-relative">
                                <div class="label-flex">
                                    <label>Mobile No.</label>
                                </div>
                                <input type="text" class="form-control readpnl" placeholder="Enter Mobile Number"
                                    value="{{$affilatedUser->country_code }}{{$affilatedUser->mobile }}" readonly>
                                <a class="drop-profile mob-change" href="{{ route('affiliate.userOldNumberSendOtp', [
                        'mobile' => $affilatedUser->mobile,
                        'country_code' => $affilatedUser->country_code,
                        'for' => 'mobile',
                        'type' => '0'
                    ]) }}">
                                    <span>Change</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form position-relative">
                                <div class="label-flex">
                                    <label>Email Address</label>
                                </div>
                                <input type="text" class="form-control readpnl" placeholder="Enter Email Address"
                                    value="{{$affilatedUser->email}}" readonly>
                                <a class="drop-profile mob-change"  href="{{ route('affiliate.userOldNumberSendOtp', [
                        'email' => $affilatedUser->email,
                        'for' => 'email',
                        'type' => '0'
                    ]) }}">
                                    <span>Change</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="product-pnls mt-4">
                            <div>
                                <div class="upload-image me-3" style="height:170px;width: 270px;">
                                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:none">
                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                            style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                        <div class="py-2" style="color:#875C3A">Document 1</div>
                                        <input type="file" accept="image/*" id="imageUpload" style="opacity:0;"
                                            name="document1"  >
                                    </label>
                                    <div class="removebtn1 topremove" style="">X</div>
                                    <img id="imagePreview"
                                        style="width:100%;height:100%;object-fit:cover;border-radius:6px;"
                                        src="{{$affilatedUser->document1 }}">
                                    </div>
                                    <p class="text-danger" id="error-document1"></p>
                                </div>
                                <input type="hidden" name="old_document1" id="old_document1" value="{{$affilatedUser->document1 }}">
                                <input type="hidden" name="old_document2" id="old_document2" value="{{$affilatedUser->document2 }}">

                                <div>
                                    <div class="upload-image" style="height:170px;width: 270px;">
                                        <label id="uploadLabel2" style="cursor:pointer;text-align:center;display:none;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                                style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                            <div class="py-2" style="color:#875C3A">Document 1</div>
                                            <input type="file" accept="image/*" id="imageUpload2" style="opacity:0;"
                                            name="document2">
                                        </label>

                                        <div class="removebtn topremove" style="">X</div>
                                        <img id="imagePreview2"
                                            style="width:100%;height:100%;object-fit:cover;border-radius:6px;"
                                            src="{{$affilatedUser->document2 }}">
                                        </div>
                                        <p class="text-danger" id="error-document2"></p>   
                                    </div>                               
                            </div>

                        </div>
                    </div>

                    <div class="dashboard-button mt-5">
                        <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                    </div>

                </div>
            </form>

            </div>

            {{-- Address tabs Start here  --}}

            <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab"
                tabindex="0">

                <form id="Affiliate_AddAddress" action="{{route('affiliate.affiliateProfilesaveAddress')}}"  method="Post">

                    @csrf

                <div class="row">

                    <div class="col-lg-12 col-md-12">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Country </label>
                            </div>
                            <select name="country" class="form-control">
                                @foreach($country as $val)
                                <option value="{{$val->id}}" @if($val->id== $affilatedUser->address_details->country)
                                    selected @endif  {{$val->id}} -- {{$affilatedUser->address_details->country}} > {{$val->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                

                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form position-relative">
                            <div class="label-flex">
                                <label>location </label>
                            </div>
                            <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Enter location"
                                value="{{$affilatedUser->address_details->locations }}"  name="locations" id="store_address">

                                <button class="btn gpsmap" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#gpspanel" aria-controls="offcanvasExample">
                                            <i class="bi bi-crosshair"></i>
                                            </button>
                                </div>               


                        </div>
                        <p class="text-danger" id="error-locations"></p> 
                    </div>
                    <input type="hidden" id="lat" name="let"
                                    value="{{ old('let', @$affilatedUser->address_details->let) }}">
                        <input type="hidden" id="lng" name="long"
                                        value="{{ old('long', @$affilatedUser->address_details->long) }}">


                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Address 1</label>
                            </div>
                            <input type="text" name="address1" class="form-control" placeholder="Enter address"
                                value="{{$affilatedUser->address_details->address1 }}" id="address_line1">
                                
                        <p class="text-danger" id="error-address1"></p> 
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6" style="display:none;">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Address 2</label>
                            </div>
                            <input type="text" name="address2" class="form-control" placeholder="Enter Address 2"
                                value="{{$affilatedUser->address_details->address2 }}" id="address_line2">
                        </div>
                        
                        <p class="text-danger" id="error-address2"></p>
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

                </form>

            </div>


            
    <div class="offcanvas offcanvas-end" tabindex="-1" id="gpspanel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Set Location</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="gps-wapper">

                <div class="setup-maps mb-0 position-relative">


                    <input id="searchBox" type="text" placeholder="Search your address"
                        class="form-control position-absolute"
                        style="top:10px;left:10px;width:300px;z-index:9999;padding:6px 10px;border-radius:4px;">

                    <div id="googleMap" style="width: 100%; height: 500px;"></div>

                    <div id="useCurrentLocation" class="mt-3 cursor-pointer">
                        <i class="bi bi-crosshair"></i> Use Current Location
                    </div>
                </div>

                <div class="find-location d-flex gap-3 py-4">
                    <div><i class="bi bi-geo-alt-fill"></i></div>
                    <p class="mb-0" id="selectedAddress"> </p>
                </div>

                <!-- Hidden inputs -->
                <input type="hidden" id="lat" name="lat">
                <input type="hidden" id="lng" name="lng">

                <!-- Done button -->
                <div class="setup-done">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="offcanvas">Done</button>
                </div>
            </div>
        </div>
    </div>



            {{-- save address Code end Here  --}}



            <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab" tabindex="0">

                @foreach($affilatedUser->bank_details as $key=>$val)
                <div class="rounded-4 desc-box bg-white mb-3">
                       
                    <div class="bankpnl d-flex justify-content-between align-items-center line2">
                        <div class="check_radio d-flex gap-2">
                            <label class="radio-group">
                                <input type="radio" name="today" checked>
                                <span class="custom-radio"></span>
                                <span class="radio-label"></span>
                            </label>
                            <div class="account-no">{{$val->account_no}}</div>
                        </div>

                        <div class="banktool">
                            <!-- <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editbankDetails">
                                <img src="{{ asset('/dealer') }}/assets/img/b-edit.svg" alt="edit icon"
                                    class="img-fluid">
                            </a> -->
                            <a href="javascript:void(0)"
                            class="editBankBtn"
                            data-id="{{$val->id}}"
                            data-affiliate="{{$affilatedUser->id}}"
                            data-bank_name="{{$val->bank_name}}"
                            data-holder="{{$val->account_holder_name}}"
                            data-account="{{$val->account_no}}"
                            data-iban="{{$val->iban}}"
                            data-swift="{{$val->swift}}"
                            data-bs-toggle="modal"
                            data-bs-target="#editbankDetails">
                                <img src="{{ asset('/dealer') }}/assets/img/b-edit.svg" class="img-fluid">
                            </a>
                            <a href="#">
                                <img src="{{ asset('/dealer') }}/assets/img/b-delete.svg" alt="delete icon"
                                    class="img-fluid deleteAccount" data-id="{{$val->id}}">
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
<div class="modal fade" id="bankDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered w-75">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title fs-5">Add Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="account-form">

          <div class="sub-form mb-2">
            <label>Bank Name</label>
            <input type="text" id="bank_name" class="form-control">
            <small class="text-danger" id="error_bank_name"></small>
          </div>

          <div class="sub-form mb-2">
            <label>Account Holder Name</label>
            <input type="text" id="account_holder_name" class="form-control">
            <small class="text-danger" id="error_account_holder_name"></small>
          </div>

          <div class="sub-form mb-2">
            <label>Account Number</label>
            <input type="text" id="account_no" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <small class="text-danger" id="error_account_no"></small>
          </div>

          <div class="sub-form mb-2">
            <label>Confirm Account Number</label>
            <input type="text" id="confirm_account_no" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <small class="text-danger" id="error_confirm_account_no"></small>
          </div>

          <div class="sub-form mb-2">
            <label>IBAN</label>
            <input type="text" id="iban" class="form-control">
            <small class="text-danger" id="error_iban"></small>
          </div>

          <div class="sub-form mb-2">
            <label>SWIFT / BIC</label>
            <input type="text" id="swift" class="form-control">
            <small class="text-danger" id="error_swift"></small>
          </div>

        </div>

        <div class="text-center mt-4">
          <button type="button" id="submit_bank_btn" class="btn btn-success w-100">
            Submit 
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Edit bank details -->
<div class="modal fade" id="editbankDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered w-75">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title fs-5">Edit Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <input type="hidden" id="edit_bank_id">

        <div class="account-form">

          <!-- Bank Name -->
          <div class="sub-form mb-2">
            <label>Bank Name</label>
            <input type="text" id="edit_bank_name" class="form-control">
            <small class="text-danger error-text" id="error_edit_bank_name"></small>
          </div>

          <!-- Account Holder Name -->
          <div class="sub-form mb-2">
            <label>Account Holder Name</label>
            <input type="text" id="edit_account_holder_name" class="form-control">
            <small class="text-danger error-text" id="error_edit_account_holder_name"></small>
          </div>

          <!-- Account Number -->
          <div class="sub-form mb-2">
            <label>Account Number</label>
            <input type="text" id="edit_account_no" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <small class="text-danger error-text" id="error_edit_account_no"></small>
          </div>

          <!-- Confirm Account Number -->
          <div class="sub-form mb-2">
            <label>Confirm Account Number</label>
            <input type="text" id="edit_confirm_account_no" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <small class="text-danger error-text" id="error_edit_confirm_account_no"></small>
          </div>

          <!-- IBAN -->
          <div class="sub-form mb-2">
            <label>IBAN</label>
            <input type="text" id="edit_iban" class="form-control">
            <small class="text-danger error-text" id="error_edit_iban"></small>
          </div>

          <!-- SWIFT -->
          <div class="sub-form mb-2">
            <label>SWIFT / BIC</label>
            <input type="text" id="edit_swift" class="form-control">
            <small class="text-danger error-text" id="error_edit_swift"></small>
          </div>

        </div>

        <div class="text-center mt-4">
          <button type="button" id="edit_submit_bank_btn" class="btn btn-success w-100">
            Update
          </button>
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
    $('#old_document1').val('');



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

    $('#old_document2').val('');


});
</script>

<!-- edit bank details -->
<script>
let affiliateUserId = '';

$(document).on('click', '.editBankBtn', function () {


    let bankId = $(this).data('id');

    affiliateUserId = $(this).data('affiliate');
    //console.log(affiliateUserId);

    $('#edit_bank_id').val(bankId);
    $('#edit_bank_name').val($(this).data('bank_name'));
    $('#edit_account_holder_name').val($(this).data('holder'));
    $('#edit_account_no').val($(this).data('account'));
    $('#edit_confirm_account_no').val($(this).data('account'));
    $('#edit_iban').val($(this).data('iban'));
    $('#edit_swift').val($(this).data('swift'));

});

function clearErrors() {
    $('.error-text').text('');
}

function showError(field, message) {
    $('#error_' + field).text(message);
}

/* Remove error while typing */
$(document).on('input', '#editbankDetails input', function () {
    let fieldId = $(this).attr('id');
    $('#error_' + fieldId).text('');
});

$('#edit_submit_bank_btn').on('click', function () {

    clearErrors();

    let bankName = $('#edit_bank_name').val().trim();
    let holder = $('#edit_account_holder_name').val().trim();
    let accountNo = $('#edit_account_no').val().trim();
    let confirmAccountNo = $('#edit_confirm_account_no').val().trim();
    let iban = $('#edit_iban').val().trim();
    let swift = $('#edit_swift').val().trim();

    let isValid = true;

    if (bankName === '') {
        showError('edit_bank_name', 'Please enter bank name');
        isValid = false;
    }

    if (holder === '') {
        showError('edit_account_holder_name', 'Please enter account holder name');
        isValid = false;
    }

    if (accountNo === '') {
        showError('edit_account_no', 'Please enter account number');
        isValid = false;
    }

    if (confirmAccountNo === '') {
        showError('edit_confirm_account_no', 'Please confirm account number');
        isValid = false;
    }

    if (accountNo !== '' && confirmAccountNo !== '' && accountNo !== confirmAccountNo) {
        showError('edit_confirm_account_no', 'Account numbers do not match');
        isValid = false;
    }

    if (iban === '') {
        showError('edit_iban', 'Please enter IBAN');
        isValid = false;
    }

    if (swift === '') {
        showError('edit_swift', 'Please enter SWIFT');
        isValid = false;
    }

    if (!isValid) return;

    /* ================= AJAX CALL ================= */

    $.ajax({
        url: "{{ url('/affiliate/updateBankAccountDetails') }}/" + $('#edit_bank_id').val(),
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            bank_name: bankName,
            account_holder_name: holder,
            account_no: accountNo,
            confirm_account_no: confirmAccountNo,
            iban: iban,
            swift: swift,
            affilated_user: affiliateUserId
        },
        beforeSend: function () {
            $('#edit_submit_bank_btn').prop('disabled', true).text('Processing...');
        },
        success: function (response) {

            if (response.status === 'success') {

                toastr.success(response.message);

                setTimeout(function () {
                    location.reload();
                }, 2000);

            } else {
                toastr.error(response.message);
            }
        },
        complete: function () {
            $('#edit_submit_bank_btn').prop('disabled', false).text('Submit Request');
        }
    });

});
</script>

<!-- add bank account -->
<script>
$(document).ready(function() {

    function clearErrors() {
        $('[id^="error_"]').text('');
    }

    function showError(fieldId, message) {
        $('#error_' + fieldId).text(message);
    }

    $(document).on('input', '#bankDetails input', function () {
        let fieldId = $(this).attr('id');
        $('#error_' + fieldId).text('');
    });

    $('#submit_bank_btn').on('click', function() {

        clearErrors();

        let bankName = $('#bank_name').val().trim();
        let accountHolder = $('#account_holder_name').val().trim();
        let accountNo = $('#account_no').val().trim();
        let confirmAccountNo = $('#confirm_account_no').val().trim();
        let iban = $('#iban').val().trim();
        let swift = $('#swift').val().trim();

        let isValid = true;

        if(bankName === '') {
            showError('bank_name', 'Please enter bank name');
            isValid = false;
        }

        if(accountHolder === '') {
            showError('account_holder_name', 'Please enter account holder name');
            isValid = false;
        }

        if(accountNo === '') {
            showError('account_no', 'Please enter account number');
            isValid = false;
        }

        if(confirmAccountNo === '') {
            showError('confirm_account_no', 'Please confirm account number');
            isValid = false;
        }

        if(accountNo !== '' && confirmAccountNo !== '' && accountNo !== confirmAccountNo) {
            showError('confirm_account_no', 'Account numbers do not match');
            isValid = false;
        }

        if(iban === '') {
            showError('iban', 'Please enter IBAN');
            isValid = false;
        }

        if(swift === '') {
            showError('swift', 'Please enter SWIFT/BIC');
            isValid = false;
        }

        if(!isValid) return;

        $.ajax({
            url: "{{ route('affiliate.addAnotherBankDetails') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                bank_name: bankName,
                account_holder_name: accountHolder,
                account_no: accountNo,
                confirm_account_no: confirmAccountNo,
                iban: iban,
                swift: swift,
            },
            beforeSend: function() {
                $('#submit_bank_btn').prop('disabled', true).text('Processing...');
            },
            success: function(response) {
                if(response.status === 'success') {
                    toastr.success(response.message);
                    $('#bankDetails').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error("Something went wrong");
                }
            },
            complete: function() {
                $('#submit_bank_btn').prop('disabled', false).text('Submit Request');
            }
        });

    });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // 1️⃣ Restore last active tab
    let activeTab = localStorage.getItem("active_product_tab");
    if (activeTab) {
        let tabEl = document.querySelector(`[data-bs-target="${activeTab}"]`);
        if (tabEl) {
            new bootstrap.Tab(tabEl).show();
        }
    }

    // 2️⃣ Save clicked tab
    document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tabBtn => {
        tabBtn.addEventListener("shown.bs.tab", function(e) {
            localStorage.setItem("active_product_tab", e.target.getAttribute(
                "data-bs-target"));
        });
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.deleteAccount').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/affiliate/deleteBankAccount/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status == "success"){
                            toastr.success(data.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr.error(data.message);
                        }
                    })
                    .catch(error => {
                        //console.error("Full Error:", error);
                        toastr.error(error.message || "Something went wrong.");
                    });
                }
            });
        });
    });
});


// save profile Code Start

$(document).on('submit', 'form#SaveProfileForm', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $(".text-danger").html("");

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
        beforeSend: function() {
            //     // Show loader
            $('#loader').show();
        },
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

                setTimeout(() => {
                     location.href =
                        "{{ route('affiliate.affiliateProfile') }}";                  
                }, 1000);

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
        complete: function() {
            // Hide loader (after success or error)
            $('#loader').hide();
        }


    });

    return false;
});
// save profile code End here

</script>

{{-- // Google map code Start here  --}}

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&callback=initMap&libraries=places"
    async defer>
</script>


<script>
let map, marker, circle, autocomplete;
let mapInitialized = false;

debugger;

// IDs of input fields
const address1Id = "address_line1";
const address2Id = "address_line2";
// const cityId = "city";
// const pincodeId = "pincode";
// const countryId = "country";
const searchBoxId = "searchBox";
const latId = "lat";
const lngId = "lng";
const selectedAddressId = "selectedAddress";
const selectedAddressStore_address = "store_address";

// selectedAddress
debugger;

function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const currentLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                loadMap(currentLocation);
            },
            () => loadMap({
                lat: 0,
                lng: 0
            }), {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
        debugger;

    } else {
        loadMap({
            lat: 0,
            lng: 0
        });
    }
}

function loadMap(loc) {
    map = new google.maps.Map(document.getElementById("googleMap"), {
        center: loc,
        zoom: 13
    });

    marker = new google.maps.Marker({
        position: loc,
        map,
        draggable: true
    });

    circle = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.3,
        map,
        center: loc,
        radius: 300
    });

    const input = document.getElementById(searchBoxId);

    // Clear input fields on map load
    // cityId, pincodeId, countryId
    [latId, lngId, address1Id, address2Id].forEach(id => {
        // document.getElementById(id).value = "";
    });
    input.value = "";
    document.getElementById(selectedAddressId).textContent = "";

    // Autocomplete setup
    autocomplete = new google.maps.places.Autocomplete(input, {
        fields: ["geometry", "name", "formatted_address", "address_components"]
    });
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) return;
        updateLocation(place.geometry.location, place);
    });

    // Manual address input on blur
    input.addEventListener("blur", () => {
        const address = input.value.trim();
        if (!address) return;
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                updateLocation(results[0].geometry.location, results[0]);
            } else {
                // alert("Address not found!");
            }
        });
    });

    // Marker drag event
    marker.addListener("dragend", () => {
        updateLocation(marker.getPosition());
    });

    // Current location button
    document.getElementById("useCurrentLocation").addEventListener("click", () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    updateLocation({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });
                },
                () => alert("Failed to retrieve your location."), {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            alert("Geolocation is not supported.");
        }
    });
}

function updateLocation(loc, placeData = null) {
    map.setCenter(loc);
    map.setZoom(15);
    marker.setPosition(loc);
    circle.setCenter(loc);

    const lat = typeof loc.lat === "function" ? loc.lat() : loc.lat;
    const lng = typeof loc.lng === "function" ? loc.lng() : loc.lng;

    document.getElementById(latId).value = lat;
    document.getElementById(lngId).value = lng;

    const geocoder = new google.maps.Geocoder();

    if (placeData && placeData.address_components) {
        populateAddressFields(placeData);
    } else {
        // Reverse geocode
        geocoder.geocode({
            location: {
                lat,
                lng
            }
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                populateAddressFields(results[0]);
            } else {
                alert("Failed to retrieve address for this location.");
            }
        });
    }
}

function populateAddressFields(place) {
    const addr = place.formatted_address || "";
    document.getElementById(searchBoxId).value = addr;

    let city = "",
        state = "",
        zip = "",
        country = "";

    place.address_components.forEach(c => {

        // console.log(c);
        // if (c.types.includes("locality")) city = c.long_name;
        // if (c.types.includes("administrative_area_level_1")) state = c.long_name;
        // if (c.types.includes("postal_code")) zip = c.long_name;
        // if (c.types.includes("country")) country = c.long_name;
    });

    const addrParts = addr.split(",");

    console.log(addrParts);

    // // Remove city, state, zip, country from line 2
    // let addrLine2Parts = addrParts.slice(2).map(part => part.trim());
    // addrLine2Parts = addrLine2Parts.filter(part => {
    //     part = part.trim().toLowerCase();
    //     return part &&
    //         (!city || !part.includes(city.toLowerCase())) &&
    //         (!state || !part.includes(state.toLowerCase())) &&
    //         (!zip || !part.includes(zip.toLowerCase())) &&
    //         (!country || !part.includes(country.toLowerCase())) &&
    //         !part.includes("usa");
    // });

    document.getElementById(address1Id).value = addrParts.slice(0, 2).join(",").trim();
    document.getElementById(address2Id).value = addrParts.slice(2, 5).join(",").trim();

    document.getElementById(selectedAddressStore_address).value = addrParts;



    // document.getElementById(cityId).value = city;
    // document.getElementById(pincodeId).value = zip;
    // document.getElementById(countryId).value = country;

    // Optional: display full address somewhere
    document.getElementById(selectedAddressId).textContent = addr;
}

// Initialize map when offcanvas opens
document.addEventListener("DOMContentLoaded", () => {
    const gpsPanel = document.getElementById("gpspanel");
    const openMapBtn = document.querySelector('[data-bs-target="#gpspanel"]');

    if (gpsPanel && openMapBtn) {
        gpsPanel.addEventListener("shown.bs.offcanvas", () => {
            if (!mapInitialized) {
                setTimeout(() => {
                    initMap();
                    mapInitialized = true;
                }, 300);
            } else {
                setTimeout(() => {
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(marker.getPosition());
                }, 300);
            }
        });
    }
});



$(document).ready(function() {
    // When user types in any input or textarea
    $(document).on('input', '.form-control, .form-check-input', function() {
        // Check if input has a value (not empty)
        if ($(this).val().trim() !== '') {
            // Remove the nearby error message
            $(this).closest('.form-group').find('.text-danger').fadeOut(200, function() {
                $(this).remove();
            });
        }
    });
});


// google mapo Code End here 


// form save Address Code Start here 


$(document).on('submit', 'form#Affiliate_AddAddress', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $(".text-danger").html("");

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
        beforeSend: function() {
            //     // Show loader
            $('#loader').show();
        },
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

                setTimeout(() => {
                    window.location.reload();
                    // location.href =
                    //     `affiliate-add-Bank-details?temp_user_id=${response.id}`;
                }, 1000);

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
        complete: function() {
            // Hide loader (after success or error)
            $('#loader').hide();
        }


    });

    return false;
});


// Form save Address Code End here 



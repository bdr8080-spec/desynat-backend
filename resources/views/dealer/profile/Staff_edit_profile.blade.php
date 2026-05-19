@include('dealer.layout.header')


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



<div class="onepage mb-5">
    <section class="section dashboard container">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
            <a href="{{route('seller.staff_edit_profile')}}" style="color:rgb(57, 55, 55)" class="title24">
                <i class="bi bi-chevron-left"></i> {{ __('seller_messages.Edit') }}
            </a>
        </div>

        <div class="tabs-panel py-4">
            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                        aria-selected="true">{{ __('seller_messages.Personal_Info') }}</button>
                </li>
            </ul>
        </div>



        <div class="tab-body-wapper">
            <div class="tab-content" id="pills-tabContent">



                <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                    aria-labelledby="pills-allproduct-tab" tabindex="0">

                    <form id="editprofile" action="{{ route('seller.Staffeditprofile') }}" method="post">

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
                                            <h6>{{ __('seller_messages.Change_Image') }}</h6>
                                            <input type="file" id="uploadImage2" class="form-control" accept="image/*"
                                                name="profile_pic">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.First_Name') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.Enter_First_Name') }}" name="first_name"
                                            value="{{$seller_details->first_name}}">

                                        <p class="text-danger" id="error-first_name"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.First_Name_Arabic') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.First_Name_Arabic') }}" name="name_ar"
                                            value="{{$seller_details->name_ar}}">
                                        <p class="text-danger" id="error-name_ar"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Mobile_No') }}</label>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Mobile number" readonly
                                            value="{{$seller_details->country_code}} {{$seller_details->mobile}}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Email_Id') }}</label>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Email id" readonly
                                            value="{{$seller_details->email}}">
                                    </div>
                                </div>
                              
                            </div>

                            <div class="dashboard-button mt-4">
                                <button type="submit" class="btn add-fillbtn w-100">{{ __('seller_messages.Save_Changes') }}</button>
                            </div>
                        </div>

                    </form>

                </div>


            </div>


        </div>

    </section>
</div>



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
                    window.location = "{{ route('seller.staff_edit_profile') }}";
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

<script>
$(document).ready(function() {
    // When a user selects a country (clicks a label)
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });


    $(document).on('click', '.country-option1', function() {
        let radio = $(this).find('.country-radio1');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag1').html('');
        $('#selected-code1').text(flag + ' ' + ' ' + name);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown1').dropdown('hide');
    });

});
</script>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Desynat Bank Details </title>
    <!-- Favicons -->
    <link href="{{ asset('/dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">

</head>

<body>

    <div class="login-header">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('/dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('/dealer') }}/assets/img/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-wapper">
        <div class="container-fluid p-0">
            <div class="login-grid-bg">
                <div class="row g-0">
                    <div class="col-lg-6 bg-logo-wapper">
                        <div class="login-img">
                            <img src="{{ asset('/dealer') }}/assets/img/Desynat-logo-2.svg" alt="image"
                                class="img-fluid logo-login">
                        </div>
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-right.svg" alt="image" class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2 signup-scroll pagescroll p-3">
                                <div class="cmn-header mb-3">
                                    <h1><a href="#"><i class="bi bi-chevron-left"></i></a> Bank Details </h1>
                                </div>

                                <form method="Post" id="Affiliate_AddBankDetails"
                                    action="{{route('affiliate.affiliateAddBankDetails')}}">
                                    <div class="step-progress py-4">
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="affilated_id" value="{{$id}}">

                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Bank Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Bank Name"
                                            name="bank_name"
                                            value="{{ old('bank_name', @$affiliate_bank->bank_name) }}">
                                        <p class="text-danger" id="error-bank_name"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Account Holder Name </label>
                                        <input type="text" class="form-control applyAlphabetSpaceOnly"
                                            placeholder="Enter Account Holder Name" name="account_holder_name"
                                            value="{{ old('account_holder_name', @$affiliate_bank->account_holder_name) }}">
                                        <p class="text-danger" id="error-account_holder_name"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name"> Account Number </label>
                                        <input type="text" class="form-control applynumberOnly"
                                            placeholder="Enter Account Number" name="account_no"
                                            value="{{ old('account_no', @$affiliate_bank->account_no) }}"
                                            maxlength="20">
                                        <p class="text-danger" id="error-account_no"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Confirm Account Number </label>
                                        <input type="text" class="form-control applynumberOnly"
                                            placeholder="Re-Enter Account Number" name="confirm_account_no"
                                            value="{{ old('confirm_account_no', @$affiliate_bank->account_no) }}"
                                            maxlength="20">
                                        <p class="text-danger" id="error-confirm_account_no"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">IBAN</label>
                                        <input type="text" class="form-control applyAlphabetSpaceOnly"
                                            placeholder="Enter IBAN" name="iban"
                                            value="{{ old('iban', @$affiliate_bank->iban) }}">
                                        <p class="text-danger" id="error-iban"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name"> SWIFT/BIC</label>
                                        <input type="text" class="form-control" placeholder="Enter Swift" name="swift"
                                            value="{{ old('swift', @$affiliate_bank->swift) }}" maxlength="15">
                                        <p class="text-danger" id="error-swift"></p>
                                    </div>
                                    <div class="login-btn mt-5">
                                        <input type="submit" class="btn btn-success w-100" value="Submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>




<!-- Vendor JS Files -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>
<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>


@include('dealer.layout.custom_code')


<script>
$(document).on('submit', 'form#Affiliate_AddBankDetails', function(event) {
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
                        `review_submit_page?temp_user_id=${response.id}`;
                    `?temp_user_id=${response.id}`;
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
</script>

</html>
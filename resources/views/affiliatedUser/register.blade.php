<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ __('affiliate_messages.desynat_affiliate') }}</title>
    <!-- Favicons -->
    <link href="{{ asset('/dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" />
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
</head>

<body>

    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(255,255,255,0.7); z-index:9999; text-align:center; padding-top:200px;">
        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"></iframe>
    </div>

    <div class="login-header">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('/dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('/dealer') }}/assets/img/global.svg" class="img-fluid" /> @if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" data-lang="ar" href="{{route('userLanguage','ar')}}"><span>{{ __('admin_messages.ar') }}</span> {{ __('affiliate_messages.arabic') }}</a></li>
                    <li><a class="dropdown-item" data-lang="en" href="{{route('userLanguage','en')}}"><span>{{ __('admin_messages.en') }}</span> {{ __('affiliate_messages.english') }}</a></li>
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

                                <form id="Affiliate_CreateAccountForm"
                                    action="{{ route('affiliate.affiliate_signup') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <h1>{{ __('affiliate_messages.sign_up') }} <br><span class="gold-color">{{ __('affiliate_messages.create_your_account') }} !</span></h1>
                                    <div class="step-progress py-4">
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>

                                    <div class="upload-image w-100">
                                        <label class="uploadLabel" id="label-3"
                                            style="cursor:pointer;text-align:center;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                            <div class="text-color-upload">{{ __('affiliate_messages.upload_profile_photo') }}</div>
                                            <input type="file" name="profile_image" accept="image/*" hidden
                                                onchange="showPreview(event,3)">
                                            <p class="text-danger ImageError3" id="error-profile_image"></p>
                                        </label>
                                        <div class="imgshow">
                                            <img id="preview-3"
                                                style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                            <span id="remove-3" class="remove-ic"
                                                style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                onclick="removeImg(3)">&times;</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">{{ __('affiliate_messages.full_name') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('affiliate_messages.enter_full_name') }}"
                                            name="full_name">

                                        <p class="text-danger" id="error-full_name"></p>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="d-block" for="">{{ __('affiliate_messages.mobile_number') }}</label>
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                {{-- <select name="country_code" id="" class="country" class="form-control">
                                @foreach ($country as $item)                       
                                    <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                                                @endforeach
                                                </select> --}}

                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                        type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">

                                                        <span id="selected-flag">
                                                            {{ old('country_flag', $country[0]->flag) }}
                                                        </span>

                                                        <span id="selected-code" class="ms-2">
                                                            {{ old('country_code', $country[0]->dial_code) }}
                                                        </span>
                                                    </button>

                                                    <ul class="dropdown-menu p-2 newcountrybox"
                                                        aria-labelledby="countryDropdown">

                                                        @foreach ($country as $index => $item)
                                                        <li>
                                                            <label
                                                                class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                                style="cursor: pointer;">
                                                                <input type="radio" name="country_code"
                                                                    value="{{ $item->dial_code }}"
                                                                    data-flag="{{ $item->flag }}"
                                                                    data-name="{{ App::getLocale() == 'en' ? $item->name : $item->name_ar }}" class="country-radio"
                                                                    {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                                    hidden>

                                                                <div width="25" height="16">
                                                                    <span>{{ $item->flag }} {{ $item->dial_code }}
                                                                        ({{ App::getLocale() == 'en' ? $item->name : $item->name_ar }})
                                                                    </span>
                                                                </div>

                                                            </label>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            </div>
                                            <div class="w-100">
                                                <input type="number" class="form-control" value=""
                                                    placeholder="{{ __('affiliate_messages.enter_mobile_number') }}" name="mobile"
                                                    oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">


                                            </div>
                                        </div>

                                        <p class="text-danger" id="error-mobile"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ __('affiliate_messages.email_address') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('affiliate_messages.enter_email_address') }}"
                                            name="email">
                                        <p class="text-danger" id="error-email"></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">{{ __('affiliate_messages.upload_document') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="upload-image w-100">
                                                    <label class="uploadLabel" id="label-1"
                                                        style="cursor:pointer;text-align:center;">
                                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                        <div class="text-color-upload">{{ __('affiliate_messages.document_1') }}</div>
                                                        <input type="file" name="document1" accept="image/*" hidden
                                                            onchange="showPreview(event,1)">
                                                    </label>
                                                    <div class="imgshow">
                                                        <img id="preview-1"
                                                            style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                        <span id="remove-1" class="remove-ic"
                                                            style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                            onclick="removeImg(1)">&times;</span>
                                                    </div>
                                                    <p class="text-danger ImageError1" id="error-document1"></p>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="upload-image w-100">
                                                    <label class="uploadLabel" id="label-2"
                                                        style="cursor:pointer;text-align:center;">
                                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                        <div class="text-color-upload">{{ __('affiliate_messages.document_2') }}</div>
                                                        <input type="file" name="document2" accept="image/*" hidden
                                                            onchange="showPreview(event,2)">
                                                    </label>
                                                    <div class="imgshow">
                                                        <img id="preview-2"
                                                            style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                        <span id="remove-2" class="remove-ic"
                                                            style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                            onclick="removeImg(2)">&times;</span>
                                                    </div>
                                                    <p class="text-danger ImageError2" id="error-document2"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password">{{ __('affiliate_messages.create_password') }}</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="{{ __('affiliate_messages.enter_password') }}" name="password" value="">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                    </div>
                                    <p class="text-danger" id="error-password"></p>
                                    <div class="form-group position-relative">
                                        <label for="password">{{ __('affiliate_messages.confirm_password') }}</label>
                                        <input type="password" class="form-control notapplyspace" id="confirm_password"
                                            placeholder="{{ __('affiliate_messages.enter_confirm_password') }}" name="confirm_password" value="">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                    </div>
                                    <p class="text-danger" id="error-confirm_password"></p>

                                    <div class="form-check py-3 form-group">
                                        <input class="form-check-input" type="checkbox" value="1" id="checkChecked"
                                            name="accept" {{ old('accept') ? 'checked' : '' }}>
                                        <label class="form-check-label mt-0" for="checkChecked">
                                            {{ __('affiliate_messages.i_accept_the') }} <span class="title-color">{{ __('affiliate_messages.terms_&_conditions') }} </span> {{ __('affiliate_messages.and') }}
                                            <span class="title-color">{{ __('affiliate_messages.policies') }}</span>
                                        </label>
                                        <p class="text-danger" id="error-accept"></p>
                                    </div>

                                    <div class="login-btn">

                                        <button type="submit"
                                            class="btn add-fillbtn w-100 btn btn-success w-100">{{ __('affiliate_messages.continue') }}</button>
                                    </div>
                                </form>

                                <div class="sign-new mt-2 text-center">
                                    <div>{{ __('affiliate_messages.already_have_an_account') }}? <a href="{{route('affiliate.affiliate_login')}}"
                                            class="link-color"> {{ __('affiliate_messages.sign_in') }}</a></div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Vendor JS Files -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<!-- <script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script> -->

<script>
$(document).ready(function() {
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });
});



$(".toggle-password").click(function() {
    $(this).toggleClass("bi-eye bi-eye-slash");
    input = $(this).parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
</script>

<script>
function showPreview(e, i) {
    const input = e.target;
    const img = document.getElementById(`preview-${i}`);
    const rm = document.getElementById(`remove-${i}`);
    const label = document.getElementById(`label-${i}`);

    if (!input.files.length) return;

    img.src = URL.createObjectURL(input.files[0]);
    img.style.display = rm.style.display = "block";
    label.style.display = "none";

    $('.ImageError' + i).html('');

    // 👇 allow same image re-upload
    // input.value = "";
}

function removeImg(i) {
    const img = document.getElementById(`preview-${i}`);
    const rm = document.getElementById(`remove-${i}`);
    const label = document.getElementById(`label-${i}`);

    img.src = "";
    img.style.display = rm.style.display = "none";
    label.style.display = "block";
}

$(document).on('submit', 'form#Affiliate_CreateAccountForm', function(event) {
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
                        `affiliate-verify-otp?temp_user_id=${response.id}&forget_password=two`;
                }, 1000);

            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            if (xhr.status == 400) {

                toastr.error(xhr.responseJSON.message);
            } else {


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


            }

        },
        complete: function() {
            // Hide loader (after success or error)
            $('#loader').hide();
        }


    });

    return false;
});
</script>


@include('dealer.layout.custom_code')


</html>
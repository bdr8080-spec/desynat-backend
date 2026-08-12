<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
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

    <style>
        .imgshowtwo {
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- <style>

        iframe#\:1\.container {
    visibility: hidden !important;
}

/* Hide the Google Translate tooltip */
.goog-te-banner-frame.skiptranslate,
.goog-tooltip,
.goog-tooltip:hover,
.goog-tooltip-vertical {
    display: none !important;
}

/* Hide the feedback popup on selected text */
#goog-gt-tt {
    display: none !important;
}
    </style>

    <style>
  body {
    visibility: hidden;
  }
</style> -->
</head>

<body>

    <div class="login-header">
        <div class="des-logo">
            <a href="#">
            <img src="{{ asset(app()->getLocale() == 'ar' ? 'dealer/assets/img/arabic-logo.svg' : 'dealer/assets/img/desynat-logo.svg') }}" class="img-fluid login" alt="Logo">
            </a>
        </div>
         <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                     <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif </span>


                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                     <li>
                                        <a class="dropdown-item" data-lang="ar" href="{{route('sellerLanguage','ar')}}" >
                                            <span>{{ __('admin_messages.ar') }}</span> {{ __('seller_messages.Arabic') }} 
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" data-lang="en"  href="{{route('sellerLanguage','en')}}" >
                                            <span>{{ __('admin_messages.en') }}</span> {{ __('seller_messages.English') }} 
                                        </a>
                                    </li>

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
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-right.svg" alt="image"
                            class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2 signup-scroll pagescroll p-3">
                                <div class="cmn-header mb-3">
                                    <h1><a href="{{ route('seller.store_information', Request()->id) }}"><i
                                                class="bi bi-chevron-left"></i></a> {{ __('seller_messages.upload_documents_bank_details') }}</h1>
                                </div>

                                <form action="{{ route('seller.upload_document', Request()->id) }}" method="post"
                                    enctype="multipart/form-data">

                                    @csrf

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

                                    @error('owner_document')
                                        <span class="text-danger" id="remove_error_message1">{{ $message }}</span>
                                    @enderror

                                    <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">{{ __('seller_messages.owners_documents') }} </label>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel"
                                                            style="cursor:pointer;text-align:center;">
                                                            <img
                                                                src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                            <div class="text-color-upload">{{ __('seller_messages.document_1') }}</div>
                                                            <input type="file" name="owner_document[]"
                                                                accept="image/*" hidden onchange="showPreview(event,1)">

                                                            <div class="imgshow">
                                                                {{-- <img class="preview1"
                                                                style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon1"
                                                                style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                onclick="removeImg(1)">&times;</span> --}}

                                                                <div class="imgshow">

                                                                    @if (isset($owner_document['0']))
                                                                        <input type="text" accept="image/*" hidden
                                                                            name="old_owner_document[]"
                                                                            class="inputImage1"
                                                                            value="{{ $owner_document['0']->document_path }}">

                                                                        <img class="preview1"
                                                                            src="{{ $owner_document['0']->document_path }}"
                                                                            style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                                                                        <span class="removeIcon1 removebtn"
                                                                            style="display:block;cursor:pointer;font-size:24px;color:red;"
                                                                            onclick="removeImg(1,{{ $owner_document['0']->id }})">&times;</span>
                                                                    @else
                                                                        <img class="preview1"
                                                                            style="display:none;max-width:100%;margin-top:10px;border-radius:8px;width=100%">
                                                                        <span class="removeIcon1 removebtn"
                                                                            style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                            onclick="removeImg(1)">&times;</span>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>



                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel"
                                                            style="cursor:pointer;text-align:center;">
                                                            <img
                                                                src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                            <div class="text-color-upload">{{ __('seller_messages.document_2') }}</div>
                                                            <input type="file" name="owner_document[]"
                                                                accept="image/*" hidden
                                                                onchange="showPreview(event,2)">

                                                            {{-- <div class="imgshow">
                                                            <img class="preview2"
                                                                style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon2"
                                                                style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                onclick="removeImg(2)">&times;</span>
                                                        </div> --}}

                                                            <div class="imgshow">
                                                                @if (isset($owner_document['1']))
                                                                    <input type="text" accept="image/*" hidden
                                                                        name="old_owner_document[]"
                                                                        class="inputImage2"
                                                                        value="{{ $owner_document['1']->document_path }}">

                                                                    <img class="preview2"
                                                                        src="{{ $owner_document['1']->document_path }}"
                                                                        style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                                                                    <span class="removeIcon2 removebtn"
                                                                        style="display:block;cursor:pointer;font-size:24px;color:red;"
                                                                        onclick="removeImg(2,{{ $owner_document['1']->id }})">&times;</span>
                                                                @else
                                                                    <img class="preview2"
                                                                        style="display:none;max-width:100%;margin-top:10px;border-radius:8px;width=100%">
                                                                    <span class="removeIcon2 removebtn"
                                                                        style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                        onclick="removeImg(2)">&times;</span>
                                                                @endif
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">{{ __('seller_messages.store_documents') }}</label>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel"
                                                            style="cursor:pointer;text-align:center;">
                                                            <img
                                                                src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                            <div class="text-color-upload">{{ __('seller_messages.document_1') }}</div>
                                                            <input type="file" name="store_document[]"
                                                                accept="image/*" hidden
                                                                onchange="showPreview(event,3)">

                                                            <div class="imgshow">

                                                                <div class="imgshow">
                                                                    @if (isset($store_document['0']))
                                                                        <input type="text" accept="image/*" hidden
                                                                            name="old_store_document[]"
                                                                            class="inputImage3"
                                                                            value="{{ $store_document['0']->document_path }}">

                                                                        <img class="preview3"
                                                                            src="{{ $store_document['0']->document_path }}"
                                                                            style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                                                                        <span class="removeIcon3 removebtn"
                                                                            style="display:block;cursor:pointer;font-size:24px;color:red;"
                                                                            onclick="removeImg(3,{{ $store_document['0']->id }})">&times;</span>
                                                                    @else
                                                                        <img class="preview3"
                                                                            style="display:none;max-width:100%;margin-top:10px;border-radius:8px;width=100%">
                                                                        <span class="removeIcon3 removebtn"
                                                                            style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                            onclick="removeImg(3)">&times;</span>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel"
                                                            style="cursor:pointer;text-align:center;">
                                                            <img
                                                                src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                            <div class="text-color-upload">{{ __('seller_messages.document_2') }}</div>
                                                            <input type="file" name="store_document[]"
                                                                accept="image/*" hidden
                                                                onchange="showPreview(event,4)">

                                                            {{-- <div class="imgshow">
                                                            <img class="preview4"
                                                                style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon4"
                                                                style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                onclick="removeImg(4)">&times;</span>
                                                        </div> --}}

                                                            <div class="imgshow">
                                                                @if (isset($store_document['1']))
                                                                    <input type="text" accept="image/*" hidden
                                                                        name="old_store_document[]"
                                                                        class="inputImage4"
                                                                        value="{{ $store_document['1']->document_path }}">

                                                                    <img class="preview4"
                                                                        src="{{ $store_document['1']->document_path }}"
                                                                        style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                                                                    <span class="removeIcon4 removebtn"
                                                                        style="display:block;cursor:pointer;font-size:24px;color:red;"
                                                                        onclick="removeImg(4,{{ $store_document['1']->id }})">&times;</span>
                                                                @else
                                                                    <img class="preview4"
                                                                        style="display:none;max-width:100%;margin-top:10px;border-radius:8px;width=100%">
                                                                    <span class="removeIcon4 removebtn"
                                                                        style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                        onclick="removeImg(4)">&times;</span>
                                                                @endif
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @error('store_document')
                                        <span class="text-danger" id="remove_error_message2">{{ $message }}</span>
                                    @enderror

                                    <div class="owner-pnl mt-4">
                                        <h5 class="mb-2">{{ __('seller_messages.bank_details') }}</h5>
                                        <div class="form-group">
                                            <label for="name">{{ __('seller_messages.account_type') }}</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="account_type" value="0"
                                                        @if (@$seller_bank->account_type == '0') checked @endif>
                                                    <label class="form-check-label mt-0" for="personal"> {{ __('seller_messages.personal') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="account_type" value="1"
                                                        @if (@$seller_bank->account_type == '1') checked @endif>
                                                    <label class="form-check-label mt-0" for="personal"> {{ __('seller_messages.business') }}
                                                    </label>
                                                </div>
                                            </div>

                                            @error('account_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="name">{{ __('seller_messages.iban') }}</label>
                                        <input type="text" minlength="7" maxlength="15" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.enter_iban_number') }}" name="iban"
                                            value="{{ old('iban', @$seller_bank->iban) }}">

                                        @error('iban')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="name">{{ __('seller_messages.swift_bic') }}</label>
                                        <input type="text" minlength="7" maxlength="15" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.enter_swift_bic_number') }}" name="swift"
                                            value="{{ old('bank_name', @$seller_bank->swift) }}">
                                        @error('swift')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="name">{{ __('seller_messages.bank_name') }}</label>
                                        <input type="text" maxlength="50" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.enter_bank_name') }}" name="bank_name"
                                            value="{{ old('bank_name', @$seller_bank->bank_name) }}">
                                        @error('bank_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="name">{{ __('seller_messages.account_holder_name') }}</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.enter_account_holder_name') }}" name="account_holder_name"
                                            value="{{ old('account_holder_name', @$seller_bank->account_holder_name) }}"
                                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                                        @error('account_holder_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <!-- <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">Upload proof of account</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel5" style="cursor:pointer;text-align:center;">
                                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"><div class="text-color-upload">Bank Statement or Bank Letter,PDF/JPG/PNG</div>
                                                            <input type="file" accept="image/*" hidden onchange="showPreview(event,5)" name="upload_proof">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview5" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon5" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">{{ __('seller_messages.upload_proof_of_account') }}</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel5"
                                                            style="cursor:pointer;text-align:center;">
                                                            <img
                                                                src="{{ asset('/dealer/assets/img/upload-icon.svg') }}">
                                                            <div class="text-color-upload">{{ __('seller_messages.upload_proof_of_account') }}
                                                            </div>
                                                            <input type="file" accept="image/*" hidden
                                                                onchange="showPreview(event,5)" name="upload_proof">
                                                        </label>



                                                        <div class="imgshow ">
                                                            {{-- ✅ Show preview if image already exists --}}
                                                            @if (!empty($seller_bank->upload_proof))
                                                                <input type="text" accept="image/*" hidden
                                                                    name="old_upload_proof" class="inputImage5"
                                                                    value="{{ $seller_bank->upload_proof }}">

                                                                <img class="preview5"
                                                                    src="{{ $seller_bank->upload_proof }}"
                                                                    style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                                                                <span class="removeIcon5 removebtn"
                                                                    style="display:block;cursor:pointer;font-size:24px;color:red;"
                                                                    onclick="removeImg(5)">&times;</span>
                                                            @else
                                                                <img class="preview5"
                                                                    style="display:none;max-width:100%;margin-top:10px;border-radius:8px;width=100%">
                                                                <span class="removeIcon5 removebtn"
                                                                    style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                                    onclick="removeImg(5)">&times;</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @error('upload_proof')
                                                        <span class="text-danger"
                                                            id="remove_error_message3">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="login-btn mt-5">

                                        <input type="submit" class="btn btn-success w-100" value="{{ __('seller_messages.continue') }}">

                                        <!-- <a href="summary_page.php" class="btn btn-success w-100">Continue</a> -->
                                    </div>

                                </form>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- <div id="google_translate_element" style="display:none;"></div>
<div id="loaderTrans"
        style="display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:#ffffff; 
        z-index:999999;   
        /* display:flex;    */
        align-items:center;
        justify-content:center;">

        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"
                style="border:none; width:200px; height:200px;">
        </iframe>
    </div> -->


</body>


<!-- Vendor JS Files -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js"></script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>

<script>
    function showPreview(e, id) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(x) {
                $('.preview' + id).attr('src', x.target.result).show();
                $('.removeIcon' + id).show();
                $('.uploadLabel' + id).hide();
            };
            reader.readAsDataURL(file);
        }

        if (id == 1 || id == 2) {
            $('#remove_error_message1').empty();
        }

        if (id == 3 || id == 4) {
            $('#remove_error_message2').empty();
        }
        if (id == 5) {
            $('#remove_error_message3').empty();
        }


    }

    function removeImg(id, o_id) {

        $('.preview' + id).attr('src', '').hide();
        $('.removeIcon' + id).hide();
        $('.uploadLabel' + id).show();

        if (o_id) {
            $('.inputImage' + id).remove();
            remove_image(o_id);

        }


    }


    // Remove Image Code

    function remove_image(val) {

        var id = val;

        $.ajax({
            url: "{{ route('seller.removeImage') }}", // keep route clean
            method: "POST", // use POST, not GET
            data: {
                id: id,
                _token: "{{ csrf_token() }}" // required for Laravel POST requests
            },

            success: function(resp) {
                if (resp.status == 'success') {
                    // location.href = "/";
                }

                if (resp.status == false) {
                    for (const key in resp.errors) {
                        console.log(resp.errors[key])
                        $(`#error-${key}`).html(resp.errors[key]);
                    }
                }

            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.message);
            },
            complete: function() {
                $('#loginButtom').prop('disabled', false);
            }
        });

    }
</script>

<!-- translator -->
<!-- <script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        autoDisplay: false
    }, 'google_translate_element');
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>

let currentLang = localStorage.getItem("selectedLang") || "en";
let translateReady = false;

/* WAIT FOR GOOGLE DROPDOWN (ROBUST VERSION) */
function waitForCombo(callback) {

    let attempts = 0;

    const timer = setInterval(() => {

        const combo = document.querySelector(".goog-te-combo");

        if (combo && combo.options.length > 1) {
            clearInterval(timer);
            translateReady = true;
            callback(combo);
        }

        attempts++;

        if (attempts > 30) {
            clearInterval(timer);
            console.warn("Google Translate not ready");
        }

    }, 200);
}


/* APPLY TRANSLATION (FIXED FIRST TIME ISSUE) */
function applyTranslation(lang) {

    const loader = document.getElementById("loaderTrans");
    if (loader) loader.style.display = "flex";

    currentLang = lang;
    localStorage.setItem("selectedLang", lang);

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // STEP 1: RESET
        trigger("en");

        setTimeout(() => {

            // STEP 2: APPLY LANGUAGE
            trigger(lang);

            // STEP 3: RETRY (VERY IMPORTANT FIX)
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                if (loader) loader.style.display = "none";

            }, 500);

        }, 300);

    });
}


/* UPDATE UI */
function updateUI(lang) {

    const current = document.getElementById("currentLang");
    if (current) current.innerText = lang.toUpperCase();

    document.querySelectorAll(".langu .dropdown-item")
        .forEach(el => el.style.background = "");

    const active = document.querySelector(`.langu .dropdown-item[data-lang="${lang}"]`);

    if (active) {
        active.style.background =
            "linear-gradient(73.47deg, #F9DBAB 0%, #7D532F 132.99%)";
    }
}


/* CLICK EVENTS */
document.querySelectorAll(".langu .dropdown-item").forEach(item => {

    item.addEventListener("click", function () {

        const lang = this.getAttribute("data-lang");

        // PREVENT CLICK BEFORE READY
        if (!translateReady) {
            console.log("Translate still loading...");
            return;
        }

        applyTranslation(lang);

    });

});


/* INITIAL LOAD */
function initLanguage() {

    const lang = localStorage.getItem("selectedLang") || "en";
    const loader = document.getElementById("loaderTrans");

    if (loader) loader.style.display = "flex";

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // RESET FIRST
        trigger("en");

        setTimeout(() => {

            trigger(lang);

            // RETRY FIX
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                // SHOW PAGE ONLY AFTER TRANSLATION
                document.body.style.visibility = "visible";

                if (loader) loader.style.display = "none";

            }, 600);

        }, 300);

    });

}

window.addEventListener("load", initLanguage);


/* BACK/FORWARD CACHE FIX */
window.addEventListener("pageshow", function (event) {

    if (event.persisted ||
        performance.getEntriesByType("navigation")[0]?.type === "back_forward") {

        setTimeout(() => {
            initLanguage();
        }, 200);
    }

});


/* HIDE GOOGLE TOOLTIP */
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.id === 'goog-gt-tt') {
                node.style.display = 'none';
            }
        });
    });
});

observer.observe(document.body, { childList: true, subtree: true });

</script> -->


@include('dealer.layout.custom_code')

</html>

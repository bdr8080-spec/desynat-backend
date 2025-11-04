<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Store Information</title>
    <!-- Favicons -->
    <link href="{{ asset('/dealer') }}/assets/img/favicon.png" rel="icon">
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

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif

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
                                    <h1><a href="{{ url()->previous() }}"><i class="bi bi-chevron-left"></i></a> Store
                                        information</h1>
                                </div>

                                <form action="{{ route('seller.store_information', request()->id) }}" method="Post">


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
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>

                                    <div class="upload-image w-100">
                                        <label id="uploadLabel" style="cursor:pointer;text-align:center;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                            <div>Upload Store Image </div>
                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)"
                                                id="edit_imageUpload">
                                        </label>

                                        @if (isset($store_info->store_image))
                                            <div class="imgshow">
                                                <img id="preview" src="{{ $store_info->store_image }}"
                                                    style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                                                <span id="remove"
                                                    style="display:block;cursor:pointer;font-size:24px;color:red;"
                                                    onclick="removeImg()">&times;</span>
                                            </div>
                                        @else
                                            <div class="imgshow">
                                                <img id="preview"
                                                    style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                <span id="remove"
                                                    style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                    onclick="removeImg()">&times;</span>
                                            </div>
                                        @endif

                                    </div>
                                    <input type="hidden" class="form-control" name="store_image" id="store_image"
                                        value=" {{ old('store_image', @$store_info->store_image) }}">

                                    @error('store_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Store Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Store name"
                                            name="store_name"
                                            value="{{ old('store_address', @$store_info->store_name) }}">
                                    </div>

                                    @error('store_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="name">Choose Country</label>
                                        <!-- <input type="text" class="form-control" placeholder="Enter Last Name" name="country" value="{{ old('country') }}"> -->

                                        <select name="country" class="form-control">
                                            @foreach ($country as $val)
                                                <option value="{{ $val->id }}"> {{ $val->name }} </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="name">Store Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Store Address"
                                            name="store_address"
                                            value="{{ old('store_address', @$store_info->store_address) }}">
                                    </div>

                                    @error('store_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="name">Address line 1</label>
                                        <input type="text" class="form-control" placeholder="Enter Address line 1"
                                            name="address_line1"
                                            value="{{ old('address_line1', @$store_info->address_line1) }}">
                                    </div>
                                    @error('address_line1')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="name">Address line 2</label>
                                        <input type="text" class="form-control" placeholder="Enter Address line 2"
                                            name="address_line2"
                                            value="{{ old('address_line2', @$store_info->address_line2) }}">
                                    </div>
                                    @error('address_line2')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror



                                    <div class="form-group phone-pnl">
                                        <label for="name">Store Phone Number</label>

                                        <div class="form-group d-flex gap-2">
                                            {{-- <select name="country_code" class="form-select" style="width: 100px">
                                                @foreach ($country as $val)
                                                    <option value="{{ $val->id }}"> {{ $val->dial_code }}
                                                    </option>
                                                @endforeach
                                            </select> --}}

                                            {{-- country code start --}}

                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-light border dropdown-toggle d-flex align-items-center"
                                                    type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span id="selected-flag">
                                                        <img src="{{ $country[0]->flag1 }}" alt="flag"
                                                            width="25" height="16">
                                                    </span>
                                                    <span id="selected-code"
                                                        class="ms-2">{{ $country[0]->dial_code }}</span>
                                                </button>

                                                <ul class="dropdown-menu" aria-labelledby="countryDropdown"
                                                    style="max-height: 250px; overflow-y: auto;">
                                                    @foreach ($country as $index => $item)
                                                        <li>
                                                            <label
                                                                class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                                style="cursor: pointer;">
                                                                <input type="radio" name="country_code"
                                                                    value="{{ $item->dial_code }}"
                                                                    data-flag="{{ $item->flag1 }}"
                                                                    class="country-radio"
                                                                    {{ $index === 0 ? 'checked' : '' }} hidden>
                                                                <img src="{{ $item->flag1 }}"
                                                                    alt="Flag of {{ $item->name }}" width="25"
                                                                    height="16">
                                                                <span>{{ $item->dial_code }}
                                                                    ({{ $item->name }})
                                                                </span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            {{-- country code end  --}}


                                            <input class="form-control" type="number" id="phone"
                                                placeholder="Enter Store Phone Number" name="store_phone"
                                                value="{{ old('store_phone', @$store_info->store_phone) }}"
                                                oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">

                                            @error('country_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                    </div>
                                    @error('store_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="name">Store mail Id</label>
                                        <input type="Email" class="form-control" placeholder="Enter Store mail Id"
                                            name="store_mail_id"
                                            value="{{ old('store_mail_id', @$store_info->store_mail_id) }}">
                                    </div>
                                    @error('store_mail_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="name">Bio</label>
                                        <textarea class="form-control" rows="3" placeholder="Write a massage...." name="bio"> {{ old('bio', @$store_info->bio) }} </textarea>
                                    </div>
                                    @error('bio')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror


                                    <div class="login-btn mt-5">
                                        <input type="submit" class="btn btn-success w-100" value="Continue">

                                        <!-- <a href="bank-details.php" class="btn btn-success w-100">Continue</a> -->
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
<script
    src="{{ asset('/dealer') }}/https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js">
</script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>


<script>
    function showPreview(e) {
        const f = e.target.files[0],
            p = preview,
            r = remove,
            u = uploadLabel;

        if (f) {
            const rdr = new FileReader();
            rdr.onload = x => {
                p.src = x.target.result;
                p.style.display = 'block';
                r.style.display = 'inline';
                u.style.display = 'none';
            };
            rdr.readAsDataURL(f);
        }
    }

    function removeImg() {
        preview.src = '';
        preview.style.display = 'none';
        remove.style.display = 'none';
        uploadLabel.style.display = 'block';
        $('#store_image').val('');
    }


    $(document).on('change', '#edit_imageUpload', function(event) {

        event.preventDefault();
        let file = $(this)[0].files[0];
        let formData = new FormData();
        formData.append('image', file);
        // let name = formData.get('file').name;
        let name = file.name;

        sessionStorage.setItem('uploadedFileName', name);
        let uploadfile = sessionStorage.getItem('uploadedFileName', name);
        // $("#fileName").text(uploadfile);
        $("#fileName").text(name); // Display the file name in the UI

        $.ajax({
            method: 'POST', // Corrected from the comment
            url: "/api/upload",
            headers: {
                'Accept-Language': 'en'
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp) {
                $('#fileName').text(name);
                window.setTimeout(function() {
                    $('.submit').attr('disabled', false);
                    $('.form-control').attr('readonly', false);
                    $('.form-control').removeClass('disabled-link');
                    $('.error-control').removeClass('disabled-link');
                    $('.submit').html('Add');
                }, 2000);
                if (resp.status == 'success') {
                    sessionStorage.setItem('FileUrl', resp.data);
                    $('#store_image').val(resp.data.url);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                var response = xhr.responseJSON;
                // Optionally handle errors here
            }
        });
    });
</script>


@include('dealer.footer');

</html>

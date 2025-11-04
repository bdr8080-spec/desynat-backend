<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sign up </title>
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
                                <form action="{{ route('seller.register') }}" method="post">
                                    <h1>Sign Up <br><span class="gold-color">Create your account !</span></h1>
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
                                        <label id="uploadLabel" style="cursor:pointer;text-align:center;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                            <div>Upload Profile Photo</div>
                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)"
                                                id="edit_imageUpload">
                                        </label>
                                        <div class="imgshow">
                                            <img id="preview"
                                                style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                            <span id="remove" class="remove-ic"
                                                style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                onclick="removeImg()">&times;</span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="profile_pic" id="Profile_image">

                                    @error('profile_pic')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @csrf

                                    <div class="form-group">
                                        <label for="name">First Name</label>
                                        <input type="text" class="form-control" placeholder="Enter First Name"
                                            name="first_name" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="name">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Last Name"
                                            name="last_name" value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Email Address"
                                            name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group phone-pnl">
                                        <label for="name">Mobile Number</label>

                                        <div class="form-group d-flex gap-2">
                                            <select name="country_code" class="form-select" style="width: 100px">
                                                @foreach ($country as $val)
                                                    <option value="{{ $val->dial_code }}"> {{ $val->dial_code }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <input class="form-control" type="tel" id="phone"
                                                placeholder="Enter mobile Number" name="mobile"
                                                value="{{ old('mobile') }}"
                                                oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">

                                        </div>
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    {{-- <div class="form-group phone-pnl">
                                        <select name="country_code">
                                            @foreach ($country as $val)
                                                <option value="{{ $val->dial_code }}"> {{ $val->dial_code }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('country_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    {{-- <div class="form-group phone-pnl">
                                        <label for="name">Mobile Number</label>
                                        <input class="form-control" type="tel" id="phone"
                                            placeholder="Enter mobile number" name="mobile"
                                            value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group position-relative">
                                        <label for="password">Create Password</label>
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter Password" name="password"
                                            value="{{ old('password') }}">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group position-relative">
                                        <label for="password">Confirm Password</label>
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter Confirm Password" name="confirm_password"
                                            value="{{ old('confirm_password') }}">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-check py-4">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="checkChecked" checked name="accept_terms">
                                        <label class="form-check-label" for="checkChecked">
                                            I accept the <span class="title-color">Terms & Conditions </span> and <span
                                                class="title-color">Policies</span>
                                        </label>
                                        @error('accept_terms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="login-btn">
                                        <input type="submit" name="submit" class="btn btn-success w-100"
                                            value="Countinue">

                                    </div>

                                </form>

                                <div class="sign-new mt-2 text-center">
                                    <div>Already have an account? <a href="{{ route('seller.login') }}"
                                            class="link-color"> Sign In</a></div>
                                </div>

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
<script
    src="{{ asset('/dealer') }}/https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js">
</script>

<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>
<script>
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
        $('#Profile_image').val('');

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
                    $('#Profile_image').val(resp.data.url);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                var response = xhr.responseJSON;
                // Optionally handle errors here
            }
        });
    });
</script>

</html>

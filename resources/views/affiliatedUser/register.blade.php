<!DOCTYPE html>
<html>

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
                                        <label class="uploadLabel" id="label-3"
                                            style="cursor:pointer;text-align:center;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                            <div class="text-color-upload">Upload Profile Photo</div>
                                            <input type="file" name="owner_document[]" accept="image/*"
                                                hidden onchange="showPreview(event,3)">
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
                                        <label for="name">First Name</label>
                                        <input type="text" class="form-control" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group phone-pnl">
                                        <label for="name">Mobile Number</label>
                                        <input type="text" class="form-control" placeholder="Enter Mobile Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Email Address">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Upload Document</label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="upload-image w-100">
                                                    <label class="uploadLabel" id="label-1"
                                                        style="cursor:pointer;text-align:center;">
                                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                        <div class="text-color-upload">Document 1</div>
                                                        <input type="file" name="owner_document[]" accept="image/*"
                                                            hidden onchange="showPreview(event,1)">
                                                    </label>
                                                    <div class="imgshow">
                                                        <img id="preview-1"
                                                            style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                        <span id="remove-1" class="remove-ic"
                                                            style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                            onclick="removeImg(1)">&times;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="upload-image w-100">
                                                    <label class="uploadLabel" id="label-2"
                                                        style="cursor:pointer;text-align:center;">
                                                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                                        <div class="text-color-upload">Document 2</div>
                                                        <input type="file" name="owner_document[]" accept="image/*"
                                                            hidden onchange="showPreview(event,2)">
                                                    </label>
                                                    <div class="imgshow">
                                                        <img id="preview-2"
                                                            style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                        <span id="remove-2" class="remove-ic"
                                                            style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                            onclick="removeImg(2)">&times;</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password">Create Password</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="Enter Password" name="password" value="{{ old('password') }}">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                    </div>
                                    <div class="form-group position-relative">
                                        <label for="password">Confirm Password</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="Enter Confirm Password" name="confirm_password"
                                            value="{{ old('confirm_password') }}">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                    </div>

                                    <div class="form-check py-4">
                                        <input class="form-check-input" type="checkbox" value="1" id="checkChecked"
                                            name="accept_terms" {{ old('accept_terms') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkChecked">
                                            I accept the <span class="title-color">Terms & Conditions </span> and <span
                                                class="title-color">Policies</span>
                                        </label>

                                    </div>


                                    <div class="login-btn">
                                        <input type="submit" name="submit" class="btn btn-success w-100"
                                            value="Continue">
                                    </div>
                                </form>

                                <div class="sign-new mt-2 text-center">
                                    <div>Already have an account? <a href="#" class="link-color"> Sign In</a></div>
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
    function showPreview(e, i) {
        const input = e.target;
        const img = document.getElementById(`preview-${i}`);
        const rm  = document.getElementById(`remove-${i}`);
        const label = document.getElementById(`label-${i}`);

        if (!input.files.length) return;

        img.src = URL.createObjectURL(input.files[0]);
        img.style.display = rm.style.display = "block";
        label.style.display = "none";

        // 👇 allow same image re-upload
        input.value = "";
    }

    function removeImg(i) {
        const img = document.getElementById(`preview-${i}`);
        const rm  = document.getElementById(`remove-${i}`);
        const label = document.getElementById(`label-${i}`);

        img.src = "";
        img.style.display = rm.style.display = "none";
        label.style.display = "block";
    }
</script>




{{-- @include('dealer.custom_code'); --}}

@include('dealer.layout.custom_code')



</html>
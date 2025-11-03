<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sign up OTP Verification </title>
    <!-- Favicons -->
    <link href="{{ asset('/dealer') }}/assets/img/favicon.png" rel="icon">
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
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-right.svg" alt="image"
                            class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2">
                                <div class="cmn-header mb-3">
                                    <h1><a href="sign-up.php"><i class="bi bi-chevron-left"></i></a> OTP</h1>
                                </div>

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
                                        <div class="progress-bar" style="width: 0%"></div>
                                    </div>
                                    <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 0%"></div>
                                    </div>
                                </div>

                                <form action="{{ route('seller.register_otp_verify', request()->id) }}" method="Post">

                                    <div class="group-radio-btn">
                                        <h3>6 digit OTP has been sent to your registered Mobile Number <span
                                                class="gold-color"> {{ $seller_details->country_code }}
                                                {{ $seller_details->mobile }}</span></h3>

                                    </div>

                                    <input type="hidden" value="{{ Request()->forgot }}" name="forgot">

                                    @csrf

                                    <div class="otp-panel py-4">
                                        <div class="otp-field" style="display: flex; gap: 8px;justify-content: center;">
                                            <input type="text" name="otp[]" maxlength="1" class="form-control"
                                                oninput="moveNext(this, 1)">
                                            <input type="text" name="otp[]" maxlength="1" class="form-control"
                                                oninput="moveNext(this, 2)">
                                            <input type="text" name="otp[]" maxlength="1" class="form-control"
                                                oninput="moveNext(this, 3)">
                                            <input type="text" name="otp[]" maxlength="1" class="form-control"
                                                oninput="moveNext(this, 4)">
                                            <input type="text" name="otp[]" maxlength="1" class="form-control"
                                                oninput="moveNext(this, 5)">
                                            <input type="text" name="otp[]" maxlength="1" class="form-control"
                                                oninput="moveNext(this, 6)">
                                        </div>
                                    </div>

                                    @error('otp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="login-btn padding-top-60">
                                        <input type="submit" class="btn btn-success w-100" value="Verify">
                                        <!-- <a href="store_page.php" class="btn btn-success w-100">Verify</a> -->
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

<script>
    const inputs = document.querySelectorAll(".otp-field input");

    inputs.forEach((input, i) => {
        input.addEventListener("input", e => {
            e.target.value = e.target.value.replace(/[^0-9a-z]/i, '').slice(0, 1);
            if (e.target.value && i < inputs.length - 1) inputs[i + 1].focus();
        });
        input.addEventListener("keydown", e => {
            if (e.key === "Backspace" && !e.target.value && i > 0) inputs[i - 1].focus();
        });
        input.addEventListener("paste", e => {
            const val = e.clipboardData.getData("text").slice(0, inputs.length).split("");
            inputs.forEach((inp, j) => inp.value = val[j] || "");
        });
    });
</script>

@include('dealer.footer');


</html>

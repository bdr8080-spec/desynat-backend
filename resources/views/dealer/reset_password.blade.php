<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">

</head>

<body>
    <div class="login-header">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('dealer') }}/assets/img/global.svg" class="img-fluid" /> EN
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
                            <img src="{{ asset('dealer') }}/assets/img/Desynat-logo-2.svg" alt="image"
                                class="img-fluid logo-login">
                        </div>
                        <img src="{{ asset('dealer') }}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{ asset('dealer') }}/assets/img/Vector-right.svg" alt="image"
                            class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2">
                                <form method="POST" action="{{ route('seller.create_password', Request()->id) }}">
                                    <div class="cmn-header mb-3">
                                        <h1><a href="otp_verify.php"><i class="bi bi-chevron-left"></i></a> Reset
                                            Password</h1>
                                    </div>
                                    @csrf

                                    @error('error')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group position-relative">
                                        <label for="password">Create New Password</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="Enter new password" name="password">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password">Confirm Password</label>
                                        <input type="password" class="form-control notapplyspace" id="password"
                                            placeholder="Enter confirm password" name="confirm_password">
                                        <i class="toggle-password  bi bi-eye-slash "></i>

                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="login-btn padding-top-60">
                                        {{-- <a href="#" class="btn btn-success w-100" data-bs-toggle="modal"
                                            data-bs-target="#alertModal">Done</a> --}}
                                        <input type="submit" value="Done" class="btn btn-success w-100">

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-radious-20 w-75">
                <div class="modal-body  p-3">
                    <div class="alertbody text-center">
                        <img src="{{ asset('dealer') }}/assets/img/success.svg" alt="image" class="img-fluid py-4">
                        <h3>Password Reset Successfully !</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>



@include('dealer.layout.footer');

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



</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">

    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />


</head>

<body>

    <div>

        <div class="login-header">
            <div class="des-logo">
                <a href="#"><img src="{{asset('admin/image/logo.svg')}}" class="img-fluid" /> </a>
            </div>
            <div class="des-language">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="/admin/image/global.svg" class="img-fluid" /> EN
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                        <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- <div class="auth-wrapper"> -->
        <div class="container-fluid p-0">
            <div class="login-grid-bg">

                <div class="row g-0">
                    <div class="col-lg-6 bg-logo-wapper">
                        <div class="login-img">
                            <img src="/admin/image/Desynat-logo-2.svg" alt="image" class="img-fluid logo-login">
                        </div>
                        <img src="/admin/image/Vector-left.svg" alt="image" class="vector-left">
                        <img src="/admin/image/Vector-right.svg" alt="image" class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <!-- RIGHT SIDE -->
                        <div class="login-content pt-40">
                            <div class="login-grid-2">
                                <div class="login">
                                    <div class="loginBackgroundeffect">
                                        <h4 class="login-text "> <span>LogIn </span></h4>
                                        <h6 class="welcome-text"> <span>Welcome Back !</span></h6>

                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email">Enter Email Id</label>
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Enter Email id" required />
                                                    <small id="emailError" style="color: red;"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-3">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" id="password"
                                                        class="form-control custom-password" name="password"
                                                        placeholder="Enter password" required />
                                                    <i toggle="#password" class="fas fa-eye toggle-password"></i>
                                                </div>
                                            </div>
                                            <small id="passwordError" style="color: red;"></small>
                                            <div id="loginError" style="color: red; display:none;"></div>
                                            <div class="col-lg-12">
                                                <div class="mt-2 d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('forgotPassword') }}">Forgot Password?</a>
                                                </div>
                                            </div>
                                            <div class="button d-flex align-items-center justify-content-center">
                                                <button id="loginBtn" class="btn custom-btn w-100">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- LEFT SIDE -->
        <!-- <div class="auth-left">
                <div class="brand-header">
                    <img src="assets/logo.png" class="brand-logo" alt="logo">
                       <span class="brand-name">Desynat</span>
                </div>
            </div> -->




        <!-- </div> -->

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script>
    // Toggle password visibility
    document.querySelectorAll(".toggle-password").forEach((toggle) => {
        toggle.addEventListener("click", function() {
            const input = document.querySelector(this.getAttribute("toggle"));
            const type =
                input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", type);

            // Toggle icon between eye (fa-eye) and eye-slash (fa-eye-slash)
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#email, #password').on('input', function() {
            const field = $(this).attr('id');

            if (field === 'email') {
                $('#emailError').text('');
            }
            if (field === 'password') {
                $('#passwordError').text('');
            }

            $('#loginError').hide().text('');
        });
        // AJAX login form submission
        $('#loginBtn').click(function(e) {
            e.preventDefault();

            $('#emailError').text('');
            $('#passwordError').text('');
            $('#loginError').hide().text('');

            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                url: '{{ route("adminLogin") }}',
                type: 'POST',
                data: {
                    email: email,
                    password: password,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = "{{ route('admin.dashboard') }}";
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.email && errors.password) {
                        $('#emailError').text(errors.email[0]);
                        $('#passwordError').text(errors.password[0]);
                    } else if (errors.email) {
                        if (errors.email[0] === 'Invalid credentials') {
                            $('#loginError').text(errors.email[0]).show();
                        } else {
                            $('#emailError').text(errors.email[0]);
                        }
                    }
                    if (errors.password) {
                        $('#passwordError').text(errors.password[0]);
                    }
                }
            });
        });
    });
    </script>
</body>

</html>
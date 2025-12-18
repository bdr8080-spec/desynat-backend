<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desynat</title>
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">

    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

</head>

<body>

   
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
                                <div class="loginBackgroundeffect text">
                                    <div class="row">

                                        <!-- HEADER BACK NAV -->
                                        <div class="col-lg-12">
                                            <div class="d-flex align-items-center gap-3 mt-2">
                                                <div class="arrow">
                                                    <a class="table-button" type="button"
                                                        href="{{ route('adminLogin') }}">
                                                        <i class="fas fa-angle-left"></i>
                                                    </a>
                                                </div>
                                                <h6 class="m-0">Forgot Password</h6>
                                            </div>
                                        </div>

                                        <!-- EMAIL INPUT -->
                                        <div class="col-lg-12 mt-3">
                                            <div class="form-group">
                                                <label for="email">Enter Email Id</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Enter Register Email id " required>
                                                <small id="emailError" style="color: red;"></small>
                                            </div>
                                        </div>

                                        <!-- SUBMIT BUTTON -->
                                        <div class="col-lg-12">
                                            <div class="button d-flex align-items-center justify-content-center">
                                                <button id="forgotBtn" class="btn custom-btn"
                                                    style="max-width: 100% !important;">
                                                    Next
                                                </button>
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

    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>

    <script>
    $(document).ready(function() {
        $('#email').on('input', function() {
            $('#emailError').text('');
        });

        // AJAX forgot password
        $('#forgotBtn').click(function(e) {
            e.preventDefault();
            $('#emailError').text('');

            var email = $('#email').val();

            $.ajax({
                url: '{{ route("forgotPassword") }}',
                type: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = "{{ route('optVerify') }}";
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.email) {
                            $('#emailError').text(errors.email[0]);
                        }
                    }
                }
            });
        });
    });
    </script>

</body>

</html>
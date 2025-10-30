<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> Desyant Dealer </title>
    <!-- Favicons -->
    <link href="{{ asset( '/dealer')}}/assets/img/favicon.png" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset( '/dealer')}}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset( '/dealer')}}/assets/custom-file/css/style.css" rel="stylesheet">
</head>

<body>

<div class="login-header">
    <div class="des-logo">
        <a href="#"><img src="{{ asset( '/dealer')}}/assets/img/desynat-logo.svg" alt="image" class="img-fluid logo-login">  </a> 
    </div>
    <div class="des-language">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset( '/dealer')}}/assets/img/global.svg" class="img-fluid" /> EN
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
                            <img src="{{ asset( '/dealer')}}/assets/img/Desynat-logo-2.svg" alt="image" class="img-fluid logo-login">                          
                        </div>
                        <img src="{{ asset( '/dealer')}}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{ asset( '/dealer')}}/assets/img/Vector-right.svg" alt="image" class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2">
                                <form>
                                    <h1>Sign In <br><span class="gold-color">Welcome back !</span></h1>
                                    

                                    <div class="form-group">
                                        <label for="email">Mobile or Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Mobile Number or Email Address">
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter Your Password">
                                        <i class="toggle-password  bi bi-eye-slash "></i>
                                    </div>
                                    <div class="form-group py-2 mb-4 text-center">
                                         <a href="forgot.php" class="link-color">Forgot Password ? </a>
                                    </div>
                                    <div class="login-btn">
                                        <a href="index.php" class="btn btn-success w-100">Login</a>
                                    </div>

                                </form>

                                <div class="sign-new mt-2 text-center">
                                    <div>Don’t have an account? <a href="sign-up.php" class="link-color"> Sign up</a></div>
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
<script src="{{ asset( '/dealer')}}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset( '/dealer')}}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{ asset( '/dealer')}}/assets/custom-file/js/main.js"></script>
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
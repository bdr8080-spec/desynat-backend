<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/responsive.css" rel="stylesheet" />
    <!-- <link href="assets/css/fontawesome.min.css" rel="stylesheet" /> -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    

    <div class="login_contenar">
        <header class="inner-header">
            <a><img src="assets/images/logo.svg" class="img-fluid" /></a>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </header>
        <div class="login_content login_content_left">
            <img src="assets/images/left-img.svg" class="left-imgone" />
            <img src="assets/images/logoone.svg" class="left-img" />
            <img src="assets/images/right-img.svg" class="left-imgtwo" />
        </div>
        <div class="login_content login_content_right">
            <div class="login_content_content">
                <h4>Sign In</h4>
                <h3>Welcome back !</h3>
                <div class="form-group mt-4">
                    <label for="">Mobile or Email Address</label>
                    <input type="text" class="form-control" placeholder="Enter Mobile Number or Email Address" />
                </div>
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">Password</label>
                    <input type="password" id="login-password" class="form-control custom-password"
                        placeholder="Enter password" style="padding-right: 40px;"/>
                    <i class="fa-solid fa-eye toggle-password" id="toggleIcon".></i>
                </div>
                <p class=" mt-3 mb-4"><a href="forget-password.html">Forgot password</a></p>
                <a type="button" class="customBtn">Login</a>
                <a class="customBtn2" style="text-decoration: none;" href="login-via-number.html">Login Via OTP</a>
                <div class="accounts signUp">
                    <a class="text-center sign">Or Sign in with</a>
                </div>

                <div class="social-icon">
                    <a class="apple">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a class="facebook">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a class="google">
                        <i class="fa-brands fa-apple"></i>
                    </a>

                </div>
                 <p class="mt-3 dontAccount">Don’t have an account? <a href="sign-up.html">Sign up</a></p>
                 <p class="guest">Continue As a Guest</p>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js" ></script>
    <!-- <script src="assets/js/all.min.js" ></script> -->
    <script src="assets/js/bootstrap.bundle.min.js" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->
     <script src="assets/js/custom.js"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/responsive.css" rel="stylesheet" />
    <!-- <link href="assets/css/fontawesome.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />
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
            <div class="login_content_content align-self-center">
                <div>
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> Forgot Password</h3>
                    <div class="radio-group my-4">
                        <label class="custom-radio">
                            <input type="radio" name="gender" value="male" checked />
                            <span class="radio-mark"></span>
                            <span class="label-text">Mobile Number</span>
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="gender" value="female" />
                            <span class="radio-mark"></span>
                            <span class="label-text">Email Address</span>
                        </label>
                    </div>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="">Enter Mobile Number</label>
                        <input class="tel-input" type="tel" value="+866" placeholder="Enter Mobile Number">
                    </div>
                    <a type="button" class="customBtn mt-4" href="otp.html">Continue</a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js" ></script>
    <!-- <script src="assets/js/all.min.js" ></script> -->
    <script src="assets/js/bootstrap.bundle.min.js" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/intlTelInput.js"></script>
     <script src="assets/js/custom.js"></script>

    
</body>
</html>
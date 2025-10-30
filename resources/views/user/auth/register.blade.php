<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/responsive.css" rel="stylesheet" />
    <!-- <link href="assets/css/fontawesome.min.css" rel="stylesheet" /> -->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />
    <link href="{{asset('user/assets/css/style.css')}}" rel="stylesheet" />
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
                     <form id="signup">
                        @csrf
                    <h4>Sign Up</h4>
                    <h3>Create your account !</h3>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="">Full Name</label>
                        <input type="password" id="login-password" name="full_name" class="form-control custom-password"
                            placeholder="Enter Full Name" style="padding-right: 40px;"/>
                    </div>
                    <div class="form-group mt-3">
                        <label class="d-block" for="">Mobile Number</label>
                        <input class="tel-input" type="tel" value="+866" placeholder="Enter Mobile Number" name="mobile">
                    </div>
                    <div class="form-group position-relative verify mt-3">
                        <label class="d-block" for="">Email Address</label>
                        <input type="password" id="login-password" class="form-control custom-password"
                            placeholder="Enter Full Name" style="padding-right: 40px;" name="email"/>
                        <span>Verify</span>
                    </div>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="">Create Password</label>
                        <input type="password" id="login-password" class="form-control custom-password"
                            placeholder="Enter password" style="padding-right: 40px;"  name="password"/>
                        <i class="fa-solid fa-eye toggle-password" id="toggleIcon"></i>
                    </div>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="">Confirm Password</label>
                        <input type="password" id="login-password" class="form-control custom-password"
                            placeholder="Enter confirm password" style="padding-right: 40px;" name="confirm_password"/>
                        <i class="fa-solid fa-eye toggle-password" id="toggleIcon"></i>
                    </div>
                    <div class="form-check term_policy my-3">
                        <input class="form-check-input" type="checkbox" value="1" id="checkIndeterminate" name="accept_terms">
                        <label class="form-check-label" for="checkIndeterminate">
                            I accept the <a href="">Terms & Conditions</a> and <a href="">Policies</a>
                        </label>
                    </div>
                    <button type="submit" class="customBtn">Sign Up</button>
                    </form>
                    <p class="mt-3 dontAccount">Don’t have an account? <a href="reset-password.html">Sign In</a></p>
                </div>
            
            </div>
           
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{asset('user/assets/js/jquery-3.7.1.min.js')}}" ></script>
    <script src="{{asset('user/assets/js/bootstrap.bundle.min.js')}}" ></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/intlTelInput.js"></script>
     <script src="{{asset('user/assets/js/custom.js')}}"></script>

     <script>
        $(document).on('submit', '#signup', function (e) {
            e.preventDefault();

            let data = new FormData(this);

            $.ajax({
                url: "{{ route('userRegister') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    console.log(resp);
                },
                error: function (xhr) {
                    console.log(xhr.responseJSON);
                }
            });
        });

     </script>
    
</body>
</html>
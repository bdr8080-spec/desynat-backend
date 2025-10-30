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
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> Reset Password</h3>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="createPassword">Create Password</label>
                        <input type="password" id="createPassword" class="form-control custom-password"
                            placeholder="Enter password" style="padding-right: 40px;"/>
                        <i class="fa-solid fa-eye toggle-password" id="toggleCreate"></i>
                    </div>

                    <div class="form-group position-relative password_icon mt-3">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-control custom-password"
                            placeholder="Enter confirm password" style="padding-right: 40px;" />
                        <i class="fa-solid fa-eye toggle-password" id="toggleConfirm"></i>
                    </div>
                    <a type="button" class="customBtn mt-4" data-bs-toggle="modal" data-bs-target="#passwordSuccess">Done</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="passwordSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/images/success.svg" class="img-fluid" />
                    <p>Password Reset Successfully !</p>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js" ></script>
    <!-- <script src="assets/js/all.min.js" ></script> -->
    <script src="assets/js/bootstrap.bundle.min.js" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->

    <script>
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            const isPassword = input.getAttribute('type') === 'password';

            // Toggle between text/password
            input.setAttribute('type', isPassword ? 'text' : 'password');

            // Toggle the icon style
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            });
        });
  </script>
</body>
</html>
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
                <div class="otp-page">
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> OTP</h3>
                    <h5 class="otp_sent">4 digit OTP has been sent to your registered Mobile Number <span>+971 1 123 123 1234</span></h5>
                    <div class="otp-container mt-3">
                        <input type="text" maxlength="1" class="otp-input" id="otp1" />
                        <input type="text" maxlength="1" class="otp-input" id="otp2" />
                        <input type="text" maxlength="1" class="otp-input" id="otp3" />
                        <input type="text" maxlength="1" class="otp-input" id="otp4" />
                    </div>
                    <a type="button" class="customBtn mt-5" href="create-password.html">Continue</a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js" ></script>
    <!-- <script src="assets/js/all.min.js" ></script> -->
    <script src="assets/js/bootstrap.bundle.min.js" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->

    <script>
        const inputs = document.querySelectorAll(".otp-input");

            inputs.forEach((input, index) => {
            input.addEventListener("input", (e) => {
                const value = e.target.value;
                // Allow only digits
                if (!/^[0-9]$/.test(value)) {
                e.target.value = "";
                return;
                }
                // Move to next input
                if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
                }
            });

            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && !e.target.value && index > 0) {
                inputs[index - 1].focus();
                }
            });
        });
  </script>
</body>
</html>
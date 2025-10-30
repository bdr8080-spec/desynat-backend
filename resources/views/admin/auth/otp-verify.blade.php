<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Desynat</title>
    <link href="css/style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="image/favicon.svg">

     <link href="{{asset('Admin/css/style.css')}}" rel="stylesheet" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <style>
      .auth-wrapper {
        display: flex;
        height: 100vh;
        width: 100%;
      }

      .auth-left {
        flex: 1;
        background: url("image/background-image.svg") no-repeat center
          center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .brand-header {
        position: absolute;
        top: 30px;
        left: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .brand-logo {
        width: 45px;
        height: 45px;
      }

      .brand-name {
        font-size: 38px;
        font-weight: 600;
        font-family: "Georgia", serif;
        color: #000;
      }

      .auth-right {
        flex: 1;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .auth-form-wrapper {
        width: 350px;
      }
      .loginBackgroundeffect {
        max-width: 470px;
      }
         .custom-topbar {
  background: linear-gradient(90deg, #c08f53, #a36a2a) !important;
  height: 74px;
  border-radius: 6px;
  padding: 0 25px;
  display: flex;
  align-items: center;
}

.header-logo {
    width: 110px;
    height: 66px;
  border-radius: 50%;
  object-fit: contain;
}

.brand-name {
  font-size: 22px;
  font-weight: 600;
  font-family: 'Georgia', serif;
  margin-left: 12px;
  color: #000;
}

.header-divider {
  flex: 1;
  /* border-bottom: 1.5px dotted rgba(0, 0, 0, 0.5); */
  margin: 0 25px;
}

.lang-btn {
  background: transparent;
  border: 1px solid rgba(0,0,0,0.7);
  padding: 6px 14px;
  border-radius: 50px;
  font-size: 14px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
}
    </style>
 <nav class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow">

        
            <div class="left-section d-flex align-items-center">
              <img src="image/favicon.svg" class="header-logo" />
             <img src="image/Desynat Logo_Final 1.svg" class="header-logo" />

            </div>

            <div class="header-divider"></div>

            <div class="right-section">
              <button class="lang-btn">
                <i class="fas fa-globe"></i> EN
                <i class="fas fa-chevron-down"></i>
              </button>
            </div>
          </nav>

    <div class="auth-wrapper">
      <!-- LEFT SIDE -->
      <div class="auth-left">
        <div class="brand-header">
          <!-- logo aa jayega baad me -->
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="auth-right">
        <div class="login-container-div">
          <div class="login">
            <div class="loginBackgroundeffect text">
              <div class="row">
                <!-- HEADER BACK NAV -->
                <div class="col-lg-12">
                  <div class="d-flex align-items-center gap-3 mt-2">
                    <div class="arrow">
                      <a class="table-button" type="button" href="{{route('forgotPassword')}}">
                        <i class="fas fa-angle-left"></i>
                      </a>
                    </div>
                    <h6 class="m-0">OTP </h6>
                  </div>
                </div>

                <div class="login">
                  <div class="loginBackgroundeffect">
                    <p class="text-start">
                      6 digit OTP has been sent to your registered mail id
                    </p>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <!-- <label for="password" class="text-center"
                            >Enter OTP</label
                          > -->
                          <div class="otp-container">
                            <input
                              type="text"
                              maxlength="1"
                              class="otp-input"
                              id="otp-1"
                              required
                            />
                            <input
                              type="text"
                              maxlength="1"
                              class="otp-input"
                              id="otp-2"
                              required
                            />
                            <input
                              type="text"
                              maxlength="1"
                              class="otp-input"
                              id="otp-3"
                              required
                            />
                            <input
                              type="text"
                              maxlength="1"
                              class="otp-input"
                              id="otp-4"
                              required
                            />
                            <input
                              type="text"
                              maxlength="1"
                              class="otp-input"
                              id="otp-4"
                              required
                            />
                            <input
                              type="text"
                              maxlength="1"
                              class="otp-input"
                              id="otp-4"
                              required
                            />
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div
                            class="d-flex align-items-center justify-content-end"
                          >
                            <a href="">Resend OTP</a>
                          </div>
                        </div>
                        <div class=" mb-5 text-center ">
                          <div id="timerOtp">
                            in <span id="seconds"></span>Secs
                          </div>
                        </div>
                           <div
                        class="button d-flex align-items-center justify-content-center"
                      >
                        <a
                          class="btn custom-btn"
                          style="max-width: 100% !important"
                          href="create-password.html"
                          >Submit</a
                        >
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

     <script src="{{asset('Admin/js/bootstrap.bundle.min.js')}}"></script>

    <script>
      // Toggle password visibility
      document.querySelectorAll(".toggle-password").forEach((toggle) => {
        toggle.addEventListener("click", function () {
          const input = document.querySelector(this.getAttribute("toggle"));
          const type =
            input.getAttribute("type") === "password" ? "text" : "password";
          input.setAttribute("type", type);

          // Toggle icon between eye and eye-slash
          this.classList.toggle("fa-eye");
          this.classList.toggle("fa-eye-slash");
        });
      });
    </script>
    <script>
      const inputs = document.querySelectorAll(".otp-input");

      inputs.forEach((input, index) => {
        input.addEventListener("input", () => {
          if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
          }
        });

        input.addEventListener("keydown", (e) => {
          if (e.key === "Backspace" && input.value === "" && index > 0) {
            inputs[index - 1].focus();
          }
        });
      });
    </script>
  </body>
</html>

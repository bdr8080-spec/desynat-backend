<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desynat</title>
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/top_ten_homecare_fav_ic.png')}}">
    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
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
                      <a class="table-button" type="button" href="{{route('adminLogin')}}">
                        <i class="fas fa-angle-left"></i>
                      </a>
                    </div>
                    <h6 class="m-0">Reset Password </h6>
                  </div>
                </div>

                <div class="login">
                            <div class="loginBackgroundeffect">
                                <!-- <a href="login.html"><i class="fas fa-long-arrow-alt-left"></i></a>
                                <img src="image/Logo2.png" al="logo" class="img-fluid" /> -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="newPassword" class="form-label">Create New Password</label>
                                            <input type="password" class="form-control" id="newPassword" placeholder="Enter New Password" required>
                                            <i toggle="#newPassword" class="fas fa-eye toggle-password"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <div class="form-group">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" id="confirmPassword" class="form-control" placeholder="Enter Confirm Password" required>
                                            <i toggle="#confirmPassword" class="fas fa-eye toggle-password"></i>
                                        </div>
                                    </div>
                                    <div class="button d-flex align-items-center justify-content-center mt-5">
                                        <a class="btn custom-btn" href="index.html" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="max-width: 100% !important;">Submit</a>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <!-- <a href="login.html"><i class="fas fa-long-arrow-alt-left"></i></a> -->
            <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-5">
                <div class="change-success text-center">
                    <img src="image/check.png" class="img-fluid" width="100px" />
                    <h2 class="mt-4">Password Reset</h2>
                    <p>Use the new password during logging in to get access your account</p>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
        </div>
    </div>

    <script src="{{asset('Admin/js/bootstrap.bundle.min.js')}}"></script>
        <script>
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = document.querySelector(this.getAttribute('toggle'));
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);

                    // Toggle icon between eye (fa-eye) and eye-slash (fa-eye-slash)
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });
        </script>
        
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ichrono</title>
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
              <img src="{{asset('admin/image/favicon.svg')}}" class="header-logo" />
             <img src="{{asset('admin/image/Desynat Logo_Final 1.svg')}}" class="header-logo" />

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
          
          <!-- HEADER -->
          <div class="col-lg-12">
            <div class="d-flex align-items-center gap-3 mt-2">
              <div class="arrow">
                <a class="table-button" type="button" href="{{ route('forgotPassword') }}">
                  <i class="fas fa-angle-left"></i>
                </a>
              </div>
              <h6 class="m-0">Reset Password</h6>
            </div>
          </div>

          <div class="col-lg-12 mt-3">
            <div class="form-group">
              <label for="newPassword" class="form-label">Create New Password</label>
              <input type="password" class="form-control" id="newPassword" placeholder="Enter New Password" required>
              <i toggle="#newPassword" class="fas fa-eye toggle-password"></i>
              <span id="passwordError" class="text-danger"></span>
            </div>
          </div>

          <div class="col-lg-12 mt-3">
            <div class="form-group">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <input type="password" id="confirmPassword" class="form-control" placeholder="Enter Confirm Password" required>
              <i toggle="#confirmPassword" class="fas fa-eye toggle-password"></i>
              <span id="confirmPasswordError" class="text-danger"></span>
            </div>
          </div>

          <div class="col-lg-12 mt-5">
            <div class="button d-flex align-items-center justify-content-center">
              <button class="btn custom-btn" id="submitPassword" style="max-width: 100% !important;">Submit</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
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

<script>
$(document).ready(function() {

  // Validation criteria function
  function passwordHint(password) {
    return "Password should be combination of at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character";
  }
  
  // Check if password meets criteria
  function meetsCriteria(password) {
    return password.length >= 8 &&
           /[A-Z]/.test(password) &&
           /[a-z]/.test(password) &&
           /[0-9]/.test(password) &&
           /[!@#$%^&*(),.?\":{}|<>]/.test(password);
  }

  // On input in newPassword field
  $('#newPassword').on('input', function() {
    let pwd = $(this).val();
    $('#passwordError').text('');
    if (pwd && !meetsCriteria(pwd)) {
      $('#passwordError').text(passwordHint(pwd));
    }
  });

  // On input in confirmPassword field
  $('#confirmPassword').on('input', function() {
    $('#confirmPasswordError').text('');
  });

  // On submit
  $('#submitPassword').click(function(e) {
    e.preventDefault();
    $('#passwordError').text('');
    $('#confirmPasswordError').text('');

    let newPassword = $('#newPassword').val();
    let confirmPassword = $('#confirmPassword').val();
    let email = "{{ $email ?? '' }}"; 

    // Check fields empty
    if (!newPassword) {
      $('#passwordError').text('Password is required');
      
    }
    if (!confirmPassword) {
      $('#confirmPasswordError').text('Confirm password is required');
      return;
    }

    // Check criteria
    if (!meetsCriteria(newPassword)) {
      $('#passwordError').text(passwordHint(newPassword));
      return;
    }

    // Check match
    if (newPassword !== confirmPassword) {
      $('#confirmPasswordError').text('Passwords do not match');
      return;
    }

    // Now do AJAX call
    $.ajax({
      url: '{{ route("changePassword") }}',
      type: 'POST',
      data: {
        email: email,
        password: newPassword,
        confirm_password: confirmPassword,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        if(response.success) {
          $('#exampleModal').modal('show');
          setTimeout(function() {
            window.location.href = "{{ route('adminLogin') }}";
          }, 5000);
        }
      },
      error: function(xhr) {
        if(xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          if(errors.password) $('#passwordError').text(errors.password[0]);
          if(errors.confirm_password) $('#confirmPasswordError').text(errors.confirm_password[0]);
        }
      }
    });

  });

});
</script>


        
</body>
</html>

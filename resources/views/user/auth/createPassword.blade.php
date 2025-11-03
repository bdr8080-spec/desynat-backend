@extends('user.auth.layout.app')


@section('content')
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
                <form id="resetPassword">
                    @csrf
                <input type="hidden" name="id" value="{{request()->temp_user_id}}">
                <div>
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> Reset Password</h3>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="createPassword">Create New Password</label>
                        <input type="password" id="createPassword" class="form-control custom-password notapplyspace"
                            placeholder="Enter New Password" style="padding-right: 40px;" name="password" />
                        <i class="fa-solid fa-eye toggle-password" id="toggleCreate"></i>
                    </div>
                     <span class="text-danger" id="error-password"></span>


                    <div class="form-group position-relative password_icon mt-3">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-control custom-password notapplyspace"
                            placeholder="Enter confirm password" style="padding-right: 40px;" name="confirm_password" />
                        <i class="fa-solid fa-eye toggle-password" id="toggleConfirm"></i>
                        {{-- <span class="text-danger" id="error-confirm_password"></span> --}}
                    </div>
                    <span class="text-danger" id="error-confirm_password"></span>

                    <button type="submit" class="customBtn mt-4">Done</a>
                </div>
                </form>
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


       <script>




        $(document).on('submit', '#resetPassword', function (e) {
            e.preventDefault();

            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('userCreatePassword') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                        $('#passwordSuccess').modal('show');
                        setTimeout(() => {
                            location.href = 'login'
                        },3000);
                    }

                    if(resp.status == false){
                        for (const key in resp.errors) {
                            console.log(resp.errors[key])
                            $(`#error-${key}`).html(resp.errors[key]);
                        }   
                    }

                },
                error: function (xhr) {
                   toastr.error(xhr.responseJSON.message);
                },
                complete: function () {
                   $('#loginButtom').prop('disabled', false);
                }
            });
        });

     </script>


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


@endsection
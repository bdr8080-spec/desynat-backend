
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
            <div class="login_content_content">
            <form id="userLogin">
                @csrf
                <h4>Sign In</h4>
                <h3>Welcome back !</h3>
                <div class="form-group mt-4">
                    <label for="">Mobile or Email Address</label>
                   
                    <div class="row">
                        <div class="col-3 d-none LoginCountryCode">
                                <select name="country_code" id="" class="form-control">
                                    @foreach ($country as $item)                       
                                        <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                                    @endforeach
                                </select>
                         </div> 
                         <div class="col-12 LoginMobileDesign">
                           <input type="text" class="form-control"  value="" placeholder="Enter Mobile Number" name="mobileOrEmail" id="LoginMobile">
                        </div>
                    </div>
                </div>
                <span class="text-danger" id="error-mobileOrEmail"></span>
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">Password</label>
                    <input type="password" name="password"  id="login-password" class="form-control custom-password"
                        placeholder="Enter password" style="padding-right: 40px;"/>
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                  <span class="text-danger" id="error-password"></span>
                <p class=" mt-3 mb-4"><a href="{{route('userForgetPassword')}}">Forgot password</a></p>
                <button type="submit" class="customBtn" id="loginButtom">Login</button>
            </form>
                <a class="customBtn2" style="text-decoration: none;" href="{{route('loginWithOtp')}}">Login Via OTP</a>
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
                 <p class="mt-3 dontAccount">Don’t have an account? <a href="{{route('userRegister')}}">Sign up</a></p>
                 <p class="guest">Continue As a Guest</p>
            </div>
        </div>
    </div>


    <script>
            

        document.addEventListener('keydown', function(e) {
            if (e.key === ' ') {
                e.preventDefault();
            }
        });



        $('#LoginMobile').on('keyup change', function () {
            let value = $(this).val().trim();

            if (value === '') return;

            if (!isNaN(value.charAt(0))) {
                $('.LoginCountryCode').addClass('d-block').removeClass('d-none');
                $('.LoginMobileDesign').addClass('col-9').removeClass('col-12');
            } else {
                $('.LoginCountryCode').addClass('d-none').removeClass('d-block');
                $('.LoginMobileDesign').addClass('col-12').removeClass('col-9');
            }
        });



        $(document).on('submit', '#userLogin', function (e) {
            e.preventDefault();

            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('userLogin') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                        location.href = "/";
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

@endsection

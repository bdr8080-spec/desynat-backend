
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
                <div class="form-group mt-lg-4 mt-md-3 mt-2">
                    <label for="">Mobile Number or Email Address</label>
                   
                    <div class="d-flex align-items-center">
                        <div class=" d-none LoginCountryCode">
                                {{-- <select name="country_code" id="" class="country form-control">
                                    @foreach ($country as $item)                       
                                        <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                                    @endforeach
                                </select> --}}

                                 <div class="dropdown">
                                        <button class="btn btn-light border dropdown-toggle d-flex align-items-center" type="button"
                                                id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span id="selected-flag">
                                                <img src="{{ $country[0]->flag1 }}" alt="flag" width="25" height="16">
                                            </span>
                                            <span id="selected-code" class="ms-2">{{ $country[0]->dial_code }}</span>
                                        </button>

                                        <ul class="dropdown-menu" aria-labelledby="countryDropdown" style="max-height: 250px; overflow-y: auto;">
                                            @foreach ($country as $index => $item)
                                                <li>
                                                    <label class="dropdown-item d-flex align-items-center gap-2 country-option" style="cursor: pointer;">
                                                        <input type="radio" name="country_code"
                                                            value="{{ $item->dial_code }}"
                                                            data-flag="{{ $item->flag1 }}"
                                                            class="country-radio"
                                                            {{ $index === 0 ? 'checked' : '' }} hidden>
                                                        <img src="{{ $item->flag1 }}" alt="Flag of {{ $item->name }}" width="25" height="16">
                                                        <span>{{ $item->dial_code }} ({{ $item->name }})</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                         </div> 
                         <div class="w-100 LoginMobileDesign">
                           <input type="text" class="form-control notapplyspace"  value="" placeholder="Please enter mobile number or email address" name="mobileOrEmail" id="LoginMobile"
                           maxlength="15"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)"
                           />
                        </div>
                    </div>
                </div>
                <span class="text-danger" id="error-mobileOrEmail"></span>
                <div class="form-group position-relative password_icon mt-lg-3 mt-md-2 mt-1">
                    <label for="">Password</label>
                    <input type="password" name="password"  id="login-password" class="form-control custom-password notapplyspace"
                        placeholder="Please enter password" style="padding-right: 40px;"/>
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
                 <p class="guest"><a href="{{route('dashboard')}}">Continue As a Guest</a></p>
            </div>
        </div>
    </div>


    <script>
            

            document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('.country-radio');
                const selectedFlag = document.getElementById('selected-flag');
                const selectedCode = document.getElementById('selected-code');

                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        const parent = this.closest('label');
                        const flagImg = parent.querySelector('img').src;
                        const dialCode = this.value;

                        selectedFlag.innerHTML = `<img src="${flagImg}" width="25" height="16">`;
                        selectedCode.textContent = dialCode;
                    });
                });
            });



        $('#LoginMobile').on('keyup change', function () {
            let value = $(this).val().trim();

            if (value === '') return;

            if (!isNaN(value.charAt(0))) {
                $('.LoginCountryCode').addClass('d-block').removeClass('d-none');
                $('.LoginMobileDesign').addClass('').removeClass('col-12');
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
                             toastr.success(resp.message);
                        setTimeout(() => {
                             location.href = "/";
                        }, 1000);
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

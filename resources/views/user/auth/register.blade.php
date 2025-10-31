
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
                     <form id="signup">
                        @csrf
                    <h4>Sign Up</h4>
                    <h3>Create your account !</h3>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="">Full Name</label>
                        <input type="text" id="login-password" name="full_name" class="form-control custom-password"
                            placeholder="Enter Full Name" style="padding-right: 40px;"/>
                    </div>
                    <span class="text-danger" id="error-full_name"></span>

                    <div class="form-group mt-3">
                        <label class="d-block" for="">Mobile Number</label>
                        <div class="row">
                        <div class="col-3">
                        <select name="country_code" id="" class="form-control">
                            @foreach ($country as $item)                       
                                <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                            @endforeach
                        </select>
                         </div> 
                         <div class="col-9">
                         <input type="number" class="form-control"  value="" placeholder="Enter Mobile Number" name="mobile">
                        </div>
                        </div>
                        {{-- <input type="hidden" value="+91" name="country_code" id="country_code"> --}}
                    </div>
                     <span class="text-danger" id="error-mobile"></span>
                    <div class="form-group position-relative verify mt-3">
                        <label class="d-block" for="">Email Address</label>
                        <input type="text" id="login-password" class="form-control custom-password"
                            placeholder="Enter Full Name" style="padding-right: 40px;" name="email"/>
                    </div>
                    <span class="text-danger" id="error-email"></span>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="">Create Password</label>
                        <input type="password" id="login-password" class="form-control custom-password"
                            placeholder="Enter password" style="padding-right: 40px;"  name="password"/>
                        <i class="fa-solid fa-eye toggle-password" id="toggleIcon"></i>
                    </div>
                    <span class="text-danger" id="error-password"></span>
                    <div class="form-group position-relative password_icon mt-3">
                        <label for="">Confirm Password</label>
                        <input type="password" id="login-password" class="form-control custom-password"
                            placeholder="Enter confirm password" style="padding-right: 40px;" name="confirm_password"/>
                        <i class="fa-solid fa-eye toggle-password" id="toggleIcon"></i>
                    </div>
                    <span class="text-danger" id="error-confirm_password"></span>
                    <div class="form-check term_policy my-3">
                        <input class="form-check-input" type="checkbox" value="1" id="checkIndeterminate" name="accept_terms">
                        <label class="form-check-label" for="checkIndeterminate">
                            I accept the <a href="">Terms & Conditions</a> and <a href="">Policies</a>
                        </label>
                    </div>
                     <span class="text-danger" id="error-accept_terms"></span>
                    <button type="submit" class="customBtn" id="signBtn">Sign Up</button>
                    </form>
                    <p class="mt-3 dontAccount">Don’t have an account? <a href="{{route('userLogin')}}">Sign In</a></p>
                </div>
            
            </div>
           
    </div>

     <script>
        $(document).on('submit', '#signup', function (e) {
            e.preventDefault();

            let data = new FormData(this);

            $('#signBtn').prop('disabled', true);


            $.ajax({
                url: "{{ route('userRegister') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                   
                    if(resp.status == true){
                        location.href = `verify-otp?temp_user_id=${resp.id}`;
                    }

                    if(resp.status == false){
                        for (const key in resp.errors) {
                            console.log(resp.errors[key])
                            $(`#error-${key}`).html(resp.errors[key]);
                        }   
                    }

                },
                error: function (xhr) {
                    console.log(xhr.responseJSON);
                }, complete: function () {
                   $('#signBtn').prop('disabled', false);
                }
            });
        });

     </script>

@endsection

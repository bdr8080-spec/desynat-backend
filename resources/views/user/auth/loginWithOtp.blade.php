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
                <div class="otp-page">
                    <h3 class="h3-heading"><span><a href="{{ url()->previous() }}"><i class="fa-solid fa-chevron-left"></i></a></span> Login Via OTP</h3>
                <form id="loginWithOtp">
                    @csrf
                    <div class="form-group mt-3">
                        <label class="d-block" for="">Enter Mobile Number</label>
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
                        <span class="text-danger" id="error-mobile"></span>
                    </div>

                    </div>
                    <button type="submit" class="customBtn mt-5" >Continue</button>
                </form>
                </div>
            </div>
          
        </div>
    </div>


    
     <script>

        document.addEventListener('keydown', function(e) {
            if (e.key === ' ') {
                e.preventDefault();
            }
        });



        $(document).on('submit', '#loginWithOtp', function (e) {
            e.preventDefault();

            let data = new FormData(this);

            $('#signBtn').prop('disabled', true);


            $.ajax({
                url: "{{ route('loginWithOtp') }}",
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
                    if(xhr.responseJSON.status==false){
                            toastr.error(xhr.responseJSON.message);
                    }
                }, complete: function () {
                   $('#signBtn').prop('disabled', false);
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
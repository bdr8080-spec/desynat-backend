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
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> OTP</h3>
                    @php

                    use Illuminate\Support\Facades\Crypt;
                    use App\Models\User;

                    try {
                            $id = Crypt::decryptString(request()->temp_user_id);
                            $user  = User::where('id',$id)->first();
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Invalid user reference.',
                            ], 400);
                        }

                    @endphp
                    <h5 class="otp_sent">6 digit OTP has been sent to your registered Mobile Number <span>{{$user->country_code}} {{$user->mobile}}</span></h5>
                       <form id="otpVerify">
                        @csrf
                        <input type="hidden" name="id" value="{{request()->temp_user_id}}">
                        <input type="hidden" name="forget_password" value="{{request()->forget_password}}">
                       <div class="otp-container mt-3">
                        <input type="text" maxlength="1" class="otp-input" id="otp1" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp2" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp3" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp4"  name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp5"  name="otp[]" />
                         <input type="text" maxlength="1" class="otp-input" id="otp6" name="otp[]" />
                     
                    </div>
                    
                    <button type="submit" class="customBtn mt-5" id="otpVerifyBtn">Continue</button>
                        </form>
                </div>
            </div>
        </div>
    </div>

      <script>
        $(document).on('submit', '#otpVerify', function (e) {
            e.preventDefault();

            let data = new FormData(this);

             $('#otpVerifyBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('userVerifyOtp') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                        location.href = resp.redirect_url
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseJSON.message);
                   toastr.error(xhr.responseJSON.message)
                },
                 complete: function () {
                   $('#otpVerifyBtn').prop('disabled', false);
                }
            });
        });

     </script>

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

@endsection
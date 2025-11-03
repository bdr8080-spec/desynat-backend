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
                    <h3 class="h3-heading">
                        <span><a href="{{ url()->previous() }}"><i class="fa-solid fa-chevron-left"></i></a></span> OTP</h3>
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
                  
                @if ($user)
                    <h5 class="otp_sent">
                        6 digit OTP has been sent to your registered 
                        @if (request()->type == '2')
                            Email Address: <span>{{ $user->email }}</span>
                        @else
                            Mobile Number: <span>{{ $user->country_code }} {{ $user->mobile }}</span>
                        @endif
                    </h5>
                @endif
                  
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
                    <button type="button" class="customBtnresend" id="resendOtpBtn" onclick="resendOtp()">Resend OTP</button>
                    <button type="submit" class="customBtn mt-5" id="otpVerifyBtn">Verify OTP</button>
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
                    }else{
                        toastr.error(resp.error);
                    }
                },
                error: function (xhr) {
                   toastr.error(xhr.responseJSON.message)
                },
                 complete: function () {
                   $('#otpVerifyBtn').prop('disabled', false);
                }
            });
        });

  
            function resendOtp() {
            let id = "{{ request()->temp_user_id }}"; 
            let button = document.getElementById('resendOtpBtn');
            let timer = 30; 

            button.disabled = true;
            button.innerText = `Resend OTP (${timer}s)`;

            let countdown = setInterval(() => {
                timer--;
                button.innerText = `Resend OTP (${timer}s)`;

                if (timer <= 0) {
                    clearInterval(countdown);
                    button.disabled = false;
                    button.innerText = "Resend OTP";
                }
            }, 1000);

            $('#resendOtpBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('userResendOtp') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (resp) {
                    toastr.success(resp.message);
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                },
                complete: function () {
                    $('#resendOtpBtn').prop('disabled', false);
                }
            });
        }



    
    
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
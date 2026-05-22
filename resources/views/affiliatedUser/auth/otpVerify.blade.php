@extends('user.auth.layout.app')



@section('content')

   <!-- <style>


        iframe#\:1\.container {
    visibility: hidden !important;
}

/* Hide the Google Translate tooltip */
.goog-te-banner-frame.skiptranslate,
.goog-tooltip,
.goog-tooltip:hover,
.goog-tooltip-vertical {
    display: none !important;
}

/* Hide the feedback popup on selected text */
#goog-gt-tt {
    display: none !important;
}
    </style>

    <style>
  body {
    visibility: hidden;
  }
</style> -->


<div class="login_contenar">
    <header class="inner-header">
        <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
        <div class="d-flex align-items-center becomSeller">
            <div class="dropdown ms-3">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                        data-bs-toggle="dropdown">

                        <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                        <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif</span>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end langu">

                        <li>
                            <a class="dropdown-item" data-lang="ar" href="{{route('userLanguage','ar')}}">
                                <span>{{ __('admin_messages.ar') }}</span> {{ __('affiliate_messages.arabic') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" data-lang="en" href="{{route('userLanguage','en')}}">
                                <span>{{ __('admin_messages.en') }}</span> {{ __('affiliate_messages.english') }}
                            </a>
                        </li>

                    </ul>
            </div>
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
                    <span><a href="{{ url()->previous() }}"><i class="fa-solid fa-chevron-left"></i></a></span> 
                    {{ __('affiliate_messages.otp_verification') }}
                </h3>
                @php

                use Illuminate\Support\Facades\Crypt;
                use App\Models\AffilatedUser;

                try {
                $id = Crypt::decryptString(request()->temp_user_id);
                $user = AffilatedUser::where('id', $id)->first();
                } catch (\Exception $e) {
                return response()->json(
                [
                'status' => false,
                'message' => 'Invalid user reference.',
                ],
                400,
                );
                }

                @endphp

                @if ($user)
                <h5 class="otp_sent">
                    {{ __('affiliate_messages.6_digit_otp_has_been_sent_to_your_registered') }}
                    @if (request()->type == '2')
                    {{ __('affiliate_messages.email_address') }}: <span>{{ $user->email }}</span>
                    @else
                    {{ __('affiliate_messages.mobile_number') }}: <span>{{ $user->country_code }} {{ $user->mobile }}</span>
                    @endif
                </h5>
                @endif

                <form id="otpVerify">
                    @csrf
                    <input type="hidden" name="id" value="{{ request()->temp_user_id }}">
                    <input type="hidden" name="forget_password" value="{{ request()->forget_password }}">
                    <input type="hidden" name="type" value="{{request()->type}}">
                    <div class="otp-container mt-3">
                        <input type="text" maxlength="1" class="otp-input" id="otp1" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp2" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp3" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp4" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp5" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp6" name="otp[]" />

                    </div>
                    <div class="resend-otp-container"
                        style="display: flex;justify-content: center;margin-top:20px !important;xmargin:0 auto; align-items: center; gap: 10px;">
                        <button type="button" class="customBtnresend" id="resendOtpBtn" onclick="resendOtp()">{{ __('affiliate_messages.resend_otp') }}
                            </button>
                        <span id="otpTimer" style="color: red;"></span>
                    </div>
                    <button type="submit" class="customBtn customBtn5 mt-5" id="otpVerifyBtn">{{ __('affiliate_messages.verify_otp') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <div id="google_translate_element" style="display:none;"></div>
<div id="loaderTrans"
        style="display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:#ffffff; 
        z-index:999999;   
        /* display:flex;    */
        align-items:center;
        justify-content:center;">

        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"
                style="border:none; width:200px; height:200px;">
        </iframe>
    </div> -->

<script>
$(document).on('submit', '#otpVerify', function(e) {
    e.preventDefault();

    let data = new FormData(this);

    $('#otpVerifyBtn').prop('disabled', true);

    $.ajax({
        url: "{{ route('affiliate.affiliate_otpVerify') }}",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(resp) {
            if (resp.status == true) {
                toastr.success(resp.message);
                setTimeout(() => {
                    location.href = resp.redirect_url
                }, 1000);
            } else {
                toastr.error(resp.error);
            }
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON.message)
        },
        complete: function() {
            $('#otpVerifyBtn').prop('disabled', false);
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    startOtpTimer(); // Start automatically on page load
});

function startOtpTimer() {
    let button = document.getElementById('resendOtpBtn');
    let timerDisplay = document.getElementById('otpTimer');
    let timer = 50; // seconds

    button.disabled = true;
    timerDisplay.innerText = `${timer}s`;

    let countdown = setInterval(() => {
        timer--;
        timerDisplay.innerText = `${timer}s`;

        if (timer <= 0) {
            clearInterval(countdown);
            button.disabled = false;
            timerDisplay.innerText = ""; // Hide timer after completion
        }
    }, 1000);
}

function resendOtp() {
    let id = "{{ request()->temp_user_id }}";

    // Restart the timer
    startOtpTimer();

    $.ajax({
        url: "{{ route('affiliate_signupResendOtp') }}",
        type: "POST",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },
        success: function(resp) {
            toastr.success(resp.message);
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON?.message || 'Something went wrong');
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
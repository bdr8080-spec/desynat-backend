@extends('user.layout.app')

@section('content')
    <div class="login_contenar">
        <div class="login_content login_content_left">
            <img src="{{asset('user/assets/images/left-img.svg')}}" class="left-imgone" />
            <img src="{{asset('user/assets/images/logoone.svg')}}" class="left-img" />
            <img src="{{asset('user/assets/images/right-img.svg')}}" class="left-imgtwo" />
        </div>
        <div class="login_content login_content_right">
            <div class="login_content_content align-self-center">
                <div class="otp-page">
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> OTP</h3>
                    <h5 class="otp_sent">Email verification link has been sent to your <span>email@example.com</span></h5>
                    <!-- <div class="otp-container mt-3">
                        <input type="text" maxlength="1" class="otp-input" id="otp1" />
                        <input type="text" maxlength="1" class="otp-input" id="otp2" />
                        <input type="text" maxlength="1" class="otp-input" id="otp3" />
                        <input type="text" maxlength="1" class="otp-input" id="otp4" />
                    </div> -->
                    <a type="button" class="customBtn mt-5" href="" data-bs-toggle="modal" data-bs-target="#verificationEmailConfirm">Verify Email</a>
                </div>
            </div>
        </div>
     </div>


     <!-- Modal -->
    <div class="modal fade" id="verificationEmailConfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/images/success.svg" class="img-fluid" />
                    <p>Email Verification Link Sent Successfully!</p>
                </div>
            </div>
        </div>
    </div>

 @endsection
@include('affiliatedUser.layout.header')

<section class="section dashboard page-100">

    <div class="login_content-box">
        <div class="d-flex justify-content-between mt-4 mb-5">
            <a href="/" class="title24 alink">
                <i class="bi bi-chevron-left"></i> OTP Verification
            </a>
        </div>

        <div class="login_content_content align-self-center">
            <form id="verifyOtp">
                <div class="otp-page">
                    <h6 class="otp_sent">To change mobile number. a verification code has been sent <span class="gold-color"> +91 - 123456789</span></h6>
                    <div class="otp-container mt-3">
                        <input type="text" maxlength="1" class="otp-input" id="otp1" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp2" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp3" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp4" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp5" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp6" name="otp[]" />
                    </div>
                </div>

                <div class="text-center mt-4">
                    <div class="resend gold-color"> Resend OTP <span>30 Sec</span></div>
                </div>

                <div class="dashboard-button mt-5">
                    <button type="submit" class="btn add-fillbtn w-100">Verify OTP</button>
                </div>

            </form>
        </div>
    </div>

    <!---- Change Mobile Number ------->
    <div class="login_content-box">
        <div class="d-flex justify-content-between mt-4 mb-5">
            <a href="/" class="title24 alink">
                <i class="bi bi-chevron-left"></i> Change Mobile Number
            </a>
        </div>

        <div class="login_content_content align-self-center">
            <form>
                <div class="otp-page">
                    <h6 class="otp_sent">Great! Now enter the mobile number you want to continue with</h6>
                </div>
                <div class="form-group mt-3">
                    <div class="w-100 LoginMobileDesign">
                        <input type="text" class="form-control notapplyspace"
                            placeholder="Please enter mobile number"
                            name="mobile" maxlength="15">
                    </div>
                </div>


                <div class="dashboard-button mt-5">
                    <button type="submit" class="btn add-fillbtn w-100">Continue</button>
                </div>

            </form>
        </div>
    </div>



</section>



<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>



@include('affiliatedUser.layout.footer')
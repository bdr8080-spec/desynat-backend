<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">

    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<style>
#otpSentMessage {
    white-space: nowrap;
}
</style>
</head>

<body style="background-color: rgba(227, 194, 149, 0.75) !important;">
    <style>
    /* .auth-wrapper {
        display: flex;
        height: 100vh;
        width: 100%;
        max-width: 900px;
        margin: 10% auto;
    } */

    .auth-left {
        flex: 1;
        background: url("image/background-image.svg") no-repeat center center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .brand-header {
        position: absolute;
        top: 30px;
        left: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-logo {
        width: 45px;
        height: 45px;
    }

    .brand-name {
        font-size: 38px;
        font-weight: 600;
        font-family: "Georgia", serif;
        color: #000;
    }

    .auth-right {
        flex: 1;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 17px;
        border: 1px solid #ddd;
        border-radius: 0px 20px 20px 0px;
    }

    .auth-form-wrapper {
        width: 350px;
    }

    .loginBackgroundeffect {
        max-width: 576px;
    }

    .custom-topbar {
     background: linear-gradient(269.87deg, #6E4527 -17.01%, #DFBF8F 99.89%) !important;
        height: 74px;
        border-radius: 6px;
        padding: 0 25px;
        display: flex;
        align-items: center;
    }

    .header-logo {
        width: 110px;
        height: 66px;
        border-radius: 50%;
        object-fit: contain;
    }

    .brand-name {
        font-size: 22px;
        font-weight: 600;
        font-family: 'Georgia', serif;
        margin-left: 12px;
        color: #000;
    }

    .header-divider {
        flex: 1;
        /* border-bottom: 1.5px dotted rgba(0, 0, 0, 0.5); */
        margin: 0 25px;
    }

    .lang-btn {
        background: transparent;
        border: 1px solid rgba(0, 0, 0, 0.7);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    </style>
    <nav class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow fixed-top">


        <div class="left-section d-flex align-items-center">
            <img src="image/favicon.svg" class="header-logo" />
            <img src="image/Desynat Logo_Final 1.svg" class="header-logo" />

        </div>

        <div class="header-divider"></div>

        <div class="right-section">
            <button class="lang-btn">
                <i class="fas fa-globe"></i> EN
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </nav>

    <div class="auth-wrapper">
        <div class="wrapper-inner">
            <!-- LEFT SIDE -->
            <div class="auth-left">
                <div class="brand-header">

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="auth-right">
                <div class="login-container-div">
                    <div class="login">
                        <div class="loginBackgroundeffect text">
                            <div class="row">
                                <!-- HEADER BACK NAV -->
                                <div class="col-lg-12">
                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <div class="arrow">
                                            <a class="table-button" href="{{ route('forgotPassword') }}">
                                                <i class="fas fa-angle-left"></i>
                                            </a>
                                        </div>
                                        <h4 class="m-0">OTP</h4>
                                    </div>
                                </div>

                                <!-- <div class="login">
                                <div class="loginBackgroundeffect"> -->
                                <h5 class="text-start" id="otpSentMessage">
                                    6 digit OTP has been sent to: <span id="adminEmail">{{ $email ?? '' }}</span>
                                </h5>



                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="otp-container">
                                                @for ($i = 1; $i <= 6; $i++) <input type="text" maxlength="1"
                                                    class="otp-input" id="otp-{{ $i }}" required>
                                                    @endfor
                                            </div>
                                            <span class="text-danger" id="otpError"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="#" id="resendOtp">Resend OTP</a>
                                        </div>
                                    </div>

                                    <div class=" text-center">
                                        <div id="timerOtp">Resend OTP in <span id="seconds">30</span> Secs</div>
                                    </div>

                                    <div class="button d-flex align-items-center justify-content-center">
                                        <button class="btn custom-btn" id="submitOtp"
                                            style="max-width: 100% !important;">Submit</button>
                                    </div>

                                </div>
                                <!-- </div>
                            </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>

    <script>
    $(document).ready(function() {
        let timer = 60;
        let interval;

        // Hide resend button initially
        $('#resendOtp').prop('disabled', true);
        $('#resendOtp').hide();
        $('#timerOtp').show(); // Show timer at start

        function startTimer() {
            clearInterval(interval); // prevent multiple intervals
            $('#timerOtp').show(); // show timer whenever countdown starts
            $('#seconds').text(formatTime(timer));

            interval = setInterval(() => {
                timer--;
                $('#seconds').text(formatTime(timer));

                if (timer <= 0) {
                    clearInterval(interval);
                    $('#resendOtp').prop('disabled', false);
                    $('#resendOtp').show(); // show resend button after timer ends
                    $('#timerOtp').hide(); // hide timer text
                }
            }, 1000);
        }

        function formatTime(seconds) {
            let min = Math.floor(seconds / 60);
            let sec = seconds % 60;
            return `${min.toString().padStart(2,'0')}:${sec.toString().padStart(2,'0')}`;
        }

        startTimer();

        // OTP input auto-focus
        $('.otp-input').on('input', function() {
            let next = $(this).next('.otp-input');
            if (next.length && $(this).val()) next.focus();
            $('#otpError').text('');
        });

        // Submit OTP
        $('#submitOtp').click(function(e) {
            e.preventDefault();
            let otp = '';
            $('.otp-input').each(function() {
                otp += $(this).val();
            });

            if (otp.length === 0) {
                $('#otpError').text('Please Enter OTP');
                return;
            } else if (otp.length > 0 && otp.length < 6) {
                $('#otpError').text('Please Enter Full 6-digit OTP');
                return;
            }

            $.ajax({
                url: '{{ route("optVerify") }}',
                type: 'POST',
                data: {
                    otp: otp,
                    email: $('#adminEmail').text(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.changePassword') }}";
                        }, 2000); 
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.otp) $('#otpError').text(errors.otp[0]);
                    }
                }
            });
        });

        // Resend OTP
        $('#resendOtp').click(function(e) {
            e.preventDefault();

            if ($(this).prop('disabled')) return;

            $.ajax({
                url: '{{ route("resendOtp") }}',
                type: 'POST',
                data: {
                    email: $('#adminEmail').text(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Reset timer and message
                        timer = 60;
                        $('#resendOtp').prop('disabled', true).hide();

                        let email = $('#adminEmail').text();
                        $('#otpSentMessage').html('6 digit OTP has been resent to: <span id="adminEmail">' + email + '</span>');

                        toastr.success(response.message);

                        startTimer(); // restart timer display
                    }
                }
            });
        });
    });
    </script>

</body>

</html>
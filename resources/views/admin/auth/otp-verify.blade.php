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

<body>

    <nav class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow fixed-top">


        <div class="left-section d-flex align-items-center">
            <img src="{{asset('admin/image/logo.svg')}}" class="img-fluid" />

        </div>

        <div class="header-divider"></div>

        <div class="right-section">
            <button class="lang-btn">
                <i class="fas fa-globe"></i> EN
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </nav>





    <div class="container-fluid p-0">
        <div class="login-grid-bg">

            <div class="row g-0">
                <div class="col-lg-6 bg-logo-wapper">
                    <div class="login-img">
                        <img src="/admin/image/Desynat-logo-2.svg" alt="image" class="img-fluid logo-login">
                    </div>
                    <img src="/admin/image/Vector-left.svg" alt="image" class="vector-left">
                    <img src="/admin/image/Vector-right.svg" alt="image" class="vector-right">
                </div>
                <div class="col-lg-6">
                    <!-- RIGHT SIDE -->
                    <div class="login-content pt-40">
                        <div class="login-grid-2">
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
                                            6 digit OTP has been sent to: <span
                                                id="adminEmail">{{ $email ?? '' }}</span>
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
                            window.location.href =
                                "{{ route('admin.changePassword') }}";
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
                        $('#otpSentMessage').html(
                            '6 digit OTP has been resent to: <span id="adminEmail">' +
                            email + '</span>');

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
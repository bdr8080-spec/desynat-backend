@extends('user.profile.layout.app')

@section('content')
    <div class="login_contenar">
        <div class="login_content login_content_left">
            <img src="{{asset('user/assets/images/left-img.svg')}}" class="left-imgone" />
            <img src="{{asset('user/assets/images/logoone.svg')}}" class="left-img" />
            <img src="{{asset('user/assets/images/right-img.svg')}}" class="left-imgtwo" />
        </div>
        <div class="login_content login_content_right">
            <div class="login_content_content align-self-center">
                <form id="verifyOtp">
                    @csrf
                    <input type="hidden" value="{{request()->id}}" name="id">
                <div class="otp-page">
                    <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> OTP</h3>
                    @if (request()->email)
                          <h5 class="otp_sent">To change email address. a verification code has been sent <span>{{request()->email}}</span></h5>
                    @else
                          <h5 class="otp_sent">To change mobile no. a verification code has been sent <span>{{request()->country_code}} {{request()->mobile}}</span></h5>
                    @endif
                     <div class="otp-container mt-3">
                        <input type="text" maxlength="1" class="otp-input" id="otp1" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp2" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp3" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp4" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp5" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" id="otp6" name="otp[]" />
                    </div>
                    <button type="submit" class="customBtn mt-5" id="verifyBtn">Verify OTP</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verifiedConfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/images/success.svg" class="img-fluid" />
                    <p id="updateMessage">Mobile Number Changed successfully !</p>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade" id="verifiedConfirmEmail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/images/success.svg" class="img-fluid" />
                    <p id="updateMessage">Email Address Change Successfully !</p>
                </div>
            </div>
        </div>
    </div>
     
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).on('submit', '#verifyOtp', function (e) {
            e.preventDefault();
            let data = new FormData(this);
            $('#verifyBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('userOldNumberVerify') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (resp) {
                    if (resp.status === true) {

                        const urlParams = new URLSearchParams(window.location.search);
                        const type = urlParams.get('type');
                        const formFor = urlParams.get('for');

                    
                        if (formFor === 'mobile') {
                            toastr.success(resp.message);
                            if (type === '0') {
                                setTimeout(() => {
                                    location.href = "update-new-number";
                                }, 1000);
                            } else if (type === '1') {
                                $('#verifiedConfirm').modal('show');
                                setTimeout(() => {
                                    location.href = "profile";
                                }, 1000);
                            }
                        } else if (formFor === 'email') {
                            if (type === '0') {
                                setTimeout(() => {
                                    location.href = "update-email-address";
                                }, 1000);
                            } else if (type === '1') {
                                $('#verifiedConfirmEmail').modal('show');
                                setTimeout(() => {
                                    location.href = "profile";
                                }, 1000);
                            }
                        }
                    } else {
                        toastr.error(resp.error || "Something went wrong. Please try again.");
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error("An error occurred while processing your request.");
                    }
                },
                complete: function () {
                    $('#verifyBtn').prop('disabled', false);
                }
            });
        });

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if ($errors->any())
            toastr.error("{{ $errors->first() }}");
        @endif
    </script>



 @endsection
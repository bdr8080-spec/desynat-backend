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
                    if(resp.status == true){
                             toastr.success(resp.message);

                     if(resp.type == '0'){
                        setTimeout(() => {
                             location.href = "update-new-number";
                        }, 1000);
                     }else{
                        setTimeout(() => {
                             location.href = "profile";
                        }, 1000);
                     }
                    }

                    if(resp.status == false){
                       toastr.error(resp.error);  
                    }

                },
                error: function (xhr) {
                   toastr.error(xhr.responseJSON.message);
                },
                complete: function () {
                   $('#verifyBtn').prop('disabled', false);
                }
            });
        });


    </script>
 @endsection
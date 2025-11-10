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
                <h3 class="h3-heading"><span><i class="fa-solid fa-chevron-left"></i></span> Change Mobile Number</h3>
                <h5 class="otp_sent">Great! now enter the mobile number that you want to continue with</h5>
                <ul class="dropdown-menu" aria-labelledby="countryDropdown" style="max-height: 250px; overflow-y: auto;">
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2 country-option" style="cursor: pointer;">
                            <input type="radio" name="country_code"
                                value="+1"
                                data-flag="flag1.png"
                                class="country-radio">
                            <img src="{{asset('user/assets/images/flag1.png')}}" alt="flag of dfd" width="25" height="16">
                            <span>fsdfs</span>
                        </label>
                    </li>
                </ul>
                <a type="button" class="customBtn mt-5" href="{{('/route5')}}">Verify OTP</a>
            </div>
        </div>
    </div>
     </div>

 @endsection
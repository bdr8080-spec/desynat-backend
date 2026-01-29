@extends('user.auth.layout.app')


@section('content')
<div class="login_contenar">
    <header class="inner-header">
        <a href="#"><img src="assets/images/logo.svg" class="img-fluid" /></a>
        <div class="d-flex align-items-center becomSeller">

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="assets/images/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
            <!-- <a href="{{url('/seller/login')}}" class="customBtn1">Become a seller</a> -->
        </div>
    </header>
    <div class="login_content login_content_left">
        <img src="assets/images/left-img.svg" class="left-imgone" />
        <img src="assets/images/logoone.svg" class="left-img" />
        <img src="assets/images/right-img.svg" class="left-imgtwo" />
    </div>
    <div class="login_content login_content_right">
        <div class="login_content_content">
            <form id="userLogin">
                @csrf
                <div class="d-flex align-items-center justify-content-between">
                    <h4>Sign In</h4>
                    <p class="guest"><a href="{{route('dashboard')}}">Switch to User</a></p>
                </div>
                <h3>Welcome back !</h3>
                <div class="form-group mt-lg-4 mt-md-3 mt-2">
                    <label for="">Mobile Number or Email Address</label>

                    <div class="d-flex align-items-center">
                        <div class=" d-none LoginCountryCode">
                            {{-- <select name="country_code" id="" class="country form-control">
                                    @foreach ($country as $item)                       
                                        <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                            @endforeach
                            </select> --}}

                            <div class="dropdown">
                                <button
                                    class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                    type="button" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                                    <span id="selected-flag">
                                        {{ old('country_flag', $country[0]->flag) }}


                                    </span>

                                    <span id="selected-code" class="ms-2">
                                        {{ old('country_code', $country[0]->dial_code) }}
                                    </span>
                                </button>

                                <ul class="dropdown-menu p-2 " aria-labelledby="countryDropdown">

                                    @foreach ($country as $index => $item)
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center gap-2 country-option"
                                            style="cursor: pointer;">
                                            <input type="radio" name="country_code" value="{{ $item->dial_code }}"
                                                data-flag="{{ $item->flag }}" data-name="{{ $item->name }}"
                                                class="country-radio"
                                                {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                hidden>

                                            <!-- <img src="{{ $item->flag1 }}"
                                                        alt="Flag of {{ $item->name }}"
                                                        width="25" height="16">

                                                    <span>{{ $item->dial_code }}
                                                        ({{ $item->name }})
                                                    </span> -->

                                            <div width="25" height="16">
                                                <span>{{ $item->flag }} {{ $item->dial_code }}
                                                    ({{ $item->name }})
                                                </span>
                                            </div>

                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                        <div class="w-100 LoginMobileDesign">
                            <input type="text" class="form-control notapplyspace" value=""
                                placeholder="Please enter mobile number or email address" name="mobileOrEmail"
                                id="LoginMobile" />
                        </div>
                    </div>
                </div>
                <span class="text-danger" id="error-mobileOrEmail"></span>
                <div class="form-group position-relative password_icon mt-lg-3 mt-md-2 mt-1">
                    <label for="">Password</label>
                    <input type="password" name="password" id="login-password"
                        class="form-control custom-password notapplyspace" placeholder="Please enter password"
                        style="padding-right: 40px;" />
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                <span class="text-danger" id="error-password"></span>
                <p class=" mt-3 mb-4"><a href="{{route('affiliate_forgotpassword')}}">Forgot password ?</a></p>
                <button type="submit" class="customBtn mb-3" id="loginButtom">Login</button>
            </form>
            <a class="customBtn2" style="text-decoration: none;" href="{{route('affiliate_loginWithOtp')}}">Login Via
                OTP</a>

            <p class="mt-3 dontAccount">Don’t have an account? <a href="{{route('affiliate.affiliate_signup')}}">Sign
                    up</a></p>

        </div>
    </div>
</div>


<script>
// document.addEventListener('DOMContentLoaded', function () {
//     const radios = document.querySelectorAll('.country-radio');
//     const selectedFlag = document.getElementById('selected-flag');
//     const selectedCode = document.getElementById('selected-code');

//     radios.forEach(radio => {
//         radio.addEventListener('change', function () {
//             const parent = this.closest('label');

//             let flagImg = radio.data('flag');


//             const flagImg = parent.querySelector('img').src;
//             const dialCode = this.value;

//             selectedFlag.innerHTML = `${flagImg}`;
//             selectedCode.textContent = dialCode;
//         });
//     });
// });

$(document).ready(function() {
    // When a user selects a country (clicks a label)
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });
});



$('#LoginMobile').on('keyup change', function() {
    let value = $(this).val().trim();

    if (value === '') return;

    if (!isNaN(value.charAt(0))) {
        $('.LoginCountryCode').addClass('d-block').removeClass('d-none');
        $('.LoginMobileDesign').addClass('').removeClass('col-12');
    } else {
        $('.LoginCountryCode').addClass('d-none').removeClass('d-block');
        $('.LoginMobileDesign').addClass('col-12').removeClass('col-9');
    }
});



$(document).on('submit', '#userLogin', function(e) {
    e.preventDefault();

    let data = new FormData(this);

    $('#loginButtom').prop('disabled', true);

    $.ajax({
        url: "{{ route('affiliate.affiliate_login') }}",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(resp) {
            if (resp.status == true) {

                if (resp.data.admin_verify == '2') {
                    toastr.success(resp.message);
                }

                setTimeout(() => {
                    location.href = "{{route('affiliate.affiliateDashboard')}}";
                }, 1000);
            }

            if (resp.status == false) {
                for (const key in resp.errors) {
                    console.log(resp.errors[key])
                    $(`#error-${key}`).html(resp.errors[key]);
                }
            }

        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON.message);
        },
        complete: function() {
            $('#loginButtom').prop('disabled', false);
        }
    });
});
</script>

@endsection
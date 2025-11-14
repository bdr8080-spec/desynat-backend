@extends('user.auth.layout.app')


@section('content')


 <div class="login_contenar">
        <header class="inner-header">
            <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
            <div class="d-flex align-items-center becomSeller">
                <a href="">Become a seller</a>
                <div class="dropdown ms-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/images/global.svg" class="img-fluid" /> EN
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                        <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
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
                    <h3 class="h3-heading"><span><a href="{{ url()->previous() }}"><i class="fa-solid fa-chevron-left"></i></a></span> Login Via OTP</h3>

                    <form id="loginWithOtp">
                            @csrf

                            {{-- Radio Selection --}}
                            <div class="radio-group my-4">
                                <label class="custom-radio">
                                    <input type="radio" name="forgetPassword" class="emailandmobile notapplyspace" value="1" checked>
                                    <span class="radio-mark"></span>
                                    <span class="label-text">Mobile Number</span>
                                </label>

                                <label class="custom-radio">
                                    <input type="radio" name="forgetPassword" class="emailandmobile" value="2">
                                    <span class="radio-mark"></span>
                                    <span class="label-text">Email Address</span>
                                </label>
                            </div>

                            {{-- Mobile Input Section --}}
                            <div class="form-group position-relative mt-3 mobileInput">
                                <label for="">Enter Mobile Number</label>
                                <div class="d-flex align-items-center">

                                    {{-- Country Dropdown --}}
                                    <div>
                                        <div class="dropdown">
                                            <button class="btn btn-light border dropdown-toggle d-flex align-items-center" type="button"
                                                    id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span id="selected-flag">
                                                    <img src="{{ $country[0]->flag }}" alt="flag" width="25" height="16">
                                                </span>
                                                <span id="selected-code" class="ms-2">{{ $country[0]->dial_code }}</span>
                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="countryDropdown" style="max-height: 250px; overflow-y: auto;">
                                                @foreach ($country as $index => $item)
                                                    <li>
                                                        <label class="dropdown-item d-flex align-items-center gap-2 country-option" style="cursor: pointer;">
                                                            <input type="radio" name="country_code"
                                                                value="{{ $item->dial_code }}"
                                                                data-flag="{{ $item->flag }}"
                                                                class="country-radio"
                                                                {{ $index === 0 ? 'checked' : '' }} hidden>
                                                            <img src="{{ $item->flag }}" alt="Flag of {{ $item->name }}" width="25" height="16">
                                                            <span>{{ $item->dial_code }} ({{ $item->name }})</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="w-100">
                                        <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile Number" maxlength="15"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)">
                                    </div>
                                </div>
                            </div>
                              <p class="text-danger" id="error-mobile"></p>

                            <div class="form-group position-relative password_icon mt-3 d-none emailInput">
                                <label for="">Enter Email ID</label>
                                <input class="form-control notapplyspace" type="email" placeholder="Enter Email ID" name="email">
                                 <p class="text-danger" id="error-email"></p>
                            </div>
                             

                            <button type="submit" class="customBtn customBtn5 mt-4">Continue</button>
                        </form>
         
                </div>
            </div>
          
        </div>
    </div>


    
     <script>


        document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('.country-radio');
                const selectedFlag = document.getElementById('selected-flag');
                const selectedCode = document.getElementById('selected-code');

                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        const parent = this.closest('label');
                        const flagImg = parent.querySelector('img').src;
                        const dialCode = this.value;

                        selectedFlag.innerHTML = `<img src="${flagImg}" width="25" height="16">`;
                        selectedCode.textContent = dialCode;
                    });
                });
            });





        $(document).on('submit', '#loginWithOtp', function (e) {
            e.preventDefault();

            let data = new FormData(this);

            $('#signBtn').prop('disabled', true);


            $.ajax({
                url: "{{ route('loginWithOtp') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {

                    toastr.success(resp.message);
                    if(resp.status == true){
                        setTimeout(() => {
                              location.href = `verify-otp?temp_user_id=${resp.id}&type=${resp.type}`;
                        }, 1000);
                    }

                    if(resp.status == false){
                        for (const key in resp.errors) {
                            console.log(resp.errors[key])
                            $(`#error-${key}`).html(resp.errors[key]);
                        }   
                    }

                },
                error: function (xhr) {
                    if(xhr.responseJSON.status==false){
                            toastr.error(xhr.responseJSON.message);
                    }
                }, complete: function () {
                   $('#signBtn').prop('disabled', false);
                }
            });
        });

     </script>


    <script>
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            const isPassword = input.getAttribute('type') === 'password';

            // Toggle between text/password
            input.setAttribute('type', isPassword ? 'text' : 'password');

            // Toggle the icon style
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
            const radios = document.querySelectorAll('.emailandmobile');
            const mobileInput = document.querySelector('.mobileInput');
            const emailInput = document.querySelector('.emailInput');

            // Listen for change on radio buttons
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === '1') {
                        // Show Mobile Input
                        mobileInput.classList.remove('d-none');
                        emailInput.classList.add('d-none');
                    } else if (this.value === '2') {
                        // Show Email Input
                        emailInput.classList.remove('d-none');
                        mobileInput.classList.add('d-none');
                    }
                });
            });
        });



  </script>

@endsection
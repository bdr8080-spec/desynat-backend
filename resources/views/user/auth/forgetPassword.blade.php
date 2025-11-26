@extends('user.auth.layout.app')
    
@section('content')
    <div class="login_contenar">
        <header class="inner-header">
            <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
            <div class="d-flex align-items-center becomSeller">
                <div class="dropdown ms-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/images/global.svg" class="img-fluid" /> EN
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                        <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                    </ul>
                </div>
                <a href="{{url('/seller/login')}}" class="customBtn1">Become a seller</a>
            </div>
        </header>
        <div class="login_content login_content_left">
            <img src="assets/images/left-img.svg" class="left-imgone" />
            <img src="assets/images/logoone.svg" class="left-img" />
            <img src="assets/images/right-img.svg" class="left-imgtwo" />
        </div>
        <div class="login_content login_content_right">
            <div class="login_content_content align-self-center">
                <div>
                    <h3 class="h3-heading"><span><a href="{{ route('userLogin') }}"><i class="fa-solid fa-chevron-left"></i></a></span>Forgot Password</h3>
                    <form id="forgetPassword">
                        @csrf
                    <div class="radio-group my-4">
                        <label class="custom-radio">
                            <input type="radio" name="forgetPassword" class="emailandmobile notapplyspace" value="1"  checked />
                            <span class="radio-mark"></span>
                            <span class="label-text">Mobile Number</span>
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="forgetPassword"  class="emailandmobile" value="2" />
                            <span class="radio-mark"></span>
                            <span class="label-text">Email Address</span>
                        </label>
                    </div>
                   
                    <div class="form-group position-relative mt-3 mobileInput">
                        <label for="">Enter Mobile Number</label>
                        <div class="d-flex align-items-center">
                            <div class="">
                                {{-- <select name="country_code" id="" class="country" class="form-control">
                                    @foreach ($country as $item)                       
                                        <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                                    @endforeach
                                </select> --}}

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
                                <input type="number" class="form-control"  value="" placeholder="Enter Mobile Number" name="mobile" maxlength="15"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)">
                            </div>
                        </div>
                        <p class="text-danger" id="error-mobile"></p>
                        </div>
                    </div>

                    <div class="form-group position-relative password_icon mt-3 d-none emailInput">
                        <label for="">Enter Email Id</label>
                        <input class="form-control notapplyspace" type="email" placeholder="Enter Mobile Number" name="email">
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




    $('.emailandmobile').on('click', function(e){
    
      let id = $(this).val();
      
        if (id == '2') {
            $('.emailInput').addClass('d-block').removeClass('d-none');
            $('.mobileInput').addClass('d-none').removeClass('d-block');
        } else {
            $('.emailInput').addClass('d-none').removeClass('d-block');
            $('.mobileInput').addClass('d-block').removeClass('d-none');
        }

    })


        $(document).on('submit', '#forgetPassword', function (e) {
            e.preventDefault();

            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('userForgetPassword') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                        location.href = `verify-otp?temp_user_id=${resp.id}&forget_password=one&type=${resp.type}`;
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
               
                },
                complete: function () {
                   $('#loginButtom').prop('disabled', false);
                }
            });
        });

     </script>

@endsection
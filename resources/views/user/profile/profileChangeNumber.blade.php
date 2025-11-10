@extends('user.layout.app')

@section('content')
    <div class="login_contenar">
    <div class="login_content login_content_left">
        <img src="{{asset('user/assets/images/left-img.svg')}}" class="left-imgone" />
        <img src="{{asset('user/assets/images/logoone.svg')}}" class="left-img" />
        <img src="{{asset('user/assets/images/right-img.svg')}}" class="left-imgtwo" />
    </div>
    <div class="login_content login_content_right">
        <form action="{{ route('userOldNumberSendOtp') }}" method="POST">
            @csrf
            <div class="login_content_content align-self-center">
                <div class="otp-page">
                    <h3 class="h3-heading">
                        <a href="javascript:history.back()" class="text-dark me-2">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                        Change Mobile Number
                    </h3>

                    <h5 class="otp_sent">
                        Great! Now enter the mobile number you want to continue with
                    </h5>

                    <div class="form-group mt-3">
                        <div class="d-flex gap-2">

                            <div class="LoginCountryCode">
                                <div class="dropdown">
                                    <button class="btn btn-light border dropdown-toggle d-flex align-items-center" type="button"
                                            id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selected-flag">
                                            <img src="{{ $country[0]->flag1 }}" alt="flag" width="25" height="16">
                                        </span>
                                        <span id="selected-code" class="ms-2">{{ $country[0]->dial_code }}</span>
                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="countryDropdown" style="max-height: 250px; overflow-y: auto;">
                                        @foreach ($country as $index => $item)
                                            <li>
                                                <label class="dropdown-item d-flex align-items-center gap-2 country-option" style="cursor: pointer;">
                                                    <input type="radio" name="country_code"
                                                        value="{{ $item->dial_code }}"
                                                        data-flag="{{ $item->flag1 }}"
                                                        class="country-radio"
                                                        {{ $index === 0 ? 'checked' : '' }} hidden>
                                                    <img src="{{ $item->flag1 }}" alt="Flag of {{ $item->name }}" width="25" height="16">
                                                    <span>{{ $item->dial_code }} ({{ $item->name }})</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="w-100 LoginMobileDesign">
                                <input type="text" class="form-control notapplyspace"
                                    placeholder="Please enter mobile number"
                                    name="mobile" id="LoginMobile">
                            </div>

                        </div>
                    </div>


                    <input type="hidden" name="for" value="mobile">
                    <input type="hidden" name="type" value="1"> 

                    <button type="submit" class="customBtn mt-5 w-100">Continue</button>
                </div>
            </div>
        </form>

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

</script>
     
 @endsection
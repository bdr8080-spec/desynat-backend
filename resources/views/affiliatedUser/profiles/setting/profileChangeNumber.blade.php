
@include('affiliatedUser.layout.header')

<section class="section dashboard page-100">

    <div class="login_contenar">
    <div class="login_content-box">
        <div class="login_content">
            <div class="login_content_content align-self-center">
            <form action="{{ route('affiliate.userOldNumberSendOtp') }}" method="POST">
                @csrf
                    <div class="otp-page">
                        <h3 class="h3-heading">
                            <a href="{{ url()->previous() }}" class="text-dark me-2">
                            <i class="bi bi-chevron-left"></i> </a> {{ __('affiliate_messages.change_mobile_number') }}
                        </h3>

                        <h6 class="otp_sent mt-3">
                            {{ __('affiliate_messages.great') }}! {{ __('affiliate_messages.now_enter_the_mobile_number_you_want_to_continue_with') }}
                        </h6>

                        <div class="form-group mt-3">
                            <div class="d-flex gap-2">

                                <div class="LoginCountryCode">
                                    <div class="dropdown">
                                        @php
                                            $kuwait = $country->firstWhere('name', 'Kuwait');
                                        @endphp
                                        <button class="btn btn-light border dropdown-toggle d-flex align-items-center" type="button"
                                                id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span id="selected-flag">
                                                <img src="{{ $kuwait->flag }}" alt="flag" width="25" height="16">
                                            </span>
                                            <span id="selected-code" class="ms-2">{{ $kuwait->dial_code }}</span>
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

                                <div class="w-100 LoginMobileDesign">
                                    <input type="text" class="form-control notapplyspace"
                                        placeholder="{{ __('affiliate_messages.please_enter_mobile_number') }}"
                                        name="mobile" id="LoginMobile" maxlength="15"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)">
                                </div>

                            </div>
                        </div>


                        <input type="hidden" name="for" value="mobile">
                        <input type="hidden" name="type" value="1"> 

                        <button type="submit" class="btn btn-success customBtn customBtn5 mt-5 w-100">{{ __('affiliate_messages.continue') }}</button>
                    </div>
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

 
           @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif
    </script>

@include('affiliatedUser.layout.footer')

     
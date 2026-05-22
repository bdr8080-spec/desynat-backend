@extends('user.auth.layout.app')

@section('content')

<div class="login_contenar">
    <header class="inner-header">
        <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
        <div class="dropdown-center mobileLang">
                                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                    <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                    <li>
                                        <a class="dropdown-item" data-lang="ar" href="{{route('userLanguage','ar')}}">
                                            <span>{{ __('admin_messages.ar') }}</span> {{ __('user_messages.arabic') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" data-lang="en" href="{{route('userLanguage','en')}}">
                                            <span>{{ __('admin_messages.en') }}</span> {{ __('user_messages.english') }}
                                        </a>
                                    </li>

                                </ul>

                            </div>
    </header>
    <div class="login_content login_content_left">
        <img src="assets/images/left-img.svg" class="left-imgone" />
        <img src="assets/images/logoone.svg" class="left-img" />
        <img src="assets/images/right-img.svg" class="left-imgtwo" />
    </div>
    <div class="login_content login_content_right">

        <div class="login_content_content">
            <form id="signup">
                @csrf
                <h4>{{ __('user_messages.sign_up') }}</h4>
                <h3>{{ __('user_messages.create_your_account') }} !</h3>

                <div class="upload-image w-100">
                    <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                        <img src="{{ asset('user/assets/images/upload-icon.svg') }}">
                        <div class="text-color-upload">{{ __('user_messages.upload_profile_image') }}</div>
                        <input type="file" accept="image/*" name="image" enctype="multipart/form-data" hidden
                            onchange="showPreview(event)">
                    </label>
                    <div class="imgshow">
                        <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                        <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;"
                            onclick="removeImg()">&times;</span>
                    </div>
                </div>

                <!-- <input type="file" name="image" enctype="multipart/form-data"> -->
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">{{ __('user_messages.full_name') }}</label>
                    <input type="text" name="full_name" class="form-control custom-password blockFirstTime"
                        placeholder="{{ __('user_messages.enter_full_name') }}" style="padding-right: 40px;" />
                </div>
                <span class="text-danger" id="error-full_name"></span>

                <div class="form-group mt-3">
                    <label class="d-block" for="">{{ __('user_messages.mobile_number') }}</label>
                    <div class="d-flex align-items-center">
                        <div class="">
                            {{-- <select name="country_code" id="" class="country" class="form-control">
                                @foreach ($country as $item)                       
                                    <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                            @endforeach
                            </select> --}}

                            <div class="dropdown">
                                <button
                                    class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                    type="button" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                                    <span id="selected-flag">
                                        {{ old('country_flag', $country[0]->flag1) }}
                                    </span>

                                    <span id="selected-code" class="ms-2">
                                        {{ old('country_code', $country[0]->dial_code) }}
                                    </span>
                                </button>

                                <ul class="dropdown-menu p-2 newcountrybox" aria-labelledby="countryDropdown">

                                    @foreach ($country as $index => $item)
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center gap-2 country-option"
                                            style="cursor: pointer;">
                                            <input type="radio" name="country_code" value="{{ $item->dial_code }}"
                                                data-flag="{{ $item->flag1 }}" data-name="{{ App::getLocale() == 'en' ? $item->name : $item->name_ar }}"
                                                class="country-radio"
                                                {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                hidden>

                                            <div width="25" height="16">
                                                <span>{{ $item->flag1 }} {{ $item->dial_code }}
                                                    ({{ App::getLocale() == 'en' ? $item->name : $item->name_ar }})
                                                </span>
                                            </div>

                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                        <div class="w-100">
                            <input type="number" class="form-control" value="" placeholder="{{ __('user_messages.enter_mobile_number') }}"
                                name="mobile"
                                oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">
                        </div>
                    </div>
                    {{-- <input type="hidden" value="+91" name="country_code" id="country_code"> --}}
                </div>
                <span class="text-danger" id="error-mobile"></span>
                <div class="form-group position-relative verify mt-3">
                    <label class="d-block" for="">{{ __('user_messages.email_address') }}</label>
                    <input type="text" class="form-control custom-password notapplyspace"
                        placeholder="{{ __('user_messages.please_enter_your_email_address') }}" style="padding-right: 40px;" name="email" />
                </div>
                <span class="text-danger" id="error-email"></span>
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">{{ __('user_messages.create_new_password') }}</label>
                    <input type="password" id="login-password" class="form-control custom-password notapplyspace"
                        placeholder="{{ __('user_messages.enter_new_password') }}" style="padding-right: 40px;" name="password" />
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                <span class="text-danger" id="error-password"></span>
                <div class="form-group position-relative password_icon mt-3">
                    <label for="">{{ __('user_messages.confirm_password') }}</label>
                    <input type="password" id="login-password" class="form-control custom-password notapplyspace"
                        placeholder="{{ __('user_messages.enter_confirm_password') }}" style="padding-right: 40px;"
                        name="confirm_password" />
                    <i class="fa-solid fa-eye toggle-passwordone" id="toggleIcon"></i>
                </div>
                <span class="text-danger" id="error-confirm_password"></span>
                <div class="form-check term_policy my-3">
                    <input class="form-check-input" type="checkbox" value="1" id="checkIndeterminate"
                        name="accept_terms">
                    <label class="form-check-label" for="checkIndeterminate">
                        {{ __('user_messages.i_accept_the') }} <a href="{{route('user.termCondition')}}">{{ __('user_messages.terms_&_conditions') }}</a> and <a href="{{route('user.returnPolicy')}}">{{ __('user_messages.policies') }}</a>
                    </label>
                </div>
                <span class="text-danger" id="error-accept_terms"></span>
                <button type="submit" class="customBtn" id="signBtn">{{ __('user_messages.sign_up_small') }}</button>
            </form>
            <p class="mt-3 dontAccount">{{ __('user_messages.already_have_an_account') }}? <a href="{{ route('userLogin') }}">{{ __('user_messages.sign_in_small') }}</a></p>
        </div>
    </div>
</div>


<script>
$(document).on('submit', '#signup', function(e) {
    e.preventDefault();

    let data = new FormData(this);

    $('#signBtn').prop('disabled', true);


    $.ajax({
        url: "{{ route('userRegister') }}",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(resp) {

            if (resp.status == true) {
                toastr.success(resp.message);
                setTimeout(() => {
                    location.href = `verify-otp?temp_user_id=${resp.id}`;
                }, 1000);

            }

            if (resp.status == false) {
                for (const key in resp.errors) {
                    $(`#error-${key}`).html(resp.errors[key]);
                }
            }

        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        },
        complete: function() {
            $('#signBtn').prop('disabled', false);
        }
    });
});


function showPreview(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(x) {
            $('.preview').attr('src', x.target.result).show();
            $('.removeIcon').show();
            $('.uploadLabel').hide();
        };
        reader.readAsDataURL(file);
    }
}

function removeImg() {
    $('.preview').attr('src', '').hide();
    $('.removeIcon').hide();
    $('.uploadLabel').show();
}



// document.addEventListener('DOMContentLoaded', function() {
//     const radios = document.querySelectorAll('.country-radio');
//     const selectedFlag = document.getElementById('selected-flag');
//     const selectedCode = document.getElementById('selected-code');

//     radios.forEach(radio => {
//         radio.addEventListener('change', function() {
//             const parent = this.closest('label');
//             const flagImg = parent.querySelector('img').src;
//             const dialCode = this.value;

//             selectedFlag.innerHTML = `<img src="${flagImg}" width="25" height="16">`;
//             selectedCode.textContent = dialCode;
//         });
//     });
// });

$(document).ready(function() {
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const restrictedInputs = document.querySelectorAll('.blockFirstTime');

    restrictedInputs.forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === ' ' && this.value.length === 0) {
                e.preventDefault();
            }
        });

        input.addEventListener('input', function() {
            if (this.value.startsWith(' ')) {
                this.value = this.value.trimStart();
            }
        });
    });
});
</script>


@endsection
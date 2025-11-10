<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> Desyant Dealer </title>
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
</head>

<body>

    <div class="login-header">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('dealer') }}/assets/img/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-wapper">
        <div class="container-fluid p-0">
            <div class="login-grid-bg">
                <div class="row g-0">
                    <div class="col-lg-6 bg-logo-wapper">
                        <div class="login-img">
                            <img src="{{ asset('dealer') }}/assets/img/Desynat-logo-2.svg" alt="image"
                                class="img-fluid logo-login">
                        </div>
                        <img src="{{ asset('dealer') }}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{ asset('dealer') }}/assets/img/Vector-right.svg" alt="image"
                            class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2">
                                <form action="{{ route('seller.login') }}" method="post">
                                    <h1>Sign In <br><span class="gold-color">Welcome back !</span></h1>

                                    @csrf
                                    <div class="form-group">
                                        <div class="form-group mt-4">
                                            <label for="">Mobile Number or Email Address</label>

                                            <div class="d-flex align-items-center gap-3">
                                                <div class=" d-none LoginCountryCode">
                                                    {{-- <select name="country_code" class="form-select"
                                                        style="width: 100px">
                                                        @foreach ($country as $item)
                                                            <option value="{{ $item->dial_code }}">
                                                                {{ $item->dial_code }}</option>
                                                        @endforeach
                                                    </select> --}}

                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                            type="button" id="countryDropdown"
                                                            data-bs-toggle="dropdown" aria-expanded="false">

                                                            <span id="selected-flag">
                                                                <img src="{{ old('country_flag', $country[0]->flag1) }}"
                                                                    alt="flag" width="25" height="16">

                                                            </span>

                                                            <span id="selected-code" class="ms-2">
                                                                {{ old('country_code', $country[0]->dial_code) }}
                                                            </span>
                                                        </button>

                                                        <ul class="dropdown-menu p-2" aria-labelledby="countryDropdown">

                                                            @foreach ($country as $index => $item)
                                                                <li>
                                                                    <label
                                                                        class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                                        style="cursor: pointer;">
                                                                        <input type="radio" name="country_code"
                                                                            value="{{ $item->dial_code }}"
                                                                            data-flag="{{ $item->flag1 }}"
                                                                            data-name="{{ $item->name }}"
                                                                            class="country-radio"
                                                                            {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                                            hidden>
                                                                        <img src="{{ $item->flag1 }}"
                                                                            alt="Flag of {{ $item->name }}"
                                                                            width="25" height="16">
                                                                        <span>{{ $item->dial_code }}
                                                                            ({{ $item->name }})
                                                                        </span>
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                </div>
                                                <div class="w-100 LoginMobileDesign">
                                                    <input type="text" class="form-control notapplyspace"
                                                        value="" placeholder="Mobile Number or Email Address"
                                                        name="email_mobile" id="LoginMobile">
                                                </div>
                                            </div>
                                        </div>
                                        @error('email_mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <div class="form-group position-relative">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control notapplyspace" id="password"
                                                placeholder="Enter Your Password" name="password">
                                            <i class="toggle-password  bi bi-eye-slash "></i>
                                        </div>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <div class="form-group py-2 mb-4 text-center">
                                            <a href="{{ route('seller.forgot') }}" class="link-color">Forgot Password
                                                ?
                                            </a>
                                        </div>
                                        <div class="login-btn">
                                            <input type="submit" class="btn btn-success w-100" name="submit"
                                                value="login">
                                        </div>
                                </form>

                                <div class="sign-new mt-2 text-center">
                                    <div>Don’t have an account? <a href="{{ route('seller.register') }}"
                                            class="link-color"> Sign up</a></div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>


<!-- Vendor JS Files -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/main.js"></script>
<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("bi-eye bi-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
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
</script>



<script>
    $(document).ready(function() {
        // When a user selects a country (clicks a label)
        $(document).on('click', '.country-option', function() {
            let radio = $(this).find('.country-radio');
            let flag = radio.data('flag');
            let code = radio.val();
            let name = radio.data('name');

            // Update the flag and code shown on the button
            $('#selected-flag img').attr('src', flag);
            $('#selected-code').text(code);

            // Set the radio input as checked
            radio.prop('checked', true);

            // Close the dropdown (Bootstrap 5)
            $('#countryDropdown').dropdown('hide');
        });
    });
</script>

@include('dealer.layout.footer');

</html>

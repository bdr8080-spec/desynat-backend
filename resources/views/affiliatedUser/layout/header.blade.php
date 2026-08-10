<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ __('affiliate_messages.desynat_affiliate') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/custom.css" rel="stylesheet">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/affiliate.css" rel="stylesheet">
    <link href="{{ asset('dealer') }}/assets/custom-file/table-lib/table-style.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery (required by Toastr) -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

<style>
    .pac-container {
        z-index: 9999;
    }

        iframe#\:1\.container {
    visibility: hidden !important;
}

/* Hide the Google Translate tooltip */
.goog-te-banner-frame.skiptranslate,
.goog-tooltip,
.goog-tooltip:hover,
.goog-tooltip-vertical {
    display: none !important;
}

/* Hide the feedback popup on selected text */
#goog-gt-tt {
    display: none !important;
}
    </style>

    <style>
  /* body {
    visibility: hidden;
  } */
</style>

</head>

<body>

    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(255,255,255,0.7); z-index:9999; text-align:center; padding-top:200px;">
        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"></iframe>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center">
            <a href="javascript:void(0)" class="logo">
                <img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg" alt="image" class="img-fluid"
                    onclick="openGallery(0)">
            </a>
            <i class="bi bi-chevron-left toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center gap-3">

                <li class="nav-item dropdown">
                     @php
                            $notificationCount = 0;

                            if (Auth::guard('affilated_user')->check()) {
                                $userId =Auth::guard('affilated_user')->user()->id;
                                $notificationCount = \App\Models\Notification::where('receiver_id', $userId)
                                    ->where('receiver_type', '4')
                                    ->where('is_read', '0')
                                    ->orderBy('id', 'desc')
                                    ->count();
                            }
                        @endphp
                    <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#notificationDialogAffiliateUser">
                        <img src="{{ asset('dealer') }}/assets/img/bell.svg" alt="icon" class="bell-icon">
                        @if($notificationCount > 0)
                        <span class="badge text-bg-danger badge-number">{{ $notificationCount }}</span>
                        @endif
                    </a>

                    <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                    </ul> -->
                </li>



                <!-- End Messages Nav -->

                <li class="nav-item dropdown">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ Auth::guard('affilated_user')->user()->profile_image ?? asset('user/assets/images/user.png') }}"
                            alt="Profile" class="rounded-circle">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <div class="seller-profile">
                                <div class="p-grid1 d-flex gap-3">
                                    <img src="{{ Auth::guard('affilated_user')->user()->profile_image ?? asset('user/assets/images/user.png') }}"
                                        alt="Profile" class="rounded-circle">
                                    <div>

                                        <h6>{{Auth::guard('affilated_user')->user()->full_name ?? ''}}</h6>
                                        <div class="h-email">{{Auth::guard('affilated_user')->user()->email ?? ''}}
                                        </div>
                                    </div>
                                </div>
                                <a class="drop-profile" href="{{route('affiliate.affiliateProfile')}}">
                                    <span>{{ __('affiliate_messages.view_profile') }}</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3"
                                href="{{route('affiliateLogout')}}">
                                <img src="{{ asset('dealer') }}/assets/img/logout.svg">
                                <span class="text-red">{{ __('affiliate_messages.logout') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="nav-item">
                    <div class="des-language">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img id="selectedFlag" src="{{asset('user/assets/images/flags/kuwait.svg')}}"
                                    class="img-fluid" />
                            </button>
                            <ul class="dropdown-menu kwdrop-panel">
                                <li class="d-flex align-self-center justify-content-between topDropdonw">
                                    <h5>Change Country </h5>
                                    <div class="data-close"><i class="bi bi-x-lg"></i></div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio d-flex align-self-center justify-content-between">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">Kuwait</span>
                                        </label>
                                        <img src="{{asset('user/assets/images/flags/kuwait.svg')}}" />
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio d-flex align-self-center justify-content-between">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">Bahrain</span>
                                        </label>
                                        <img src="{{asset('user/assets/images/flags/bahrain.svg')}}" />
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio d-flex align-self-center justify-content-between">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">Qatar</span>
                                        </label>
                                        <img src="{{asset('user/assets/images/flags/qatar.svg')}}" />
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio d-flex align-self-center justify-content-between">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">Saudi Arabia</span>
                                        </label>
                                        <img src="{{asset('user/assets/images/flags/saudi-arabia.svg')}}" />
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio d-flex align-self-center justify-content-between">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">UAE</span>
                                        </label>
                                        <img src="{{asset('user/assets/images/flags/uae.svg')}}" />
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio d-flex align-self-center justify-content-between">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">Oman</span>
                                        </label>
                                        <img src="{{asset('user/assets/images/flags/oman.svg')}}" />
                                    </div>
                                </li>

                                <li class="country-mt p-3 mt-4">
                                    <button type="button" class="btn affiliate-btn w-100">Save</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="des-language">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                KWD
                            </button>
                            <ul class="dropdown-menu kwdrop-panel">
                                <li class="d-flex align-self-center justify-content-between topDropdonw">
                                    <h5>Change Currency </h5>
                                    <div class="data-close"><i class="bi bi-x-lg"></i></div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">KWD</span>
                                        </label>
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">BHD</span>
                                        </label>
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">QAR</span>
                                        </label>
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">SAR</span>
                                        </label>
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">AED</span>
                                        </label>
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">OMR</span>
                                        </label>
                                    </div>
                                </li>
                                <li class="country-space">
                                    <div class="check_radio">
                                        <label class="radio-group">
                                            <input type="radio" name="today">
                                            <span class="custom-radio"></span>
                                            <span class="radio-label">USD</span>
                                        </label>
                                    </div>
                                </li>


                                <li class="country-mt p-3 mt-4">
                                    <button type="button" class="btn affiliate-btn w-100">Save</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li> -->

                <li>
                    <div class="des-language">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                    <span id="currentLang">@if(app()->getLocale()=='en') {{ __('admin_messages.en') }} @else {{ __('admin_messages.ar') }} @endif</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                    <li>
                                        <a class="dropdown-item" data-lang="ar" href="{{route('userLanguage','ar')}}">
                                            <span>{{ __('admin_messages.ar') }}</span> {{ __('affiliate_messages.arabic') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" data-lang="en" href="{{route('userLanguage','en')}}">
                                            <span>{{ __('admin_messages.en') }}</span> {{ __('affiliate_messages.english') }}
                                        </a>
                                    </li>

                                </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    

    @include('affiliatedUser.layout.sideBar')
    <main id="main" class="main">
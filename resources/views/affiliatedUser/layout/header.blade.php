<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Desynat Affiliate </title>
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
    <link href="{{ asset('dealer') }}/assets/custom-file/table-lib/table-style.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery (required by Toastr) -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

</head>

<body>

    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(255,255,255,0.7); z-index:9999; text-align:center; padding-top:200px;">
        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"></iframe>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center">
            <a href="{{ route('seller.dashboard') }}" class="logo">
                <img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg" alt="image" class="img-fluid"
                    id="storyModal">
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center gap-3">

                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('dealer') }}/assets/img/bell.svg" alt="icon" class="bell-icon">
                        <!-- <span class="badge bg-primary badge-number">4</span> -->
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
                                <a class="drop-profile" href="/profile">
                                    <span>View Profile</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3"
                                href="{{route('affiliateLogout')}}">
                                <img src="{{ asset('dealer') }}/assets/img/logout.svg">
                                <span class="text-red">Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
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
                </li>

                <li>
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
                </li>
            </ul>
        </nav>
    </header>

    @include('affiliatedUser.layout.sideBar')
    <main id="main" class="main">
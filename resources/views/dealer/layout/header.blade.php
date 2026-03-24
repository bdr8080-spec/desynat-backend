<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
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
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="{{route('seller.All_chats')}}">
                        <img src="{{ asset('dealer') }}/assets/img/chat.svg" alt="icon" class="bell-icon">
                        <!-- <span class="badge bg-success badge-number">3</span> -->
                    </a>
                    <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                    </ul> -->
                </li>
                @php
                    use Illuminate\Support\Facades\Auth;
                    use App\Models\Notification;

                    $notifications = [];

                    if (Auth::guard('seller')->check()) {
                        $sellerId = Auth::guard('seller')->user()->id;

                        $notificationCount = Notification::where('receiver_id', $sellerId)
                            ->where('receiver_type', '3')
                            ->where('is_read','0')
                            ->orderBy('created_at', 'desc')
                            ->count();
                    }
                @endphp

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="offcanvas" data-bs-target="#notificationDialog" >
                        <img src="{{ asset('dealer') }}/assets/img/bell.svg" alt="icon" class="bell-icon">
                        @if($notificationCount>0)
                        <span class="badge bg-primary badge-number">{{$notificationCount}}</span>
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

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

                        @php

                        $seller_details=Auth::guard('seller')->user()

                        @endphp

                        @if($seller_details)

                        <img src="{{$seller_details->profile_pic}}" alt="Profile" class="rounded-circle">


                        @else
                        <img src="{{ asset('dealer') }}/assets/img/profile-img.jpg" alt="Profile"
                            class="rounded-circle">


                        @endif
                        <!-- <span class="d-none d-md-block dropdown-toggle ps-2">Seller</span> -->
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            @if($seller_details)

                            <div class="seller-profile">
                                <div class="p-grid1 d-flex gap-3">
                                    <img src="{{$seller_details->profile_pic}}" alt="Profile" class="rounded-circle">
                                    <div>
                                        <h6>{{$seller_details->first_name}}</h6>
                                        <div class="h-email">{{$seller_details->email}} </div>
                                    </div>
                                </div>
                                <a class="drop-profile" href="{{ route('seller.view_profile') }}">
                                    <span>View Profile</span>
                                </a>
                            </div>

                            @else
                            <div class="seller-profile">
                                <div class="p-grid1 d-flex gap-3">
                                    <img src="{{ asset('dealer') }}/assets/img/profile-img.jpg" alt="Profile"
                                        class="rounded-circle">
                                    <div>
                                        <h6>Vijay</h6>
                                        <div class="h-email">vijay@gmail.com</div>
                                    </div>
                                </div>
                                <a class="drop-profile" href="{{ route('seller.view_profile') }}">
                                    <span>View Profile</span>
                                </a>
                            </div>


                            @endif

                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3"
                                href="{{ route('seller.logout') }}">
                                <img src="{{ asset('dealer') }}/assets/img/logout.svg">
                                <span class="text-red">Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="des-language">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ asset('dealer') }}/assets/img/global.svg" class="img-fluid" />

                                @if(App::getLocale()=='en')
                                EN
                                @elseif(App::getLocale()=='ar')
                                AR
                                @else
                                EN
                                @endif

                            </button>
                            <ul class="dropdown-menu">

                                <li
                                    style="@if (app()->getLocale() === 'ar') Background:linear-gradient(73.47deg, #F9DBAB 0%, #7D532F 132.99%);  @endif ">
                                    <a class="dropdown-item" href="{{ route('seller_lang') }}?lang=ar"><span>AR</span>
                                        Arabic</a>
                                    <!-- @if (app()->getLocale() === 'ar') Active @endif -->
                                </li>

                                <li
                                    style="@if (app()->getLocale() === 'en') Background:linear-gradient(73.47deg, #F9DBAB 0%, #7D532F 132.99%);  @endif ">
                                    <a class="dropdown-item" href="{{ route('seller_lang') }}?lang=en"><span>EN</span>
                                        English</a>
                                    <!-- @if (app()->getLocale() === 'en') Active @endif  -->
                                </li>

                            </ul>
                        </div>
                    </div>
                </li>

            </ul>


        </nav>

    </header>


    @if(Request()->Path()!=='seller/view-profile' && Request()->Path()!=='seller/edit-profile' )
    @include('dealer.layout.sideBar')
    <main id="main" class="main">
        @endif
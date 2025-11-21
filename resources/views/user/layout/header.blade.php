<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desynat</title>
        <link href="{{ asset('user/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('user/assets/css/responsive.css') }}" rel="stylesheet" />
    <!-- <link href="assets/css/fontawesome.min.css" rel="stylesheet" /> -->
     <link rel="icon" type="image/x-icon" href="{{ asset('user/assets/images/desynat_fav_ic.svg') }}">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" />
     <link href="{{ asset('user/assets/css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<style>
    .pac-container {
        z-index: 9999;
    }
</style>

@php
use App\Models\Category;
use App\Models\UserCurrentLocation;

         $user = Auth::guard('web')->user();
        if($user){
              $userLocation = UserCurrentLocation::where('user_id', $user->id)->first();
        }
    
         $data = Category::with('subCategories')->get();
@endphp

</head>
<body>
    
    <header class="header-main">
        <nav class="navbar navbar-expand-lg">
            <div class="w-100">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap mobileResponsive">
                    <div class="d-flex align-self-center justify-content-between mobileResponsiveheaderCont w-100">
                        <a class="navbar-brand" href="{{route('dashboard')}}"><img src="{{asset('user/assets/images/logo.svg')}}" class="img-fluid" /></a>
                        <div class="header_nav_button_dropdown d-flex">
                            @if (Auth::guard('web')->check())
                            
                            <div class="user_nav_inner_profile">
                                <span>
                                    <img src="{{asset('user/assets/images/chat.svg')}}" class=img-fluid />
                                </span>
                                <span>
                                    <img src="{{asset('user/assets/images/like_dislike.svg')}}" class=img-fluid />
                                </span>
                                <span>
                                    <img src="{{asset('user/assets/images/cart.svg')}}" class=img-fluid />
                                </span>
                                <span>
                                    <img src="{{asset('user/assets/images/noti.svg')}}" class=img-fluid />
                                </span>
                            </div>

                            <div class="dropdown-center userDropdown">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ Auth::guard('web')->user()->profile_image ?? asset('user/assets/images/user.png') }}" alt="" height="50px" width="80px" /> 
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end profileDropdown">
                                    <li>
                                        <div class="profileContenar d-flex align-items-center justify-conten-between">
                                            <div class="profile d-flex align-items-center gap-3">
                                                <div class="profileContenar_img">
                                                    <img src="{{ Auth::guard('web')->user()->profile_image ?? asset('user/assets/images/user.png') }}" class="img-fluid" />
                                                </div>
                                                <div class="profile_detail">
                                                    <p>{{Auth::guard('web')->user()->full_name ?? ''}}</p>
                                                    <label>{{Auth::guard('web')->user()->email ?? ''}}</label>
                                                </div>  
                                            </div>
                                            <div class="ms-auto">
                                                <a href="{{route('userProfile')}}">
                                                    <span><i class="bi bi-pencil"></i></span>                                                     
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="profile_buttons">
                                            <div class="row">
                                                <div class="col-lg-6 my-2">
                                                    <button class="custom-btn3">My wallet</button>
                                                </div>
                                                <div class="col-lg-6 my-2">
                                                    <button class="custom-btn3">My Orders</button>
                                                </div>
                                                <div class="col-lg-6 my-2">
                                                    <button class="custom-btn3">My saved Cards</button>
                                                </div>
                                                <div class="col-lg-6 my-2">
                                                    <button class="custom-btn3">Saved Addresses</button>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled profile_links">
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/terms.svg')}}" />
                                                Terms & Condition
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/return.svg')}}" />
                                                Return Policy
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/about-us.svg')}}" />
                                                About Us
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/faq.svg')}}" />
                                                FAQ's
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/change-lang.svg')}}" />
                                                Change Language
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/cancel-policy.svg')}}" />
                                                Cancellation Policy
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/exchange.svg')}}" />
                                                Exchange Policy
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/support.svg')}}" />
                                                Support
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/becom-affilit.svg')}}" />
                                                Become An Affiliate
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/setting.svg')}}" />
                                                Settings
                                                <i class="fa-solid fa-chevron-right i_icon"></i>
                                            </a></li>
                                            <li>
                                                <a class="dropdown-item text-center" href="{{route('userLogout')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                                        </ul>
                                    </li>
                                    <!-- <li><a class="dropdown-item text-center" href="{{route('userLogout')}}">Logout</a></li> -->
                                </ul>
                            </div>
                            @else
                                <a class="customBtn1 mobileSignup" href="{{route('userLogin')}}"><i class="fa-regular fa-user"></i> SIGN IN/SIGN UP</a>
                            @endif
                    
                        <div class="dropdown-center mobileLang">
                            <button class="btn btn-secondary dropdown-toggle customBtn1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 5px 10px !important;">
                                <img id="selectedFlag" src="{{asset('user/assets/images/flags/kuwait.svg')}}" class="img-fluid" />
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu" aria-labelledby="countryDropdownBtn">
                                <li class="topDropdonw">
                                    <p>Change Country
                                        <i class="fa-solid fa-xmark"></i>
                                    </p>
                                </li>
                                <li class="dropdown-item" data-country="Kuwait" data-flag="{{asset('user/assets/images/flags/kuwait.svg')}}">
                                    <div class="d-flex align-self-center justify-content-between">
                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">Kuwait</span>
                                            </label>
                                        </div>
                                        <img src="{{asset('user/assets/images/flags/kuwait.svg')}}" />
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Bahrain" data-flag="{{asset('user/assets/images/flags/bahrain.svg')}}">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">Bahrain</span>
                                            </label>
                                        </div>
                                        <img src="{{asset('user/assets/images/flags/bahrain.svg')}}" />
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Qatar" data-flag="{{asset('user/assets/images/flags/qatar.svg')}}">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">Qatar</span>
                                            </label>
                                        </div>
                                        <img src="{{asset('user/assets/images/flags/qatar.svg')}}" />
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Saudi Arabia" data-flag="{{asset('user/assets/images/flags/saudi-arabia.svg')}}">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">Saudi Arabia</span>
                                            </label>
                                        </div>
                                        <img src="{{asset('user/assets/images/flags/saudi-arabia.svg')}}" />
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="UAE" data-flag="{{asset('user/assets/images/flags/uae.svg')}}">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio"> 
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">UAE</span>
                                            </label>
                                        </div>
                                        <img src="{{asset('user/assets/images/flags/uae.svg')}}" />
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Oman" data-flag="{{asset('user/assets/images/flags/oman.svg')}}">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">Oman</span>
                                            </label>
                                        </div>
                                        <img src="{{asset('user/assets/images/flags/oman.svg')}}" />
                                    </div>
                                </li>
                                <li>
                                    <button class="customBtn customBtn5 mt-lg-5 mt-md-3 mt-3">Save</button>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-center mobileLang">
                            <button class="btn btn-secondary dropdown-toggle customBtn1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 5px 10px !important;">
                                <span id="selectedCurrency">KWD</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu currency">
                                <li class="topDropdonw">
                                    <p>Change Currency
                                        <i class="fa-solid fa-xmark"></i>
                                    </p>
                                </li>
                                <li class="dropdown-item" data-country="Kuwait">
                                    <div class="d-flex align-self-center justify-content-between">
                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">KWD</span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Bahrain">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">BHD</span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Qatar">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">QAR</span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Saudi Arabia">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">SAR</span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="UAE">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">AED</span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item" data-country="Oman">
                                    <div class="d-flex align-self-center justify-content-between">

                                        <div class="radio-group">
                                            <label class="custom-radio">
                                                <input type="radio" name="gender" value="male" checked />
                                                <span class="radio-mark"></span>
                                                <span class="label-text">OMR</span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <button class="customBtn customBtn5 mt-lg-5 mt-md-3 mt-3">Save</button>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-center mobileLang">
                            <button class="btn btn-secondary dropdown-toggle customBtn1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 5px 10px !important;">
                                <img src="{{asset('user/assets/images/global.svg')}}" class="img-fluid" /> EN
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end langu">
                                <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                                <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                            </ul>
                        </div>
                    </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                    </div>
                    
                    
                    
                </div>
                <div class="desynat_navigation_bar_header">
                    <div class="container-fluid">
                        <div class="row">
                        <div class="col-lg-2 col-md-6 col-6  d-lg-block d-md-block d-none">
                            <div class="track_location">
                                <h6>Deliver to {{@Auth::guard('web')->user()->full_name ?? 'Guest'}}</h6>
                                <div class="d-flex align-self-center w-100" data-bs-toggle="modal" data-bs-target="#changeLocation">
                                    <button type="button" class="customBtnLocation btn" >
                                        <img src="{{asset('user/assets/images/Icon.svg')}}" class="img-fluid me-2" /> <span id="cityField"></span> 
                                    </button>
                                    <span class="">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-6  d-lg-block d-md-block d-none">
                            <div class="form-group position-relative search">
                                <input type="text" class="form-control" placeholder="Search Product or Brand" />
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            
                            <div class="collapse navbar-collapse customNavbar" id="navbarSupportedContent">
                               
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 w-100 justify-content-end flex-wrap">
                                    @foreach ($data as $item)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="handleSubCategory({{$item->id}})">
                                            {{$item->name}}
                                        </a>
                                        <div class="dropdown-menu sell_clothes">
                                            <div class="scroll-wrapper">
                                                <button class="scroll-arrow scroll-btn scroll-left" type="button" aria-label="scroll left">
                                                    <i class="fa-solid fa-chevron-left"></i>
                                                </button>
                                                <div class="scroll-content row justify-content-between flex-lg-nowrap">
                                                    @foreach ($item->subCategories as $value)
                                                        <div class="col-lg-3 col-md-4 col-12">
                                                        <div class="clothes_content">
                                                            <p>{{$value->name_english}}</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Shirt</a>
                                                                </li>
                                                                <li>
                                                                    <a href="">Shirt</a>
                                                                </li>
                                                                <li>
                                                                    <a href="">Shirt</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    
                                                </div>
                                                <button class="scroll-arrow scroll-btn scroll-right" type="button" aria-label="scroll right">
                                                    <i class="fa-solid fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
            
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#">Best Selling</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Live</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#">Gift Card</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Stores</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
        </nav>
    </header>


    <!-- Modal -->
    <div class="modal fade location" id="changeLocation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Change Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- ✅ Hidden fields for lat/lng -->
                <input type="hidden" id="lat" name="lat" value="{{@$userLocation->latitude}}">
                <input type="hidden" id="lng" name="lng" value="{{@$userLocation->longitude}}">

                <div class="modal-body">
                    <div class="form-group position-relative search w-100 mb-3">
                        <input type="text" class="form-control" placeholder="Search address" />
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div>
                        <img src="https://staticmapmaker.com/img/google-placeholder.png" class="img-fluid" />
                    </div>

                    <div class="mt-3">
                        <h5>Location</h5>
                        <p id="locationUpdate"></p>
                    </div>

                    <button class="customBtn saveCurrentAddress mt-3">Change Location</button>
                </div>
            </div>
        </div>
    </div>




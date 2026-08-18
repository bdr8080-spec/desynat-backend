<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ __('user_messages.desynat') }}</title>
    <link href="{{ asset('user/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('user/assets/css/responsive.css') }}" rel="stylesheet" />
    <!-- <link href="assets/css/fontawesome.min.css" rel="stylesheet" /> -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('user/assets/images/desynat_fav_ic.svg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="{{ asset('user/assets/css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
        



<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N52BWTJ8');</script>
<!-- End Google Tag Manager -->


             <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-LT6YZ5ZYF1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    
    gtag('js', new Date());
    gtag('config', 'G-LT6YZ5ZYF1');
  </script>

  <!-- <style>
    .disabled-category {
    pointer-events: none;
}

.disabled-link {
    opacity: 0.5;
    cursor: not-allowed !important;
}

.disabled-category:hover .dropdown-menu {
    display: none !important;
}
  </style> -->


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

    /* body {
    visibility: hidden;
  } */


    /* .custom-radio input[type="radio"] {
        display: none;
    }

    .custom-radio span {
        display: block;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
    } 

     */

    .mobileLang .custom-radio input[type="radio"]:checked+span {
        color: #9e7750;
        font-weight: 700;
    } 
    .owl-prev.disabled {
    visibility: hidden;
}

    </style>

    @php
    use App\Models\Category;
    use App\Models\UserCurrentLocation;
    use App\Models\Story;

    $user = Auth::guard('web')->user();
    if($user){
    $userLocation = UserCurrentLocation::where('user_id', $user->id)->first();
    }

    $data = Category::with('subCategories')->get();

    $adminStories = Story::where('type','1')->where('status','1')->get();

    @endphp


    @php
    $isHome = request()->routeIs('dashboard'); // change 'home' to your route name
    @endphp

</head>




<body>

    <header class="header-main">
        <nav class="navbar navbar-expand-lg">
            <div class="w-100">
                <div
                    class="container-fluid d-flex align-items-center justify-content-between flex-wrap mobileResponsive">
                    <div class="d-flex align-self-center justify-content-between mobileResponsiveheaderCont w-100">
                        <a class="navbar-brand">
                            <img src="{{asset('user/assets/images/logo.svg')}}" class="img-fluid" usemap="#logoMap" /> 
                            <!-- <img src="{{ asset(app()->getLocale() == 'ar' ? 'user/assets/images/arabic-logo.svg' : 'user/assets/images/logo.svg') }}"
                            class="img-fluid" usemap="#logoMap" alt="Logo"> -->
                        </a>
                        <map name="logoMap">
                            <area shape="rect" coords="0,0,50,50" href="javascript:void(0)"
                                onclick="onAdminIconClick(0)">
                            <area shape="rect" coords="60,0,200,50" href="{{route('dashboard')}}">
                        </map>

                        <div class="header_nav_button_dropdown d-flex">
                            @if (Auth::guard('web')->check())

                            <div class="user_nav_inner_profile">
                                <a href="{{route('user.allChats')}}" class="position-relative">
                                    <span>
                                        <span id="chatCount" class="badge text-bg-danger red-badge"></span>
                                        <img src="{{asset('user/assets/images/chat.svg')}}" class=img-fluid />
                                    </span>
                                </a>
                                <a href="{{route('user.wishList')}}">
                                    <span>
                                        <img src="{{asset('user/assets/images/like_dislike.svg')}}" class=img-fluid />
                                    </span>
                                </a>
                                @php
                                $cartCount = App\Models\Addtocart::where('user_id', auth()->id())->count();
                                @endphp
                                <a href="{{route('user.view_cart')}}" class="position-relative">
                                    <span>
                                        @if($cartCount > 0)
                                        <span class="badge text-bg-danger red-badge">{{ $cartCount }}</span>
                                        @endif
                                        <img src="{{asset('user/assets/images/cart.svg')}}" class=img-fluid />
                                    </span>
                                </a>
                                @php
                                $notificationCount = 0;

                                if (Auth::guard('web')->check()) {
                                $notificationCount = \App\Models\Notification::where('receiver_id', auth()->id())
                                ->where('receiver_type', '2')
                                ->where('is_read', '0')
                                ->orderBy('id', 'desc')
                                ->count();
                                }
                                @endphp

                                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#notificationDialogUser"
                                    class="position-relative">
                                    <span class="bell-icon">
                                        @if($notificationCount > 0)
                                        <span class="badge text-bg-danger badge-number">{{ $notificationCount }}</span>
                                        @endif
                                        <!-- <img src="{{ asset('user/assets/images/noti.svg') }}" class="img-fluid" /> -->
                                        <i class="bi bi-bell-fill"></i>
                                    </span>
                                </a>
                            </div>

                            <div class="dropdown-center userDropdown">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ Auth::guard('web')->user()->profile_image ?? asset('user/assets/images/user.png') }}"
                                        alt="" height="40px" width="40px" />
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end profileDropdown">
                                    <li>
                                        <div class="profileContenar d-flex align-items-center justify-conten-between">
                                            <div class="profile d-flex align-items-center gap-3">
                                                <div class="profileContenar_img">
                                                    <img src="{{ Auth::guard('web')->user()->profile_image ?? asset('user/assets/images/user.png') }}"
                                                        class="img-fluid" />
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
                                                    <a href="{{route('user.myWallet')}}" class="custom-btn3">
                                                        {{ __('user_messages.my_wallet') }}</a>
                                                </div>
                                                <div class="col-lg-6 my-2">
                                                    <a href="{{route('user.myOrders')}}" class="custom-btn3">
                                                        {{ __('user_messages.my_orders') }}</a>
                                                </div>
                                                <div class="col-lg-6 my-2">
                                                    <a href="{{route('user.saved_cards')}}" class="custom-btn3">
                                                        {{ __('user_messages.my_saved_cards') }}</a>
                                                </div>
                                                <div class="col-lg-6 my-2">
                                                    <a href="{{route('user.view_address')}}" class="custom-btn3">
                                                        {{ __('user_messages.saved_addresses') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled profile_links">
                                            <li><a href="{{route('user.termCondition')}}">
                                                    <img src="{{asset('user/assets/images/profile-icon/terms.svg')}}" />
                                                    {{ __('user_messages.terms_&_conditions') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('user.returnPolicy')}}">
                                                    <img
                                                        src="{{asset('user/assets/images/profile-icon/return.svg')}}" />
                                                    {{ __('user_messages.return_policy') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('user.aboutUs')}}">
                                                    <img
                                                        src="{{asset('user/assets/images/profile-icon/about-us.svg')}}" />
                                                    {{ __('user_messages.about_us') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('user.faq')}}">
                                                    <img src="{{asset('user/assets/images/profile-icon/faq.svg')}}" />
                                                    {{ __('user_messages.faqs') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('user.cancellationPolicy')}}">
                                                    <img
                                                        src="{{asset('user/assets/images/profile-icon/cancel-policy.svg')}}" />
                                                    {{ __('user_messages.cancellation_policy') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('user.exchangePolicy')}}">
                                                    <img
                                                        src="{{asset('user/assets/images/profile-icon/exchange.svg')}}" />
                                                    {{ __('user_messages.exchange_policy') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('user.support')}}">
                                                    <img
                                                        src="{{asset('user/assets/images/profile-icon/support.svg')}}" />
                                                    {{ __('user_messages.support') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('affiliate.affiliate_startPage')}}">
                                                    <img
                                                        src="{{asset('user/assets/images/profile-icon/becom-affilit.svg')}}" />
                                                    {{ __('user_messages.become_an_affiliate') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li><a href="{{route('user.setting')}}">
                                                    <img
                                                        src="{{asset('user/assets/images/profile-icon/setting.svg')}}" />
                                                    {{ __('user_messages.settings') }}
                                                    <i class="fa-solid fa-chevron-right i_icon"></i>
                                                </a></li>
                                            <li>
                                                <a class="dropdown-item text-center" href="{{route('userLogout')}}" id="logoutBtn"><i
                                                        class="fa-solid fa-arrow-right-from-bracket"></i> {{ __('user_messages.logout') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- <li><a class="dropdown-item text-center" href="{{route('userLogout')}}">Logout</a></li> -->
                                </ul>
                            </div>
                            @else
                            <a class="customBtn1 mobileSignup" href="{{route('userLogin')}}"><i
                                    class="fa-regular fa-user"></i> {{ __('user_messages.sign_in') }}/{{ __('user_messages.sign_up') }}</a>
                            @endif

                            <!-- Country code  -->

                            <div class="dropdown-center mobileLang">
                                @php
                                    $defaultCountry = $GetsellerCountry->firstWhere('name', 'Kuwait');
                                @endphp
                                <button class="btn btn-secondary dropdown-toggle customBtn1 " type="button"
                                    data-bs-toggle="dropdown" {{ !$isHome ? 'disabled' : '' }}>
                                    <!-- <img id="selectedFlag" src="{{@$defaultCountry->flag1}}" class="img-fluid" />
                                     -->
                                    <span id="selectedFlag" style="font-size:20px">{{@$defaultCountry->flag1}}</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                                    <li class="topDropdonw">
                                        <p>{{ __('user_messages.change_country') }} <i class="fa-solid fa-xmark"></i></p>
                                    </li>

                                    @foreach($GetsellerCountry as $key=>$val)
                                    <li class="dropdown-item" data-flag="{{$val->flag1}}">
                                        <label class="custom-radio d-flex justify-content-between">
                                            <input type="radio" name="country_language" value="{{$val->id}}"
                                                {{ session('country_id', $defaultCountry->id) == $val->id ? 'checked' : '' }}>
                                            @if(app()->getLocale() == 'en')
                                            <span>{{$val->name}}</span>
                                            @else
                                            <span>{{$val->name_ar}}</span>
                                            @endif
                                            <!-- <img src="{{$val->flag1}}" width="20"> -->
                                            <span style="font-size:20px">{{ $val->flag1 }}</span>

                                            <!-- <div width="20">{{$val->flag1}} </div> -->
                                            
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Currency code  -->

                            <div class="dropdown-center mobileLang">
                                @php
                                    $defaultCountry = $GetsellerCountry->firstWhere('name', 'Kuwait');
                                @endphp
                                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                    {{ !$isHome ? 'disabled' : '' }}>
                                    <span id="selectedCurrency">
                                        
                                    @if(App::getlocale()=='en'){{ session('currency',@$defaultCountry->currency_code) }} @else {{ session('currency', @$defaultCountry->currency_code_ar) }} @endif 

                                    </span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu currency">
                                    <li class="topDropdonw">
                                        <p>{{ __('user_messages.change_currency') }} <i class="fa-solid fa-xmark close-dropdown"></i></p>
                                    </li>

                                    @foreach($GetsellerCountry as $key=>$val)
                                    <li class="dropdown-item">
                                        <label class="custom-radio">
                                            <input type="radio" name="currency" value="{{ App::getLocale() == 'en' ? $val->currency_code : $val->currency_code_ar }}"
                                                @php
                                                $selectedCurrency = session('currency');

                                                if (!$selectedCurrency) {
                                                    $selectedCurrency = $defaultCountry->currency_code;
                                                }
                                            @endphp data-english="{{$val->currency_code}}" data-arabic="{{$val->currency_code_ar}}"  >
                                            <span>  
                                           @if(App::getlocale()=='en'){{$val->currency_code}} @else {{$val->currency_code_ar}} @endif 
                                                                               
                                        </span>
                                        </label>
                                    </li>
                                    @endforeach
                                    <li>
                                        <button class="customBtn customBtn5">{{ __('user_messages.save') }}</button>
                                    </li>

                                </ul>
                            </div>


                            <!-- langauge Change Code  -->

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
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                    </div>



                </div>
                <div class="desynat_navigation_bar_header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-2 col-md-6 col-6  d-lg-block d-md-block d-none">
                                <div class="track_location">
                                    <h6>{{ __('user_messages.deliver_to') }} {{@Auth::guard('web')->user()->full_name ?? 'Guest'}}</h6>
                                    <div class="d-flex align-self-center w-100" data-bs-toggle="modal"
                                        data-bs-target="#changeLocation">
                                        <button type="button" class="customBtnLocation btn">
                                            <img src="{{asset('user/assets/images/Icon.svg')}}"
                                                class="img-fluid me-2" /> <span id="cityField"></span>
                                        </button>
                                        <span class="">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-6  d-lg-block d-md-block d-none">
                                <form action="{{route('user.allproduct')}}" method="get" id="searchForm">

                                    <div class="form-group position-relative search">
                                        <input type="text" id="headerSearchInput" autocomplete="off"
                                            class="form-control" placeholder="{{ __('user_messages.search_product') }}" />
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                    <div class="searchdrop" style="display: none;">
                                        <div class="latestsearch">
                                            <h6>{{ __('user_messages.latest_search_result') }}</h6>
                                            <div class="latest-lists" id="latestSearchResults"></div>
                                        </div>
                                        <div class="latestsearch">
                                            <h6>{{ __('user_messages.recommended') }}</h6>
                                            <div class="latest-lists" id="recommendedResults"></div>
                                        </div>

                                        <div class="latestsearch">
                                            <h6>{{ __('user_messages.recent_search') }}</h6>
                                            <div class="latest-lists" id="recentSearchResults"></div>
                                        </div>

                                    </div>
                                </form>

                            </div>


                            <div class="col-lg-6 col-12">

                                <div class="collapse navbar-collapse customNavbar" id="navbarSupportedContent">

                                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 w-100 justify-content-end flex-wrap">
                                        @foreach ($data->where('status', 1) as $index =>$item)
                                        <li class="nav-item dropdown {{ $item->status == 0 ? 'disabled-category' : '' }}">
                                            <a class="nav-link dropdown-toggle position-relative {{ $index == 0 ? 'active' : '' }} {{ $item->status == 0 ? 'disabled-link' : '' }}"
                                                href="{{ $item->status == 0 ? 'javascript:void(0)' : '#' }}" role="button" @if($item->status != 0)
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    onclick="handleSubCategory({{ $item->id }})"
                                                @endif>
                                                @if(app()->getLocale() == 'ar')
                                                    {{ $item->name_ar }}
                                                @else
                                                    {{ $item->name }}
                                                @endif
                                            </a>
                                            <div class="dropdown-menu sell_clothes">
                                                <div class="scroll-wrapper">
                                                    <!-- <button class="scroll-arrow scroll-btn scroll-left" type="button"
                                                        aria-label="scroll left">
                                                        <i class="fa-solid fa-chevron-left"></i>
                                                    </button> -->
                                                    <div class="scroll-content">
                                                    <div class="row">
                                                        @foreach($item->subCategories->where('status', 1)->chunk(5) as $chunk)
                                                            <div class="col-lg-4">
                                                                @foreach($chunk as $value)
                                                                    <div class="menu-sub">
                                                                        <div class="clothes_content">
                                                                            <!-- <a href="{{ route('user.allproduct', [
                                                                                'category_id[]' => $value->category_id,
                                                                                'sub_category_id[]' => $value->id
                                                                            ]) }}"> -->
                                                                            <!-- <a href="{{ route('user.category_wise_store', $value->category_id) }}"> -->
                                                                            <a href="{{ route('user.category_wise_store', [
                                                                                    'category_id' => $value->category_id,
                                                                                    'subcategory_id' => $value->id
                                                                                ]) }}">
                                                                                <p>
                                                                                    @if(app()->getLocale() == 'ar')
                                                                                        {{ $value->name_arabic }}
                                                                                    @else
                                                                                        {{ $value->name_english }}
                                                                                    @endif
                                                                                </p>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                        
                                                    </div>
                                                    <!-- <button class="scroll-arrow scroll-btn scroll-right" type="button"
                                                        aria-label="scroll right">
                                                        <i class="fa-solid fa-chevron-right"></i>
                                                    </button> -->
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach

                                        <li class="nav-item">
                                            <a class="nav-link active" id="bestSellingLink" href="#sellingbest">{{ __('user_messages.best_selling') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('user.getLiveSellerRecords')}}">{{ __('user_messages.live') }}</a>
                                        </li>
                                        @if (Auth::guard('web')->check())
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page"
                                                href="{{route('user.gift_cards')}}">{{ __('user_messages.gift_card') }}</a>
                                        </li>
                                        @endif
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('user.category_wise_store')}}">{{ __('user_messages.stores') }}</a>
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
    <div class="modal fade location" id="changeLocation" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('user_messages.change_location') }}</h1>
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
                        <!-- <div id="useCurrentLocation" class="use-lc">
                            <i class="bi bi-crosshair"></i> Use Current Location
                        </div> -->

                        <h5>{{ __('user_messages.location') }}</h5>
                        <p id="locationUpdate"></p>
                    </div>

                    <button class="customBtn saveCurrentAddress mt-3">{{ __('user_messages.change_location') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div id="google_translate_element" style="display:none;"></div>
    <div id="loaderTrans" style="display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:#ffffff; 
        z-index:999999;   
        /* display:flex;    */
        align-items:center;
        justify-content:center;">

        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"
            style="border:none; width:200px; height:200px;">
        </iframe>
    </div>

    <!-- chnage country and currency Code  -->

    <!-- <script>

    var locale="{{App::getlocale()}}";


    document.addEventListener("DOMContentLoaded", function() {
        
            //debugger

        // ================= LOAD FROM LOCAL STORAGE =================
        let currency = localStorage.getItem("currency");
        let currencyAr = localStorage.getItem("currencyAr");
        let flag = localStorage.getItem("flag");
        let country_id = localStorage.getItem("country_id");

        if (currency) {
            
            if(locale=='en'){
                currency=currency
            }else{
                currency=currencyAr;
            }
            

            document.getElementById("selectedCurrency").innerText = currency;
            document.querySelectorAll('[name="currency"]').forEach(r => {
                if (r.value === currency) r.checked = true;
            });
        }

        if (flag) document.getElementById("selectedFlag").src = flag;

           // debugger
        if (country_id) {
            document.querySelectorAll('[name="country_language"]').forEach(r => {
                if (r.value === country_id) r.checked = true;
            });
        }

        // ================= COUNTRY CHANGE =================
        document.querySelectorAll('[name="country_language"]').forEach(radio => {
            radio.addEventListener("change", function() {

                let parent = this.closest(".dropdown-item");
                let flag = parent.getAttribute("data-flag");

                document.getElementById("selectedFlag").src = flag;

                localStorage.setItem("country_id", this.value);
                localStorage.setItem("flag", flag);

                // SAVE IN LARAVEL SESSION
                fetch("/set-country", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        country_id: this.value


                    })
                });
            });
        });

        // ================= CURRENCY SAVE =================
        document.querySelector('.currency .customBtn5').addEventListener("click", function() {

            let selected = document.querySelector('[name="currency"]:checked');

           // debugger

            if (selected) {
                let value = selected.value;

                document.getElementById("selectedCurrency").innerText = value;


                            // fetch data attributes
                let englishValue = selected.dataset.english;
                let arabicValue = selected.dataset.arabic;


                localStorage.setItem("currency", englishValue);
                localStorage.setItem("currencyAr", arabicValue);

                // SAVE IN LARAVEL SESSION
                fetch("/set-currency", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        currency: value
                    })
                });

                // Close dropdown
                let dropdown = bootstrap.Dropdown.getInstance(
                    document.querySelector('.currency').previousElementSibling
                );
                if (dropdown) dropdown.hide();

                window.location.reload();

            }
        });

    });

    // Close Currency Dropdown To Close on Click 

    document.addEventListener("DOMContentLoaded", function() {

        const closeBtn = document.querySelector('.close-dropdown');
        const toggleBtn = document.querySelector('[data-bs-toggle="dropdown"]');

        closeBtn.addEventListener('click', function(e) {
            // e.stopPropagation(); // optional

            let dropdown = bootstrap.Dropdown.getInstance(
                document.querySelector('.currency').previousElementSibling
            );
            if (dropdown) dropdown.hide();

        });

    });
    </script> -->

    <script>
var locale = "{{ App::getLocale() }}";

document.addEventListener("DOMContentLoaded", function () {

    // ================= LOAD FROM LOCAL STORAGE =================
    let currency = localStorage.getItem("currency");
    let currencyAr = localStorage.getItem("currencyAr");
    let flag = localStorage.getItem("flag");
    let country_id = localStorage.getItem("country_id");

    // ================= DEFAULT KUWAIT =================
    if (!country_id) {

        let kuwaitCountry = document.querySelector(
            '[name="country_language"][data-country="Kuwait"]'
        );

        if (kuwaitCountry) {

            kuwaitCountry.checked = true;

            let parent = kuwaitCountry.closest(".dropdown-item");
            let kuwaitFlag = parent.getAttribute("data-flag");

            // document.getElementById("selectedFlag").src = kuwaitFlag;

            document.getElementById("selectedFlag").textContent = kuwaitFlag;
            

            localStorage.setItem("country_id", kuwaitCountry.value);
            localStorage.setItem("flag", kuwaitFlag);
        }
    }

    if (!currency) {

        let kuwaitCurrency = document.querySelector(
            '[name="currency"][data-english="KWD"]'
        );

        if (kuwaitCurrency) {

            kuwaitCurrency.checked = true;

            let displayCurrency = locale === "en"
                ? kuwaitCurrency.dataset.english
                : kuwaitCurrency.dataset.arabic;

            document.getElementById("selectedCurrency").innerText = displayCurrency;

            localStorage.setItem("currency", kuwaitCurrency.dataset.english);
            localStorage.setItem("currencyAr", kuwaitCurrency.dataset.arabic);
        }
    }

    // ================= LOAD SAVED CURRENCY =================
    currency = localStorage.getItem("currency");
    currencyAr = localStorage.getItem("currencyAr");

    if (currency) {

        let displayCurrency = locale === "en" ? currency : currencyAr;

        document.getElementById("selectedCurrency").innerText = displayCurrency;

        document.querySelectorAll('[name="currency"]').forEach(r => {

            if (r.dataset.english === currency) {
                r.checked = true;
            }

        });
    }

    // ================= LOAD SAVED FLAG =================
    flag = localStorage.getItem("flag");

    if (flag) {
        document.getElementById("selectedFlag").src = flag;
    }

    // ================= LOAD SAVED COUNTRY =================
    country_id = localStorage.getItem("country_id");

    if (country_id) {

        document.querySelectorAll('[name="country_language"]').forEach(r => {

            if (r.value == country_id) {
                r.checked = true;
            }

        });
    }

    // ================= COUNTRY CHANGE =================
    document.querySelectorAll('[name="country_language"]').forEach(radio => {

        radio.addEventListener("change", function () {

            let parent = this.closest(".dropdown-item");
            let selectedFlag = parent.getAttribute("data-flag");

            document.getElementById("selectedFlag").textContent = selectedFlag;

            localStorage.setItem("country_id", this.value);
            localStorage.setItem("flag", selectedFlag);

            fetch("/set-country", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    country_id: this.value
                })
            });

        });

    });

    // ================= SAVE CURRENCY =================
    document.querySelector('.currency .customBtn5').addEventListener("click", function () {

        let selected = document.querySelector('[name="currency"]:checked');

        if (!selected) return;

        let englishValue = selected.dataset.english;
        let arabicValue = selected.dataset.arabic;

        let displayCurrency = locale === "en"
            ? englishValue
            : arabicValue;

        document.getElementById("selectedCurrency").innerText = displayCurrency;

        localStorage.setItem("currency", englishValue);
        localStorage.setItem("currencyAr", arabicValue);

        fetch("/set-currency", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                currency: englishValue
            })
        })
        .then(response => response.json())
        .then(() => {

            let dropdown = bootstrap.Dropdown.getInstance(
                document.querySelector('.currency').previousElementSibling
            );

            if (dropdown) {
                dropdown.hide();
            }

            window.location.reload();

        });

    });

    // ================= CLOSE CURRENCY DROPDOWN =================
    const closeBtn = document.querySelector('.close-dropdown');

    if (closeBtn) {

        closeBtn.addEventListener('click', function () {

            let dropdown = bootstrap.Dropdown.getInstance(
                document.querySelector('.currency').previousElementSibling
            );

            if (dropdown) {
                dropdown.hide();
            }

        });

    }

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const logoutBtn = document.getElementById('logoutBtn');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();

            localStorage.removeItem("currency");
            localStorage.removeItem("currencyAr");
            localStorage.removeItem("flag");
            localStorage.removeItem("country_id");

            window.location.href = this.href;
        });
    }

});
</script>

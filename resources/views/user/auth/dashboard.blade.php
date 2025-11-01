<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desynat</title>
    <link href="{{asset('user/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('user/assets/css/responsive.css')}}" rel="stylesheet" />
    <!-- <link href="assets/css/fontawesome.min.css" rel="stylesheet" /> -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="{{asset('user/assets/css/owl.carousel.css')}}" rel="stylesheet" />
    <link href="{{asset('user/assets/css/style.css')}}" rel="stylesheet" />

</head>
<body>

    <header class="header-main">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="w-100">
                    <div class="d-flex align-self-center justify-content-between">
                        <div>
                            <a class="navbar-brand" href="#"><img src="{{asset('user/assets/images/logo.svg')}}" /></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                     
                        <div class="header_nav_button_dropdown">
                               @if (Auth::guard('web')->check())
                               <img src="{{Auth::guard('web')->user()->profile_image}}" alt="" height="50px" width="80px"> 
                               @else
                                 <a class="customBtn1" href="{{route('userLogin')}}"><i class="fa-regular fa-user"></i> SIGN IN/SIGN UP</a>
                                 @endif
                       
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img id="selectedFlag" src="{{asset('user/assets/images/flags/kuwait.svg')}}" class="img-fluid" />
                                </button>
                                <ul class="dropdown-menu custom-dropdown-menu  dropdown-menu-end" aria-labelledby="countryDropdownBtn">
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
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedCurrency">KWD</span>
                                </button>
                                <ul class="dropdown-menu custom-dropdown-menu currency dropdown-menu-end">
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
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset('user/assets/images/global.svg')}}" class="img-fluid" /> EN
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="desynat_navigation_bar_header">
                        <div class="row">
                            <div class="col-lg-2 col-md-6 col-6">
                                <div class="track_location">
                                    <h6>Deliver to Reshab</h6>
                                    <div class="d-flex align-self-center w-100">
                                        <button>
                                            <img src="{{asset('user/assets/images/Icon.svg')}}" class="img-fluid" /> Durgapur 
                                        </button>
                                        <span class="ms-5">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-6">
                                <div class="form-group position-relative search">
                                    <input type="text" class="form-control" placeholder="Search Product or Brand" />
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="collapse navbar-collapse customNavbar" id="navbarSupportedContent">
                                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-wrap">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                men
                                            </a>
                                            <div class="dropdown-menu sell_clothes">

                                                <div class="row justify-content-between">
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>CLOTHING</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Shirt</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>SHOES</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Sneakers</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>WATCHES</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Leather</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>EYEWEAR</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Sunglasses</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>Exclusive</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Shirts</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Women
                                            </a>
                                            <div class="dropdown-menu sell_clothes">

                                                <div class="row justify-content-between">
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>CLOTHING</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Shirt</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>SHOES</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Sneakers</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>WATCHES</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Leather</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>EYEWEAR</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Sunglasses</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>Exclusive</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Shirts</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                KIds
                                            </a>
                                            <div class="dropdown-menu sell_clothes">

                                                <div class="row justify-content-between">
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>CLOTHING</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Shirt</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>SHOES</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Sneakers</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>WATCHES</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Leather</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>EYEWEAR</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Sunglasses</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="clothes_content">
                                                            <p>Exclusive</p>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a href="">Shirts</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
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


    <div class="customContainer">
        <div class="owl-carousel owl-theme customOwlcarousel">
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
        </div>
    </div>

    <section class="customContainer categorie_contenar">
        <h3>Categories</h3>
        <div class="row">
            <div class="col-lg-4 my-3 text-center categorie_cotent">
                <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" />
                <h3>Dresses</h3>
            </div>
            <div class="col-lg-4 my-3 text-center categorie_cotent">
                <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" />
                <h3>Abaya</h3>
            </div>
            <div class="col-lg-4 my-3 text-center categorie_cotent">
                <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" />
                <h3>Suits</h3>
            </div>
            <div class="col-lg-4 my-3 text-center categorie_cotent">
                <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" />
                <h3>Abaya</h3>
            </div>
            <div class="col-lg-4 my-3 text-center categorie_cotent">
                <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" />
                <h3>Cord Set</h3>
            </div>
            <div class="col-lg-4 my-3 text-center categorie_cotent">
                <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" />
                <h3>Dresses</h3>
            </div>
        </div>
    </section>

    <div class="customContainer suggestStore">
        <h3>Suggested Stores</h3>
        <div class="suggestStore_contenar">
            <div class="owl-carousel storeCarousel">
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            </div>
            
        </div>
        <div class="suggestStore_contenar">
            <div class="owl-carousel storeCarousel">
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            </div>
            
        </div>
    </div>

    <section class="bestSelling customContainer">
        <h3>Best Selling</h3>
        <div class="owl-carousel bestSellingCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="customContainer">
        <h3>Browse some Premium stores</h3>
        <div class="premiumImg">
            <img src="{{asset('user/assets/images/premium.svg')}}" class="img-fluid" />
        </div>
    </div>

    <section class="bestSelling customContainer">
        <h3>Top Rated</h3>
        <div class="owl-carousel topRatedCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="customContainer">
        <h3>Browse some discounted deals</h3>
        <div class="premiumImg">
            <img src="{{asset('user/assets/images/discount-deals.svg')}}" class="img-fluid" />
        </div>
    </div>

    <section class="customContainer">
        <h3>Newest Products</h3>
        <div class="row">
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-content">
                        <h5>3pcs Set (by Abaya)</h5>
                        <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span>(123K)</span>
                        </div>
                        <div class="price">
                        <strong>KD 239</strong>
                        <span class="old-price">KD 299</span>
                        <span class="discount">20% off</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="row justify-content-between">
            <div class="col-lg-3">
                <img src="{{asset('user/assets/images/logo.svg')}}" class="img-fluid" />
                <span class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </span>
                <button class="customBtn1">Become an Affiliate Customer</button> 
            </div>
            <div class="col-lg-5">
                <div class="footerNavLink ms-20percenter">
                    <div class="footerNavLink_content">
                        <h6>Customer Policy</h6>
                        <ul class="navs list-unstyled">
                            <li>
                                <a href="">About Us</a>
                            </li>
                             <li>
                                <a href="">Terms & Condition</a>
                            </li>
                             <li>
                                <a href="">Return Policy</a>
                            </li>
                             <li>
                                <a href="">Exchange Policy</a>
                            </li>
                             <li>
                                <a href="">FAQs</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footerNavLink_content">
                        <h6>Customer Policy</h6>
                        <ul class="navs list-unstyled">
                            <li>
                                <a href="">XYZgmail.com</a>
                            </li>
                             <li>
                                <a href="">+ 965 36214565</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footerNavLink">
                    <div class="footerNavLink_content ms-auto">
                        <h6>Get the App</h6>
                        <div class="getTheApp d-flex align-items-end flex-column">
                            <img src="{{asset('user/assets/images/play-store.svg')}}" class="img-fluid" />
                            <img src="{{asset('user/assets/images/ios-app.svg')}}" class="img-fluid" />
                        </div>
                        <ul class="list-unstyled social_icon">
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/Social icon.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/Instagram_logo_2016.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/social_facebook.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/social_x_circle 1.svg')}}" class="img-fluid" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="{{asset('user/assets/js/jquery-3.7.1.min.js')}}" ></script>
    <!-- <script src="assets/js/all.min.js" ></script> -->
    <script src="{{asset('usser/assets/js/bootstrap.bundle.min.js')}}" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->
    <script src="{{asset('user/assets/js/owl.carousel.js')}}"></script>
    <script src="{{asset('user/assets/js/custom.js')}}"></script>

     <script>
        $('.customOwlcarousel').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            nav:false,
            dots:true,
            responsive:{
                0:{
                    items:1,
                },
                600:{
                    items:1,
                },
                1000:{
                    items:1,
                    dots:true
                }
            }
        })
    </script>

    <script>
        $('.storeCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 8
                }
            },
            slideBy: 1 // slides one by one
        });

        $('.bestSellingCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            },
            slideBy: 1 // slides one by one
        });

        $('.topRatedCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            },
            slideBy: 1 // slides one by one
        });
    </script>
  
</script>
</body>
</html>
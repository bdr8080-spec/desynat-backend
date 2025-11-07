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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="{{ asset('user/assets/css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>
<body>
    
    <header class="header-main">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="w-100">
                    <div class="d-flex align-self-center justify-content-between">
                        <div>
                            <a class="navbar-brand" href="#"><img src="assets/images/logo.svg" /></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                        <div class="header_nav_button_dropdown">
                            <button class="customBtn1"><i class="fa-regular fa-user"></i> SIGN IN/SIGN UP</button>
                            <div class="dropdown userDropdown">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{Auth::guard('web')->user()->profile_image}}" alt="" height="50px" width="80px" /> 
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end profileDropdown">
                                    <li>
                                        <div class="profileContenar d-flex align-items-center justify-conten-between">
                                            <div class="profile d-flex align-items-center gap-3">
                                                <div class="profileContenar_img">
                                                    <img src="{{asset('user/assets/images/user.png')}}" class="img-fluid" />
                                                </div>
                                                <div class="profile_detail">
                                                    <p>Ahmed Farhan</p>
                                                    <label>farhan713@mail.com</label>
                                                </div>  
                                            </div>
                                            <span><i class="bi bi-pencil"></i></span>                                                     
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
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/return.svg')}}" />
                                                Return Policy</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/about-us.svg')}}" />
                                                About Us</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/faq.svg')}}" />
                                                FAQ's</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/change-lang.svg')}}" />
                                                Change Language</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/cancel-policy.svg')}}" />
                                                Cancellation Policy</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/exchange.svg')}}" />
                                                Exchange Policy</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/support.svg')}}" />
                                                Support</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/becom-affilit.svg')}}" />
                                                Become An Affiliate</a></li>
                                            <li><a href="">
                                                <img src="{{asset('user/assets/images/profile-icon/setting.svg')}}" />
                                                Settings</a></li>
                                            <li><a class="dropdown-item text-center" href="{{route('userLogout')}}">Logout</a></li>
                                        </ul>
                                    </li>
                                    <!-- <li><a class="dropdown-item text-center" href="{{route('userLogout')}}">Logout</a></li> -->
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img id="selectedFlag" src="assets/images/flags/kuwait.svg" class="img-fluid" />
                                </button>
                                <ul class="dropdown-menu custom-dropdown-menu  dropdown-menu-end" aria-labelledby="countryDropdownBtn">
                                    <li class="topDropdonw">
                                        <p>Change Country
                                            <i class="fa-solid fa-xmark"></i>
                                        </p>
                                    </li>
                                    <li class="dropdown-item" data-country="Kuwait" data-flag="assets/images/flags/kuwait.svg">
                                        <div class="d-flex align-self-center justify-content-between">
                                            <div class="radio-group">
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="male" checked />
                                                    <span class="radio-mark"></span>
                                                    <span class="label-text">Kuwait</span>
                                                </label>
                                            </div>
                                            <img src="assets/images/flags/kuwait.svg" />
                                        </div>
                                    </li>
                                    <li class="dropdown-item" data-country="Bahrain" data-flag="assets/images/flags/bahrain.svg">
                                        <div class="d-flex align-self-center justify-content-between">

                                            <div class="radio-group">
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="male" checked />
                                                    <span class="radio-mark"></span>
                                                    <span class="label-text">Bahrain</span>
                                                </label>
                                            </div>
                                            <img src="assets/images/flags/bahrain.svg" />
                                        </div>
                                    </li>
                                    <li class="dropdown-item" data-country="Qatar" data-flag="assets/images/flags/qatar.svg">
                                        <div class="d-flex align-self-center justify-content-between">

                                            <div class="radio-group">
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="male" checked />
                                                    <span class="radio-mark"></span>
                                                    <span class="label-text">Qatar</span>
                                                </label>
                                            </div>
                                            <img src="assets/images/flags/qatar.svg" />
                                        </div>
                                    </li>
                                    <li class="dropdown-item" data-country="Saudi Arabia" data-flag="assets/images/flags/saudi-arabia.svg">
                                        <div class="d-flex align-self-center justify-content-between">

                                            <div class="radio-group">
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="male" checked />
                                                    <span class="radio-mark"></span>
                                                    <span class="label-text">Saudi Arabia</span>
                                                </label>
                                            </div>
                                            <img src="assets/images/flags/saudi-arabia.svg" />
                                        </div>
                                    </li>
                                    <li class="dropdown-item" data-country="UAE" data-flag="assets/images/flags/uae.svg">
                                        <div class="d-flex align-self-center justify-content-between">

                                            <div class="radio-group">
                                                <label class="custom-radio"> 
                                                    <input type="radio" name="gender" value="male" checked />
                                                    <span class="radio-mark"></span>
                                                    <span class="label-text">UAE</span>
                                                </label>
                                            </div>
                                            <img src="assets/images/flags/uae.svg" />
                                        </div>
                                    </li>
                                    <li class="dropdown-item" data-country="Oman" data-flag="assets/images/flags/oman.svg">
                                        <div class="d-flex align-self-center justify-content-between">

                                            <div class="radio-group">
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="male" checked />
                                                    <span class="radio-mark"></span>
                                                    <span class="label-text">Oman</span>
                                                </label>
                                            </div>
                                            <img src="assets/images/flags/oman.svg" />
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
                                    <img src="assets/images/global.svg" class="img-fluid" /> EN
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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeLocation">
                                            <img src="assets/images/Icon.svg" class="img-fluid" /> Durgapur 
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


    <div class="my-profile customContainer">
        <div class="d-flex align-items-center mt-3 justify-content-between">
            <a href=""><i class="fa-solid fa-chevron-left"></i> My Profile (edit)</a>
            <button class="customBtn2"><i class="fa-solid fa-lock"></i>Change Password</button>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="profile d-flex align-items-center gap-3">
                    <div class="profileContainer_img">
                        <img id="profileImg" src="assets/images/user.png" class="img-fluid" alt="Profile Image" />
                    </div>
                    <label for="fileInput" class="changeImageText">Change Image</label>
                    <input type="file" id="fileInput" accept="image/*" hidden />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" placeholder="Faizan Ansari" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group mobile position-relative">
                    <label for="">Mobile No.</label>
                    <input type="text" class="form-control" placeholder="Faizan Ansari" />
                    <a href="" class="change">Change</a>
                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="form-group mobile position-relative">
                    <label for="">Email Id</label>
                    <input type="email" class="form-control" placeholder="faizanansari@mail.com" />
                    <a class="change">Change</a>
                </div>
            </div>
            <div class="col-lg-12">
                <button class="customBtn w-100 mt-4">Save</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{asset('user/assets/js/jquery-3.7.1.min.js')}}" ></script>
    <script src="{{asset('user/assets/js/bootstrap.bundle.min.js')}}" ></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/intlTelInput.js"></script>
     <script src="{{asset('user/assets/js/custom.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#fileInput").change(function (e) {
                const file = e.target.files[0];
                if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $("#profileImg").attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
                }
            });
            });
    </script>

</body>
</html>
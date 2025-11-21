@extends('user.layout.app')

@section('content')

<div class="customContainer">
    <div class="owl-carousel owl-theme customOwlcarousel">
        <div class="item">
            <img src="{{asset('user/')}}/assets/images/category-img.svg" class="img-fluid" />
        </div>
        <div class="item">
            <img src="{{asset('user/')}}/assets/images/category-img.svg" class="img-fluid" />
        </div>
        <div class="item">
            <img src="{{asset('user/')}}/assets/images/category-img.svg" class="img-fluid" />
        </div>
        <div class="item">
            <img src="{{asset('user/')}}/assets/imagess/category-img.svg" class="img-fluid" />
        </div>
    </div>
</div>

<div class="categoryDetail customContainer">
    <div class="row">
        <div class="col-lg-4">
            <div class="category_filter">
                <div class="d-flex align-items-center justify-content-between">
                    <h3>Filter</h3>
                    <span>Clear</span>
                </div>
                <div class="form-group mt-4">
                    <h5>Ratings</h5>
                    <div class="form-check my-4">
                        <input class="form-check-input mb-1" type="checkbox" value="" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            Upto 2 Star
                        </label>
                    </div>
                    <div class="form-check my-4">
                        <input class="form-check-input" type="checkbox" value="" id="checkChecked" checked>
                        <label class="form-check-label" for="checkChecked">
                            Upto 3 Star
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <h5>Availability</h5>
                    <div class="form-check my-4">
                        <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault1">
                        <label class="form-check-label" for="radioDefault1">
                            Open
                        </label>
                    </div>
                    <div class="form-check my-4">
                        <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault2" checked>
                        <label class="form-check-label" for="radioDefault2">
                            Busy
                        </label>
                    </div>
                </div>
                <div class="form-group delivery">
                    <div class="form-check my-4">
                        <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            Sortest Delivery time
                        </label>
                    </div>
                    <div class="form-check my-4">
                        <input class="form-check-input" type="checkbox" value="" id="checkChecked" checked>
                        <label class="form-check-label" for="checkChecked">
                            Highest Sale
                        </label>
                    </div>
                </div>
                <button class="customBtn customBtn5 mt-5">Apply</button>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="categoryDetail_content">
                <div class="seArch">
                    <div class="form-group position-relative search">
                        <input type="text" class="form-control" placeholder="Search" />
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button class="customBtn customBtn5">Search</button>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <a href="">
                            <div class="category-store">
                                <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                                <div class="category-store-content">
                                    <div class="user-infoCat_detail d-flex align-items-center">
                                        <div class="user">
                                            <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                        </div>
                                        <p>Atif Aslam</p>
                                    </div>
                                    <div class="rate-content d-flex align-items-center">
                                        <div class="rate">
                                            <span><i class="bi bi-star-fill"></i></span>
                                            <span><i class="bi bi-star-fill"></i></span>
                                            <span><i class="bi bi-star-fill"></i></span>
                                            <span><i class="bi bi-star-fill"></i></span>
                                            <span><i class="bi bi-star-fill"></i></span>
                                        </div>
                                        <p>(123K)</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 my-3">
                        <div class="category-store">
                            <img src="{{asset('user/')}}/assets/images/category/category1.svg" class="img-fluid" />
                            <div class="category-store-content">
                                <div class="user-infoCat_detail d-flex align-items-center">
                                    <div class="user">
                                        <img src="{{asset('user/')}}/assets/images/user.png" class="img-fluid" />
                                    </div>
                                    <p>Atif Aslam</p>
                                </div>
                                <div class="rate-content d-flex align-items-center">
                                    <div class="rate">
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                        <span><i class="bi bi-star-fill"></i></span>
                                    </div>
                                    <p>(123K)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('.customOwlcarouselCat').owlCarousel({
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

@endsection



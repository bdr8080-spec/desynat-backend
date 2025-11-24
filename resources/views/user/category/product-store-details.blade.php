@extends('user.layout.app')

@section('content')

<div class="customContainer">
        <div class="row">
            <div class="col-lg-5">
                <div id="carouselExampleCaptions" class="customProduct_Carousel carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1">
                            <div class="product_slide_img">
                                <img src="{{asset('user')}}/assets/images/product-detail.png" class="img-fluid" alt="...">
                            </div>
                        </button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2">
                            <div class="product_slide_img">
                                <img src="{{asset('user')}}/assets/images/product-detail.png" class="img-fluid" alt="...">
                            </div>
                        </button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3">
                            <div class="product_slide_img">
                                <img src="{{asset('user')}}/assets/images/product-detail.png" class="img-fluid" alt="...">
                            </div>
                        </button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                            <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                            <img src="{{asset('user')}}/assets/images/product-detail.png" class="img-fluid" alt="...">
                            
                        </div>
                        <div class="carousel-item">
                            <img src="{{asset('user')}}/assets/images/product-detail.png" class="img-fluid" alt="...">
                            
                        </div>
                        <div class="carousel-item">
                            <img src="{{asset('user')}}/assets/images/product-detail.png" class="img-fluid" alt="...">
                            
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="productList_content">
                    <!-- <div class=" float-end justify-content-end">
                        <a href="{{ route('seller.Add_product') }}" >
                        <img src="{{asset('dealer/assets/img/edit2.png')}}" class="" ></a>
                        <img src="{{asset('dealer/assets/img/delete2.png')}}" class="">

                    </div> -->
                    <h4 class="fw-semibold">Levies</h4>
                    <p class="text-muted mb-1">Silk Blend Heavy Sequence Work Co-Ord (Set of 3)</p>
                    <span class="bought">100 + bought</span>

                    <div class="d-flex align-items-center mb-2">
                        <span class="text-warning fs-5">★★★★☆</span>
                        <span class="ms-2 text-muted">(123K)</span>
                    </div>

                    <div class="d-flex align-items-center mb-1">
                        <h4 class="fw-bold text-dark me-2">239 KD</h4>
                        <del class="text-muted me-2">239 KD</del>
                        <span class="text-danger fw-semibold">20% off</span>
                    </div>
                    <p class="text-success small">inclusive of all taxes</p>

                    <hr>

                    <h6 class="fw-semibold mb-2">More Color</h6>
                    <div class="d-flex gap-2 mb-4 color-tabs">
                        <div class="color-box" data-color="#efe3c4" style="background:#efe3c4"></div>
                        <div class="color-box" data-color="#8ea6ff" style="background:#8ea6ff"></div>
                        <div class="color-box" data-color="#c79aff" style="background:#c79aff"></div>
                        <div class="color-box" data-color="#ff6f99" style="background:#ff6f99"></div>
                    </div>

                    <!-- BOX THAT WILL CHANGE COLOR -->
                    <div id="previewBox" class="preview-box">
                        Color Preview Box
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-semibold">Available Size</h6>
                        <a href="#" class="text-brown fw-semibold text-decoration-none">Size Guide</a>
                    </div>

                    <div class="d-flex gap-2 mb-4">
                        <button class="size-btn">S</button>
                        <button class="size-btn disabled">M</button>
                        <button class="size-btn">L</button>
                        <button class="size-btn">XL</button>
                    </div>

                    <button class="customBtn2">Custom Order</button>

                    <div class="d-flex align-items-center gap-3 mt-5">
                    <button class="customBtn2 mt-0">Add to Bag</button>
                    <button class="customBtn">Buy Now</button>
                    </div>

                    <div class="container my-4">
                        <div class="desc-box p-4 rounded-4">
                            <h5 class="fw-semibold">Description</h5>
                            <p class="mt-3 text-muted">
                                lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                labore

                                dolore magna aliqua. Ut enim ad minimdipisicing elit, sed do eiusmod tempor incididunt ut labore
                                aliqua

                                dolore magna aliqua. Ut enim ad minim aliqua.
                            </p>
                            <h5 class="fw-semibold mt-4">Specification</h5>
                            <ul class="mt-3 spec-list">
                                <li>Type 1 - Feature</li>
                                <li>Type 2 - Feature</li>
                                <li>Type 3 - Feature</li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-4 rounded-4 shadow-sm" style="background:#fff;">
                        <div class="row mb-2">
                            <div class="col-6">Return allowed ?
                            </div>
                            <div class="col-6 text-end">32</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Exchange allowed ?
                            </div>
                            <div class="col-6 text-end">32</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Review & ratings allowed ?
                            </div>
                            <div class="col-6 text-end">32</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Is it an Affiliated Product?
                            </div>
                            <div class="col-6 text-end">32</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Is this a Customized product?
                            </div>
                            <div class="col-6 text-end">32</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Ready to ship?
                            </div>
                            <div class="col-6 text-end">32</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Cash on delivery allowed?

                            </div>
                            <div class="col-6 text-end">32</div>
                        </div>
                    </div>

                    <div class="container my-4">
                        <div class="review-box p-4 rounded-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                        class="profile-img img-fluid" width="60" />
                                    <div>
                                        <h6 class="fw-semibold mb-1">Gimhana</h6>
                                        <span class="text-warning fs-5">★★★★☆</span>
                                    </div>
                                </div>
                                <span class="text-muted">11 Nov 2025</span>
                            </div>
                            <p class="mt-3 text-muted">
                                lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minimdipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim aliqua.
                            </p>
                            <div class="d-flex gap-3 mt-3">
                                <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                                <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                            </div>
                        </div>

                        <div class="review-box p-4 rounded-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                        class="profile-img img-fluid" width="60" />
                                    <div>
                                        <h6 class="fw-semibold mb-1">Gimhana</h6>
                                        <span class="text-warning fs-5">★★★★☆</span>
                                    </div>
                                </div>
                                <span class="text-muted">11 Nov 2025</span>
                            </div>
                            <p class="mt-3 text-muted">
                                lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minimdipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim aliqua.
                            </p>
                            <div class="d-flex gap-3 mt-3">
                                <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                                <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <section class="bestSelling customContainer mt-3">
                    <div class="owl-carousel topRatedCarousel">
                        <div class="item">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
                                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
                                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
                                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
                                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
                                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".color-box").click(function () {

                // Remove active from all
                $(".color-box").removeClass("active");

                // Add active class to clicked one
                $(this).addClass("active");

                // Get color
                let color = $(this).data("color");

                // Apply color
                $("#previewBox").css("background", color);
            });
        });
    </script>

@endsection
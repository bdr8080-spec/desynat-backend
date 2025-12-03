@extends('user.layout.app')

@section('content')
<style>
.cd-change-btn {
    background: #8a6a4366;
    border: 1px solid #d2b48c;
    padding: 7px 15px;
    border-radius: 8px;
    font-size: 16px;
    color: #000;
    cursor: pointer;
}

.cd-size {
    color: #9b744d;
    cursor: pointer;
}

.cart-counts button {
    width: 32px;
    height: 32px;
    border: none;
    background: linear-gradient(to bottom, #c7a276, #9b744a);
    color: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cart-counts {
    margin-top: 12px;
    align-items: center;
}

.qty-number {
    font-size: 20px;
    font-weight: 600;
    min-width: 40px;
    text-align: center;
}

.action-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.left-action {
    display: flex;
    flex-direction: column;
}


.cart-counts {
    background: #fff;
    padding: 5px 10px;
    border-radius: 8px;
}


.qty-wrapper {
    margin-top: 12px;
    background: white;
    padding: 12px;
    border-radius: 8px;
}
</style>
<div class="customContainer">
    <div class="row">
        <div class="col-lg-5">
            @php
            $firstVariant = reset($product_variants);
            $allImages = $firstVariant['variant_image'];
            @endphp

            <div id="carouselExampleCaptions" class="customProduct_Carousel carousel slide">

                <div class="carousel-indicators">
                    @foreach ($allImages as $index => $img)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}">
                        <div class="product_slide_img">
                            <img id="mainImage" src="{{ $img }}" class="img-fluid" alt="Slide {{ $index + 1 }}">
                        </div>
                    </button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @foreach ($allImages as $index => $img)
                    @if($index == 0)
                    <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                    {{-- <button class="wishlist-btn"><i class="{{$data->wishlist == '1' ? 'fa-solid' : 'fa-regular' }}
                    fa-heart" onclick="addWishListFunctionproduct({{$data->id}})"></i></button> --}}


                    @if (Auth::guard('web')->user())
                    <span class="wishlist-btn" style="cursor: pointer"><i id="wishlistProduct{{ $data->id }}"
                            class="fa-regular {{ $data->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                            onclick="addWishListFunctionproduct({{ $data->id }})"></i></span>
                    @else
                    <a class="wishlist-btn text-decoration-underline" href="{{route('userLogin')}}">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                    @endif

                    @endif
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">

                        <div class="carousel_item_img">
                            <img src="{{ $img }}" class="img-fluid" alt="Slide Image">
                        </div>
                    </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

        </div>

        <div class="col-lg-7">
            <div class="productList_content ps-3">
                <div class="d-flex justify-content-between">
                    <h4 class="fw-semibold text-capitalize">{{$data->brand->name_english}}</h4>
                    <button class="cd-change-btn">100+ Bought</button>

                </div>

                <p class="text-muted mb-1">{{$data->product_name_en}}</p>

                <div class="d-flex align-items-center mb-1">
                    <h4 class="fw-bold text-dark me-2" id="finalPrice">{{$firstVariant['final_price']}} KD</h4>
                    <del class="text-muted me-2" id="actualPrice">{{$firstVariant['actual_price']}} KD</del>
                    <span class="text-danger fw-semibold">{{$firstVariant['discount_value']}}% off</span>
                </div>

                <p class="text-muted mb-1">{{$data->store->store_name}}/{{$data->category->name}}</p>


                <hr>

                <h6 class="fw-semibold mb-2">More Color</h6>
                <div class="d-flex gap-2 mb-4 color-tabs">

                    @foreach ($product_variants as $variant)
                    <div class="color-box choose-color" data-color="{{ $variant['color_hex'] }}"
                        style="background: {{ $variant['color_hex'] }}">
                    </div>
                    @endforeach

                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold">Select Size</h6>
                    <h6 class="cd-size"
                        id="sizeGuideBtn"
                        data-bs-toggle="modal"
                        data-bs-target="#sizechart"
                        data-size-chart="{{ $data->upload_size_chart }}">
                        Size Guide
                    </h6>


                </div>

                <div class="d-flex gap-2 mb-4" id="sizeContainer">
                    @foreach ($firstVariant['sizes'] as $size)
                    <!-- <button class="size-btn">{{ $size }}</button> -->
                    <button class="size-btn" data-size="{{ $size }}" data-variant-id="{{ $firstVariant['variant_id'] }}"
                        data-product-id="{{ $firstVariant['product_id'] }}">{{ $size }}</button>
                    @endforeach
                </div>
                <input type="hidden" id="variantId" name="variant_id">
                <input type="hidden" id="productId" name="product_id">

                {{-- <h4 class="fw-semibold">{{$data->product_name_en}}</h4>
                <p class="text-muted mb-1">{{$data->description_en}}</p> --}}
                <div id="optionError" style="color:red; font-size:14px; display:none;"></div>
                @if ($data->customized_product==1)
                <button class="customBtn2">Custom Order</button>
                @endif


                <!-- start -->
                <div class="action-wrapper mt-3">

                    <!-- VIEW MY BAG (ALWAYS FULL WIDTH) -->
                    <div class="bag-topbar-full d-flex justify-content-between align-items-center" id="bagTopbar">
                        <div><strong>({{$cartCount}} Items)</strong> View My Bag</div>
                        <i class="bi bi-arrow-right arrow-icon"></i>
                    </div>

                    <div class="action-row d-flex align-items-center gap-3 mt-2">

                        <!-- LEFT SIDE -->
                        <div class="left-action w-50">

                            <!-- ADD TO BAG -->
                            <button class="customBtn2 w-100" id="addToBagBtn">Add to Bag</button>

                            <!-- QUANTITY BOX -->
                            <div class="quantity-box">
                                <div class="cart-counts d-flex justify-content-between align-items-center">
                                    <button class="qty-btn" id="minusBtn"><i class="bi bi-dash icons"></i></button>
                                    <div class="qty-number" id="qtyNumber">01</div>
                                    <button class="qty-btn" id="plusBtn"><i class="bi bi-plus icons"></i></button>
                                </div>
                            </div>

                        </div>

                        <!-- BUY NOW BUTTON -->
                        <button class="customBtn w-50" id="buyNowBtn">Buy Now</button>

                    </div>

                </div>
         <!-- end -->


                <!-- start -->
                <!-- <div class="quantity-box w-100">
                    <div class="bag-topbar d-flex justify-content-between align-items-center mt-3">
                        <div> <strong>({{$cartCount}} Items)</strong> View My Bag </div> <i
                            class="bi bi-arrow-right arrow-icon"></i>
                    </div>
                    <div class="cart-counts d-flex gap-5 mt-2">
                        <button class="qty-btn" id="minusBtn"> <i class="bi bi-dash icons"></i>
                        </button>
                        <div class="qty-number" id="qtyNumber">01</div>
                        <button class="qty-btn" id="plusBtn"> <i class="bi bi-plus icons"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button class="customBtn2 mt-0" id="addToBagBtn">Add
                        to Bag</button>
                    <button class="customBtn">Buy Now</button>
                </div> -->
                <!-- end -->

                <div class="my-4">
                    <div class="desc-box p-4 rounded-4">
                        <h5 class="fw-semibold">Description</h5>
                        <p class="mt-3 text-muted">
                            {{ $data->description_en }}
                        </p>
                        <h5 class="fw-semibold mt-4">Specification</h5>
                        <ul class="mt-3 spec-list">
                            @foreach ($data->product_specifications as $item)

                            <li>{{$item->name_en}} - {{$item->feature_en}}</li>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="check-delivery-box">
                    <div class="cd-header">
                        <h4>Check delivery</h4>
                        <button class="cd-change-btnss">Change</button>
                    </div>

                    <div class="cd-input">
                        <input type="number" placeholder="Enter Pincode" value="125478">
                    </div>

                    <ul class="cd-info">
                        <li>
                            <i class="bi bi-truck"></i>
                            Get it by <strong>24/12/2024</strong>
                        </li>
                        <li>
                            <i class="bi bi-cash-coin"></i>
                            Cash on Delivery Available
                        </li>
                        <li>
                            <i class="bi bi-arrow-repeat"></i>
                            7 Days Return & Exchange
                        </li>
                    </ul>
                </div>
                {{-- <div class="p-4 rounded-4 shadow-sm" style="background:#fff;">
                        <div class="row mb-2">
                            <div class="col-6">
                                @if($product->product_return==1) {{$product->return_days}} days @else No @endif
            </div>
            <div class="col-6 text-end">@if($product->product_exchangable==1) {{$product->exchangable_days}} days @else
                No @endif</div>
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
    </div> --}}
    <!-- <div class="p-4 rounded-4 shadow-sm desc-box mt-4   ">
        <div class="row mb-2">
            <div class="col-6">Return allowed ?
            </div>
            <div class="col-6 text-end">@if($data->product_return==1) {{$data->return_days}} days @else No @endif </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">Exchange allowed ?
            </div>
            <div class="col-6 text-end">@if($data->product_exchangable==1) {{$data->exchangable_days}} days @else No
                @endif </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">Review & ratings allowed ?
            </div>
            <div class="col-6 text-end">@if($data->review_rating==1) Yes @else No @endif </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">Is it an Affiliated Product?
            </div>
            <div class="col-6 text-end">@if($data->affiliated_product==1) Yes @else No @endif </div>

        </div>
        <div class="row mb-2">
            <div class="col-6">Is this a Customized product?
            </div>
            <div class="col-6 text-end">@if($data->customized_product==1) Yes @else No @endif </div>

        </div>
        <div class="row">
            <div class="col-6">Ready to ship?
            </div>
            <div class="col-6 text-end">@if($data->ready_to_ship==1) Yes @else No @endif </div>
        </div>
        <div class="row">
            <div class="col-6">Cash on delivery allowed?

            </div>
            <div class="col-6 text-end">@if($data->cash_on_delivery==1) Yes @else No @endif </div>

        </div>
    </div> -->


    <div class="container my-4">
        <div class="cd-header">
            <h4>Customers Ratings</h4>
            <h6 class="cd-size">View All</h6>
        </div>
        <div class="desc-box p-4 rounded-4">
            <div class="review-box p-4 rounded-4">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="profile-img img-fluid"
                            width="60" />
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
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="profile-img img-fluid"
                            width="60" />
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
</div>

<div class="col-lg-12">
    <section class="bestSelling customContainer mt-3 pb-0">
        <h3>Similiar Product</h3>
        <div class="owl-carousel topRatedCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/simliar1.png') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar2.png') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar3.jpg') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar4.jpg') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar4.png') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar5.png') }}" alt="Product">
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

    <section class="bestSelling customContainer mt-3 pt-0">
        <div class="owl-carousel topRatedCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/simliar1.png') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar2.png') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar3.jpg') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar4.jpg') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar4.png') }}" alt="Product">
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
                        <img src="{{ asset('user/assets/images/simliar5.png') }}" alt="Product">
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



  <div class="modal fade sizechart" id="sizechart" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Size Chart</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="sizeChartBody">

                    </div>
            </div>
        </div>
    </div>


@php
ob_start();
@endphp

<button class='share-btn'><i class='fa-solid fa-share'></i></button>

@if(Auth::guard('web')->user())
<span class="wishlist-btn" style="cursor: pointer">
    <i id="wishlistProduct{{ $data->id }}"
        class="fa-regular {{ $data->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
        onclick="addWishListFunctionproduct({{ $data->id }})"></i>
</span>
@else
<a class="wishlist-btn text-decoration-underline" href="{{ route('userLogin') }}">
    <i class="fa-regular fa-heart"></i>
</a>
@endif

@php
$wishlistBlock = trim(preg_replace('/\s+/', ' ', ob_get_clean()));
@endphp


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ------------------------------
    // VARIABLES
    // ------------------------------
    const productVariants = @json($product_variants);
    const cartData        = @json($cartData); // keyed by variants_id
    const wishlistHTML    = `{!! $wishlistBlock !!}`;

    let firstClick       = true;

    let quantityBox      = document.querySelector(".quantity-box");
    let qtyDisplay       = document.getElementById("qtyNumber");
    let plusBtn          = document.getElementById("plusBtn");
    let minusBtn         = document.getElementById("minusBtn");
    let addToBagBtn      = document.getElementById("addToBagBtn");
    let errorBox         = document.getElementById("optionError");
    let viewMyBagDiv     = document.getElementById("bagTopbar");

    // ------------------------------
    // INITIAL UI STATE
    // ------------------------------
    quantityBox.style.setProperty("display", "none", "important");
    viewMyBagDiv.style.setProperty("display", "none", "important");

    // ------------------------------
    // HELPER FUNCTIONS
    // ------------------------------
    function getQty() {
        return parseInt(qtyDisplay.textContent) || 1;
    }

    function setQty(qty) {
        qtyDisplay.textContent = qty < 10 ? "0" + qty : qty;
    }

    function sendToCart(qty) {
        let product_id = document.getElementById("productId").value;
        let variant_id = document.getElementById("variantId").value;

        if (!product_id || !variant_id) {
            toastr.error("Something went wrong. Please reselect options.");
            return;
        }

        fetch("{{ route('user.addToCart') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                product_id: product_id,
                variant_id: variant_id,
                quantity: qty
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === "error") {
                toastr.error(data.message);
            } else {
                toastr.success(data.message);
                    setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        })
        .catch(() => {
            toastr.error("Something went wrong.");
        });
    }

    function updateCartUIForVariant(variantId) {
        const cartItem = cartData[variantId];

        if (cartItem) {
            // Show quantity box and "View My Bag"
            quantityBox.style.setProperty("display", "block", "important");
            viewMyBagDiv.style.setProperty("display", "flex", "important");
            addToBagBtn.style.display = "none";

            setQty(cartItem.quantity);
            firstClick = false; // prevent firstClick logic
        } else {
            // Reset UI if not in cart
            quantityBox.style.setProperty("display", "none", "important");
            viewMyBagDiv.style.setProperty("display", "none", "important");
            addToBagBtn.style.display = "block";

            setQty(1);
            firstClick = true;
        }
    }

    // ------------------------------
    // REMOVE DUPLICATE EVENT LISTENERS
    // ------------------------------
    plusBtn.replaceWith(plusBtn.cloneNode(true));
    minusBtn.replaceWith(minusBtn.cloneNode(true));
    addToBagBtn.replaceWith(addToBagBtn.cloneNode(true));

    plusBtn     = document.getElementById("plusBtn");
    minusBtn    = document.getElementById("minusBtn");
    addToBagBtn = document.getElementById("addToBagBtn");

    // ------------------------------
    // COLOR CLICK HANDLER
    // ------------------------------
    document.querySelectorAll(".choose-color").forEach((colorBox, index) => {
        colorBox.addEventListener("click", function () {
            let colorHex = this.dataset.color;

            // Highlight active color
            document.querySelectorAll(".choose-color").forEach(c => c.classList.remove("active"));
            this.classList.add("active");

            // Find variant
            let variant = Object.values(productVariants).find(v => v.color_hex === colorHex);
            if (!variant) return;

            // Update price
            document.getElementById("actualPrice").innerText = variant.actual_price + " KD";
            document.getElementById("finalPrice").innerText  = variant.final_price + " KD";

            // Update sizes
            let sizeContainer = document.getElementById("sizeContainer");
            sizeContainer.innerHTML = "";

            variant.sizes.forEach(size => {
                sizeContainer.innerHTML += `
                    <button class="size-btn"
                        data-size="${size}"
                        data-variant-id="${variant.variant_id}"
                        data-product-id="${variant.product_id}">
                        ${size}
                    </button>
                `;
            });

            attachSizeClickEvents(variant);

            // Update images
            let images = variant.variant_image;
            let carouselIndicators = document.querySelector(".carousel-indicators");
            let carouselInner      = document.querySelector(".carousel-inner");

            carouselIndicators.innerHTML = "";
            carouselInner.innerHTML      = "";

            images.forEach((img, idx) => {
                carouselIndicators.innerHTML += `
                    <button type="button"
                        data-bs-target="#carouselExampleCaptions"
                        data-bs-slide-to="${idx}"
                        class="${idx === 0 ? 'active' : ''}">
                        <div class="product_slide_img">
                            <img src="${img}" class="img-fluid"/>
                        </div>
                    </button>
                `;

                carouselInner.innerHTML += `
                    <div class="carousel-item ${idx === 0 ? 'active' : ''}">
                        ${idx === 0 ? wishlistHTML : ''}
                        <div class="carousel_item_img">
                            <img src="${img}" class="img-fluid">
                        </div>
                    </div>
                `;
            });

            // Auto-select first size
            let firstSizeButton = document.querySelector(".size-btn");
            if (firstSizeButton) firstSizeButton.click();
        });

        // Auto-click first color on page load
        if (index === 0) colorBox.click();
    });

    // ------------------------------
    // SIZE CLICK HANDLER
    // ------------------------------
    function attachSizeClickEvents(variant) {
        const sizeButtons = document.querySelectorAll(".size-btn");
        const hiddenInputVariant = document.getElementById("variantId");
        const hiddenInputProduct = document.getElementById("productId");

        sizeButtons.forEach(button => {
            button.addEventListener("click", function () {
                sizeButtons.forEach(btn => {
                    btn.classList.remove("active");
                    btn.style.background = "";
                });

                this.classList.add("active");
                this.style.background = "#FAEBD7";

                hiddenInputVariant.value = this.dataset.variantId;
                hiddenInputProduct.value  = this.dataset.productId;

                document.getElementById("actualPrice").innerText = variant.actual_price + " KD";
                document.getElementById("finalPrice").innerText  = variant.final_price + " KD";

                // Update UI based on cart
                updateCartUIForVariant(this.dataset.variantId);
            });
        });
    }

    // ------------------------------
    // ADD TO BAG CLICK
    // ------------------------------
    addToBagBtn.addEventListener("click", function () {
        let selectedColor = document.querySelector(".choose-color.active");
        let selectedSize  = document.querySelector(".size-btn.active");

        errorBox.style.display = "none";
        errorBox.innerHTML = "";

        if (!selectedColor) {
            errorBox.style.display = "block";
            errorBox.innerHTML = "Please Select a Color.";
            return;
        }
        if (!selectedSize) {
            errorBox.style.display = "block";
            errorBox.innerHTML = "Please Select a Size.";
            return;
        }

        if (firstClick) {
            firstClick = false;

            setQty(1);

            viewMyBagDiv.style.setProperty("display", "flex", "important");
            quantityBox.style.setProperty("display", "block", "important");
            addToBagBtn.style.display = "none";

            sendToCart(1);
        }
    });

    // ------------------------------
    // PLUS BUTTON CLICK
    // ------------------------------
    plusBtn.addEventListener("click", () => {
        if (quantityBox.style.getPropertyValue("display") !== "block") return;

        let qty = getQty();
        qty += 1;

        setQty(qty);
        sendToCart(qty);
    });

    // ------------------------------
    // MINUS BUTTON CLICK
    // ------------------------------
    minusBtn.addEventListener("click", () => {
        if (quantityBox.style.getPropertyValue("display") !== "block") return;

        let qty = getQty();

        if (qty === 1) {
            quantityBox.style.setProperty("display", "none", "important");
            viewMyBagDiv.style.setProperty("display", "none", "important");
            addToBagBtn.style.display = "block";

            setQty(1);
            firstClick = true;
            return;
        }

        qty -= 1;

        setQty(qty);
        sendToCart(qty);
    });

});
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {

    const sizeGuideBtn = document.getElementById("sizeGuideBtn");
    const sizeChartBody = document.getElementById("sizeChartBody");

    sizeGuideBtn.addEventListener("click", function() {
        // Get size chart URL from button data attribute
        const sizeChartImage = this.dataset.sizeChart;

        if (sizeChartImage) {
            sizeChartBody.innerHTML = `<img src="${sizeChartImage}" class="img-fluid" alt="Size Chart">`;
        } else {
            sizeChartBody.innerHTML = `<p class="text-center">No size chart available.</p>`;
        }
    });

    // Clear modal content on close to avoid duplicates
    const sizeChartModal = document.getElementById("sizechart");
    sizeChartModal.addEventListener("hidden.bs.modal", function () {
        sizeChartBody.innerHTML = "";
    });

});
</script>














@endsection
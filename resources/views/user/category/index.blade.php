@extends('user.layout.app')

@section('content')
    <div class="customContainer">
        <div class="">
            <div class="">
                <img src="{{ asset('user/assets/images/image-sg.svg') }}" class="img-fluid" />
            </div>
        </div>
    </div>

    <div class="storeClient_profile customsmallContainer">
        <div class="row">
            <div class="col-lg-6">
                <div class="profile_main">
                    <div class="d-flex align-items-center">
                        <div class="img-contenar">
                            <div class="storeClient_profile_img">
                                <img src="{{ $store_details['store']['store_image'] }}" class="img-fluid" />
                            </div>
                        </div>
                        <div class="storeClient_profile_content">
                            <div class="d-flex align-items-center">
                                <h3>{{ $store_details['store']['store_name'] }}</h3>
                                <span class="status_on_off">

                                    @if ($store_details['store']['Store_Availability'] == 1)
                                        Availble
                                    @else
                                        Busy
                                    @endif

                                </span>
                            </div>
                            <div class="product-content">
                                <p>{{ $store_details['store']['store_name'] }}</p>
                                <div class="rating">
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star-half-stroke"></i></span>
                                    <span class="totalstart">(1K)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>{{ $store_details['store']['bio'] }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="qr_code d-flex ms-auto justify-content-end">
                    <div class="qr-section">
                        <div id="qrCodeBox"></div>

                        <div class="copy-link-box" id="copyLinkBtn">
                            <span>Copy Link</span>
                            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828817.png" alt="Copy"
                                class="copy-icon">
                        </div>

                        <p id="copiedMsg">Link Copied!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="customsmallContainer reels">
        <div class="row">
            <div class="col-lg-12">
                <div class="suggestStore_contenar">
                    <div class="owl-carousel storeCarousel">
                        <div class="item" onclick="openGallery(0)">
                            <div class="suggestStore_content">
                                <div class="suggestedStore_img">
                                    <img src="{{ asset('user/') }}/assets/images/store1.jpg" class="img-fluid" />
                                </div>
                                <p>Kurtas</p>
                            </div>
                        </div>
                        <div class="item" onclick="openGallery(1)">
                            <div class="suggestStore_content">
                                <div class="suggestedStore_img">
                                    <img src="{{ asset('user/') }}/assets/images/store1.jpg" class="img-fluid" />
                                </div>
                                <p>Polo</p>
                            </div>
                        </div>
                        <div class="item" onclick="openGallery(2)">
                            <div class="suggestStore_content">
                                <div class="suggestedStore_img">
                                    <img src="{{ asset('user/') }}/assets/images/store1.jpg" class="img-fluid" />
                                </div>
                                <p>Shirts</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="suggestStore_content">
                                <div class="suggestedStore_img">
                                    <img src="{{ asset('user/') }}/assets/images/store1.jpg" class="img-fluid" />
                                </div>
                                <p>Casuals</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="suggestStore_content">
                                <div class="suggestedStore_img">
                                    <img src="{{ asset('user/') }}/assets/images/store1.jpg" class="img-fluid" />
                                </div>
                                <p>Formals</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="suggestStore_content">
                                <div class="suggestedStore_img">
                                    <img src="{{ asset('user/') }}/assets/images/store1.jpg" class="img-fluid" />
                                </div>
                                <p>Kurtas</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="product_reels customContainer">
        <ul class="nav nav-tabs customNavTabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane"
                    type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">Product</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reels-tab" data-bs-toggle="tab" data-bs-target="#reels-tab-pane" type="button"
                    role="tab" aria-controls="reels-tab-pane" aria-selected="false">Reels</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
                tabindex="0">
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
                                        <input class="form-check-input mb-1" type="checkbox" value=""
                                            id="checkDefault">
                                        <label class="form-check-label" for="checkDefault">
                                            Upto 2 Star
                                        </label>
                                    </div>
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" value="" id="checkChecked"
                                            checked>
                                        <label class="form-check-label" for="checkChecked">
                                            Upto 3 Star
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5>Availability</h5>
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="radioDefault"
                                            id="radioDefault1">
                                        <label class="form-check-label" for="radioDefault1">
                                            Open
                                        </label>
                                    </div>
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="radioDefault"
                                            id="radioDefault2" checked>
                                        <label class="form-check-label" for="radioDefault2">
                                            Busy
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group delivery">
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault">
                                        <label class="form-check-label" for="checkDefault">
                                            Sortest Delivery time
                                        </label>
                                    </div>
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" value="" id="checkChecked"
                                            checked>
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
                                <div class="row">

                                    @foreach ($store_details['All_Product'] as $item)
                                        <div class="col-lg-4 col-md-4 col-12 my-3">

                                            <div class="product-card">
                                                <div class="product-img">

                                                    <a href="{{ url('/route2') }}">
                                                        @foreach ($item->product_variants[0]->variant_image as $key => $val)
                                                            @if ($key != 0)
                                                                @php break  @endphp
                                                            @endif
                                                            <img src="{{ $val }}" alt="Product">
                                                        @endforeach

                                                    </a>


                                                    <span class="wishlist-btn"><i id="wishlistProduct{{ $item->id }}"
                                                            class="fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                                                            onclick="addWishListFunctionproduct({{ $item->id }})"></i></span>
                                                </div>
                                                <div class="product-content">

                                                    <a href="{{ url('/route2') }}">

                                                        <h5>{{ $item->product_name_en }}</h5>
                                                        <div class="rating">
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star-half-stroke"></i>
                                                            <span>(1K)</span>
                                                        </div>
                                                        <div class="price">
                                                            <strong>{{ $item->product_variants[0]->actual_price }}
                                                                KD</strong>
                                                            <span
                                                                class="old-price">{{ $item->product_variants[0]->final_price }}
                                                                KD</span>
                                                            <span class="discount">

                                                                {{ $item->product_variants[0]->discount_value }}
                                                                {{ $item->product_variants[0]->discount_type == '1' ? '%' : 'Off' }}

                                                            </span>
                                                        </div>
                                                    </a>


                                                </div>
                                            </div>

                                        </div>
                                    @endforeach



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="reels-tab-pane" role="tabpanel" aria-labelledby="reels-tab" tabindex="0">
                <div class="categoryDetail_content reels_content">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('user.layout.app')

@section('content')

@php

if(App::getLocale()=='en'){
$currency = session('currency', 'KWD');
}else{
$currency = session('currencyAr', 'دينار كويتي');
}
    $rate = session('rate', '1');

@endphp

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

.disabled-btn {
    opacity: 0.5;
    cursor: not-allowed !important;
    pointer-events: none;
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
                    <button class="share-btn product" data-link="{{ route('user.product_details',[$data->id]) }}"><i class="fa-solid fa-share"></i></button>
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
                    <h4 class="fw-semibold text-capitalize">
                        @if(app()->getLocale() == 'en')
                        {{$data->brand->name_english}}
                        @else
                        {{$data->brand->name_arabic}}
                        @endif
                    </h4>
                    <button class="cd-change-btn">{{ __('user_messages.100+_bought') }}</button>

                </div>

                <p class="text-muted mb-1">
                    @if(app()->getLocale() == 'en')
                    {{$data->product_name_en}}
                    @else
                    {{$data->product_name_ar}}
                    @endif
                </p>

                <div class="d-flex align-items-center mb-1">


                    <h4 class="fw-bold text-dark me-2" id="finalPrice">{{ number_format(convertPriceInUserWeb($firstVariant['final_price']), 2) }}   {{ $currency }}</h4>

                    @if($firstVariant['discount_value']!=="0")
                    <del class="text-muted me-2" id="actualPrice">
                    {{ number_format(convertPriceInUserWeb($firstVariant['actual_price']), 2) }}  {{ $currency }} 
                    </del>
                    <span class="text-danger fw-semibold">{{$firstVariant['discount_value']}}% {{ __('user_messages.off') }}</span>
                    @endif

                </div>

                <p class="text-muted mb-1">{{$data->store->store_name}}/@if(app()->getLocale() == 'en'){{$data->category->name}}@else{{$data->category->name_ar}}@endif</p>


                <hr>

                <h6 class="fw-semibold mb-2">{{ __('user_messages.more_color') }}</h6>
                <div class="d-flex gap-2 mb-4 color-tabs">

                    @foreach ($product_variants as $variant)
                    <div class="color-box choose-color" data-color="{{ $variant['color_hex'] }}"
                        style="background: {{ $variant['color_hex'] }}">
                    </div>
                    @endforeach

                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold">{{ __('user_messages.select_size') }}</h6>
                    <h6 class="cd-size" id="sizeGuideBtn" data-bs-toggle="modal" data-bs-target="#sizechart"
                        data-size-chart="{{ $data->upload_size_chart }}">
                        {{ __('user_messages.size_guide') }}
                    </h6>


                </div>

                <div class="d-flex gap-2 mb-4" id="sizeContainer">
                    @foreach ($firstVariant['sizes'] as $size)
                    <!-- <button class="size-btn">{{ $size }}</button> -->
                    <button class="size-btn" data-size="{{ $size }}" data-variant-id="{{ $firstVariant['variant_id'] }}"
                        data-product-id="{{ $firstVariant['product_id'] }}"
                        data-Stock-id="{{$firstVariant['total_stock']}}">{{ $size }}</button>
                    @endforeach
                </div>
                <input type="hidden" id="variantId" name="variant_id">
                <input type="hidden" id="productId" name="product_id">

                @if(auth()->guard('web')->check() && auth()->guard('web')->user())

                {{-- <h4 class="fw-semibold">{{$data->product_name_en}}</h4>
                <p class="text-muted mb-1">{{$data->description_en}}</p> --}}
                <div id="optionError" style="color:red; font-size:14px; display:none;"></div>
                @if ($data->customized_product==1)
                  <button 
                    class="customBtn2 {{ $data->store->Store_Availability == 0 ? 'disabled-btn' : '' }}" 
                    id="customOrder"
                    {{ $data->store->Store_Availability == 0 ? 'disabled' : '' }}
                >
                    {{ __('user_messages.custom_order') }}
                </button>
                @endif

                @endif


                <!-- start -->
                <div class="action-wrapper mt-3">

                    <!-- VIEW MY BAG (ALWAYS FULL WIDTH) -->
                    <div class="bag-topbar-full d-flex justify-content-between align-items-center" id="bagTopbar">
                        <div><strong>({{$cartCount}} {{ __('user_messages.items') }})</strong> {{ __('user_messages.view_my_bag') }}</div>
                        <a href="{{route('user.view_cart')}}"><i class="bi bi-arrow-right arrow-icon"></i></a>
                    </div>

                    <div class="action-row d-flex align-items-center gap-3 mt-2">

                       @if(auth()->guard('web')->check() && auth()->guard('web')->user())
                        <!-- LEFT SIDE -->
                        <div class="left-action w-50">

                            <!-- ADD TO BAG -->
                            <button 
                                class="customBtn2 w-100 addToBagBtnRemove {{ $data->store->Store_Availability == 0 ? 'disabled-btn' : '' }}" 
                                id="addToBagBtn"
                                {{ $data->store->Store_Availability == 0 ? 'disabled' : '' }}
                            >
                                {{ __('user_messages.add_to_bag') }}
                            </button>

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
                        <button 
                            class="customBtn w-50 {{ $data->store->Store_Availability == 0 ? 'disabled-btn' : '' }}" 
                            id="buyNowBtn"
                            {{ $data->store->Store_Availability == 0 ? 'disabled' : '' }}
                        >
                            {{ __('user_messages.buy_now') }}
                        </button>

                        @else

                       
                          <div class="left-action w-50">

                            <!-- ADD TO BAG -->
                          <a href="{{route('userLogin')}}" class="customBtn2 w-100 addToBagBtnRemove text-center" id="addToBagBtn">{{ __('user_messages.add_to_bag') }} </a>

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
                    <a href="{{route('userLogin')}}" class="customBtn w-50" id="buyNowBtn">{{ __('user_messages.buy_now') }}</a>
                    @endif

                    </div>

                </div>
                <!-- end -->

                <div class="my-4">
                    <div class="desc-box p-4 rounded-4">
                        <h5 class="fw-semibold">{{ __('user_messages.description') }}</h5>
                        <p class="mt-3 text-muted">
                            @if(app()->getLocale() == 'en')
                            {{ $data->description_en }}
                            @else
                            {{ $data->description_ar }}
                            @endif
                        </p>
                        <h5 class="fw-semibold mt-4">{{ __('user_messages.specification') }}</h5>
                        <ul class="mt-3 spec-list">
                            @foreach ($data->product_specifications as $item)

                            <li>@if(app()->getLocale() == 'en'){{$item->name_en}}@else{{$item->name_ar}}@endif - @if(app()->getLocale() == 'en'){{$item->feature_en}}@else{{$item->feature_ar}}@endif</li>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="check-delivery-box">
                    <div class="cd-header">
                        <h4>{{ __('user_messages.check_delivery') }}</h4>
                        <button class="cd-change-btnss">{{ __('user_messages.change') }}</button>
                    </div>

                    <div class="cd-input">
                        <input type="number" placeholder="{{ __('admin_messages.enter_pincode') }}" value="125478">
                    </div>

                    <ul class="cd-info">
                        <li>
                            <i class="bi bi-truck"></i>
                            {{ __('user_messages.get_it_buy') }} @if(app()->getLocale() == 'en')<strong>24/12/2024</strong>@else<strong>٢٤/١٢/٢٠٢٤</strong>@endif
                        </li>
                        <li>
                            <i class="bi bi-cash-coin"></i>
                            {{ __('user_messages.cash_on_delivery_available') }}
                        </li>
                        <li>
                            <i class="bi bi-arrow-repeat"></i>
                            {{ __('user_messages.7_days_return_&_exchange') }}
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
            <h4>{{ __('user_messages.customer_ratings') }}</h4>
            <h6 class="cd-size">{{ __('user_messages.view_all') }}</h6>
        </div>
        <div class="desc-box p-4 rounded-4">
            @forelse($data->review as $review)
            <div class="review-box p-4 rounded-4">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <!-- User Profile Image -->
                        <img src="{{ $review->user_details->profile_image ?? 'https://cdn-icons-png.flaticon.com/512/149/149071.png' }}"
                            class="profile-img img-fluid" width="60" alt="User Profile" />
                        <div>
                            <h6 class="fw-semibold mb-1">{{ $review->user_details->full_name ?? 'Anonymous' }}</h6>
                            <!-- Product Rating (stars) -->
                            <span class="text-warning fs-5">
                                @for ($i = 1; $i <= 5; $i++) <i
                                    class="bi bi-star{{ $i <= $review->product_rating ? '-fill' : '' }} text-warning">
                                    </i>
                                    @endfor
                            </span>
                        </div>
                    </div>
                    <span class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</span>
                </div>
                <p class="mt-3 text-muted">
                    {{ $review->product_review ?? __('user_messages.no_review_provided') }}
                </p>
                <div class="d-flex gap-3 mt-3">
                    <!-- Render Product Images (if any) -->
                    @php

                    // $productImages = json_decode($review->product_image);
                    $productImages = $review->product_image;
                    @endphp

                    @if($productImages && is_array($productImages))
                    @foreach($productImages as $image)
                    <img src="{{ $image }}" class="review-img" alt="Review Image"
                        style="width: 100px; height: 100px; object-fit: cover;" />
                    @endforeach
                    @else

                    @endif
                </div>
            </div>
            @empty
            <p>{{ __('user_messages.no_reviews_yet') }}. {{ __('user_messages.be_the_first_to_review_this_product') }}!</p>
            @endforelse




        </div>
    </div>
</div>
</div>

<!-- <div class="col-lg-12">
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
          
        </div>
    </section>
</div>
 -->

</div>
</div>




<div class="modal fade sizechart" id="sizechart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('user_messages.size_chart') }}</h1>
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
<!-- <button class='share-btn'><i class='fa-solid fa-share'></i></button> -->

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

const currencySymbal="{{$currency}}";
const currencyrate="{{$rate}}";


document.addEventListener("DOMContentLoaded", function() {

    // ------------------------------
    // VARIABLES
    // ------------------------------
    const productVariantsByColor = @json($product_variants); // grouped by color
    const productVariantsById = @json($productVariantsById); // flat lookup by variant_id
    const cartData = @json($cartData); // keyed by variants_id
    const wishlistHTML = `{!! $wishlistBlock !!}`;

    let firstClick = true;

    let quantityBox = document.querySelector(".quantity-box");
    let qtyDisplay = document.getElementById("qtyNumber");
    let plusBtn = document.getElementById("plusBtn");
    let minusBtn = document.getElementById("minusBtn");
    let addToBagBtn = document.getElementById("addToBagBtn");
    let errorBox = document.getElementById("optionError");
    let viewMyBagDiv = document.getElementById("bagTopbar");

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
            //toastr.error("Something went wrong. Please reselect options.");
            return;
        }

        // ✅ Get reference link if ref exists
        let referenceLink = null;
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('ref')) {
            referenceLink = window.location.href;
            //console.log(referenceLink);
        }

        // ✅ If already in cart → go to cart
        if (cartData[variant_id]) {
            window.location.href = "{{ route('user.view_cart') }}";
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
                quantity: qty,
                reference_link: referenceLink
            })
        })
        .then(r => r.json())
        .then(data => {

            if (data.status === "error") {
                toastr.error(data.message);

                setTimeout(() => {
                    location.reload();
                }, 1000);

            } else {

                toastr.success(data.message);

                setTimeout(() => {
                    location.reload();
                }, 1000);
            }

        })
        .catch(() => {
            toastr.error("Something went wrong.");
        });
    }

    function updateCartUIForVariant(variantId) {
        const cartItem = cartData[variantId];

        if (cartItem) {
            quantityBox.style.setProperty("display", "block", "important");
            viewMyBagDiv.style.setProperty("display", "flex", "important");
            addToBagBtn.style.display = "none";

            setQty(cartItem.quantity);

            console.log(cartItem);

            firstClick = false;
        } else {
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

    plusBtn = document.getElementById("plusBtn");
    minusBtn = document.getElementById("minusBtn");
    addToBagBtn = document.getElementById("addToBagBtn");

    // ------------------------------
    // COLOR CLICK HANDLER
    // ------------------------------

    const activeProduct = JSON.parse(localStorage.getItem("activeSingleProduct"));
    const savedColor = activeProduct?.ColorCode || null;
    const savedSize = activeProduct?.SizeCode || null;

    const colorBoxes = document.querySelectorAll(".choose-color");

    const SizeBoxes = document.querySelectorAll(".size-btn");

    colorBoxes.forEach((colorBox, index) => {

        colorBox.addEventListener("click", function() {
            const colorHex = this.dataset.color;

            // Remove active from all
            colorBoxes.forEach(c => c.classList.remove("active"));

            // Add active to clicked
            this.classList.add("active");

            const variant = Object.values(productVariantsByColor)
                .find(v => v.color_hex === colorHex);
            if (!variant) return;

            // Update prices
            document.getElementById("actualPrice").innerText = variant.actual_price*currencyrate + " {{$currency}}";
            document.getElementById("finalPrice").innerText = variant.final_price*currencyrate + " {{$currency}}";

            // Update sizes
            const sizeContainer = document.getElementById("sizeContainer");
            sizeContainer.innerHTML = "";

            variant.sizes.forEach(size => {
                const variantForSize = Object.values(productVariantsById)
                    .find(v => v.color_hex === colorHex && v.size === size);

                sizeContainer.innerHTML += `
                <button class="size-btn"
                   data-color=${colorHex}
                    data-size="${size}"
                    data-variant-id="${variantForSize.variant_id}"
                    data-product-id="${variantForSize.product_id}"
                    data-stock-id="${variantForSize.total_stock}">
                    ${size}
                </button>
            `;
            });

            attachSizeClickEvents();

            // Update images
            const images = variant.variant_image;

            const carouselIndicators = document.querySelector(".carousel-indicators");
            const carouselInner = document.querySelector(".carousel-inner");

            carouselIndicators.innerHTML = "";
            carouselInner.innerHTML = "";

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
            // document.querySelector(".size-btn")?.click();
        });

        // 🔥 AUTO-SELECT COLOR FROM LOCALSTORAGE
        if (savedColor && colorBox.dataset.color === savedColor) {
            colorBox.click();
        }
    });

    // Fallback: click first color if no saved color
    if (!savedColor && colorBoxes.length) {
        colorBoxes[0].click();
    }

    // ------------------------------
    // SIZE CLICK HANDLER

    var SizeSelect = false;

    function attachSizeClickEvents() {

        const sizeButtons = document.querySelectorAll(".size-btn");

        const single_Active_product = JSON.parse(localStorage.getItem('activeSingleProduct'));
        const savedSizeCode = single_Active_product?.SizeCode;
        const savedColorCode = single_Active_product?.ColorCode;

        SizeSelect = false; // reset once

        sizeButtons.forEach(button => {

            // ✅ CLICK HANDLER
            button.addEventListener("click", function() {
                activateSize(this);
                SizeSelect = true;
            });

            // ✅ AUTO-ACTIVATE SAVED SIZE + COLOR
            if (
                !SizeSelect && // stop after first match
                savedSizeCode &&
                button.dataset.size === savedSizeCode &&
                button.dataset.color === savedColorCode
            ) {
                activateSize(button);
                SizeSelect = true;
            }
        });

        // ✅ FALLBACK: select first size only if nothing matched
        if (!SizeSelect && sizeButtons.length > 0) {
            sizeButtons[0].click();
        }
    }




    function activateSize(button) {
        const sizeButtons = document.querySelectorAll(".size-btn");

        sizeButtons.forEach(btn => {
            btn.classList.remove("active");
            btn.style.background = "";
        });


        var single_Active_product = JSON.parse(localStorage.getItem('activeSingleProduct'));
        var savedSizeCode = single_Active_product?.SizeCode;


        button.classList.add("active");
        button.style.background = "#FAEBD7";

        const variantId = button.dataset.variantId;
        const variant = productVariantsById[variantId];

        document.getElementById("variantId").value = variant.variant_id;
        document.getElementById("productId").value = variant.product_id;

        document.getElementById("actualPrice").innerText = variant.actual_price * currencyrate + " {{$currency}}";
        document.getElementById("finalPrice").innerText = variant.final_price * currencyrate + " {{$currency}}";

        updateCartUIForVariant(variantId);
        AddAndBuyButtonHideAndShowCode();
    }

    // ------------------------------
    // ADD TO BAG CLICK
    // ------------------------------
    addToBagBtn.addEventListener("click", function() {
        const selectedColor = document.querySelector(".choose-color.active");
        const selectedSize = document.querySelector(".size-btn.active");

        errorBox.style.display = "none";
        errorBox.innerHTML = "";

        if (!selectedColor) {
            errorBox.style.display = "block";
            errorBox.innerHTML = "{{ __('user_messages.please_select_a_color') }}";
            return;
        }
        if (!selectedSize) {
            errorBox.style.display = "block";
            errorBox.innerHTML = "{{ __('user_messages.please_select_a_size') }}";
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
            sendToCart(0);
            return;
        }

        qty -= 1;

        setQty(qty);
        sendToCart(qty);
    });

    // ------------------------------
    // BUY NOW CLICK
    // ------------------------------
    const buyNowBtn = document.getElementById("buyNowBtn");

    buyNowBtn.addEventListener("click", function() {
        const selectedColor = document.querySelector(".choose-color.active");
        const selectedSize = document.querySelector(".size-btn.active");

        errorBox.style.display = "none";
        errorBox.innerHTML = "";

        if (!selectedColor) {
            errorBox.style.display = "block";
            errorBox.innerHTML = "{{ __('user_messages.please_select_a_color') }}";
            return;
        }

        if (!selectedSize) {
            errorBox.style.display = "block";
            errorBox.innerHTML = "{{ __('user_messages.please_select_a_size') }}";
            return;
        }

        const variantId = selectedSize.dataset.variantId;
        const productId = selectedSize.dataset.productId;

        let referenceLink = null;
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('ref')) {
            referenceLink = window.location.href;
            console.log(referenceLink);
        }

        // ✅ If already in cart → go to cart
        if (cartData[variantId]) {
            window.location.href = "{{ route('user.view_cart') }}";
            return;
        }

        // Not in cart → add then redirect
        fetch("{{ route('user.addToCart') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    variant_id: variantId,
                    quantity: 1,
                    reference_link: referenceLink
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === "error") {
                    toastr.error(data.message);
                } else {
                    toastr.success(data.message);

                    setTimeout(() => {
                        window.location.href = "{{ route('user.view_cart') }}";
                    }, 800);
                }
            })
            .catch(() => {
                toastr.error("Something went wrong.");
            });
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
            sizeChartBody.innerHTML =
                `<img src="${sizeChartImage}" class="img-fluid" alt="Size Chart" style="max-width: 100%; height: 400px; object-fit: contain;">`;
        } else {
            sizeChartBody.innerHTML = `<p class="text-center">{{ __('user_messages.no_size_chart_available') }}</p>`;
        }
    });

    // Clear modal content on close to avoid duplicates
    const sizeChartModal = document.getElementById("sizechart");
    sizeChartModal.addEventListener("hidden.bs.modal", function() {
        sizeChartBody.innerHTML = "";
    });

});


// get Active size Button Value

// Get the active button
function AddAndBuyButtonHideAndShowCode() {

    const activeColor = document.querySelector('.color-box.active');
    const activeBtn = document.querySelector('.size-btn.active');

    if (activeBtn) {
        // Access data attributes
        const size = activeBtn.getAttribute('data-size');
        const stock = activeBtn.getAttribute('data-stock-id');
        console.log("Active size:", size, "Stock:", stock);


        // // Active Color Code Set Data In LocalStorage 
        const ColorCode = activeColor.getAttribute('data-color');

        const Singleactiveproduct = {
            ColorCode: ColorCode,
            SizeCode: size,
        };

        localStorage.setItem('activeSingleProduct', JSON.stringify(Singleactiveproduct));

        // Active Color Code Set Data In LocalStorage  Codeend Here 


        if (stock <= 0) {

            $('.addToBagBtnRemove').hide();
            $('#buyNowBtn').hide();
        } else {
            // $('.addToBagBtnRemove').show();
            $('#buyNowBtn').show();

        }

        // ActiveButtonofLocalStorage();



    } else {
        console.log("No size selected yet");
    }

}
</script>

<!-- custom order -->
 <script>
document.addEventListener('DOMContentLoaded', function() {

    const customBtn = document.getElementById('customOrder');
    const productId = document.getElementById('productId');
    const variantId = document.getElementById('variantId');
    const optionError = document.getElementById('optionError');

    customBtn.addEventListener('click', function(e) {
        e.preventDefault();

        optionError.style.display = 'none';

        const product_id = productId.value;
        const variant_id = variantId.value;

        //  Validation
        if (!product_id || !variant_id) {
            optionError.textContent = "{{ __('user_messages.please_select_product_and_variant') }}";
            optionError.style.display = 'block';
            return;
        }

        fetch("{{ route('user.createCustomOrder') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                product_id: product_id,
                variation_id: variant_id
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                const unique_id = res.data.data.unique_id;
                window.location.href = "{{ route('user.userChat', '') }}/" + unique_id;
            } else {
                optionError.textContent = res.message || 'Failed to create custom order';
                optionError.style.display = 'block';
            }
        })
        .catch(err => {
            optionError.textContent = 'Something went wrong';
            optionError.style.display = 'block';
            console.error(err);
        });
    });

});
</script>

<script>
document.addEventListener('click', function (e) {

    var shareBtn = e.target.closest('.share-btn.product');

    if (shareBtn) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        var link = shareBtn.getAttribute('data-link');

        if (!link) {
            console.error('Share link not found');
            return;
        }

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(link).then(function () {
                toastr.success("{{ __('user_messages.link_copied_to_clipboard') }}");
            }).catch(function () {
                fallbackCopy(link);
            });
        } else {
            fallbackCopy(link);
        }

        return false;
    }

}, true);

function fallbackCopy(text) {
    var temp = document.createElement("textarea");
    temp.value = text;
    document.body.appendChild(temp);
    temp.select();
    document.execCommand("copy");
    document.body.removeChild(temp);

    toastr.success("{{ __('user_messages.link_copied_to_clipboard') }}");
}
</script>



@endsection
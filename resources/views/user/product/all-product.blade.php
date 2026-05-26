@extends('user.layout.app')

@section('content')

@php
    $currency = session('currency', 'KWD');

@endphp

<div class="product_reels customContainer">

    <!-- <h1>All products</h1> -->

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
            tabindex="0">
            <div class="categoryDetail customContainer">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="category_filter pb-3 mb-3 d-flex align-items-center justify-content-between">
                            <h3 style="color: var(--secondry2-color);">{{ __('user_messages.sort_by') }}</h3>
                            <a data-bs-toggle="modal" data-bs-target="#sortMOdal">
                                <img src="{{asset('user')}}/assets/images/sort.svg" class="img-fluid" />
                            </a>
                        </div>
                        <div class="category_filter">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3>{{ __('user_messages.filters') }}</h3>
                                <a href="{{ url('user/all-product/') }}">{{ __('user_messages.clear') }}</a>
                            </div>
                            <form action="{{ url('user/all-product/') }}" method="GET">
                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.category') }}</h5>
                                    @foreach ($category as $key => $item)
                                    <div class="form-check my-4">
                                        <input class="form-check-input mb-1" type="radio" name="category_id[]"
                                            value="{{ $item->id }}" id="category_{{ $key }}"
                                            {{ is_array(request()->category_id) && in_array($item->id, request()->category_id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="category_{{ $key }}">
                                            @if(app()->getLocale() == 'en')
                                            {{ $item->name }}
                                            @else
                                            {{ $item->name_ar }}
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.brand') }}</h5>
                                    <small>{{ __('user_messages.a_z') }}</small>
                                    @foreach ($brand as $key => $item)
                                    <div class="form-check my-4 brand-item {{ $key >= 8 ? 'd-none extra-brand' : '' }}">
                                        <input class="form-check-input mb-1" type="checkbox" name="brand_id[]"
                                            value="{{ $item->id }}" id="brand_{{ $key }}"
                                            {{ is_array(request()->brand_id) && in_array($item->id, request()->brand_id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="brand_{{ $key }}">
                                            @if(app()->getLocale() == 'en')
                                            {{ $item->name_english }}
                                            @else
                                            {{ $item->name_arabic }}
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                    @if(count($brand) > 8)
                                    <button id="seeMoreBtn" type="button" class="btn btn-link p-0"
                                        style="font-size:14px; color:var(--third-color);font-weight: 500;">
                                        {{ __('user_messages.see_more') }}
                                    </button>
                                    @endif
                                </div>
                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.price') }}</h5>
                                    <div class="slider-wrap" id="priceArea">
                                        <div class="track">
                                            <div class="left-dot"></div>
                                            <div class="track-line"></div>

                                            <div class="active-indicator" id="indicator"></div>

                                            <div class="value-bubble" id="valueBubble">100000 {{ __('user_messages.kd') }}</div>

                                            <input type="range" min="99" max="100000"
                                                value="{{ request()->price_max ?? 50000 }}" id="priceRange"
                                                style="width:100%;">
                                            <input type="hidden" name="price_min" id="priceMin"
                                                value="{{ request()->price_min ?? 99 }}">
                                            <input type="hidden" name="price_max" id="priceMax"
                                                value="{{ request()->price_max ?? 50000 }}">
                                        </div>

                                        <div class="ticks">
                                            <div class="tick text-start">99 {{ __('user_messages.kd') }}</div>
                                            <div class="tick text-end">100000 {{ __('user_messages.kd') }}</div>
                                        </div>
                                    </div>
                                </div>


                                {{-- Color --}}
                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.color') }}</h5>

                                    @foreach ($color as $key => $item)
                                    <div
                                        class="form-check my-4 color-item {{ $key >= 10 ? 'd-none extra-color' : '' }}">
                                        <input class="form-check-input" type="checkbox" name="color_id[]"
                                            value="{{ $item->id }}" id="color{{ $item->id }}"
                                            {{ is_array(request()->color_id) && in_array($item->id, request()->color_id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="color{{ $item->id }}">
                                            @if(app()->getLocale() == 'en')
                                            {{ $item->name }}
                                            @else
                                            {{ $item->name_ar }}
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach

                                    @if(count($color) > 10)
                                    <button type="button" id="toggleColors" class="btn btn-sm btn-link p-0 mt-2">
                                        {{ __('user_messages.see_more') }}
                                    </button>
                                    @endif
                                </div>

                                {{-- Discount Range --}}
                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.discount_range') }}</h5>
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="discount" value="10"
                                            id="discount10" {{ request()->discount == 10 ? 'checked' : '' }}>

                                        <label class="form-check-label" for="discount10">
                                            10%
                                        </label>
                                    </div>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="discount" value="20"
                                            id="discount20" {{ request()->discount == 20 ? 'checked' : '' }}>

                                        <label class="form-check-label" for="discount20">
                                            20%
                                        </label>
                                    </div>
                                </div>

                                {{-- Sizes --}}
                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.sizes') }}</h5>
                                    @foreach ($size as $key => $item)
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" name="size_id[]"
                                            value="{{ $item->id }}" id="size_{{ $key }}"
                                            {{ is_array(request()->size_id) && in_array($item->id, request()->size_id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="size_{{ $key }}">
                                            @if(app()->getLocale() == 'en')
                                            {{ $item->name }}
                                            @else
                                            {{ $item->name_ar }}
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>


                                {{-- Ratings --}}
                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.ratings') }}</h5>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="rating" value="2"
                                            id="rating2" {{ request()->rating == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rating2">
                                            {{ __('user_messages.upto_2_star') }}
                                        </label>
                                    </div>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="rating" value="3"
                                            id="rating3" {{ request()->rating == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rating3">
                                            {{ __('user_messages.upto_3_star') }}
                                        </label>
                                    </div>
                                </div>

                                {{-- Delivery Time --}}
                                <div class="form-group mt-4">
                                    <h5>{{ __('user_messages.delivery_time') }}</h5>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="delivery_time" value="1"
                                            id="del1" {{ request()->delivery_time == '1' ? 'checked' : '' }}>

                                        <label class="form-check-label" for="del1">
                                            {{ __('user_messages.today_2_days') }}
                                        </label>
                                    </div>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="delivery_time" value="2"
                                            id="del2" {{ request()->delivery_time == '2' ? 'checked' : '' }}>

                                        <label class="form-check-label" for="del2">
                                            {{ __('user_messages.3_5_days') }}
                                        </label>
                                    </div>
                                </div>

                                {{-- Delivery Options --}}
                                <div class="form-group delivery">
                                    <h5>{{ __('user_messages.sort_preference') }}</h5>
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            name="delivery_option[]" id="shortest"
                                            {{ is_array(request()->delivery_option) && in_array('1', request()->delivery_option) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="shortest">
                                            {{ __('user_messages.shortest_delivery_time') }}
                                        </label>
                                    </div>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" value="2"
                                            name="delivery_option[]" id="highest_sale"
                                            {{ is_array(request()->delivery_option) && in_array('2', request()->delivery_option) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="highest_sale">
                                            {{ __('user_messages.highest_sale') }}
                                        </label>
                                    </div>
                                </div>

                                <button class="customBtn customBtn5 mt-5">{{ __('user_messages.apply') }}</button>

                            </form>


                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="categoryDetail_content">
                            <div class="row">

                                @forelse ($AllProduct as $item)
                                <div class="col-lg-4 col-md-4 col-6 my-3 cardblock">
                                    <a href="{{ route('user.product_details',[$item->id]) }}"
                                        style="text-decoration:none;">
                                        <div class="product-card">
                                            <div class="product-img">
                                                @foreach ($item->product_variants[0]->variant_image as $key => $val)
                                                @if ($key != 0)
                                                @php break @endphp
                                                @endif
                                                <img src="{{ $val }}" alt="Product">
                                                @endforeach

                                                @if (Auth::guard('web')->user())
                                                <span class="wishlist-btn" style="cursor: pointer"><i
                                                        id="wishlistProduct{{ $item->id }}"
                                                        class="fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                                                        onclick="addWishListFunctionproduct({{ $item->id }})"></i></span>
                                                @else
                                                <a class="wishlist-btn text-decoration-underline"
                                                    href="{{route('userLogin')}}">
                                                    <i class="fa-regular fa-heart"></i>
                                                </a>
                                                @endif

                                            </div>

                                            <div class="product-content">
                                                <h5 class="black-title">
                                                    @if(app()->getLocale() == 'en')
                                                    {{ $item->product_name_en }}
                                                    @else
                                                    {{ $item->product_name_ar }}
                                                    @endif

                                                    ({{ "by " . @$store_details['store']['store_name'] }})
                                                </h5>
                                                <div class="rating">
                                                    @php
                                                        $rating = $item->average_rating ?? 0;
                                                        $fullStars = floor($rating);
                                                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                                    @endphp

                                                    @if($rating > 0)

                                                        @for($i = 0; $i < $fullStars; $i++)
                                                            <i class="fa-solid fa-star"></i>
                                                        @endfor

                                                        @if($hasHalfStar)
                                                            <i class="fa-solid fa-star-half-stroke"></i>
                                                        @endif

                                                        @for($i = 0; $i < $emptyStars; $i++)
                                                            <i class="fa-regular fa-star"></i>
                                                        @endfor

                                                    @else

                                                        @for($i = 0; $i < 5; $i++)
                                                            <i class="fa-regular fa-star"></i>
                                                        @endfor

                                                    @endif

                                                    <span>({{ $item->review->count() ?? 0 }})</span>
                                                </div>

                                                 <div class="price">
                                                    <strong>
                                                    {{ $currency }} {{ number_format(convertPriceInUserWeb($item->product_variants[0]->final_price), 2) }}
                                                    </strong>

                                                    <span class="old-price">
                                                    {{ $currency }} {{ number_format(convertPriceInUserWeb($item->product_variants[0]->actual_price), 2) }}
                                                    </span>

                                                    <span class="discount">
                                                    {{ $item->product_variants[0]->discount_value }}
                                                    {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}
                                                    </span>
                                                </div>




                                                <!-- <div class="price">
                                                    <strong>{{ $item->product_variants[0]->final_price }}
                                                        KD</strong>

                                                    @if($item->product_variants[0]->discount_value!=="0")
                                                    <div class="d-block">
                                                        <span
                                                            class="old-price">{{ $item->product_variants[0]->actual_price }}
                                                            KD</span>
                                                        <span class="discount">

                                                            {{ $item->product_variants[0]->discount_value }}
                                                            {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}

                                                        </span>
                                                    </div>

                                                    @endif

                                                </div> -->



                                            </div>

                                        </div>
                                    </a>
                                </div>
                                @empty

                            <h2>
                                <center>{{__('user_messages.no_data_found')}} </center>
                            </h2>
                        @endforelse



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
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/m1.jpg" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/m2.png" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/m3.jpg" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/m4.png" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{ asset('user/') }}/assets/images/product.svg" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<form action="{{ url('user/store-details/' . request()->id) }}" method="GET">
    <div class="modal fade" id="sortMOdal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header border-0">
                    <h3 class="modal-title fs-5">Sort By</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort1" value="1"
                                {{ request('sort_filter') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort1">Recommended</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort2" value="2"
                                {{ request('sort_filter') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort2">Price: Low to High</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort3" value="3"
                                {{ request('sort_filter') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort3">Price: High to Low</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort4" value="4"
                                {{ request('sort_filter') == 4 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort4">Newest First</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort5" value="5"
                                {{ request('sort_filter') == 5 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort5">Customer Ratings</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort6" value="6"
                                {{ request('sort_filter') == 6 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort6">Best Selling</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort7" value="7"
                                {{ request('sort_filter') == 7 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort7">Fastest Delivery</label>
                        </div>

                    </div>

                    <div class="d-flex align-items-center gap-3 mt-3">
                        <a href="" id="clearSort" class="custom-btn6 text-center w-100 text-white"
                            style="    text-decoration: auto;">Clear</a>
                        <button type="submit" class="custom-btn6" style="padding:8px 10px; color:#fff !important;">
                            Apply
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</form>



<script>
var images = [
    "{{asset('user')}}/assets/images/store1.jpg",
    "{{asset('user')}}/assets/images/item-1.svg",
    "{{asset('user')}}/assets/images/item-2.svg",
    "{{asset('user')}}/assets/images/store1.jpg",
    "{{asset('user')}}/assets/images/store1.jpg",
    "{{asset('user')}}/assets/images/store1.jpg"
];

var currentIndex = 0;
var timer = null;
var duration = 3000; // 3 sec like WhatsApp

function openGallery(index) {
    currentIndex = index;
    document.getElementById("statusViewer").style.display = "flex";

    generateProgressBars();
    showImage();
}

function generateProgressBars() {
    const container = document.getElementById("progressContainer");
    container.innerHTML = "";

    images.forEach((img, i) => {
        container.innerHTML += `
                    <div class="progress-bar">
                        <div class="progress-fill" id="bar${i}"></div>
                    </div>
                `;
    });
}

function showImage() {
    document.getElementById("statusImage").src = images[currentIndex];
    startProgress();
}

function startProgress() {
    clearTimeout(timer);

    // Reset all bars
    document.querySelectorAll(".progress-fill").forEach(bar => {
        bar.style.width = "0%";
        bar.style.transition = "none";
    });

    // Small delay so restart animation properly
    setTimeout(() => {
        let bar = document.getElementById("bar" + currentIndex);
        bar.style.transition = `${duration}ms linear`;
        bar.style.width = "100%";
    }, 10);

    timer = setTimeout(() => {
        showNext();
    }, duration);
}

function showNext() {
    if (currentIndex < images.length - 1) {
        currentIndex++;
        showImage();
    } else {
        closeStatus(); // Close after last image like WhatsApp
    }
}

function showPrev() {
    if (currentIndex > 0) {
        currentIndex--;
        showImage();
    }
}

function closeStatus() {
    clearTimeout(timer);
    document.getElementById("statusViewer").style.display = "none";
}
</script>

<script>
(function() {
    const range = document.getElementById('priceRange');
    const indicator = document.getElementById('indicator');
    const bubble = document.getElementById('valueBubble');
    const trackLine = document.querySelector('.track-line');
    const wrap = document.querySelector('.track');

    function updateVisuals() {
        let min = +range.min;
        let max = +range.max;
        let val = +range.value;

        // Update bubble text
        bubble.textContent = val + " KD";

        // Slider position percentage
        const percent = ((val - min) / (max - min)) * 100;

        // Move indicator circle
        const lineRect = trackLine.getBoundingClientRect();
        const wrapperRect = wrap.getBoundingClientRect();

        const pos = lineRect.left + (percent / 100) * lineRect.width + window.scrollX;
        const leftRel = pos - wrapperRect.left - (indicator.offsetWidth / 2);

        indicator.style.left = leftRel + "px";

        // Move bubble above the thumb
        const thumbX = pos - wrapperRect.left;
        bubble.style.left = thumbX + "px";

        // Dynamic fill color
        range.style.background = `
                    linear-gradient(to right, 
                    #b68560 0%, 
                    #b68560 ${percent}%, 
                    #e9d2b7 ${percent}%, 
                    #e9d2b7 100%)
                `;
    }

    range.addEventListener("input", updateVisuals);
    window.addEventListener("resize", updateVisuals);

    updateVisuals(); // initialize
})();


document.getElementById('seeMoreBtn')?.addEventListener('click', function() {
    const extras = document.querySelectorAll('.extra-brand');

    const hidden = [...extras].some(e => e.classList.contains('d-none'));

    extras.forEach(e => e.classList.toggle('d-none'));

    this.textContent = hidden ? 'See Less' : 'See More';
});

document.getElementById('toggleColors')?.addEventListener('click', function() {
    const extraColors = document.querySelectorAll('.extra-color');
    const isHidden = extraColors[0].classList.contains('d-none');

    extraColors.forEach(item => {
        item.classList.toggle('d-none');
    });

    this.textContent = isHidden ? "See Less" : "See More";
});
</script>

<script>
const slider = document.getElementById('priceRange');
const priceMinInput = document.getElementById('priceMin');
const priceMaxInput = document.getElementById('priceMax');
const valueBubble = document.getElementById('valueBubble');

slider.addEventListener('input', function() {
    const value = this.value;
    valueBubble.innerText = value + ' KD';
    // Update the hidden input
    priceMaxInput.value = value;
});
</script>

<script>
window.onpageshow = function(event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        window.location.reload();
    }
};
</script>

@endsection
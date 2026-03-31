@extends('user.layout.app')

@section('content')
<div class="customContainer">
    <div>
        <div>
            <img src="{{ $store_details['store']['store_image'] }}" class="store-banner-img" />
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
                            <img src="{{ $store_details['store']['store_image'] }}" class="img-fluid" style="cursor:pointer" onclick="openSellerGallery(0)" />
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
                            <p> {{$store_details['store']->seller_information->first_name}}
                                {{$store_details['store']->seller_information->last_name}}</p>
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
                        <img src="https://cdn-icons-png.flaticon.com/512/1828/1828817.png" alt="Copy" class="copy-icon">

                        <!-- {!! QrCode::size(110)->generate($qrSellerCode) !!} -->

                        <img src="{{$store_details['store']->seller_information->profile_qr}}" class="" width="100px">


                    </div>

                    <p id="copiedMsg">{{$store_details['store']->seller_information->qrSellerUrl}}</p>
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
                    <!-- <div class="item">
                        <div class="suggestStore_content">
                            <div class="suggestedStore_img">
                                <img src="{{ asset('user/') }}/assets/images/store1.jpg" class="img-fluid" />
                            </div>
                            <p>Kurtas</p>
                        </div>
                    </div> -->
                    @forelse($seller_highlights as $highlight)
                        <div class="item">
                            <div class="suggestStore_content"
                                onclick='openHighlightGallery(@json($seller_highlights), {{ $loop->index }})'>

                                <div class="suggestedStore_img" onclick="highlightGallery(0)">
                                    <img src="{{ $highlight->file }}" class="img-fluid" />
                                </div>

                                <p>{{ $highlight->title ?? 'Highlight' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="item text-center">
                            <p>No highlights</p>
                        </div>
                    @endforelse
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
                        <div class="category_filter pb-3 mb-3 d-flex align-items-center justify-content-between">
                            <h3 style="color: var(--secondry2-color);">Sort By</h3>
                            <a data-bs-toggle="modal" data-bs-target="#sortMOdal">
                                <img src="{{asset('user')}}/assets/images/sort.svg" class="img-fluid" />
                            </a>
                        </div>
                        <div class="category_filter">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3>Filters</h3>
                                <a href="{{route('user.store_details',[request()->id])}}">Clear</a>
                            </div>
                            <form action="{{ url('user/store-details/' . request()->id) }}" method="GET">
                                <div class="form-group mt-4">
                                    <h5>Category</h5>
                                    @foreach ($category as $key => $item)
                                    <div class="form-check my-4">
                                        <input class="form-check-input mb-1" type="radio" name="category_id[]"
                                            value="{{ $item->id }}" id="category_{{ $key }}"
                                            {{ is_array(request()->category_id) && in_array($item->id, request()->category_id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="category_{{ $key }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group mt-4">
                                    <h5>Brand</h5>
                                    <small>A-z</small>
                                    @foreach ($brand as $key => $item)
                                    <div class="form-check my-4 brand-item {{ $key >= 8 ? 'd-none extra-brand' : '' }}">
                                        <input class="form-check-input mb-1" type="checkbox" name="brand_id[]"
                                            value="{{ $item->id }}" id="brand_{{ $key }}"
                                            {{ is_array(request()->brand_id) && in_array($item->id, request()->brand_id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="brand_{{ $key }}">
                                            {{ $item->name_english }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @if(count($brand) > 8)
                                    <button id="seeMoreBtn" type="button" class="btn btn-link p-0"
                                        style="font-size:14px; color:var(--third-color);font-weight: 500;">
                                        See More
                                    </button>
                                    @endif
                                </div>
                                <div class="form-group mt-4">
                                    <h5>Price</h5>
                                    <div class="slider-wrap" id="priceArea">
                                        <div class="track">
                                            <div class="left-dot"></div>
                                            <div class="track-line"></div>

                                            <div class="active-indicator" id="indicator"></div>

                                            <div class="value-bubble" id="valueBubble">100000 KD</div>

                                            <input type="range" min="99" max="100000"
                                                value="{{ request()->price_max ?? 50000 }}" id="priceRange"
                                                style="width:100%;">
                                            <input type="hidden" name="price_min" id="priceMin"
                                                value="{{ request()->price_min ?? 99 }}">
                                            <input type="hidden" name="price_max" id="priceMax"
                                                value="{{ request()->price_max ?? 50000 }}">
                                        </div>

                                        <div class="ticks">
                                            <div class="tick text-start">99 KD</div>
                                            <div class="tick text-end">100000 KD</div>
                                        </div>
                                    </div>
                                </div>


                                {{-- Color --}}
                                <div class="form-group mt-4">
                                    <h5>Color</h5>

                                    @foreach ($color as $key => $item)
                                    <div
                                        class="form-check my-4 color-item {{ $key >= 10 ? 'd-none extra-color' : '' }}">
                                        <input class="form-check-input" type="checkbox" name="color_id[]"
                                            value="{{ $item->id }}" id="color{{ $item->id }}"
                                            {{ request()->color_id == $item->id ? 'checked' : '' }}>

                                        <label class="form-check-label" for="color{{ $item->id }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                    @endforeach

                                    @if(count($color) > 10)
                                    <button type="button" id="toggleColors" class="btn btn-sm btn-link p-0 mt-2">
                                        See More
                                    </button>
                                    @endif
                                </div>

                                {{-- Discount Range --}}
                                <div class="form-group mt-4">
                                    <h5>Discount Range</h5>
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
                                    <h5>Sizes</h5>
                                    @foreach ($size as $key => $item)
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" name="size_id[]"
                                            value="{{ $item->id }}" id="size_{{ $key }}"
                                            {{ is_array(request()->size_id) && in_array($item->id, request()->size_id) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="size_{{ $key }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>


                                {{-- Ratings --}}
                                <div class="form-group mt-4">
                                    <h5>Ratings</h5>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="rating" value="2"
                                            id="rating2" {{ request()->rating == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rating2">
                                            Upto 2 Star
                                        </label>
                                    </div>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="rating" value="3"
                                            id="rating3" {{ request()->rating == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rating3">
                                            Upto 3 Star
                                        </label>
                                    </div>
                                </div>

                                {{-- Delivery Time --}}
                                <div class="form-group mt-4">
                                    <h5>Delivery Time</h5>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="delivery_time" value="1-2"
                                            id="del1" {{ request()->delivery_time == '1-2' ? 'checked' : '' }}>

                                        <label class="form-check-label" for="del1">
                                            Today - 2 days
                                        </label>
                                    </div>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="radio" name="delivery_time" value="3-5"
                                            id="del2" {{ request()->delivery_time == '3-5' ? 'checked' : '' }}>

                                        <label class="form-check-label" for="del2">
                                            3 - 5 days
                                        </label>
                                    </div>
                                </div>

                                {{-- Delivery Options --}}
                                <div class="form-group delivery">
                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" value="shortest"
                                            name="delivery_option[]" id="shortest"
                                            {{ is_array(request()->delivery_option) && in_array('shortest', request()->delivery_option) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="shortest">
                                            Shortest Delivery time
                                        </label>
                                    </div>

                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" value="highest_sale"
                                            name="delivery_option[]" id="highest_sale"
                                            {{ is_array(request()->delivery_option) && in_array('highest_sale', request()->delivery_option) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="highest_sale">
                                            Highest Sale
                                        </label>
                                    </div>
                                </div>

                                <button class="customBtn customBtn5 mt-5">Apply</button>

                            </form>


                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="categoryDetail_content">
                            <div class="row">

                                @foreach ($store_details['All_Product'] as $item)
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
                                                <h5 class="black-title">{{ $item->product_name_en }}
                                                    ({{ "by " . $store_details['store']['store_name'] }})</h5>
                                                <div class="rating">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                    <span>(1K)</span>
                                                </div>
                                                <div class="price">
                                                    <strong>{{ $item->product_variants[0]->final_price }}
                                                        KD</strong>
                                                    <div class="d-block">
                                                        <span
                                                            class="old-price">{{ $item->product_variants[0]->actual_price }}
                                                            KD</span>
                                                        <span class="discount">

                                                            {{ $item->product_variants[0]->discount_value }}
                                                            {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}

                                                        </span>
                                                    </div>
                                                </div>



                                            </div>

                                        </div>
                                    </a>
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
                    @forelse($seller_reels as $reel)
                    <div class="col-lg-3 col-md-3 col-12 my-3">
                        <div class="product-img">
                            <img src="{{$reel->file}}" alt="Product">
                            <button class="wishlist-btn">
                                <img src="{{asset('user/assets/images/reels_check.svg')}}" class="img-fluid"
                                    alt="check" />
                            </button>
                        </div>
                    </div>
                    @empty
                        <div class="item text-center">
                            <p>No highlights</p>
                        </div>
                    @endforelse
 
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
                        <a href="{{route('user.store_details',[request()->id])}}" id="clearSort"
                            class="custom-btn6 text-center w-100 text-white"
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
<input type="hidden" name="seller_id" id="seller_id" value="{{ $store_details['store']['seller_id'] }}" />
<a href="javascript:void(0)" class="fixedchat">
    <img src="{{ asset('user/') }}/assets/images/chat-ic.svg" alt="chat icon" class="img-fluid" />
</a>

  <!-- Seller logo story section -->
<div class="status-viewer bgwhite" id="statusSeller">
    <div class="container adminstatus">
        <div class="story-header d-flex justify-content-between">
            <div></div>
            <button type="button" class="btn btn-light" onclick="closeSellerStatus()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="logostatus">
            <div id="progressContainerSeller" class="progress-container"></div>
            
            <div class="status-img">
                <img id="statusImageSeller" class="img-fluid" style="display:none;" />
                
                <video id="statusVideoSeller"
                       style="width:100%; height:100%; object-fit:contain; display:none;"
                       controls autoplay muted>
                </video>
            </div>
        </div>    
    </div>
</div>

<!-- Highlight Story Viewer -->
<div class="status-viewer" id="statusHighlight" style="display:none;">

    <div class="progress-container" id="progressContainerHighlight"></div>

    <div class="status-img">
        <img id="statusImageHighlight" style="display:none;" />
        <video id="statusVideoHighlight" style="display:none;" autoplay muted></video>
    </div>

    <button onclick="closeHighlight()">Close</button>
</div>


<!-- New Highlight Story Viewer -->

<div class="status-viewer bgwhite" id="heighlightSeller">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <h3></h3>
            <button type="button" class="btn btn-light" onclick="closeheighStatus()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <div id="progressContainer" class="progress-container"></div>
            <div class="status-img">
                <img id="statusImage" class="img-fluid" alt="status" />
            </div>
        </div>    
    </div>
</div>

<!-- New reel  Viewer -->

<div class="status-viewer bgwhite" id="newreels">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <h3></h3>
            <button type="button" class="btn btn-light" onclick="closeheighStatus()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <div class="status-img">
                <img id="statusImage" class="img-fluid" alt="status" />
            </div>
        </div>    
    </div>
</div>


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

<script>
document.addEventListener("DOMContentLoaded", function() {

    const chatBtn = document.querySelector('.fixedchat');
    const sellerId = document.querySelector('input[name="seller_id"]').value;

    if (chatBtn) {
        chatBtn.addEventListener('click', function() {

            fetch("{{ route('user.create_normal_chat') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        seller_id: sellerId
                    })
                })
                .then(res => res.json())
                .then(res => {

                    if (res.status === 'success') {

                        const uniqueId = res.data.data.unique_id;

                        let chatUrl = "{{ route('user.userChat', ':id') }}";
                        chatUrl = chatUrl.replace(':id', uniqueId);

                        window.location.href = chatUrl;
                    }

                })
                .catch(err => console.error('Chat creation failed', err));
        });
    }

});
</script>

<!-- copy Seller profile Link -->
<script>
document.getElementById("copyLinkBtn").addEventListener("click", function() {
    const text = document.getElementById("copiedMsg").innerText;

    navigator.clipboard.writeText(text).then(function() {
        // alert("Link copied!");
        toastr.success('Link copied');
    }).catch(function(err) {
        console.error("Failed to copy: ", err);
    });
});
</script>

<script>

var sellerStories = null;  
var sellerIndex = 0;
var sellerTimer = null;
var sellerDuration = 3000;
var sellerLoading = false;    // prevent multiple API calls

// ================= CLICK HANDLER =================
function openSellerGallery(index = 0) {
    console.log("[SELLER] Clicked");

    // Prevent multiple clicks while loading
    if (sellerLoading) {
        //console.log("[SELLER] Already loading...");
        return;
    }

    // If not loaded → fetch from API
    if (sellerStories === null) {
        loadSellerStories(index);
    } 
    // If already loaded and has stories → open gallery
    else if (sellerStories.length > 0) {
        showSellerGallery(index);
    } 
    // If loaded but empty → do nothing
    else {
        //console.log("[SELLER] No stories → do nothing");
    }
}

// ================= LOAD STORIES FROM API =================
function loadSellerStories(openIndex = 0) {

    sellerLoading = true;

    // Get seller_id from hidden input
    var sellerInput = document.getElementById("seller_id");

    if (!sellerInput) {
        //console.error("[SELLER] seller_id input not found!");
        sellerLoading = false;
        return;
    }

    var seller_id = sellerInput.value;
    //console.log("[SELLER] seller_id:", seller_id);

    $.ajax({
        url: "{{ route('user.get_seller_story') }}",
        type: "GET",
        dataType: "json",

        data: {
            seller_id: seller_id
        },

        success: function(res) {
            sellerLoading = false;

           // console.log("[SELLER] API RESPONSE:", res);

            if (res.status === "success" && Array.isArray(res.data.data)) {
                sellerStories = res.data.data;
            } else {
                sellerStories = [];
            }

            // If stories exist → open gallery
            if (sellerStories.length > 0) {
                showSellerGallery(openIndex);
            } else {
                //console.log("[SELLER] No stories found → do nothing");
            }
        },

        error: function(err) {
            sellerLoading = false;
            console.error("[SELLER] AJAX ERROR:", err);
            sellerStories = [];
        }
    });
}

function showSellerGallery(index) {
    //console.log('123');

    sellerIndex = index;

    var container = document.getElementById("statusSeller");
    if (!container) {
        console.error("[SELLER] statusSeller not found");
        return;
    }

    container.style.display = "block";

    generateSellerProgressBars();
    showSellerStory();
}


function generateSellerProgressBars() {

    var container = document.getElementById("progressContainerSeller");

    if (!container) {
       // console.error("[SELLER] progressContainerSeller not found");
        return;
    }

    container.innerHTML = "";

    sellerStories.forEach((s, i) => {
        container.innerHTML += `
            <div class="progress-bar">
                <div class="progress-fill" id="sellerBar${i}"></div>
            </div>
        `;
    });
}

function showSellerStory() {

    var story = sellerStories[sellerIndex];

    //console.log("[SELLER] showStory index:", sellerIndex, story);

    if (!story) {
        closeSellerStatus();
        return;
    }

    var img = document.getElementById("statusImageSeller");
    var video = document.getElementById("statusVideoSeller");

    if (!img || !video) {
        //console.error("[SELLER] Image or Video element missing");
        return;
    }

    // Reset
    img.style.display = "none";
    video.style.display = "none";
    video.pause();
    video.currentTime = 0;

    var file = story.file;

    if (!file) {
        //console.warn("[SELLER] Empty file → skipping");
        showNextSeller();
        return;
    }

    //console.log("[SELLER] FILE:", file);

    if (file.match(/\.(mp4|webm|ogg)$/i)) {

        video.src = file;
        video.style.display = "block";
        video.controls = true;

        video.onloadedmetadata = function () {
            sellerDuration = (video.duration * 1000) || 3000;
            startSellerProgress();
            video.play().catch(e => console.warn("[SELLER] Play blocked:", e));
        };

        video.onerror = function () {
            console.error("[SELLER] Video failed → skipping");
            showNextSeller();
        };

    } 
    else {

        img.src = file;
        img.style.display = "block";

        sellerDuration = 3000;
        startSellerProgress();
    }
}


function startSellerProgress() {

    clearTimeout(sellerTimer);

    document.querySelectorAll("#progressContainerSeller .progress-fill")
        .forEach(bar => {
            bar.style.width = "0%";
            bar.style.transition = "none";
        });

    setTimeout(() => {
        var bar = document.getElementById("sellerBar" + sellerIndex);

        if (bar) {
            bar.style.transition = sellerDuration + "ms linear";
            bar.style.width = "100%";
        }
    }, 10);

    sellerTimer = setTimeout(() => {
        showNextSeller();
    }, sellerDuration);
}


function showNextSeller() {

    if (sellerIndex < sellerStories.length - 1) {
        sellerIndex++;
        showSellerStory();
    } else {
        closeSellerStatus();
    }
}


function showPrevSeller() {

    if (sellerIndex > 0) {
        sellerIndex--;
        showSellerStory();
    }
}

function closeSellerStatus() {

    clearTimeout(sellerTimer);

    var video = document.getElementById("statusVideoSeller");

    if (video) {
        video.pause();
        video.currentTime = 0;
    }

    var container = document.getElementById("statusSeller");

    if (container) {
        container.style.display = "none";
    }
}

</script>


<script>
    // New Highlight Story Viewer

    var images = [
        "{{asset('user')}}/assets/images/store1.jpg",
        "{{asset('user')}}/assets/images/item-1.svg",
        "{{asset('user')}}/assets/images/item-2.svg",
    ];

    var currentIndex = 0;
    var timer = null;
    var duration = 3000;

    function highlightGallery(index) {
        currentIndex = index;
        document.getElementById("heighlightSeller").style.display = "block";
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
            closeheighStatus(); 
        }
    }

    function showPrev() {
        if (currentIndex > 0) {
            currentIndex--;
            showImage();
        }
    }

    function closeheighStatus() {
        clearTimeout(timer);
        document.getElementById("heighlightSeller").style.display = "none";
    }

</script>



@endsection
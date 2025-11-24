@extends('user.layout.app')

@section('content')
    <div class="customContainer">
        <div class="">
            <div class="">
                <img src="{{ asset('user/assets/images/image-sg.svg') }}" class="img-fluid" />
            </div>
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
                            <div class="category_filter pb-3 mb-3 d-flex align-items-center justify-content-between">
                                <h3>Sort By</h3>
                                <span>
                                    <img src="{{asset('user')}}/assets/images/sort.svg" class="img-fluid" />
                                </span>
                            </div>
                            <div class="category_filter">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3>Filters</h3>
                                    <span>Clear</span>
                                </div>
                                <form action="{{ url('user/store-details/' . request()->id) }}" method="GET">
                                        <div class="form-group mt-4">
                                            <h5>Category</h5>
                                            @foreach ($category as $key => $item)
                                            <div class="form-check my-4">
                                                <input class="form-check-input mb-1"
                                                    type="checkbox"
                                                    name="category[]"
                                                    value="{{ $item->id }}"
                                                    id="category_{{ $key }}"
                                                    {{ is_array(request()->category) && in_array($item->id, request()->category) ? 'checked' : '' }}>
                                                
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
                                            <div class="form-check my-4">
                                                <input class="form-check-input mb-1"
                                                    type="checkbox"
                                                    name="brand_id[]"
                                                    value="{{ $item->id }}"
                                                    id="brand_{{ $key }}"
                                                    {{ is_array(request()->brand_id) && in_array($item->id, request()->brand_id) ? 'checked' : '' }}>
                                                
                                                <label class="form-check-label" for="brand_{{ $key }}">
                                                    {{ $item->name_english }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="form-group mt-4">
                                            <h5>Price</h5>
                                            <div class="slider-wrap" id="priceArea">
                                                <div class="track">
                                                    <div class="left-dot"></div>
                                                    <div class="track-line"></div>

                                                    <div class="active-indicator" id="indicator"></div>

                                                    <div class="value-bubble" id="valueBubble">249 KD</div>

                                                    <input type="range"
                                                        min="99"
                                                        max="999"
                                                        value="{{ request()->price ?? 249 }}"
                                                        id="priceRange"
                                                        name="price"
                                                        style="width:100%;">
                                                </div>

                                                <div class="ticks">
                                                    <div class="tick text-start">99 KD</div>
                                                    <div class="tick">249 KD</div>
                                                    <div class="tick text-end">999 KD</div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Color --}}
                                        <div class="form-group mt-4">
                                            <h5>Color</h5>

                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="color"
                                                    value="1"
                                                    id="color1"
                                                    {{ request()->color == 1 ? 'checked' : '' }}>

                                                <label class="form-check-label" for="color1">
                                                    Color
                                                </label>
                                            </div>

                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="color"
                                                    value="2"
                                                    id="color2"
                                                    {{ request()->color == 2 ? 'checked' : '' }}>

                                                <label class="form-check-label" for="color2">
                                                    Color
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Discount Range --}}
                                        <div class="form-group mt-4">
                                            <h5>Discount Range</h5>
                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="discount"
                                                    value="10"
                                                    id="discount10"
                                                    {{ request()->discount == 10 ? 'checked' : '' }}>
                                                
                                                <label class="form-check-label" for="discount10">
                                                    10%
                                                </label>
                                            </div>

                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="discount"
                                                    value="20"
                                                    id="discount20"
                                                    {{ request()->discount == 20 ? 'checked' : '' }}>
                                                
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
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="size[]"
                                                    value="{{ $item->name }}"
                                                    id="size_{{ $key }}"
                                                    {{ is_array(request()->size) && in_array($item->name, request()->size) ? 'checked' : '' }}>
                                                
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
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="rating"
                                                    value="2"
                                                    id="rating2"
                                                    {{ request()->rating == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="rating2">
                                                    Upto 2 Star
                                                </label>
                                            </div>

                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="rating"
                                                    value="3"
                                                    id="rating3"
                                                    {{ request()->rating == 3 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="rating3">
                                                    Upto 3 Star
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Delivery Time --}}
                                        <div class="form-group mt-4">
                                            <h5>Delivery Time</h5>

                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="delivery_time"
                                                    value="1-2"
                                                    id="del1"
                                                    {{ request()->delivery_time == '1-2' ? 'checked' : '' }}>
                                                
                                                <label class="form-check-label" for="del1">
                                                    Today - 2 days
                                                </label>
                                            </div>

                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="delivery_time"
                                                    value="3-5"
                                                    id="del2"
                                                    {{ request()->delivery_time == '3-5' ? 'checked' : '' }}>
                                                
                                                <label class="form-check-label" for="del2">
                                                    3 - 5 days
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Delivery Options --}}
                                        <div class="form-group delivery">
                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    value="shortest"
                                                    name="delivery_option[]"
                                                    id="shortest"
                                                    {{ is_array(request()->delivery_option) && in_array('shortest', request()->delivery_option) ? 'checked' : '' }}>
                                                
                                                <label class="form-check-label" for="shortest">
                                                    Shortest Delivery time
                                                </label>
                                            </div>

                                            <div class="form-check my-4">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    value="highest_sale"
                                                    name="delivery_option[]"
                                                    id="highest_sale"
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
        (function () {
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
</script>   

@endsection

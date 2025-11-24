@extends('user.layout.app')

@section('content')

<div class="customContainer">
    <div class="row">
        <div class="col-lg-5">

            {{-- PRODUCT IMAGES CAROUSEL --}}
            <div id="carouselExampleCaptions" class="carousel slide customProduct_Carousel">

                {{-- CAROUSEL INDICATORS --}}
                <div class="carousel-indicators">
                    @foreach($product['product_variants'] as $index => $variant)
                        @foreach($variant['variant_image'] as $key => $img)
                        <button type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}">
                            <div class="product_slide_img">
                                <img src="{{ $img }}" class="img-fluid">
                            </div>
                        </button>
                        @endforeach
                    @endforeach
                </div>

                {{-- CAROUSEL IMAGES --}}
                <div class="carousel-inner">
                    @foreach($product['product_variants'] as $index => $variant)
                        @foreach($variant['variant_image'] as $img)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                            <button class="wishlist-btn">
                                <i class="{{ $product['wishlist'] ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart' }}"></i>
                            </button>

                            <img src="{{ $img }}" class="img-fluid">
                        </div>
                        @endforeach
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

        {{-- PRODUCT DETAILS --}}
        <div class="col-lg-7">
            <div class="productList_content">

                <h4 class="fw-semibold">{{ $product['brand']['name'] ?? 'Brand' }}</h4>
                <p class="text-muted mb-1">{{ $product['product_name_en'] }}</p>

                <span class="bought">100 + bought</span>

                <div class="d-flex align-items-center mb-2">
                    <span class="text-warning fs-5">★★★★☆</span>
                    <span class="ms-2 text-muted">(123K)</span>
                </div>

                {{-- PRICE BASED ON FIRST VARIANT --}}
                @php
                    $variant = $product['product_variants'][0];
                @endphp

                <div class="d-flex align-items-center mb-1">
                    <h4 class="fw-bold text-dark me-2">{{ $variant['final_price'] }} KD</h4>
                    <del class="text-muted me-2">{{ $variant['actual_price'] }} KD</del>
                    <span class="text-danger fw-semibold">{{ $variant['discount_value'] }}% off</span>
                </div>
                <p class="text-success small">inclusive of all taxes</p>

                <hr>

                {{-- COLOR OPTIONS --}}
                <h6 class="fw-semibold mb-2">More Color</h6>
                <div class="d-flex gap-2 mb-4 color-tabs">
                    @foreach($product['product_variants'] as $variant)
                        <div class="color-box"
                            data-color="{{ $variant['color']['hex_code'] }}"
                            style="background: {{ $variant['color']['hex_code'] }}">
                        </div>
                    @endforeach
                </div>

                <div id="previewBox" class="preview-box">Color Preview Box</div>

                {{-- SIZE OPTIONS --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-semibold">Available Size</h6>
                    <a href="#" class="text-brown fw-semibold">Size Guide</a>
                </div>

                <div class="d-flex gap-2 mb-4">
                    @foreach($product['product_variants'] as $variant)
                        <button class="size-btn">{{ $variant['size']['name'] }}</button>
                    @endforeach
                </div>

                <button class="customBtn2">Custom Order</button>

                <div class="d-flex align-items-center gap-3 mt-5">
                    <button class="customBtn2 mt-0">Add to Bag</button>
                    <button class="customBtn">Buy Now</button>
                </div>

                {{-- DESCRIPTION --}}
                <div class="container my-4">
                    <div class="desc-box p-4 rounded-4">
                        <h5 class="fw-semibold">Description</h5>
                        <p class="mt-3 text-muted">{{ $product['description_en'] }}</p>

                        {{-- SPECIFICATION --}}
                        <h5 class="fw-semibold mt-4">Specification</h5>
                        <ul class="mt-3 spec-list">
                            @foreach($product['product_specifications'] as $spec)
                                <li>{{ $spec['type'] }} - {{ $spec['value'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- PRODUCT META --}}
                <div class="p-4 rounded-4 shadow-sm bg-white">
                    <div class="row mb-2">
                        <div class="col-6">Return allowed?</div>
                        <div class="col-6 text-end">{{ $product['product_return'] == 1 ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Exchange allowed?</div>
                        <div class="col-6 text-end">{{ $product['product_exchangable'] == 1 ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Review allowed?</div>
                        <div class="col-6 text-end">{{ $product['review_rating'] == 1 ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Affiliated Product?</div>
                        <div class="col-6 text-end">{{ $product['affiliated_product'] == 1 ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Customized product?</div>
                        <div class="col-6 text-end">{{ $product['customized_product'] == 1 ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Ready to ship?</div>
                        <div class="col-6 text-end">{{ $product['ready_to_ship'] == 1 ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6">Cash on Delivery?</div>
                        <div class="col-6 text-end">{{ $product['cash_on_delivery'] == 1 ? 'Yes' : 'No' }}</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- RELATED PRODUCTS CAROUSEL --}}
        <div class="col-lg-12">
            <section class="bestSelling customContainer mt-3">
                <div class="owl-carousel topRatedCarousel">

                    @foreach($relatedProducts as $item)
                    <div class="item">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="{{ $item->image }}" alt="Product">
                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                            </div>
                            <div class="product-content">
                                <h5>{{ $item->name }}</h5>
                                <div class="rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <span>(123K)</span>
                                </div>
                                <div class="price">
                                    <strong>KD {{ $item->price }}</strong>
                                    <span class="old-price">KD {{ $item->old_price }}</span>
                                    <span class="discount">{{ $item->discount }}% off</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </section>
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

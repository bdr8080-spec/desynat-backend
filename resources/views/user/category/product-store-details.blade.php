@extends('user.layout.app')

@section('content')

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
                            <button type="button"
                                data-bs-target="#carouselExampleCaptions"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index == 0 ? 'active' : '' }}"
                                aria-current="{{ $index == 0 ? 'true' : 'false' }}">
                                <div class="product_slide_img">
                                    <img id="mainImage"  src="{{ $img }}" class="img-fluid" alt="Slide {{ $index + 1 }}">
                                </div>
                            </button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach ($allImages as $index => $img)
                            @if($index == 0)
                                <button class="share-btn"><i class="fa-solid fa-share"></i></button>
                                <button class="wishlist-btn"><i class="{{$data->wishlist == '1' ? 'fa-solid' : 'fa-regular' }} fa-heart" onclick="addWishListFunctionproduct({{$data->id}})"></i></button>
                            @endif
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">

                                <div class="carousel_item_img">
                                    <img src="{{ $img }}" class="img-fluid" alt="Slide Image">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" 
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button"
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

            </div>

            <div class="col-lg-7">
                <div class="productList_content">

                    <h4 class="fw-semibold">{{$data->product_name_en}}</h4>
                    <p class="text-muted mb-1">{{$data->product_name_en}}</p>

                    <div class="d-flex align-items-center mb-1">
                        <h4 class="fw-bold text-dark me-2" id="finalPrice">{{$firstVariant['final_price']}} KD</h4>
                        <del class="text-muted me-2" id="actualPrice">{{$firstVariant['actual_price']}} KD</del>
                        <span class="text-danger fw-semibold">{{$firstVariant['discount_value']}}% off</span>
                    </div>

                    <hr>

                    <h6 class="fw-semibold mb-2">More Color</h6>
                    <div class="d-flex gap-2 mb-4 color-tabs">

                        @foreach ($product_variants as $variant)
                            <div class="color-box choose-color"
                                data-color="{{ $variant['color_hex'] }}"
                                style="background: {{ $variant['color_hex'] }}" 
                                >
                            </div>
                        @endforeach

                    </div>

                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-semibold">Available Size</h6>
                    </div>

                        <div class="d-flex gap-2 mb-4" id="sizeContainer">
                                @foreach ($firstVariant['sizes'] as $size)
                                    <button class="size-btn">{{ $size }}</button>
                                @endforeach
                            </div>


                            <h4 class="fw-semibold">{{$data->product_name_en}}</h4>
                            <p class="text-muted mb-1">{{$data->description_en}}</p>

                    <button class="customBtn2">Custom Order</button>

                    <div class="d-flex align-items-center gap-3 mt-5">
                        <button class="customBtn2 mt-0">Add to Bag</button>
                        <button class="customBtn">Buy Now</button>
                    </div>

                    <div class="container my-4">
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
                    {{-- <div class="p-4 rounded-4 shadow-sm" style="background:#fff;">
                        <div class="row mb-2">
                            <div class="col-6">
                                @if($product->product_return==1) {{$product->return_days}} days  @else No @endif
                             </div>
                            <div class="col-6 text-end">@if($product->product_exchangable==1) {{$product->exchangable_days}} days @else No @endif</div>
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
                    <div class="p-4 rounded-4 shadow-sm desc-box">
                        <div class="row mb-2">
                            <div class="col-6">Return allowed ?
                            </div>
                            <div class="col-6 text-end">@if($data->product_return==1) {{$data->return_days}} days  @else No @endif </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Exchange allowed ?
                            </div>
                            <div class="col-6 text-end">@if($data->product_exchangable==1) {{$data->exchangable_days}} days @else No @endif </div>
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


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script>
    var productVariants = @json($product_variants);
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {


        const productVariants = @json($product_variants);

        document.querySelectorAll(".choose-color").forEach(box => {

            box.addEventListener("click", function () {

                let colorHex = this.dataset.color;
                let variant = Object.values(productVariants).find(v => v.color_hex === colorHex);

                if (!variant) return;


                document.getElementById("actualPrice").innerText = variant.actual_price + " KD";
                document.getElementById("finalPrice").innerText  = variant.final_price + " KD";


    
                let sizeContainer = document.getElementById("sizeContainer");
                sizeContainer.innerHTML = ""; 
                variant.sizes.forEach(size => {
                    sizeContainer.innerHTML += `<button class="size-btn">${size}</button>`;
                });


            
                let images = variant.variant_image;
                let carouselIndicators = document.querySelector(".carousel-indicators");
                let carouselInner = document.querySelector(".carousel-inner");

                carouselIndicators.innerHTML = "";
                carouselInner.innerHTML = "";

                images.forEach((img, index) => {

                    carouselIndicators.innerHTML += `
                        <button type="button" 
                            data-bs-target="#carouselExampleCaptions" 
                            data-bs-slide-to="${index}" 
                            class="${index == 0 ? 'active' : ''}">
                            <div class="product_slide_img">
                                <img src="${img}" class="img-fluid"/>
                            </div>
                        </button>
                    `;

                    carouselInner.innerHTML += `
                        <div class="carousel-item ${index == 0 ? 'active' : ''}">
                            ${index == 0 ? `
                                <button class='share-btn'><i class='fa-solid fa-share'></i></button>
                                <button class='wishlist-btn'><i class='fa-regular fa-heart'></i></button>
                            ` : ''}
                            <div class="carousel_item_img">
                            <img src="${img}" class="img-fluid">
                            </div>
                        </div>
                    `;
                });
            });
        });

    });
</script>


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
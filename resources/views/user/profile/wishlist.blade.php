@extends('user.layout.app')

@section('content')

<div class="product_reels customContainer">
        <ul class="nav nav-tabs customNavTabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">Product</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reels-tab" data-bs-toggle="tab" data-bs-target="#reels-tab-pane" type="button" role="tab" aria-controls="reels-tab-pane" aria-selected="false">Reels</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
                <div class="categoryDetail customContainer">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <div class="categoryDetail_content">
                                <div class="row">
                                    @forelse ($wishListProduct as $item)
                                    <div class="col-lg-3 col-md-3 col-12 my-3" id="hideWisListProduct{{$item->id}}">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{ $item->product_variants->first()->variant_image[0] ?? '' }}" width="120">
                                                <button class="wishlist-btn" onclick="addWishListFunctionproduct({{$item->id}})"><i class="fa-solid fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>{{$item->product_name_en}} ({{$item->user_name}})</h5>
                                                <div class="rating">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                    <span>(123K)</span>
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
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                        <h3>No WishList Found</h3>
                                    @endforelse
                                  
                                    {{-- <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
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
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="reels-tab-pane" role="tabpanel" aria-labelledby="reels-tab" tabindex="0">
                <div class="categoryDetail_content reels_content">
                    <div class="row">
                        <!-- <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div> -->
                        @if($wishlistedReels->isEmpty())
                            <div class="col-12 my-3 text-center">
                                <p>No reels added to wishlist</p>
                            </div>
                        @else
                            @foreach($wishlistedReels as $reel)
                                @php
                                    $fileUrl = $reel['reel_details']['file'] ?? '';
                                    $extension = strtolower(pathinfo(parse_url($fileUrl, PHP_URL_PATH), PATHINFO_EXTENSION));
                                    $isVideo = in_array($extension, ['mp4', 'webm', 'ogg', 'mov']);
                                @endphp

                                <div class="col-lg-3 col-md-3 col-12 my-3">
                                    <div class="product-card">
                                        <div class="product-img">
                                            @if($isVideo)
                                                <video controls width="100%" style="border-radius:6px;">
                                                    <source src="{{ $fileUrl }}" type="video/{{ $extension }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{ $fileUrl }}" alt="Reel Image" style="border-radius:6px; width:100%;">
                                            @endif

                                            <button class="wishlist-btn" data-reel-id="{{ $reel->reel_id }}"><i class="fa-solid fa-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
document.querySelectorAll('.wishlist-btn').forEach(button => {
    button.addEventListener('click', async function() {
        const reelId = this.dataset.reelId;
        const icon = this.querySelector('i');

        try {
            const response = await $.ajax({
                url: "{{ route('user.add_remove_reel_to_whishlist') }}",
                method: "POST",
                data: { reel_id: reelId, _token: "{{ csrf_token() }}" },
                dataType: "json",
            });

            if (response.status === 'success') {
                toastr.success(response.message);
                setTimeout(() => {
                    location.reload();
                }, 1000);

            } else {
                toastr.error(response.message || 'Failed to update wishlist');
            }
        } catch (error) {
            console.error(error);
            toastr.error('Something went wrong');
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabContentContainer = document.getElementById('tabContentContainer');

    // 1️⃣ Restore last active tab on page load
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show(); // Show the saved tab immediately
        }
    }

    // 2️⃣ Show tab container after activating the saved tab
    if (tabContentContainer) {
        tabContentContainer.classList.add('active-shown');
    }

    // 3️⃣ Reload page when user clicks a different tab
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            const currentTab = localStorage.getItem("activeTab");
            if (currentTab !== this.id) {
                e.preventDefault(); // Stop Bootstrap from switching tab immediately
                localStorage.setItem("activeTab", this.id);
                //location.reload(); // reload before tab content shows
            }
        });
    });
});
</script>


@endsection
@extends('user.layout.app')

@section('content')
<div class="customContainer">
    <div class="owl-carousel owl-theme customOwlcarousel2 storeBanner">
        @if(empty($topBanners['data']) || count($topBanners['data']) == 0)
        <div class="item">
            <div class="Bannerstores">
                <img src="{{ asset('user/assets/images/active-banner.png') }}" alt="banner" class="img-fluid" />
            </div>
        </div>
        @else
        @foreach($topBanners['data'] as $banner)
        <div class="item">
            <div class="Bannerstores">
                <a href="{{ url('user/store-details/' . ($banner->seller_details->store_info->id ?? '')) }}">
                    <img src="{{ $banner->upload_banner }}" alt="banner" class="img-fluid" />
                </a>
            </div>
        </div>
        @endforeach
        @endif


    </div>
</div>

<section class="customContainer categorie_contenar" id="subCategorySection">
    <h3 class="mid-headng">Categories</h3>
    <div class="row">
        @forelse ($subCategory as $item)
        <div class="col-lg-4 col-md-4 col-6 my-lg-3 my-2 text-center">
            <a class="category_detail" href="{{ route('user.category_wise_store', $item->category_id) }}">
                <div class="categorie_cotent">
                    <div class="categorie_cotent-img">
                        <img src="{{ $item->image }}" class="img-fluid" />
                    </div>
                    <h3 class="mt-3">{{ $item->name_english }}</h3>
                </div>
            </a>
        </div>
        @empty
        <div class="col-lg-4 col-md-4 col-6 my-3 text-center categorie_cotent">
            {{-- <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" /> --}}
            <h3>No Category Found</h3>
        </div>
        @endforelse
    </div>
</section>

<div class="customContainer suggestStore">
    <h3 class="mid-headng mb-3">Suggested Stores</h3>
    <div class="suggestStore_contenar">
        <div class="owl-carousel storeCarousel">
            @foreach($stores as $store)
            <div class="item">
                <div class="suggestStore_content">
                    <a href="{{ route('user.store_details', $store->id) }}" style="text-decoration:none; color:inherit;">
                    <div class="suggestedStore_img">
                        <img src="{{ $store->store_image }}" class="img-fluid circle-image"
                            alt="{{ $store->store_name }}" />
                    </div>
                    </a>
                    <h5>{{ $store->store_name }}</h5>
                </div>
            </div>
            @endforeach

            <!-- <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div> -->
        </div>

    </div>
    <!-- <div class="suggestStore_contenar">
            <div class="owl-carousel storeCarousel">
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
            </div>

        </div> -->
</div>

<section class="bestSelling customContainer">
    <h3 class="mid-headng mb-3">Best Selling</h3>
    <div class="owl-carousel bestSellingCarousel">

        @foreach($bestSellingProduct as $key=>$item)

        <div class="item">
            <div class="product-card blacktitle">
              
                    <div class="product-img">
                        <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">
                        @foreach ($item->product_variants[0]->variant_image as $key => $val1)
                        @if ($key != 0)
                        @php break @endphp
                        @endif
                        <img  style="z-index:-99" src="{{ $val1 }}" alt="Product">
                        @endforeach
                        </a>

                        @if (Auth::guard('web')->user())
                        <span class="wishlist-btn" style="cursor: pointer;z-index:999"><i style="cursor: pointer;z-index:99999999"
                                class="wishlistProduct{{ $item->id }} fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                                onclick="addWishListFunctionproduct({{ $item->id }},`home`)"></i></span>
                        @else
                        <a class="wishlist-btn text-decoration-underline" style="cursor: pointer;z-index:99" href="{{route('userLogin')}}">
                            <i class="fa-regular fa-heart" style="cursor: pointer;z-index:999999"></i>
                        </a>
                        @endif

                        <button class="share-btn"><img
                                src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                      <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">
                    <div class="product-content">
                        <h5>{{ $item->product_name_en }}</h5>
                        <div class="rating">
                            @php
                                $rating = $item->product_avg_rating ?? 0;
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

                            <span>({{ $item->review_count ?? 0 }})</span>
                        </div>
                        <div class="price">
                            <strong>KD {{ $item->product_variants[0]->final_price }}</strong>
                            <span class="old-price">KD {{ $item->product_variants[0]->actual_price }}</span>
                            <span class="discount"> {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        @endforeach

        <!-- <div class="item">
            <div class="product-card">
                <div class="product-img">
                    <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                    <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
   -->
    </div>
</section>

<div class="customContainer">
    <h3 class="mid-headng mb-3">Browse some Premium stores</h3>

    <div class="owl-carousel owl-theme customOwlcarousel2 storeBanner">
        @if(empty($bottomBanners['data']) || count($bottomBanners['data']) == 0)
        <div class="item">
            <div class="premiumImg">
                <img src="{{ asset('user/assets/images/active-banner.png') }}" class="img-fluid" />
            </div>
        </div>
        @else
        @foreach($bottomBanners['data'] as $banner)
        <div class="item">
            <div class="premiumImg">
                <a href="{{ url('user/store-details/' . ($banner->seller_details->store_info->id ?? '')) }}">
                    <img src="{{ $banner->upload_banner }}" class="img-fluid" />
                </a>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <!-- @if(empty($bottomBanners['data']) || count($bottomBanners['data']) == 0)
            <div class="premiumImg">
                <img src="{{ asset('user/assets/images/active-banner.png') }}" class="img-fluid" />
            </div>
        @else
            @foreach($bottomBanners['data'] as $banner)
                <div class="premiumImg">
                    <img src="{{ $banner->upload_banner }}" class="img-fluid" />
                </div>
            @endforeach
        @endif -->
</div>

<section class="bestSelling customContainer mt-3">
    <h3 class="mid-headng mb-3">Top Rated</h3>
    <div class="owl-carousel topRatedCarousel">

        @foreach($TopRatingProduct as $key=>$item)

        <div class="item">
            <div class="product-card blacktitle">
                   <div class="product-img">
            
                    <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">
            
                        @foreach ($item->product_variants[0]->variant_image as $key => $val1)
                        @if ($key != 0)
                        @php break @endphp
                        @endif
                        <img  style="z-index:-1;" src="{{ $val1 }}" alt="Product">
                        @endforeach

                    </a>

                        @if (Auth::guard('web')->user())
                        <span class="wishlist-btn" style="cursor: pointer;z-index:999999999999"><i style="z-index:999999999;"
                                class="wishlistProduct{{ $item->id }} fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                                onclick="addWishListFunctionproduct({{ $item->id }},`home`)"></i></span>
                        @else
                        <a class="wishlist-btn text-decoration-underline"  style="cursor: pointer;z-index:99999999" href="{{route('userLogin')}}">
                            <i class="fa-regular fa-heart"></i>
                        </a>
                        @endif

                        <button class="share-btn"><img
                                src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                     <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">
            
                    <div class="product-content">
                        <h5>{{ $item->product_name_en }}</h5>
                        <div class="rating">
                            @php
                                $rating = $item->product_avg_rating ?? 0;
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

                            <span>({{ $item->review_count ?? 0 }})</span>
                        </div>
                        <div class="price">
                            <strong>KD {{ $item->product_variants[0]->final_price }}</strong>
                            <span class="old-price">KD {{ $item->product_variants[0]->actual_price }}</span>
                            <span class="discount"> {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}
                            </span>
                        </div>
                    </div>
                </a>
                </div>
        </div>

        @endforeach

    </div>
</section>

<div class="customContainer">
    <h3 class="mid-headng mb-3">Browse some discounted deals</h3>

    <div class="owl-carousel owl-theme customOwlcarousel2 storeBanner">
        <!-- <div class="item">
                <div class="premiumImg">
                    <img src="{{ asset('user/assets/images/discount-deals.svg') }}" class="img-fluid" />
                </div>
            </div> -->

        @foreach($homeDealBanner as $key=>$val)
        <div class="item">
            <div class="premiumImg ">
                <a
                    href="{{ url('user/store-details/' . ($val->sellerDealrecord->first()->product_details->store_id ?? '')) }}">
                    <img src="{{$val->image}}" class="img-fluid" />
                </a>
            </div>
        </div>
        @endforeach


    </div>

</div>

<section class="customContainer mt-3">
    <h3 class="mid-headng mb-0">Newest Products</h3>
    <div class="row">

        @foreach($userNewestProduct as $key=>$item)

        <div class="col-lg-3 col-md-4 col-6 my-3">
            <div class="product-card blacktitle">
                    <div class="product-img">
                         <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">
           
                        @foreach ($item->product_variants[0]->variant_image as $key => $val1)
                        @if ($key != 0)
                        @php break @endphp
                        @endif
                        <img style="z-index:-99" src="{{ $val1 }}" alt="Product">
                        @endforeach
                         </a>

                        @if (Auth::guard('web')->user())
                        <span class="wishlist-btn" style="cursor: pointer;z-index:99999999"><i
                                class="wishlistProduct{{ $item->id }} fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                                onclick="addWishListFunctionproduct({{ $item->id }},`home`)"></i></span>
                        @else
                        <a class="wishlist-btn text-decoration-underline"  style="cursor: pointer;z-index:99999999" href="{{route('userLogin')}}">
                            <i class="fa-regular fa-heart"></i>
                        </a>
                        @endif

                        <button class="share-btn"><img
                                src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                     <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">
           
                    <div class="product-content">
                        <h5>{{ $item->product_name_en }}</h5>
                        <div class="rating">
                            @php
                                $rating = $item->product_avg_rating ?? 0;
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

                            <span>({{ $item->review_count ?? 0 }})</span>
                        </div>
                        <div class="price">
                            <strong>KD {{ $item->product_variants[0]->final_price }}</strong>
                            <span class="old-price">KD {{ $item->product_variants[0]->actual_price }}</span>
                            <span class="discount"> {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}
                            </span>
                        </div>
                    </div>
                </a>
                </div>
        </div>

        @endforeach


    </div>
</section>

<!-- banner Modal image -->
@auth
@if(isset($banners) && $banners->count() > 0)
<div class="modal-wapper" id="showBanner">
    <div class="modal-content-2">
        <div class="banner-body">
            <button type="button" class="btn-skip">Skip</button>
            <div class="popbanner">
                <div class="owl-carousel owl-theme bannerpop">
                    @foreach($banners as $banner)
                    <div class="item">
                        <div class="bannerScreen">
                            <img src="{{ $banner->image }}" alt="Banner" class="img-fluid" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endauth


<script>
document.addEventListener("DOMContentLoaded", function() {

    const skipBtn = document.querySelector('.btn-skip');
    const bannerModal = document.getElementById('showBanner');
    let bannerUpdated = false; // prevent double call

    function updateBannerView() {
        if (bannerUpdated) return;
        bannerUpdated = true;

        if (bannerModal) {
            bannerModal.style.display = 'none';
        }

        fetch("{{ route('user.updateBannerView') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    // console.log('Banner marked as viewed');
                }
            })
            .catch(err => console.error('Error updating banner view', err));
    }

    // 1️⃣ Click on Skip button
    if (skipBtn) {
        skipBtn.addEventListener('click', updateBannerView);
    }

    // 2️⃣ Auto call after 10 seconds
    //  setTimeout(updateBannerView, 10000);

});
</script>



<script>
function handleSubCategory(id) {
    $.ajax({
        url: "{{ route('dashboard') }}",
        method: "GET",
        data: {
            id: id
        },
        beforeSend: function() {
            $('#verifyBtn').prop('disabled', true);
        },
        success: function(resp) {
            $('#subCategorySection').html(resp);
        },
        error: function(xhr) {

        },
        complete: function() {
            $('#verifyBtn').prop('disabled', false);
        }
    });
}
</script>

<script>
document.addEventListener('click', function (e) {

    var shareBtn = e.target.closest('.share-btn');

    if (shareBtn) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation(); // 🔥 strongest blocker

        var link = shareBtn.closest('a').getAttribute('href');

        if (navigator.clipboard) {
            navigator.clipboard.writeText(link).then(function () {
                toastr.success('Link copied to clipboard');
            });
        } else {
            var temp = document.createElement("input");
            document.body.appendChild(temp);
            temp.value = link;
            temp.select();
            document.execCommand("copy");
            document.body.removeChild(temp);

            toastr.success('Link copied to clipboard');
        }

        return false; // extra safety
    }

}, true); 
</script>




@endsection
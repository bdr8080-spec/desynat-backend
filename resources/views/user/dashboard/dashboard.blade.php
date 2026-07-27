@extends('user.layout.app')

@section('content')

@php

if(App::getLocale()=='en'){
$currency = session('currency', 'KWD');
}else{
$currency = session('currencyAr', 'دينار كويتي');
}

@endphp


<div class="customContainer">

    <div class="owl-carousel owl-theme customOwlcarousel2 storeBanner">
        @if(empty($topBanners['data']) || count($topBanners['data']) == 0)
        <div class="item">
            <div class="Bannerstores">
                <img src="{{ asset('user/assets/images/active-banner.png') }}" alt="banner" class="img-fluid" />
            </div>
            <div class="adsTitle">Ads</div>
        </div>
        @else
        @foreach($topBanners['data'] as $banner)
        <div class="item">
            <div class="Bannerstores">
                <a href="{{ url('user/store-details/' . ($banner->seller_details->store_info->id ?? '')) }}">
                    <img src="{{ $banner->upload_banner }}" alt="banner" class="img-fluid" />
                </a>
            </div>
            <div class="adsTitle">Ads</div>
        </div>
        @endforeach
        @endif


    </div>
</div>

<section class="customContainer categorie_contenar sliderarrow" id="subCategorySection">
    <h3 class="mid-headng">{{ __('user_messages.categories') }} </h3>

    <div class="owl-carousel categoryProducts">

        @forelse ($subCategory as $item)
            <div class="item">
                <a class="category_detail"
                    href="{{ route('user.category_wise_store', $item->category_id) }}?subcategory={{ $item->id }}">

                    <div class="categorie_cotent cat_title text-center">
                        <div class="categorie_cotent-img">
                            <img src="{{ $item->image }}" class="img-fluid" alt="Category">
                        </div>

                        @if(app()->getLocale() == 'en')
                            <h3 class="mt-3">{{ $item->name_english }}</h3>
                        @else
                            <h3 class="mt-3">{{ $item->name_arabic }}</h3>
                        @endif
                    </div>
                </a>
            </div>

        @empty
            <div class="item">
                <div class="my-3 text-center categorie_cotent">
                    <h3>{{ __('user_messages.no_category_found') }}</h3>
                </div>
            </div>
        @endforelse

    </div>

    <!-- <div class="row">
        @forelse ($subCategory as $item)
        <div class="col-lg-4 col-md-4 col-6 my-lg-3 my-2 text-center">
            <a class="category_detail"
                href="{{ route('user.category_wise_store', $item->category_id) }}?subcategory={{$item->id}} ">
                <div class="categorie_cotent cat_title">
                    <div class="categorie_cotent-img">
                        <img src="{{ $item->image }}" class="img-fluid" />
                    </div>
                    @if(app()->getLocale() == 'en')
                    <h3 class="mt-3">{{ $item->name_english }}</h3>
                    @else
                    <h3 class="mt-3">{{ $item->name_arabic }}</h3>
                    @endif
                </div>
            </a>
        </div>
        @empty
        <div class="col-lg-4 col-md-4 col-6 my-3 text-center categorie_cotent">
            {{-- <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" /> --}}
            <h3>{{ __('user_messages.no_category_found') }}</h3>
        </div>
        @endforelse
    </div> -->
</section>

<div class="customContainer suggestStore">
    <h3 class="mid-headng mb-3">{{ __('user_messages.suggested_stores') }}</h3>
    <div class="suggestStore_contenar sliderarrow">
        <!-- <div class="owl-carousel storeCarousel">
            @foreach($stores as $store)
            <div class="item">
                <div class="suggestStore_content">
                    <a href="{{ route('user.store_details', $store->id) }}"
                        style="text-decoration:none; color:inherit;">
                        <div class="suggestedStore_img">
                            <img src="{{ $store->store_image }}" class="img-fluid circle-image"
                                alt="{{ $store->store_name }}" />
                        </div>
                    </a>
                    <h5 class="storeName">{{ $store->store_name }}</h5>
                </div>
            </div>
            @endforeach
        </div> -->

        <div class="owl-carousel storeCarousel">
            @foreach($stores->chunk(2) as $group)
                <div class="item">
                    @foreach($group as $store)
                        <div class="suggestStore_content mb-3">
                            <a href="{{ route('user.store_details', $store->id) }}" style="text-decoration:none; color:inherit;">
                                <div class="suggestedStore_img">
                                    <img src="{{ $store->store_image }}" class="img-fluid circle-image" alt="{{ $store->store_name }}">
                                </div>
                            </a>
                            <h5 class="storeName">{{ $store->store_name }}</h5>
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>

    </div>

</div>


<section class="bestSelling customContainer sliderarrow">
    <div id="sellingbest" class="demo">
    <h3 class="mid-headng mb-3">{{ __('user_messages.best_selling') }}</h3>
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
                        <img style="z-index:-99" src="{{ $val1 }}" alt="Product">
                        @endforeach
                    </a>

                    @if (Auth::guard('web')->user())
                    <span class="wishlist-btn" style="cursor: pointer;"><i style="cursor: pointer;"
                            class="wishlistProduct{{ $item->id }} fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                            onclick="addWishListFunctionproduct({{ $item->id }},`home`)"></i></span>
                    @else
                    <a class="wishlist-btn text-decoration-underline" style="cursor: pointer;"
                        href="{{route('userLogin')}}">
                        <i class="fa-regular fa-heart" style="cursor: pointer;"></i>
                    </a>
                    @endif

                    <button class="share-btn" data-link="{{ route('user.product_details',[$item->id]) }}"><img
                            src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>

                </div>

                <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">
                    <div class="product-content">
                        @if(app()->getLocale() == 'en')
                        <h5>{{ $item->product_name_en }}@if(!empty($item->store))({{$item->store->store_name}})@endif
                        </h5>
                        @else
                        <h5>{{ $item->product_name_ar }}@if(!empty($item->store))({{$item->store->store_name}})@endif
                        </h5>
                        @endif
                        <div class="rating">
                            @php
                            $rating = $item->product_avg_rating ?? 0;
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            @if($rating > 0)

                            @for($i = 0; $i < $fullStars; $i++) <i class="fa-solid fa-star"></i>
                                @endfor

                                @if($hasHalfStar)
                                <i class="fa-solid fa-star-half-stroke"></i>
                                @endif

                                @for($i = 0; $i < $emptyStars; $i++) <i class="fa-regular fa-star"></i>
                                    @endfor

                                    @else

                                    @for($i = 0; $i < 5; $i++) <i class="fa-regular fa-star"></i>
                                        @endfor

                                        @endif

                                        <span>({{ $item->review_count ?? 0 }})</span>
                        </div>
                        <!-- <div class="price">
                            <strong>KD {{ $item->product_variants[0]->final_price }}</strong>
                            <span class="old-price">KD {{ $item->product_variants[0]->actual_price }}</span>
                            <span class="discount"> {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}
                            </span>
                        </div> -->


                        <div class="price">
                            <strong>
                                {{ $currency }}
                                {{ number_format(convertPriceInUserWeb($item->product_variants[0]->final_price), 2) }}
                            </strong>

                            <span class="old-price">
                                {{ $currency }}
                                {{ number_format(convertPriceInUserWeb($item->product_variants[0]->actual_price), 2) }}
                            </span>

                            <span class="discount">
                                {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% ' . __('user_messages.off') : __('user_messages.off') }}
                            </span>
                        </div>

                    </div>
                </a>
            </div>
        </div>

        @endforeach

</div>
    </div>
</section>

<div class="customContainer">
    <h3 class="mid-headng mb-3">{{ __('user_messages.browse_some_premium_stores') }}</h3>

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

</div>

<section class="bestSelling customContainer mt-3 sliderarrow">
    <h3 class="mid-headng mb-3">{{ __('user_messages.top_rated') }}</h3>
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
                        <img style="z-index:-1;" src="{{ $val1 }}" alt="Product">
                        @endforeach

                    </a>

                    @if (Auth::guard('web')->user())
                    <span class="wishlist-btn" style="cursor: pointer;"><i style=""
                            class="wishlistProduct{{ $item->id }} fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                            onclick="addWishListFunctionproduct({{ $item->id }},`home`)"></i></span>
                    @else
                    <a class="wishlist-btn text-decoration-underline" style="cursor: pointer;"
                        href="{{route('userLogin')}}">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                    @endif

                    <button class="share-btn" data-link="{{ route('user.product_details',[$item->id]) }}"><img
                            src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
                </div>
                <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">

                    <div class="product-content">
                        @if(app()->getLocale() == 'en')
                        <h5>{{ $item->product_name_en }}@if(!empty($item->store))({{$item->store->store_name}})@endif
                        </h5>
                        @else
                        <h5>{{ $item->product_name_ar }}@if(!empty($item->store))({{$item->store->store_name}})@endif
                        </h5>
                        @endif
                        <div class="rating">
                            @php
                            $rating = $item->product_avg_rating ?? 0;
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            @if($rating > 0)

                            @for($i = 0; $i < $fullStars; $i++) <i class="fa-solid fa-star"></i>
                                @endfor

                                @if($hasHalfStar)
                                <i class="fa-solid fa-star-half-stroke"></i>
                                @endif

                                @for($i = 0; $i < $emptyStars; $i++) <i class="fa-regular fa-star"></i>
                                    @endfor

                                    @else

                                    @for($i = 0; $i < 5; $i++) <i class="fa-regular fa-star"></i>
                                        @endfor

                                        @endif

                                        <span>({{ $item->review_count ?? 0 }})</span>
                        </div>
                        <!-- <div class="price">
                            <strong>KD {{ $item->product_variants[0]->final_price }}</strong>
                            <span class="old-price">KD {{ $item->product_variants[0]->actual_price }}</span>
                            <span class="discount"> {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}
                            </span>
                        </div> -->

                        <div class="price">
                            <strong>
                                {{ $currency }}
                                {{ number_format(convertPriceInUserWeb($item->product_variants[0]->final_price), 2) }}
                            </strong>

                            <span class="old-price">
                                {{ $currency }}
                                {{ number_format(convertPriceInUserWeb($item->product_variants[0]->actual_price), 2) }}
                            </span>

                            <span class="discount">
                                {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% ' . __('user_messages.off') : __('user_messages.off') }}
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
    <h3 class="mid-headng mb-3">{{ __('user_messages.browse_some_discounted_deals') }}</h3>

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
    <h3 class="mid-headng mb-0">{{ __('user_messages.newest_products') }}</h3>
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
                    <span class="wishlist-btn" style="cursor: pointer;"><i
                            class="wishlistProduct{{ $item->id }} fa-regular {{ $item->wishlist == 1 ? 'fa-solid fa-heart' : 'fa-heart' }}"
                            onclick="addWishListFunctionproduct({{ $item->id }},`home`)"></i></span>
                    @else
                    <a class="wishlist-btn text-decoration-underline" style="cursor: pointer;"
                        href="{{route('userLogin')}}">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                    @endif

                    <button class="share-btn" data-link="{{ route('user.product_details',[$item->id]) }}"><img
                            src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
                </div>
                <a href="{{ route('user.product_details',[$item->id]) }}" style="text-decoration:none;">

                    <div class="product-content">
                        @if(app()->getLocale() == 'en')
                        <h5>{{ $item->product_name_en }}@if(!empty($item->store))({{$item->store->store_name}})@endif
                        </h5>
                        @else
                        <h5>{{ $item->product_name_ar }}@if(!empty($item->store))({{$item->store->store_name}})@endif
                        </h5>
                        @endif
                        <div class="rating">
                            @php
                            $rating = $item->product_avg_rating ?? 0;
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            @if($rating > 0)

                            @for($i = 0; $i < $fullStars; $i++) <i class="fa-solid fa-star"></i>
                                @endfor

                                @if($hasHalfStar)
                                <i class="fa-solid fa-star-half-stroke"></i>
                                @endif

                                @for($i = 0; $i < $emptyStars; $i++) <i class="fa-regular fa-star"></i>
                                    @endfor

                                    @else

                                    @for($i = 0; $i < 5; $i++) <i class="fa-regular fa-star"></i>
                                        @endfor

                                        @endif

                                        <span>({{ $item->review_count ?? 0 }})</span>
                        </div>
                        <!-- <div class="price">
                            <strong>KD {{ $item->product_variants[0]->final_price }}</strong>
                            <span class="old-price">KD {{ $item->product_variants[0]->actual_price }}</span>
                            <span class="discount"> {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% Off' : 'Off' }}
                            </span>
                        </div> -->

                        <div class="price">
                            <strong>
                                {{ $currency }}
                                {{ number_format(convertPriceInUserWeb($item->product_variants[0]->final_price), 2) }}
                            </strong>

                            <span class="old-price">
                                {{ $currency }}
                                {{ number_format(convertPriceInUserWeb($item->product_variants[0]->actual_price), 2) }}
                            </span>

                            <span class="discount">
                                {{ $item->product_variants[0]->discount_value }}
                                {{ $item->product_variants[0]->discount_type == '1' ? '% ' . __('user_messages.off') : __('user_messages.off') }}
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
document.addEventListener('click', function(e) {

    var shareBtn = e.target.closest('.share-btn');

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
            navigator.clipboard.writeText(link).then(function() {
                toastr.success("{{ __('user_messages.link_copied_to_clipboard') }}");
            }).catch(function() {
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

<!-- tidio chatbot -->
<script src="//code.tidio.co/{{ config('app.TIDIO_KEY') }}.js" async></script>

<script>
document.addEventListener("tidioChat-ready", function() {

    if (!window.tidioChatApi) return;

    @php
    $user = Auth::guard('web') -> user();
    $fullName = $user ? $user -> full_name : 'Guest';
    $email = $user ? $user -> email : 'guest_'.uniqid();
    $role = $user ? 'user' : 'guest';
    @endphp

    const email = "{{ $email }}";
    const role = "{{ $role }}";
    const fullName = "{{ $fullName }}";
    // console.log(fullName);

    const uniqueId = role + "_" + email;


    window.tidioChatApi.setVisitorData({
        name: fullName,
        email: email,
        distinct_id: uniqueId,
        role: role
    });

    window.tidioChatApi.on("messageFromVisitor", function(event) {});

    window.tidioChatApi.on("messageFromOperator", function(event) {});

});
</script>




@endsection
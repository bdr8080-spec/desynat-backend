@extends('user.layout.app')

@section('content')

@php

if(App::getLocale()=='en'){
$currency = session('currency', 'KWD');
}else{
$currency = session('currencyAr', 'دينار كويتي');
}

@endphp


<style>
.share-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: 1px solid transparent;
    border-radius: 50%;
    background: linear-gradient(#fff, #fff) padding-box, linear-gradient(to bottom left, #DFBF8F, #6E4527) border-box;
    width: 32px;
    color: var(--secondry2-color);
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 15;
}

.progress-container {
    display: flex;
    gap: 4px;
    padding: 10px 0;
}

.story-progress {
    flex: 1;
    height: 4px;
    background: #ddd;
    overflow: hidden;
    border-radius: 5px;
}

.story-progress-fill {
    width: 0%;
    height: 100%;
    background: #007bff;
}
.hightop{
    position: absolute;
    top: 14px;
    font-size: 13px;
    color:#fff;
}

</style>
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
                            <img src="{{ $store_details['store']->seller_information->profile_pic }}" class="img-fluid" style="cursor:pointer" onclick="openSellerGallery(0)" />
                        </div>
                    </div>
                    <div class="storeClient_profile_content">
                        <div class="d-flex align-items-center">
                            <h3>{{ $store_details['store']['store_name'] }}</h3>
                            <span class="status_on_off">

                                @if ($store_details['store']['Store_Availability'] == 1)
                                {{ __('user_messages.available') }}
                                @else
                                {{ __('user_messages.busy') }}
                                @endif

                            </span>
                        </div>
                        <div class="product-content">
                            <p> {{$store_details['store']->seller_information->first_name}}
                                {{$store_details['store']->seller_information->last_name}}</p>

                            @php
                                $totalReviews = 0;

                                foreach ($store_details['All_Product'] as $product) {
                                    $totalReviews += $product->review->count();
                                }

                                $rating = $store_details['store']->average_store_rating ?? 0;

                                $fullStars = floor($rating);
                                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            <div class="rating">

                                @if($rating > 0)

                                    @for($i = 0; $i < $fullStars; $i++)
                                        <span><i class="fa-solid fa-star"></i></span>
                                    @endfor

                                    @if($hasHalfStar)
                                        <span><i class="fa-solid fa-star-half-stroke"></i></span>
                                    @endif

                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <span><i class="fa-regular fa-star"></i></span>
                                    @endfor

                                @else

                                    @for($i = 0; $i < 5; $i++)
                                        <span><i class="fa-regular fa-star"></i></span>
                                    @endfor

                                @endif

                                <span class="totalstart">
                                    ({{ $totalReviews }})
                                </span>

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
                        <span>{{ __('user_messages.copy_link') }}</span>
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

                    @forelse($seller_highlights as $highlight)

                        @php
                            $firstHighlight = $highlight['highlights'][0];
                            $extension = pathinfo($firstHighlight['file'], PATHINFO_EXTENSION);
                        @endphp

                        <div class="item">

                            <div class="suggestStore_content"
                                onclick='openHighlightViewer(@json($highlight))'>

                                <div class="suggestedStore_img">

                                    @if(in_array(strtolower($extension), ['mp4','webm','ogg']))

                                        <video class="img-fluid" autoplay muted loop playsinline>
                                            <source src="{{ $firstHighlight['file'] }}" type="video/{{ $extension }}">
                                        </video>

                                    @else

                                        <img src="{{ $firstHighlight['file'] }}" class="img-fluid" />

                                    @endif

                                </div>

                                <p>{{ $highlight['title'] ?? 'Highlight' }}</p>

                            </div>

                        </div>

                    @empty

                        <div class="item text-center">
                            <p>{{ __('user_messages.no_highlights') }}</p>
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
                type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">{{ __('user_messages.product') }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reels-tab" data-bs-toggle="tab" data-bs-target="#reels-tab-pane" type="button"
                role="tab" aria-controls="reels-tab-pane" aria-selected="false">{{ __('user_messages.reels') }}</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
            tabindex="0">
            <div class="categoryDetail customContainer">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="category_filter pb-3 mb-3 d-flex align-items-center justify-content-between">
                            <h3 style="color: var(--secondry2-color);">{{ __('user_messages.sort_by') }}</h3>
                            <a data-bs-toggle="modal" data-bs-target="#sortMOdal">
                                <img src="{{asset('user')}}/assets/images/sort.svg" class="img-fluid" />
                            </a>
                        </div>
                        <div class="category_filter">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3>{{ __('user_messages.filters') }}</h3>
                                <a href="{{route('user.store_details',[request()->id])}}">{{ __('user_messages.clear') }}</a>
                            </div>
                            <form action="{{ url('user/store-details/' . request()->id) }}" method="GET">
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

                                            <input type="range" min="1" max="1000"
                                                value="{{ request()->price_max ?? 500 }}" id="priceRange"
                                                style="width:100%;">
                                            <input type="hidden" name="price_min" id="priceMin"
                                                value="{{ request()->price_min ?? 1 }}">
                                            <input type="hidden" name="price_max" id="priceMax"
                                                value="{{ request()->price_max ?? 500 }}">
                                        </div>

                                        <div class="ticks">
                                            <div class="tick text-start">1 {{ __('user_messages.kd') }}</div>
                                            <div class="tick text-end">1000 {{ __('user_messages.kd') }}</div>
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
                    <div class="col-lg-9">
                        <div class="categoryDetail_content">
                            <div class="row">

                                @forelse ($store_details['All_Product'] as $item)
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
                                                <span class="share-btn product" data-link="{{ route('user.product_details',[$item->id]) }}"><i class="fa-solid fa-share"></i></span>
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

                                                    ({{ "by " . $store_details['store']['store_name'] }})</h5>
                                                <!-- <div class="rating">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                    <span>(1K)</span>
                                                </div> -->
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
                                                <!-- <div class="price">
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
                                                </div> -->

                                                 <div class="price">
                                                    <strong>
                                                    {{ $currency }} {{ number_format(convertPriceInUserWeb($item->product_variants[0]->final_price), 2) }}
                                                    </strong>

                                                    <span class="old-price">
                                                    {{ $currency }} {{ number_format(convertPriceInUserWeb($item->product_variants[0]->actual_price), 2) }}
                                                    </span>

                                                    <span class="discount">
                                                    {{ $item->product_variants[0]->discount_value }}
                                                    {{ $item->product_variants[0]->discount_type == '1' 
                                                        ? '% ' . __('user_messages.off') 
                                                        : __('user_messages.off') 
                                                    }}
                                                    </span>
                                                </div>



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

                    @forelse($seller_reels as $reel)
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-img" data-reel='@json($reel)' style="position:relative; cursor:pointer;">
                                
                                @php
                                    $isVideo = preg_match('/\.(mp4|webm|ogg)$/i', $reel->file);
                                @endphp

                                @if($isVideo)
                                    <video src="{{ $reel->file }}" muted autoplay loop style="width:100%; height:100%; object-fit:cover;"></video>
                                @else
                                    <img src="{{ $reel->file }}" alt="Product" class="img-fluid">
                                @endif

                                <!-- Wishlist button -->
                                <button class="wishlist-btn reel-wishlist" data-reel-id="{{ $reel->id }}" style="position:absolute; top:10px; right:10px; z-index:10;">
                                    @if($reel->is_whishlisted==1)
                                        <img src="{{ asset('user/assets/images/reels_check.svg') }}" class="img-fluid" alt="check" />
                                    @else
                                        <i class="fa-regular fa-heart"></i>
                                    @endif
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="item text-center">
                            <p>{{ __('user_messages.no_reels_found') }}</p>
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
                    <h3 class="modal-title fs-5">{{ __('user_messages.sort_by') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort1" value="1"
                                {{ request('sort_filter') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort1">{{ __('user_messages.recommended') }}</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort2" value="2"
                                {{ request('sort_filter') == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort2">{{ __('user_messages.price') }}: {{ __('user_messages.low_to_high') }}</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort3" value="3"
                                {{ request('sort_filter') == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort3">{{ __('user_messages.price') }}: {{ __('user_messages.high_to_low') }}</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort4" value="4"
                                {{ request('sort_filter') == 4 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort4">{{ __('user_messages.newest_first') }}</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort5" value="5"
                                {{ request('sort_filter') == 5 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort5">{{ __('user_messages.customer_ratings') }}</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort6" value="6"
                                {{ request('sort_filter') == 6 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort6">{{ __('user_messages.best_selling') }}</label>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="sort_filter" id="sort7" value="7"
                                {{ request('sort_filter') == 7 ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort7">{{ __('user_messages.fastest_delivery') }}</label>
                        </div>

                    </div>

                    <div class="d-flex align-items-center gap-3 mt-3">
                        <a href="{{route('user.store_details',[request()->id])}}" id="clearSort"
                            class="custom-btn6 text-center w-100 text-white"
                            style="    text-decoration: auto;">{{ __('user_messages.clear') }}</a>
                        <button type="submit" class="custom-btn6" style="padding:8px 10px; color:#fff !important;">
                            {{ __('user_messages.apply') }}
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
            <div class="story-pnl-progress d-flex gap-3 p-3 align-item-center">
                <div class="box-story">
                    <img id="storyProfileImage"  src="{{asset('user/assets/images/desynat_fav_ic.svg')}}" alt="image" class="img-fluid">
                </div>
                <div class="hightop-2">
                    <div id="storyStoreName" class="storyTime">Desynat</div>
                    <div id="storyCreatedTime" class="storyTime">6 sec ago</div>
                </div>
            </div>
            
            <div class="status-img">
                <img id="statusImageSeller" class="img-fluid" style="display:none;" />
                
                <video id="statusVideoSeller"
                       style="width:100%; height:100%; object-fit:contain; display:none;"
                       controls autoplay muted>
                </video>
                <!-- <div id="adsTitle" class="adsTitle"></div> -->
            </div>
        </div>    
    </div>
</div>


<!-- New Highlight Story Viewer -->

<div class="status-viewer bgwhite" id="highlightViewer">
    <div class="container highlightStatus adminstatus">
        <div class="story-header d-flex justify-content-between">
            <div></div>
            <button type="button" class="btn btn-light" onclick="closeHighlightViewer()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="logostatus">
            <div id="progressContainerHighlight" class="progress-container"></div>
            
            <div class="p-2 hightop">
                <div class="storyTime">Highlight Name </div>
                <div class="storyTime">6 sec ago</div>
            </div>
            
            <div class="status-img">
                <img id="highlightImage" class="img-fluid" style="display:none;" />
                
                <video id="highlightVideo"
                       style="width:100%; height:100%; object-fit:contain; display:none;"
                       controls autoplay muted>
                </video>
            </div>
        </div>    
    </div>
</div>

<!-- New reel  Viewer -->

<div class="status-viewer bgwhite" id="reelViewer" style="display:none;">
    <div class="container reelStatus adminstatus">
        <div class="story-header d-flex justify-content-between">
            <div></div>
            <button type="button" class="btn btn-light" onclick="closeReelViewer()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="logostatus">
            <div id="progressContainerReel" class="progress-container"></div>

            <div class="status-img">
                <img id="reelImage" class="img-fluid" style="display:none;" />
                <video id="reelVideo" style="width:100%; height:100%; object-fit:contain; display:none;" controls autoplay muted></video>
            </div>

            <div class="add-caption">
                <p id="reelCaption"></p>
            </div>
            <div class="caption-share">
                <button class="wishlist-btn reel-wishlist" id="viewerWishlistBtn" data-reel-id=""><i class="fa-regular fa-heart"></i></button>
                <button class="share-btn reply-ic" id="shareReelBtn"><i class="bi bi-reply"></i></button>
            </div>
        </div>    
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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
        // bubble.textContent = val + " KD";
        bubble.textContent = `${val} {{ __('user_messages.kd') }}`;

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
        toastr.success("{{ __('user_messages.link_copied_to_clipboard') }}");
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
var sellerLoading = false;


// ================= PAGE LOAD CHECK STORY =================
$(document).ready(function () {

    loadSellerStoriesOnPageLoad();

});



// ================= LOAD STORY ON PAGE LOAD =================
function loadSellerStoriesOnPageLoad() {


    var sellerInput = document.getElementById("seller_id");


    if (!sellerInput) {

        return;

    }


    var seller_id = sellerInput.value;



    $.ajax({

        url: "{{ route('user.get_seller_story') }}",

        type: "GET",

        dataType: "json",


        data: {

            seller_id: seller_id

        },


        success: function(res) {


            if (res.status === "success" && Array.isArray(res.data.data)) {


                sellerStories = res.data.data;


            } else {


                sellerStories = [];


            }



            var profileDiv = document.querySelector('.storeClient_profile_img');



            if (sellerStories.length > 0) {


                if(profileDiv){

                    profileDiv.classList.add('story-active');

                }


            } else {


                if(profileDiv){

                    profileDiv.classList.remove('story-active');

                }


            }


        },


        error: function(err) {


            console.error("[SELLER] Initial story load error:", err);


            sellerStories = [];


        }


    });


}





// ================= CLICK HANDLER =================

function openSellerGallery(index = 0) {


    console.log("[SELLER] Clicked");


    if (sellerLoading) {

        return;

    }



    if (sellerStories === null) {


        loadSellerStories(index);


    } 

    else if (sellerStories.length > 0) {


        showSellerGallery(index);


    } 

    else {


        return;

    }

}





// ================= LOAD STORIES FROM API =================

function loadSellerStories(openIndex = 0) {


    sellerLoading = true;


    var sellerInput = document.getElementById("seller_id");



    if (!sellerInput) {


        sellerLoading = false;

        return;


    }



    var seller_id = sellerInput.value;



    $.ajax({


        url: "{{ route('user.get_seller_story') }}",

        type: "GET",

        dataType: "json",


        data: {


            seller_id: seller_id


        },


        success: function(res) {


            sellerLoading = false;



            if (res.status === "success" && Array.isArray(res.data.data)) {


                sellerStories = res.data.data;


            } else {


                sellerStories = [];


            }




            var profileDiv = document.querySelector('.storeClient_profile_img');



            if (sellerStories.length > 0) {


                if(profileDiv){


                    profileDiv.classList.add('story-active');


                }


            } else {


                if(profileDiv){


                    profileDiv.classList.remove('story-active');


                }


            }




            if (sellerStories.length > 0) {


                showSellerGallery(openIndex);


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


    sellerIndex = index;


    var container = document.getElementById("statusSeller");


    if (!container) {


        return;


    }


    container.style.display = "block";


    generateSellerProgressBars();

    showSellerStory();


}






function generateSellerProgressBars() {


    var container = document.getElementById("progressContainerSeller");


    if (!container) {


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



    if (!story) {


        closeSellerStatus();

        return;


    }
    updateStoryHeader(story);



    var img = document.getElementById("statusImageSeller");

    var video = document.getElementById("statusVideoSeller");

    // const adsTitle = document.getElementById("adsTitle");

    // if (adsTitle) {
    //     if (story.payment_status == "1") {
    //         adsTitle.textContent = "{{ app()->getLocale() == 'ar' ? 'إعلان' : 'Ad' }}";
    //         adsTitle.style.display = "block";
    //     } else {
    //         adsTitle.textContent = "";
    //         adsTitle.style.display = "none";
    //     }
    // }



    if (!img || !video) {


        return;


    }



    img.style.display = "none";

    video.style.display = "none";


    video.pause();

    video.currentTime = 0;




    var file = story.file;



    if (!file) {


        showNextSeller();

        return;


    }




    if (file.match(/\.(mp4|webm|ogg)$/i)) {



        video.src = file;

        video.style.display = "block";

        video.controls = true;



        video.onloadedmetadata = function () {


            sellerDuration = (video.duration * 1000) || 3000;


            startSellerProgress();


            video.play().catch(e => console.warn(e));


        };



        video.onerror = function () {


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



        if(bar){


            bar.style.transition = sellerDuration + "ms linear";

            bar.style.width = "100%";


        }


    },10);





    sellerTimer = setTimeout(() => {


        showNextSeller();


    }, sellerDuration);



}







function showNextSeller(){


    if(sellerIndex < sellerStories.length - 1){


        sellerIndex++;

        showSellerStory();


    } else {


        closeSellerStatus();


    }


}






function showPrevSeller(){


    if(sellerIndex > 0){


        sellerIndex--;

        showSellerStory();


    }


}






function closeSellerStatus(){


    clearTimeout(sellerTimer);



    var video = document.getElementById("statusVideoSeller");



    if(video){


        video.pause();

        video.currentTime = 0;


    }




    var container = document.getElementById("statusSeller");



    if(container){


        container.style.display = "none";


    }


}

function updateStoryHeader(story) {

    const storyStoreName = document.getElementById("storyStoreName");
    const storyCreatedTime = document.getElementById("storyCreatedTime");
    const storyProfileImage = document.getElementById("storyProfileImage");

    if (!storyStoreName || !storyCreatedTime) {
        return;
    }

        // Seller store name
            if (story.seller_details) {

            const firstName = story.seller_details.first_name || "";
            const lastName = story.seller_details.last_name || "";

            storyStoreName.textContent =
                (firstName + " " + lastName).trim();

        } else {

            storyStoreName.textContent = "";

        }


        // Seller store image
        if (
            story.seller_details &&
            story.seller_details.store_info &&
            story.seller_details.store_info.store_image
        ) {

            storyProfileImage.src =
                story.seller_details.store_info.store_image;

        }


    if (story.created_at) {

        storyCreatedTime.textContent =
            getStoryTimeAgo(story.created_at);

    }

}

function getStoryTimeAgo(createdAt) {

    const createdDate = new Date(createdAt);

    if (isNaN(createdDate.getTime())) {
        return "";
    }

    const now = new Date();

    let seconds = Math.floor(
        (now.getTime() - createdDate.getTime()) / 1000
    );

    if (seconds < 0) {
        seconds = 0;
    }


    if (seconds < 60) {

        return seconds + " sec ago";

    }


    const minutes = Math.floor(seconds / 60);

    if (minutes < 60) {

        return minutes + " min ago";

    }


    const hours = Math.floor(minutes / 60);

    if (hours < 24) {

        return hours + " hour" + (hours > 1 ? "s" : "") + " ago";

    }


    const days = Math.floor(hours / 24);

    if (days < 30) {

        return days + " day" + (days > 1 ? "s" : "") + " ago";

    }


    const months = Math.floor(days / 30);

    if (months < 12) {

        return months + " month" + (months > 1 ? "s" : "") + " ago";

    }


    const years = Math.floor(months / 12);

    return years + " year" + (years > 1 ? "s" : "") + " ago";
}


</script>


 <!-- highlight -->
<script>
// let highlightTimer = null;
// let highlightDuration = 3000; // default for images

// function openHighlightViewer(highlight) {
//     clearTimeout(highlightTimer);

//     const imageEl = document.getElementById("highlightImage");
//     const videoEl = document.getElementById("highlightVideo");
//     const progressContainer = document.getElementById("progressContainerHighlight");

//     // Hide previous media
//     imageEl.style.display = "none";
//     videoEl.style.display = "none";
//     videoEl.pause();
//     videoEl.src = "";

//     // Reset progress bar
//     progressContainer.innerHTML = `
//         <div class="progress-bar" style="width:100%; height:4px; background:#ddd;">
//             <div class="progress-fill" id="highlightProgressFill" style="width:0%; height:100%; background:#007bff;"></div>
//         </div>
//     `;
//     const progressFill = document.getElementById("highlightProgressFill");

//     const file = highlight.file;
//     const isVideo = file.match(/\.(mp4|webm|ogg)$/i);

//     if (isVideo) {
//         videoEl.src = file;
//         videoEl.style.display = "block";

//         videoEl.onloadedmetadata = function() {
//             highlightDuration = videoEl.duration * 1000;
//             startHighlightProgress(progressFill, highlightDuration, closeHighlightViewer);
//         };

//         videoEl.onended = function() {
//             closeHighlightViewer();
//         };
//     } else {
//         imageEl.src = file;
//         imageEl.style.display = "block";
//         highlightDuration = 3000;
//         startHighlightProgress(progressFill, highlightDuration, closeHighlightViewer);
//     }

//     document.getElementById("highlightViewer").style.display = "block";
// }

// function startHighlightProgress(progressEl, duration, callback) {
//     clearTimeout(highlightTimer);

//     // Reset progress
//     progressEl.style.transition = "none";
//     progressEl.style.width = "0%";

//     // Trigger animation
//     setTimeout(() => {
//         progressEl.style.transition = `width ${duration}ms linear`;
//         progressEl.style.width = "100%";
//     }, 50);

//     highlightTimer = setTimeout(callback, duration);
// }

// function closeHighlightViewer() {
//     clearTimeout(highlightTimer);

//     const imageEl = document.getElementById("highlightImage");
//     const videoEl = document.getElementById("highlightVideo");
//     const progressFill = document.getElementById("highlightProgressFill");

//     document.getElementById("highlightViewer").style.display = "none";

//     imageEl.style.display = "none";
//     videoEl.pause();
//     videoEl.style.display = "none";

//     if (progressFill) {
//         progressFill.style.transition = "none";
//         progressFill.style.width = "0%";
//     }
// }

let highlightStories = [];
let highlightIndex = 0;
let highlightTimer = null;


// OPEN VIEWER
function openHighlightViewer(highlightGroup) {

    clearTimeout(highlightTimer);

    highlightStories = highlightGroup.highlights;
    highlightIndex = 0;


    document.getElementById("highlightViewer").style.display = "block";


    renderHighlightProgress();


    showHighlight();

}



// CREATE ALL PROGRESS BARS
function renderHighlightProgress() {

    const container = document.getElementById("progressContainerHighlight");

    container.innerHTML = "";


    highlightStories.forEach((item,index)=>{

        container.innerHTML += `
            <div style="flex:1;margin:2px;background:#ddd;height:4px;">
                <div id="highlightProgress_${index}"
                     style="width:0%;height:100%;background:#007bff;">
                </div>
            </div>
        `;

    });

}



// SHOW CURRENT HIGHLIGHT
function showHighlight(){

    clearTimeout(highlightTimer);


    if(highlightIndex >= highlightStories.length){

        closeHighlightViewer();
        return;

    }


    const highlight = highlightStories[highlightIndex];


    const imageEl = document.getElementById("highlightImage");
    const videoEl = document.getElementById("highlightVideo");


    // Reset media

    imageEl.style.display = "none";
    imageEl.src = "";


    videoEl.pause();
    videoEl.src = "";
    videoEl.style.display = "none";



    // Update progress bars

    highlightStories.forEach((item,index)=>{

        let bar = document.getElementById(
            `highlightProgress_${index}`
        );


        if(!bar) return;


        if(index < highlightIndex){

            bar.style.width = "100%";

        }else{

            bar.style.width = "0%";

        }

    });



    let currentBar = document.getElementById(
        `highlightProgress_${highlightIndex}`
    );



    let file = highlight.file;


    let isVideo = file.match(/\.(mp4|webm|ogg)$/i);



    if(isVideo){


        videoEl.src = file;

        videoEl.muted = true;
        videoEl.autoplay = true;
        videoEl.playsInline = true;

        videoEl.style.display = "block";



        videoEl.onloadedmetadata = function(){

            videoEl.play();


            startHighlightProgress(
                currentBar,
                videoEl.duration * 1000
            );

        };



        videoEl.onended = function(){

            nextHighlight();

        };


    }else{


        imageEl.src = file;

        imageEl.style.display = "block";


        startHighlightProgress(
            currentBar,
            3000
        );

    }

}



// PROGRESS ANIMATION
function startHighlightProgress(progressEl,duration){

    clearTimeout(highlightTimer);


    progressEl.style.transition="none";
    progressEl.style.width="0%";


    setTimeout(()=>{

        progressEl.style.transition =
            `width ${duration}ms linear`;

        progressEl.style.width="100%";


    },50);



    highlightTimer=setTimeout(()=>{

        nextHighlight();

    },duration);

}



// NEXT
function nextHighlight(){

    highlightIndex++;


    if(highlightIndex >= highlightStories.length){

        closeHighlightViewer();

    }else{

        showHighlight();

    }

}



// CLOSE
function closeHighlightViewer(){

    clearTimeout(highlightTimer);


    document.getElementById("highlightViewer").style.display="none";


    const imageEl=document.getElementById("highlightImage");
    const videoEl=document.getElementById("highlightVideo");


    imageEl.style.display="none";


    videoEl.pause();
    videoEl.src="";
    videoEl.style.display="none";


    highlightStories=[];
    highlightIndex=0;


    document.getElementById(
        "progressContainerHighlight"
    ).innerHTML="";

}
</script>

<!-- reel -->

<script>
let reelTimer = null;
let reelDuration = 3000;

// OPEN VIEWER
function openReelViewer(reel){
    clearTimeout(reelTimer);

    const imageEl = document.getElementById("reelImage");
    const videoEl = document.getElementById("reelVideo");
    const progressContainer = document.getElementById("progressContainerReel");

    imageEl.style.display = "none";
    videoEl.style.display = "none";
    videoEl.pause();
    videoEl.src = "";

    // Reset progress bar
    progressContainer.innerHTML = `
        <div class="progress-bar" style="width:100%; height:4px; background:#ddd;">
            <div class="progress-fill" id="reelProgressFill" style="width:0%; height:100%; background:#007bff;"></div>
        </div>
    `;
    const progressFill = document.getElementById("reelProgressFill");

    const file = reel.file;
    const isVideo = file.match(/\.(mp4|webm|ogg)$/i);

    if(isVideo){
        videoEl.src = file;
        videoEl.style.display = "block";
        videoEl.muted = true;
        videoEl.play().catch(err => console.warn("Video play error:", err));

        videoEl.onloadedmetadata = function(){
            reelDuration = videoEl.duration * 1000;
            startReelProgress(progressFill, reelDuration, closeReelViewer);
        }

        videoEl.onended = function(){
            closeReelViewer();
        }
    } else {
        imageEl.src = file;
        imageEl.style.display = "block";
        reelDuration = 3000;
        startReelProgress(progressFill, reelDuration, closeReelViewer);
    }

    // ✅ SET CAPTION
    document.getElementById("reelCaption").innerText = reel.caption ?? '';

    // ✅ SET WISHLIST BUTTON DATA + STATE
    const wishlistBtn = document.getElementById("viewerWishlistBtn");
    wishlistBtn.setAttribute("data-reel-id", reel.id);

    if(reel.is_whishlisted == 1){
        wishlistBtn.innerHTML = '<img src="/user/assets/images/reels_check.svg" class="img-fluid" alt="check" />';
    } else {
        wishlistBtn.innerHTML = '<i class="fa-regular fa-heart"></i>';
    }

    // ✅ SET SHARE FILE
    document.getElementById("shareReelBtn").setAttribute("data-file", reel.file);

    document.getElementById("reelViewer").style.display = "block";
}

// PROGRESS BAR
function startReelProgress(progressEl, duration, callback){
    clearTimeout(reelTimer);
    progressEl.style.transition = "none";
    progressEl.style.width = "0%";

    setTimeout(()=>{
        progressEl.style.transition = `width ${duration}ms linear`;
        progressEl.style.width = "100%";
    },50);

    reelTimer = setTimeout(callback, duration);
}

// CLOSE VIEWER
function closeReelViewer(){
    clearTimeout(reelTimer);

    const imageEl = document.getElementById("reelImage");
    const videoEl = document.getElementById("reelVideo");
    const progressFill = document.getElementById("reelProgressFill");

    document.getElementById("reelViewer").style.display = "none";

    imageEl.style.display = "none";

    videoEl.pause();
    videoEl.style.display = "none";

    if(progressFill){
        progressFill.style.transition = "none";
        progressFill.style.width = "0%";
    }
}

$(document).ready(function(){

    // CLICK ON REEL (IGNORE WISHLIST BUTTON)
    $(document).on('click', '.product-img', function(e){
        if($(e.target).closest('.wishlist-btn.reel').length) return;

        const reel = JSON.parse($(this).attr('data-reel'));
        openReelViewer(reel);
    });

    // WISHLIST AJAX (UNCHANGED)
     $(document).on('click', '.reel-wishlist', function(e){
        e.stopPropagation();

        const button = $(this);
        const reelId = button.data('reel-id');

        $.ajax({
            url: "{{ route('user.add_remove_reel_to_whishlist') }}",
            type: "POST",
            data: { reel_id: reelId, _token: "{{ csrf_token() }}" },
            success: function(response){
                if(response.status === 'success'){
                    if(button.find('i').length){
                        button.html('<img src="{{ asset('user/assets/images/reels_check.svg') }}" class="img-fluid" alt="check" />');
                    } else {
                        button.html('<i class="fa-regular fa-heart"></i>');
                    }
                    toastr.success(response.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Something went wrong');
                }
            },
            error: function(xhr){
                var msg = 'Something went wrong';
                if(xhr.responseJSON && xhr.responseJSON.message){
                    msg = xhr.responseJSON.message;
                }
                toastr.error(msg);
            }
        });
    });

    // ✅ SHARE BUTTON (COPY LINK)
    $(document).on('click', '#shareReelBtn', function(e){
        e.stopPropagation();

        const file = $(this).attr('data-file');

        if(!file){
            toastr.error('No link found');
            return;
        }

        navigator.clipboard.writeText(file)
        .then(function(){
            toastr.success("{{ __('user_messages.link_copied_to_clipboard') }}");
        })
        .catch(function(){
            toastr.error('Failed to copy link');
        });
    });

});
</script>

<script>
$(document).ready(function () {

    let seller_id = $('#seller_id').val();

    // get store_id from URL (last segment)
    let store_id = window.location.pathname.split('/').pop();

    $.ajax({
        url: "{{ route('user.CaptureSellerStoreVisitorWeb') }}",
        type: "POST",
        data: {
            seller_id: seller_id,
            store_id: store_id,
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
           // console.log('Visitor captured:', response);
        },
        error: function (xhr) {
           // console.log('Error:', xhr.responseJSON);
        }
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
                toastr.success('Link copied to clipboard');
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
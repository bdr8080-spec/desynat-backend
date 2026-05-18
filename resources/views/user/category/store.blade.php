@extends('user.layout.app')

@section('content')

<style>
.story-active{
    border: 4px solid transparent!important;
    background: linear-gradient(#fff, #fff) padding-box, linear-gradient(to bottom left, #DFBF8F, #6E4527) border-box;
}
</style>
    <div class="customContainer">
        <div class="owl-carousel owl-theme customcatOwlcarousel storeBanner">
            @if(empty($catBanners['data']) || count($catBanners['data']) == 0)
                <div class="item">
                    <div class="Bannerstores">
                        <img src="{{ asset('user/') }}/assets/images/category-img.svg" class="img-fluid" />
                    </div>
                </div>
                @else
                    @foreach($catBanners['data'] as $banner)
                        <div class="premiumImg">
                            <a href="{{ url('user/store-details/' . ($banner->seller_details->store_info->id ?? '')) }}">
                                <img src="{{ $banner->upload_banner }}" class="img-fluid" />
                            </a>
                        </div>
                    @endforeach
            @endif
           
           
        </div>
    </div>

    <div class="categoryDetail customContainer">
        <div class="row">
            <div class="col-lg-4">
                <div class="category_filter">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3>{{ __('user_messages.filter') }}</h3>
                        <a href="{{ url('user/category-wise-store/' . request()->id)}}">{{ __('user_messages.clear') }}</a>
                    </div>
                    <form action="{{ url('user/category-wise-store/' . request()->id) }}" method="GET">
                        <div class="form-group mt-4">
                            <h5>{{ __('user_messages.ratings') }}</h5>

                            <div class="form-check my-4">
                                <input class="form-check-input mb-1" type="checkbox" 
                                    value="2" id="rating2" name="rating[]"  {{ is_array(request()->rating) && in_array('2', request()->rating) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating2">
                                    {{ __('user_messages.upto_2_star') }}
                                </label>
                            </div>

                            <div class="form-check my-4">
                                <input class="form-check-input" type="checkbox" 
                                    value="3" id="rating3" name="rating[]"  {{ is_array(request()->rating) && in_array('3', request()->rating) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating3">
                                    {{ __('user_messages.upto_3_star') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>{{ __('user_messages.availability') }}</h5>

                            <div class="form-check my-4">
                                <input class="form-check-input" type="radio" 
                                    name="availability" value="1" id="availability_open" {{request()->availability == '1' ? 'checked' : ''}}>
                                <label class="form-check-label" for="availability_open">
                                    {{ __('user_messages.open') }}
                                </label>
                            </div>

                            <div class="form-check my-4">
                                <input class="form-check-input" type="radio" 
                                    name="availability" value="0" id="availability_busy" {{request()->availability == '0' ? 'checked' : ''}}>
                                <label class="form-check-label" for="availability_busy">
                                    {{ __('user_messages.busy') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group delivery">
                            <h5>{{ __('user_messages.sort_preference') }}</h5>

                            <div class="form-check my-4">
                                <input class="form-check-input" name="sort[]" type="checkbox" 
                                    value="0" id="delivery_short" {{ is_array(request()->sort) && in_array('0', request()->sort) ? 'checked' : '' }}>
                                <label class="form-check-label" for="delivery_short">
                                    {{ __('user_messages.shortest_delivery_time') }}
                                </label>
                            </div>

                            <div class="form-check my-4">
                                <input class="form-check-input" name="sort[]" type="checkbox" 
                                    value="1" id="high_sale" {{ is_array(request()->sort) && in_array('1', request()->sort) ? 'checked' : '' }}>
                                <label class="form-check-label" for="high_sale">
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
                    <form action="{{ url('user/category-wise-store/' . request()->id) }}" method="GET">
                        <div class="seArch">
                            <div class="form-group position-relative search">
                                <input type="text" class="form-control" placeholder="{{ __('user_messages.search') }}" name="search" value="{{request()->search}}" />
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button class="customBtn customBtn5">{{ __('user_messages.search') }}</button>
                        </div>
                    </form>

                    <div class="row">

                        @forelse ($store_data as $item)
                            <div class="col-lg-4 col-md-4 col-6 my-3">
                                <a  href="{{route('user.store_details',[$item->id])}}" style="text-decoration:none;">
                                    <div class="category-store">
                                        <div class="category_store_img">
                                            <img src="{{ $item->store_image }}" class="img-fluid" />
                                        </div>
                                        <div class="category-store-content">
                                            <div class="user-infoCat_detail d-flex align-items-center">
                                                <div class="user sellerStory" id="sellerStory{{ $item->seller_information->id }}">
                                                    <img src="{{ $item->seller_information->profile_pic }}"
                                                        class="img-fluid" style="cursor:pointer" onclick="openSellerGallery(event, {{ $item->seller_information->id }})" />
                                                </div>
                                                {{-- <p>{{ $item->seller_information->first_name }}
                                                    {{ $item->seller_information->last_name }}</p> --}}
                                                    <p> {{$item->store_name}}</p>
                                            </div>
                                            <div class="rate-content d-flex align-items-center">
                                                <div class="rate">
                                                    @php
                                                        $rating = $item->average_store_rating ?? 0;

                                                        $fullStars = floor($rating);
                                                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                                    @endphp

                                                    @if($rating > 0)

                                                        @for($i = 0; $i < $fullStars; $i++)
                                                            <span><i class="bi bi-star-fill"></i></span>
                                                        @endfor

                                                        @if($hasHalfStar)
                                                            <span><i class="bi bi-star-half"></i></span>
                                                        @endif

                                                        @for($i = 0; $i < $emptyStars; $i++)
                                                            <span><i class="bi bi-star"></i></span>
                                                        @endfor

                                                    @else

                                                        @for($i = 0; $i < 5; $i++)
                                                            <span><i class="bi bi-star"></i></span>
                                                        @endfor

                                                    @endif
                                                </div>
                                                <p>({{ $item->total_review_count ?? 0 }})</p>

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

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>

var sellerStories = [];
var sellerIndex = 0;
var sellerTimer = null;
var sellerDuration = 3000;
var sellerLoading = false;
var currentSellerId = null;

// ================= CLICK HANDLER =================
function openSellerGallery(event, sellerId, index = 0) {

    event.preventDefault();
    event.stopPropagation();

    if (sellerLoading) return;

    currentSellerId = sellerId;
    sellerIndex = index;

    loadSellerStories(sellerId, index);
}

// ================= LOAD STORIES =================
function loadSellerStories(seller_id, openIndex = 0) {

    sellerLoading = true;

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

            const profileDiv = document.getElementById("sellerStory" + seller_id);

            const hasStories = sellerStories.length > 0;

            if (profileDiv) {
                profileDiv.classList.toggle("story-active", hasStories);
            }

            if (hasStories) {
                showSellerGallery(openIndex);
            }
        },

        error: function(err) {

            sellerLoading = false;
            sellerStories = [];
            console.error(err);
        }
    });
}

// ================= SHOW GALLERY =================
function showSellerGallery(index) {

    sellerIndex = index;

    var container = document.getElementById("statusSeller");

    if (!container) return;

    container.style.display = "block";

    generateSellerProgressBars();
    showSellerStory();
}

// ================= PROGRESS BARS =================
function generateSellerProgressBars() {

    var container = document.getElementById("progressContainerSeller");

    if (!container) return;

    container.innerHTML = "";

    sellerStories.forEach((s, i) => {
        container.innerHTML += `
            <div class="progress-bar">
                <div class="progress-fill" id="sellerBar${i}"></div>
            </div>
        `;
    });
}

// ================= SHOW STORY =================
function showSellerStory() {

    var story = sellerStories[sellerIndex];

    if (!story) {
        closeSellerStatus();
        return;
    }

    var img = document.getElementById("statusImageSeller");
    var video = document.getElementById("statusVideoSeller");

    if (!img || !video) return;

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
            video.play().catch(() => {});
        };

        video.onerror = function () {
            showNextSeller();
        };

    } else {

        img.src = file;
        img.style.display = "block";

        sellerDuration = 3000;
        startSellerProgress();
    }
}

// ================= PROGRESS =================
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

// ================= NEXT STORY =================
function showNextSeller() {

    if (sellerIndex < sellerStories.length - 1) {
        sellerIndex++;
        showSellerStory();
    } else {
        closeSellerStatus();
    }
}

// ================= PREV STORY =================
function showPrevSeller() {

    if (sellerIndex > 0) {
        sellerIndex--;
        showSellerStory();
    }
}

// ================= CLOSE =================
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


@endsection
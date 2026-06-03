@extends('admin.layout.app')
@section('content')

<style>
.deleteReelBtn {
    background: var(--bg-color) !important;
    color: #fff;
    border: none;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 6px;
    cursor: pointer;
}
</style>

<div class="inner-content management">

    <div class="d-flex gap-2 align-items-center">
        <a href="{{route('sellerManagement')}}"><i class="bi bi-chevron-left"></i></a>
        <h2 class="h2">{{ __('admin_messages.seller_details') }}</h2>
    </div>

    <div class="brand-banner">
        <img src="https://d79swovq1y56s.cloudfront.net/uploads/lAHVxEhGIV.png" alt="Profile" class="img-fluid">
    </div>

    <div class="mb-5 viewSeller">
        <div class="profile-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="user_view">
                        <div class="position-relative">
                            <div class="addprofile">
                                <img src="https://d79swovq1y56s.cloudfront.net/profile/1777366604.jpg"
                                    class="img-fluid">
                            </div>
                        </div>
                        <div class="user_content">
                            <h5 class="mb-0">{{$data['first_name']}} {{$data['last_name']}}</h5>
                            <small class="text-muted">{{$data['country_code']}} {{$data['mobile']}}</small><br>
                            <small class="text-muted">{{$data['email']}}</small>
                            @php
                                $rating = $data['average_store_rating'] ?? 0;

                                $fullStars = floor($rating);

                                // Show half star only when decimal part is >= 0.5
                                $decimal = $rating - $fullStars;
                                $hasHalfStar = $decimal >= 0.5;

                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            <div class="star-rating mt-1">
                                {{-- Full Stars --}}
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor

                                {{-- Half Star --}}
                                @if ($hasHalfStar)
                                    <i class="bi bi-star-half"></i>
                                @endif

                                {{-- Empty Stars --}}
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="bi bi-star"></i>
                                @endfor

                                <span class="text-black"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h6 class="fw-bold"> {{$data['store_info']['store_name'] ?? __('admin_messages.n/a')}} </h6>
                <small class="text-muted"> {{$data['store_info']['country_code'] ?? __('admin_messages.n/a')}} {{$data['store_info']['store_phone'] }} </small><br>
                <small class="text-muted"> {{$data['store_info']['store_mail_id'] ?? __('admin_messages.n/a')}}</small>
                <div class="mt-2 mb-0"> {{$data['store_info']['store_address'] ?? __('admin_messages.n/a')}} </div>
            </div>
        </div>

        <div class="py-2">
            <h5 class="h2">{{ __('admin_messages.total_orders') }}({{$data['total_orders']}})</h5>
        </div>
        <div class="order-total">
            <div class="row mt-0">
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex mb-3">
                        <div class="dash-content">
                            <h5>{{ __('admin_messages.completed') }}  </h5>
                            <div class="title30">{{$data['total_completed_orders']}}</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex mb-3">
                        <div class="dash-content">
                            <h5>{{ __('admin_messages.cancelled') }}  </h5>
                            <div class="title30">{{$data['total_cancelled_orders']}}</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex">
                        <div class="dash-content">
                            <h5>{{ __('admin_messages.total_earnings') }}  </h5>
                            <div class="title30">{{$data['total_earning']}} {{ __('admin_messages.kd') }}</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex">
                        <div class="dash-content">
                            <h5>{{ __('admin_messages.commission') }}  </h5>
                            <div class="title30">0 {{ __('admin_messages.kd') }}</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>


        <div class="py-3">
            <h5 class="h2">{{ __('admin_messages.highlights') }}</h5>
        </div>

        <div class="product-row d-flex align-items-center gap-2 profile-card">
            @if(!empty($data['highlights']) && count($data['highlights']) > 0)
                @foreach($data['highlights'] as $index => $highlight)
                    <div class="product-item" onclick='openSellerHighlightViewer(@json($highlight))'>
                        @php
                            $extension = pathinfo($highlight['file'], PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                            <video class="product-circle" autoplay muted loop playsinline>
                                <source src="{{ $highlight['file'] }}" type="video/{{ $extension }}">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <img src="{{ $highlight['file'] }}" class="product-circle">
                        @endif

                        <small>{{ $highlight['title'] ?? '' }}</small>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p>{{ __('admin_messages.no_data_found') }}</p>
                </div>
            @endif


        </div>

        <div class="reels-wrapper mt-4 pb-5">
            <div class="py-3">
                <h5 class="h2">{{ __('admin_messages.story') }}</h5>
            </div>

            <div class="row">
                @if(!empty($data['stories']) && count($data['stories']) > 0)

                    @foreach($data['stories'] as $index => $story)
                        <div class="col-lg-3 col-md-3 mb-3">
                            <div class="reels-grid" onclick="showStory({{ $index }})">
                                <div class="reel-card">
                                    @php
                                        $extension = pathinfo($story['file'], PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                        <video class="img-fluid" autoplay muted loop playsinline>
                                            <source src="{{ $story['file'] }}" type="video/{{ strtolower($extension) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ $story['file'] }}" alt="image" class="img-fluid">
                                    @endif
                                </div>
                            </div>

                            <div class="text-center mt-2">
                                <button class="deleteStoryBtn" data-id="{{ $story['id'] }}">
                                    {{ __('admin_messages.delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="col-12 text-center">
                        <p>{{ __('admin_messages.no_data_found') }}</p>
                    </div>
                @endif
            </div>

        </div>

        <div class="reels-wrapper mt-4 pb-5">
            <div class="py-3">
                <h5 class="h2">{{ __('admin_messages.reels') }}</h5>
            </div>

            <div class="row">
                @if(!empty($data['reels']) && count($data['reels']) > 0)

                    @foreach($data['reels'] as $index => $reel)
                        <div class="col-lg-3 col-md-3 mb-3">
                            <div class="reels-grid" onclick="showReels({{ $index }})">
                                <div class="reel-card">
                                    @php
                                        $extension = pathinfo($reel['file'], PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                        <video class="img-fluid" autoplay muted loop playsinline>
                                            <source src="{{ $reel['file'] }}" type="video/{{ strtolower($extension) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ $reel['file'] }}" alt="image" class="img-fluid">
                                    @endif
                                </div>
                            </div>

                            <div class="text-center mt-2">
                                <button class="deleteReelBtn" data-id="{{ $reel['id'] }}">
                                    {{ __('admin_messages.delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="col-12 text-center">
                        <p>{{ __('admin_messages.no_data_found') }}</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

    <!-- Seller Highlight Viewer Modal -->
    <div class="status-viewer bgwhite" id="sellerHighlightViewer" style="display:none;">
        <div class="container highlightStatus">
            <div class="story-header d-flex justify-content-between">
                <div></div>
                <button type="button" class="btn btn-light" onclick="closeSellerHighlightViewer()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="logostatus">
                <div id="sellerProgressContainer" class="progress-container"></div>
                
                <div class="status-img">
                    <img id="sellerHighlightImage" class="img-fluid" style="display:none;" />
                    
                    <video id="sellerHighlightVideo"
                        style="width:100%; height:100%; object-fit:contain; display:none;"
                        controls autoplay muted>
                    </video>
                </div>
            </div>    
        </div>
    </div>

    <!--  story show  section -->
    <div class="status-viewer bgwhite" id="storyview">
        <div class="container">
            <div class="story-header d-flex justify-content-between py-4">
                <div class="d-flex gap-2">
                    <a href="javascript:void(0)" onclick="closeStatus3()"><i class="bi bi-chevron-left"></i> </a>
                    <h3>{{ __('admin_messages.story') }} </h3>
                </div>
                <button type="button" class="btn btn-light" onclick="closeStatus3()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="logostatus">
                <label class="status-img">
                    <div class="status-img" id="previewContainer">
                        <img id="showImageStory" class="img-fluid" style="display:none;" />
                        <video id="showVideoStory" class="img-fluid" controls style="display:none;"></video>
                    </div>
                </label>
            </div>

            <div class="dashboard-button mt-4 logostatus bgwhite d-flex justify-content-center gap-4" id="reelActions">
            </div>
        </div>
    </div>

    <!--  reeels show  section -->
    <div class="status-viewer bgwhite" id="reelsview">
        <div class="container">
            <div class="story-header d-flex justify-content-between py-4">
                <div class="d-flex gap-2">
                    <a href="javascript:void(0)" onclick="closeStatus2()"><i class="bi bi-chevron-left"></i> </a>
                    <h3>{{ __('seller_messages.Reel') }} </h3>
                </div>
                <button type="button" class="btn btn-light" onclick="closeStatus2()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="logostatus">
                <label class="status-img">
                    <div class="status-img" id="previewContainer">
                        <img id="showImageReel" class="img-fluid" style="display:none;" />
                        <video id="showVideoReel" class="img-fluid" controls style="display:none;"></video>
                    </div>
                </label>
                <div class="add-caption">
                    <h6 id="reelAddedOn">Added On 02/04/2026</h6>
                    <p id="reelCaption">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam iure enim laudantium labore veniam necessitatibus illo alias aperiam harum</p>
                </div>
            </div>

            <div class="dashboard-button mt-4 logostatus bgwhite d-flex justify-content-center gap-4" id="reelActions">
            </div>
        </div>
    </div>

</div>








@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    var reels = @json($data['reels'] ?? []);
    var currentReelIndex = null;

    document.addEventListener('DOMContentLoaded', function () {
        $("#reelsview").hide();
    });

    function showReels(index) {

        if (!reels.length || !reels[index]) return;

        $("#reelsview").show();
        currentReelIndex = index;

        var reel = reels[index];
        var file = reel.file || '';

        // Format date
        var addedOn = "N/A";

        if (reel.created_at) {
            var date = new Date(reel.created_at);
            addedOn =
                String(date.getDate()).padStart(2, '0') + '/' +
                String(date.getMonth() + 1).padStart(2, '0') + '/' +
                date.getFullYear();
        }

        var caption = (reel.caption && reel.caption.trim()) ? reel.caption : "N/A";

        var img = $("#showImageReel");
        var video = $("#showVideoReel");

        // reset
        img.hide().attr("src", "");
        video.hide();

        var videoEl = video.get(0);
        if (videoEl) {
            videoEl.pause();
            videoEl.src = "";
        }

        // show media
        if (/\.(mp4|webm|ogg)$/i.test(file)) {
            video.attr("src", file).show();

            if (videoEl) {
                videoEl.load();
                videoEl.play();
            }
        } else {
            img.attr("src", file).show();
        }

        $("#reelAddedOn").text("Added On " + addedOn);
        $("#reelCaption").text(caption);
    }

    function closeStatus2() {

        $("#reelsview").hide();

        var video = $("#showVideoReel").get(0);
        if (video) {
            video.pause();
            video.src = "";
        }
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.deleteReelBtn').forEach(button => {

        button.addEventListener('click', function () {

            let reelId = this.getAttribute('data-id');
            let reelElement = document.getElementById('reel-' + reelId);

            Swal.fire({
                title: "{{ __('admin_messages.are_you_sure?') }}",
                text: "{{ __('admin_messages.you_wont_be_able_to_revert_this') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "{{ __('admin_messages.yes_delete_it') }}",
                cancelButtonText: "{{ __('admin_messages.cancel') }}"
            }).then((result) => {

                if (result.isConfirmed) {

                    fetch(`/admin/deleteReel/${reelId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status === 'success') {

                            toastr.success(data.message);

                             setTimeout(() => location.reload(), 1000);

                        } else {
                            toastr.error(data.message);
                        }

                    })
                    .catch(() => {
                        toastr.error('Something went wrong.');
                    });

                }

            });

        });

    });

});
</script>

<script>
    var stories = @json($data['stories'] ?? []);
    var currentReelIndex = null;

    document.addEventListener('DOMContentLoaded', function () {
        $("#storyview").hide();
    });

    function showStory(index) {

        if (!stories.length || !stories[index]) return;

        $("#storyview").show();
        currentStoryIndex = index;

        var story = stories[index];
        var file = story.file || '';


        var img = $("#showImageStory");
        var video = $("#showVideoStory");

        // reset
        img.hide().attr("src", "");
        video.hide();

        var videoEl = video.get(0);
        if (videoEl) {
            videoEl.pause();
            videoEl.src = "";
        }

        // show media
        if (/\.(mp4|webm|ogg)$/i.test(file)) {
            video.attr("src", file).show();

            if (videoEl) {
                videoEl.load();
                videoEl.play();
            }
        } else {
            img.attr("src", file).show();
        }

    }

    function closeStatus3() {

        $("#storyview").hide();

        var video = $("#showVideoStory").get(0);
        if (video) {
            video.pause();
            video.src = "";
        }
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.deleteStoryBtn').forEach(button => {

        button.addEventListener('click', function () {

            let reelId = this.getAttribute('data-id');
            let reelElement = document.getElementById('reel-' + reelId);

            Swal.fire({
                title: "{{ __('admin_messages.are_you_sure?') }}",
                text: "{{ __('admin_messages.you_wont_be_able_to_revert_this') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "{{ __('admin_messages.yes_delete_it') }}",
                cancelButtonText: "{{ __('admin_messages.cancel') }}"
            }).then((result) => {

                if (result.isConfirmed) {

                    fetch(`/admin/deleteStory/${reelId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status === 'success') {

                            toastr.success(data.message);

                             setTimeout(() => location.reload(), 1000);

                        } else {
                            toastr.error(data.message);
                        }

                    })
                    .catch(() => {
                        toastr.error('Something went wrong.');
                    });

                }

            });

        });

    });

});
</script>


<!-- highlight viewer -->
<script>
let sellerHighlightTimer = null;
let sellerHighlightDuration = 3000; // default duration for images

function openSellerHighlightViewer(highlight) {
    clearTimeout(sellerHighlightTimer);

    const imageEl = document.getElementById("sellerHighlightImage");
    const videoEl = document.getElementById("sellerHighlightVideo");
    const progressContainer = document.getElementById("sellerProgressContainer");

    // Hide previous media
    imageEl.style.display = "none";
    videoEl.style.display = "none";
    videoEl.pause();
    videoEl.src = "";

    // Reset progress bar
    progressContainer.innerHTML = `
        <div class="progress-bar" style="width:100%; height:4px; background:#ddd;">
            <div class="progress-fill" id="sellerHighlightProgressFill" style="width:0%; height:100%; background:#007bff;"></div>
        </div>
    `;
    const progressFill = document.getElementById("sellerHighlightProgressFill");

    const file = highlight.file;
    const isVideo = file.match(/\.(mp4|webm|ogg)$/i);

    if (isVideo) {
        videoEl.src = file;
        videoEl.style.display = "block";

        videoEl.onloadedmetadata = function() {
            sellerHighlightDuration = videoEl.duration * 1000;
            startSellerHighlightProgress(progressFill, sellerHighlightDuration, closeSellerHighlightViewer);
        };

        videoEl.onended = function() {
            closeSellerHighlightViewer();
        };
    } else {
        imageEl.src = file;
        imageEl.style.display = "block";
        sellerHighlightDuration = 3000; // 3 seconds for images
        startSellerHighlightProgress(progressFill, sellerHighlightDuration, closeSellerHighlightViewer);
    }

    document.getElementById("sellerHighlightViewer").style.display = "block";
}

function startSellerHighlightProgress(progressEl, duration, callback) {
    clearTimeout(sellerHighlightTimer);

    // Reset progress
    progressEl.style.transition = "none";
    progressEl.style.width = "0%";

    // Trigger animation
    setTimeout(() => {
        progressEl.style.transition = `width ${duration}ms linear`;
        progressEl.style.width = "100%";
    }, 50);

    sellerHighlightTimer = setTimeout(callback, duration);
}

function closeSellerHighlightViewer() {
    clearTimeout(sellerHighlightTimer);

    const imageEl = document.getElementById("sellerHighlightImage");
    const videoEl = document.getElementById("sellerHighlightVideo");
    const progressFill = document.getElementById("sellerHighlightProgressFill");

    document.getElementById("sellerHighlightViewer").style.display = "none";

    imageEl.style.display = "none";
    videoEl.pause();
    videoEl.style.display = "none";

    if (progressFill) {
        progressFill.style.transition = "none";
        progressFill.style.width = "0%";
    }
}
</script>
@include('dealer.layout.header')

<div class="onepage-2">
    <div class="customContainer position-relative">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
            <div class="title24">
                <a href="{{route('seller.dashboard')}}" style="color:rgb(57, 55, 55)">
                    <i class="bi bi-chevron-left"></i> Add Highlight
                </a>
            </div>
        </div>
    </div>
</div>

<div class="product-pnls2 mt-3 mb-3">
    <div class="upload-image" style="height:250px;">
        <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">
            <div id="bannerPlaceholderImg">
                <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                    style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                <div class="py-2" style="color:#875C3A">
                    Upload image
                </div>
            </div>
            <img id="bannerUploadedImg" src="" alt="image" class="img-fluid uploadbnr" style="display:none;">

            <input type="file" accept="image/*" id="banner_image_upload" style="opacity:0;position: absolute;"
                name="upload_banner">
        </label>
    </div>
</div>

<label class="banner-text">Highlight Name</label>
<div class="group-radio-btn d-flex gap-5 align-items-center flex-wrap py-3 pe-3">
    <div class="check_radio">
        <label class="radio-group">
            <input type="radio" name="banner_position" value="1" checked>
            <span class="custom-radio"></span>
            <span class="radio-label">Select from previous</span>
        </label>
    </div>

    <div class="check_radio">
        <label class="radio-group">
            <input type="radio" name="banner_position" value="2">
            <span class="custom-radio"></span>
            <span class="radio-label">Add New</span>
        </label>
    </div>
</div>

<div class="sub-form">
    <input type="text" class="form-control" placeholder="Enter Highlight Name">
</div>

<div class="product_reels customContainer mt-4">
    <div class="title24">Select From gallary</div>
    <div class="reels-wrapper mt-4">
        <div class="row">
            @foreach($highlights as $index => $highlight)
                <div class="col-lg-3 col-md-3">
                    <div class="reels-grid" onclick="addHighlight({{ $index }})">
                        <div class="reel-card">
                            @php
                                $extension = pathinfo($highlight->file, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                <video class="img-fluid" muted loop playsinline preload="metadata">
                                    <source src="{{ $highlight->file }}" type="video/{{ $extension }}">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <img src="{{ $highlight->file }}" alt="image" class="img-fluid">
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<!-- Seller story section -->
<div class="status-viewer bgwhite" id="Addstory">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <h3>T-shirt </h3>
            <button type="button" class="btn btn-light" onclick="closeStatus1()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <div class="status-img">
                <img id="highlightImg" class="img-fluid" />
                <video id="highlightVideo" class="img-fluid" controls style="display:none;"></video>
            </div>
        </div>   

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100">Add to highlight</button>
        </div>
    </div>
</div>




<script>
document.getElementById('banner_image_upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('bannerUploadedImg').src = e.target.result;
        document.getElementById('bannerUploadedImg').style.display = 'block';
        document.getElementById('bannerPlaceholderImg').style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>

<script>
    var highlights = @json($highlights);
</script>

<script>
    var currentHighlightIndex = 0;

    function addHighlight(index) {
        currentHighlightIndex = index;

        document.getElementById("Addstory").style.display = "block";
        loadHighlight();
    }

    function loadHighlight() {
        var highlight = highlights[currentHighlightIndex];
        var file = highlight.file;

        var img = document.getElementById("highlightImg");
        var video = document.getElementById("highlightVideo");

        // Reset
        img.style.display = "none";
        video.style.display = "none";
        video.pause();
        video.src = "";

        // Detect type
        if (file.match(/\.(mp4|webm|ogg)$/i)) {
            video.src = file;
            video.style.display = "block";
            video.play();
        } else {
            img.src = file;
            img.style.display = "block";
        }
    }

    function closeStatus1() {
        document.getElementById("Addstory").style.display = "none";

        // stop video
        var video = document.getElementById("highlightVideo");
        video.pause();
        video.src = "";
    }
</script>

<!-- upload from gallery -->
 <script>
document.querySelector('.add-fillbtn').addEventListener('click', async function () {
    const img = document.getElementById('highlightImg');
    const video = document.getElementById('highlightVideo');
    const loader = document.getElementById('loader'); // make sure you have a loader div

    // 1️⃣ Get the full file URL from preview
    let fileUrl = null;

    if (img.style.display !== 'none' && img.src) {
        fileUrl = img.src; // existing image URL
    } else if (video.style.display !== 'none' && video.src) {
        fileUrl = video.src; // existing video URL
    }

    if (!fileUrl) {
        toastr.error("No preview found to add to highlight.");
        return;
    }

    try {
        // 2️⃣ Show loader
        if (loader) loader.style.display = 'block';

        // 3️⃣ Send URL to backend
        const formData = new FormData();
        formData.append('file', fileUrl);

        const response = await fetch("{{ route('seller.upload_highlight_from_gallery') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: formData
        });

        const data = await response.json();

        // 4️⃣ Hide loader
        if (loader) loader.style.display = 'none';

        // 5️⃣ Handle response
        if (response.status === 422) {
            toastr.error(data.message || 'Validation error');
            return;
        }

        if (data.status === 'success') {
            toastr.success(data.message || 'Highlight added successfully');
            setTimeout(() => location.reload(), 1500);
        } else {
            toastr.error(data.message || 'Failed to add highlight');
        }

    } catch (error) {
        if (loader) loader.style.display = 'none';
        toastr.error('Something went wrong');
        console.error(error);
    }
});
</script>



@include('dealer.layout.footer');
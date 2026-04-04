@include('dealer.layout.header')
<style>
.add-fillbtn-abc {
    background: var(--all-btn-bg);
    line-height: 35px;
    color: #fff;
}
</style>

<style>
.deleteHighlightBtn {
    background: linear-gradient(135deg, #ff4d4d, #cc0000);
    color: #fff;
    border: none;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.deleteHighlightBtn:hover {
    background: linear-gradient(135deg, #e60000, #990000);
    transform: scale(1.05);
}

button.deleteHighlightBtn {
    margin-left: 90px;
    margin-bottom: 50px;
}
</style>

<div class="onepage-2">
    <div class="customContainer position-relative">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
            <div class="title24">
                <a href="{{route('seller.view_profile')}}" style="color:rgb(57, 55, 55)">
                    <i class="bi bi-chevron-left"></i> Add Highlight
                </a>
            </div>
        </div>
    </div>
</div>

<div class="product-pnls2 mt-3 mb-3">
    <div class="upload-image" style="height:250px; position: relative;">
        <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">
            <div id="bannerPlaceholderImg">
                <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                     style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                <div class="py-2" style="color:#875C3A">Upload image/video</div>
            </div>

            <!-- Image Preview -->
            <img id="bannerUploadedImg" src="" alt="preview" class="img-fluid uploadbnr" style="display:none;">

            <!-- Video Preview -->
            <video id="bannerUploadedVideo" class="img-fluid uploadbnr" controls style="display:none;"></video>

            <input type="file" accept="image/*,video/*" id="banner_image_upload" style="opacity:0;position:absolute;" name="upload_banner">
        </label>
        <div id="fileError" style="color:red; font-size:0.9rem;"></div>
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

<select id="previousHighlights" class="form-select mb-3">
    <option value="">Select Highlight</option>
    @foreach($highlights as $highlight)
        <option value="{{ $highlight->title }}">{{ $highlight->title }}</option>
    @endforeach
</select>

<input type="text" id="highlightTitleInput" class="form-control mb-3" placeholder="Enter Highlight Name" style="display:none;">
<div id="titleError" style="color:red; font-size:0.9rem;"></div>

<button id="submitHighlight" type="button" class="btn add-fillbtn w-100">Submit</button>

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
                    <button class="deleteHighlightBtn" data-id="{{ $highlight->id }}">
                        Delete
                    </button>
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
            <button type="button" class="btn add-fillbtn-abc w-100">Add to highlight</button>
        </div>
    </div>
</div>




<!-- <script>
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
</script> -->

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
document.querySelector('.add-fillbtn-abc').addEventListener('click', async function () {
    const img = document.getElementById('highlightImg');
    const video = document.getElementById('highlightVideo');
    const loader = document.getElementById('loader'); // loader div
    const titleEl = document.querySelector('#Addstory .story-header h3'); // fetch title
    const title = titleEl ? titleEl.textContent.trim() : '';

    // 1️⃣ Get the full file URL from preview
    let fileUrl = null;

    if (img.style.display !== 'none' && img.src) {
        fileUrl = img.src;
    } else if (video.style.display !== 'none' && video.src) {
        fileUrl = video.src;
    }

    if (!fileUrl) {
        toastr.error("No preview found to add to highlight.");
        return;
    }

    try {
        // 2️⃣ Show loader
        if (loader) loader.style.display = 'block';

        // 3️⃣ Send URL and title to backend
        const formData = new FormData();
        formData.append('file', fileUrl);
        formData.append('title', title); // add title

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



<!-- upload highlight -->
<script>
const fileInput = document.getElementById('banner_image_upload');
const fileImg = document.getElementById('bannerUploadedImg');
const fileVideo = document.getElementById('bannerUploadedVideo');
const placeholder = document.getElementById('bannerPlaceholderImg');
const fileError = document.getElementById('fileError');

const radios = document.querySelectorAll('input[name="banner_position"]');
const dropdown = document.getElementById('previousHighlights');
const inputField = document.getElementById('highlightTitleInput');
const titleError = document.getElementById('titleError');
const submitBtn = document.getElementById('submitHighlight');

// --- File Preview ---
fileInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    fileError.textContent = '';

    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const type = file.type;

        // Reset preview
        fileImg.style.display = 'none';
        fileVideo.style.display = 'none';
        fileVideo.pause();
        fileVideo.src = '';

        if (type.startsWith('image/')) {
            fileImg.src = e.target.result;
            fileImg.style.display = 'block';
            placeholder.style.display = 'none';
        } else if (type.startsWith('video/')) {
            fileVideo.src = e.target.result;
            fileVideo.style.display = 'block';
            fileVideo.controls = true;
            fileVideo.play();
            placeholder.style.display = 'none';
        }
    };
    reader.readAsDataURL(file);
});

// --- Handle radio buttons ---
function updateHighlightField() {
    const selected = document.querySelector('input[name="banner_position"]:checked').value;

    if (selected === "1") {
        // Show dropdown, hide input field
        dropdown.style.display = 'block';
        inputField.style.display = 'none';
        inputField.value = ''; // Clear input
        titleError.textContent = '';
    } else {
        // Show input field, hide dropdown
        dropdown.style.display = 'none';
        inputField.style.display = 'block';
        dropdown.value = ''; // Clear dropdown
        titleError.textContent = '';
    }
}

radios.forEach(r => r.addEventListener('change', updateHighlightField));

// Remove title error when dropdown or input changes
dropdown.addEventListener('change', () => {
    titleError.textContent = '';
});
inputField.addEventListener('input', () => {
    titleError.textContent = '';
});
updateHighlightField();

// --- Submit ---
submitBtn.addEventListener('click', async function() {
    fileError.textContent = '';
    titleError.textContent = '';

    const selectedRadio = document.querySelector('input[name="banner_position"]:checked').value;
    let title = '';

    // Get title based on selection
    if (selectedRadio === "1") {
        title = dropdown.value.trim();
    } else {
        title = inputField.value.trim();
    }

    const file = fileInput.files[0];
    const hasPreview = (fileImg.src && fileImg.style.display !== 'none') || (fileVideo.src && fileVideo.style.display !== 'none');

    // Validation
    let hasError = false;
    if (!file && !hasPreview) {
        fileError.textContent = 'Please select image/video';
        hasError = true;
    }
    if (!title) {
        titleError.textContent = selectedRadio === "1" ? 'Please select title' : 'Please enter highlight name';
        hasError = true;
    }
    if (hasError) return;

    const formData = new FormData();

    if (file) {
        formData.append('file', file);
    } else {
        // No new file, use preview URL for existing media (if backend supports)
        formData.append('file', fileVideo.src || fileImg.src);
    }
    formData.append('title', title);

    try {
        if (window.loader) loader.style.display = 'block';

        const res = await fetch("{{ route('seller.upload_highlight') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        });
        const data = await res.json();
        if (window.loader) loader.style.display = 'none';

        if (data.status === 'success') {
            toastr.success(data.message || 'Highlight added successfully');
            setTimeout(() => location.reload(), 1500);
        } else {
            toastr.error(data.message || 'Something went wrong');
        }
    } catch (err) {
        if (window.loader) loader.style.display = 'none';
        toastr.error('Something went wrong');
        console.error(err);
    }
});
</script>

<script>
document.body.addEventListener('click', function(e) {

    // --- Delete Highlight ---
    const deleteBtn = e.target.closest('.deleteHighlightBtn');
    if (deleteBtn) {
        e.stopPropagation(); // 
        const highlightId = deleteBtn.getAttribute('data-id');
        if (!highlightId) return;

       // if (!confirm("Are you sure you want to delete this highlight?")) return;

        const originalHTML = deleteBtn.innerHTML;
       // deleteBtn.innerHTML = "Deleting...";
        deleteBtn.style.pointerEvents = "none";

        fetch(`/seller/delete_highlight/${highlightId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            deleteBtn.innerHTML = originalHTML;
            deleteBtn.style.pointerEvents = "auto";

            if (data.status === "success") {
                toastr.success(data.message || "Highlight deleted");
                setTimeout(() => location.reload(), 1000);
            } else {
                toastr.error(data.message || "Failed to delete highlight");
            }
        })
        .catch(err => {
            console.error(err);
            deleteBtn.innerHTML = originalHTML;
            deleteBtn.style.pointerEvents = "auto";
            toastr.error("Something went wrong");
        });

        return; // stop further processing
    }


});
</script>




@include('dealer.layout.footer');
@include('dealer.layout.header')

<style>
.deleteStoryBtn {
    background: linear-gradient(135deg, #ff4d4d, #cc0000);
    color: #fff;
    border: none;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.deleteStoryBtn:hover {
    background: linear-gradient(135deg, #e60000, #990000);
    transform: scale(1.05);
}

button.deleteStoryBtn {
    margin-left: 90px;
    margin-bottom: 50px;
}
</style>

<div class="onepage-2">
    <div class="customContainer position-relative">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
            <div class="title24">
                <a href="{{route('seller.view_profile')}}" style="color:rgb(57, 55, 55)">
                    <i class="bi bi-chevron-left"></i>  {{ __('seller_messages.Add_Story') }}
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
                    {{ __('seller_messages.Upload_Image_Video') }}
                </div>
            </div>
            <img id="bannerUploadedImg" src="" alt="image" class="img-fluid uploadbnr" style="display:none;">
            <video id="bannerUploadedVideo" class="img-fluid uploadbnr" controls
                style="display:none;"></video>
        </label>
        <input type="file"
               id="banner_image_upload"
               name="file"
               accept="image/*,video/*"
               style="display:none;">
    </div>
</div>


<div class="product_reels customContainer mt-4">
    <div class="title24">{{ __('seller_messages.Select_From_Gallery') }}</div>
    <div class="reels-wrapper mt-4">
        <div class="row">
            @foreach($sellerStories as $index => $story)
                <div class="col-lg-3 col-md-3">
                    <div class="reels-grid" onclick="addSeller({{ $index }})">
                        <div class="reel-card">
                            @php
                                $extension = pathinfo($story->file, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                <video class="img-fluid" muted loop playsinline preload="metadata">
                                    <source src="{{ $story->file }}" type="video/{{ $extension }}">
                                   {{ __('seller_messages.Browser_Not_Support_Video') }}
                                </video>
                            @else
                                <img src="{{ $story->file }}" alt="image" class="img-fluid">
                            @endif
                        </div>
                    </div>
                    <button class="deleteStoryBtn" data-id="{{ $story->id }}">
                         {{ __('seller_messages.Delete') }}
                    </button>
                </div>
            @endforeach
        </div>

    </div>
</div>

<!-- Seller story section -->
<div class="status-viewer bgwhite" id="Addstory12">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
           <h3>{{ __('seller_messages.Add_Story') }}</h3>
            <button type="button" class="btn btn-light" onclick="closeStatus1()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <div class="status-img">
                <img id="storyimg12" class="img-fluid" alt="status" />
                <video id="storyvideo12" class="img-fluid" controls style="display:none;"></video>
            </div>
        </div>   

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100">  {{ __('seller_messages.Upload') }}</button>
        </div>
    </div>
</div>



<script>
    var sellerStories = @json($sellerStories);
    //console.log(stories);
</script>

<script>
    var currentIndex = 0;

    function addSeller(index) {
        currentIndex = index;

        document.getElementById("Addstory12").style.display = "block";
        loadStory();
    }

    function loadStory() {
        var story = sellerStories[currentIndex];
        var file = story.file;

        var img = document.getElementById("storyimg12");
        var video = document.getElementById("storyvideo12");

        // Reset both
        img.style.display = "none";
        video.style.display = "none";
        video.pause();
        video.src = "";

        // Check file type
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
        document.getElementById("Addstory12").style.display = "none";

        // Stop video on close
        var video = document.getElementById("storyvideo12");
        video.pause();
        video.src = "";
    }
</script>


<!-- add story -->
<script>
document.getElementById('banner_image_upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const img = document.getElementById('bannerUploadedImg');
    const video = document.getElementById('bannerUploadedVideo');
    const placeholder = document.getElementById('bannerPlaceholderImg');
    const loader = document.getElementById('loader');

    // Reset preview
    img.style.display = 'none';
    video.style.display = 'none';
    placeholder.style.display = 'none';

    const fileType = file.type;

    //  Show preview
    if (fileType.startsWith('video/')) {
        const videoURL = URL.createObjectURL(file);
        video.src = videoURL;
        video.style.display = 'block';
    } else {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    //  Prepare form data
    let formData = new FormData();
    formData.append('file', file);

    //  Show loader
    if (loader) loader.style.display = 'block';

    //  AJAX upload
    fetch("{{ route('seller.upload_story') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: formData
    })
    .then(async res => {
        let data;
        try {
            data = await res.json();
        } catch (e) {
            throw new Error("Invalid JSON response");
        }

        return { statusCode: res.status, body: data };
    })
    .then(({ statusCode, body }) => {
        if (loader) loader.style.display = 'none';

        //  Handle Laravel validation (422)
        if (statusCode === 422) {
            toastr.error(body.message || 'Validation error');
            return;
        }

        //  Handle API response
        if (body.status === 'success') {
            toastr.success(body.message || 'Uploaded successfully');

            setTimeout(() => {
                location.reload();
            }, 1500);
        } else if (body.status === 'failed') {
            toastr.error(body.message || 'Upload failed');

            setTimeout(() => {
                window.location.href = "{{ route('seller.all_plans') }}";
            }, 1500);

        } else {
            toastr.error(body.message || 'Something went wrong');
        }
    })
    .catch(error => {
        if (loader) loader.style.display = 'none';
        toastr.error('Something went wrong');
        console.error(error);
    });
});
</script>

<!-- upload from gallery -->
<script>
document.querySelector('.add-fillbtn').addEventListener('click', async function () {
    const img = document.getElementById('storyimg12');
    const video = document.getElementById('storyvideo12');
    const loader = document.getElementById('loader');

    let fileUrl = null;

    if (img.style.display !== 'none' && img.src) {
        fileUrl = img.src; // existing image URL
    } else if (video.style.display !== 'none' && video.src) {
        fileUrl = video.src; // existing video URL
    }

    if (!fileUrl) {
        toastr.error("No preview found to save.");
        return;
    }

    try {
        if (loader) loader.style.display = 'block';

        const formData = new FormData();
        formData.append('file', fileUrl);

        const response = await fetch("{{ route('seller.upload_story_from_gallery') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: formData
        });

        const data = await response.json();

        if (loader) loader.style.display = 'none';

        if (response.status === 422) {
            toastr.error(data.message || 'Validation error');
            return;
        }

        if (data.status === 'success') {
            toastr.success(data.message || 'Story added successfully');
            setTimeout(() => location.reload(), 1500);
        } else if (data.status === 'failed') {
            toastr.error(data.message || 'Upload failed');

            setTimeout(() => {
                window.location.href = "{{ route('seller.all_plans') }}";
            }, 1500);

        } else {
            toastr.error(data.message || 'Something went wrong');
        }

    } catch (error) {
        if (loader) loader.style.display = 'none';
        toastr.error('Something went wrong');
        console.error(error);
    }
});
</script>

<!-- delete story -->
<script>
document.body.addEventListener('click', function(e) {

    const deleteBtn = e.target.closest('.deleteStoryBtn');
    if (deleteBtn) {
        e.stopPropagation(); // 
        const storyId = deleteBtn.getAttribute('data-id');
        if (!storyId) return;

       // if (!confirm("Are you sure you want to delete this highlight?")) return;

        const originalHTML = deleteBtn.innerHTML;
       // deleteBtn.innerHTML = "Deleting...";
        deleteBtn.style.pointerEvents = "none";

        fetch(`/seller/delete_story/${storyId}`, {
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

        return; 
    }


});
</script>





@include('dealer.layout.footer');
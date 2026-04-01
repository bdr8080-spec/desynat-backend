@include('dealer.layout.header')

<div class="onepage-2">
    <div class="customContainer position-relative">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
            <div class="title24">
                <a href="{{route('seller.dashboard')}}" style="color:rgb(57, 55, 55)">
                    <i class="bi bi-chevron-left"></i> Add Story
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


<div class="product_reels customContainer mt-4">
    <div class="title24">Select From gallary</div>
    <div class="reels-wrapper mt-4">
        <div class="row">
            @foreach($highlights as $index => $highlight)
            <div class="col-lg-3 col-md-3">
                <div class="reels-grid" onclick="addSeller({{ $index }})">
                    <div class="reel-card">
                        <img src="{{$highlight->file}}" alt="image" class="img-fluid">
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
            <h3>Add Story </h3>
            <button type="button" class="btn btn-light" onclick="closeStatus1()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <div class="status-img">
                <img id="storyimg" class="img-fluid" alt="status" />
                <video id="storyvideo" class="img-fluid" controls style="display:none;"></video>
            </div>
        </div>   

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100">Upload</button>
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
    var stories = @json($stories);
</script>

<script>
    var currentIndex = 0;

    function addSeller(index) {
        currentIndex = index;

        document.getElementById("Addstory").style.display = "block";
        loadStory();
    }

    function loadStory() {
        var story = stories[currentIndex];
        var file = story.file;

        var img = document.getElementById("storyimg");
        var video = document.getElementById("storyvideo");

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
        document.getElementById("Addstory").style.display = "none";

        // Stop video on close
        var video = document.getElementById("storyvideo");
        video.pause();
        video.src = "";
    }
</script>





@include('dealer.layout.footer');
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
            <div class="col-lg-3 col-md-3">
                <div class="reels-grid" onclick="addSeller(0)">
                    <div class="reel-card">
                        <img src="{{asset('dealer/assets/img/reel-1.svg')}}" alt="image" class="img-fluid">
                    </div>
                    <!-- <div class="play-icon">
                        <i class="bi bi-play-fill"></i>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="reels-grid">
                    <div class="reel-card">
                        <img src="{{asset('dealer/assets/img/reel-2.svg')}}" alt="image" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="reels-grid">
                    <div class="reel-card">
                        <img src="{{asset('dealer/assets/img/reel-3.svg')}}" alt="image" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="reels-grid">
                    <div class="reel-card">
                        <img src="{{asset('dealer/assets/img/reel-1.svg')}}" alt="image" class="img-fluid">
                    </div>
                </div>
            </div>
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
                <img id="storyimg" class="img-fluid" alt="status" />
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
    var images = [ "{{asset('user')}}/assets/images/store1.jpg",];

    var currentIndex = 0;
    function addSeller(index) {
        currentIndex = index;
        document.getElementById("Addstory").style.display = "block";
        storyimg();
    }
    function storyimg() {
        document.getElementById("storyimg").src = images[currentIndex];
    }
    function closeStatus1() {
        clearTimeout(timer);
        document.getElementById("Addstory").style.display = "none";
    }
</script>



@include('dealer.layout.footer');
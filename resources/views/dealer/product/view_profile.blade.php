@include('dealer.layout.header')
<!-- <style>
.brand-banner {
    height: 250px;
    width: 100%;
    border-radius: 10px;
}

.brand-banner img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 12px;
}

.profile-card {
    margin-top: -60px;
    background: #fff;
    border-radius: 12px;
    width: 83%;
    padding: 25px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 2;
    position: relative;
    margin-left: 3rem;
    margin-bottom: 3rem;
}

.profile-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
}

.star-rating i, .star-rating {
    color: #f6b100;
}

.qr-box img {
    width: 70px;
}

/* ---- Products Row ---- */
.product-row {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    width: 83%;
    margin-left: 3rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
}

.product-item {
    text-align: center;
}

.product-circle {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    object-fit: cover;
}

.add-circle {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: #f5f5f5;
    border: 2px dashed #c2c2c2;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    cursor: pointer;
}

/* ---- Tab Bar ---- */
.tab-bar {
    width: 83%;
    margin-left: 3rem;
    display: flex;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
}

.tab-bar div {
    flex: 1;
    text-align: center;
    padding: 12px;
    background: #fff;
    border: 1px solid #d8c2a6;
    cursor: pointer;
    font-weight: 600;
}

.tab-bar .active {
    background: linear-gradient(90deg, #b8864b, #d6b58d);
    color: #fff;
}
</style>

<section class="section dashboard container">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between">
        <h1 class="title24"><i class="bi bi-chevron-left"></i> Profile</h1>
        <div>
            <a href="{{ route('seller.Add_product') }}">
                <img src="{{asset('dealer/assets/img/edit2.png')}}">
            </a>
        </div>
    </div>

    <div class="bg-light">

        <div class="container mt-4 position-relative">

         
            <div class="brand-banner">
                <img src="{{asset('dealer/assets/img/imagebnr.png')}}" alt="Profile">
            </div>

           
            <div class="profile-card">

                <div class="row align-items-center">
                    <div class="col-md-1 col-2">
                        <img src="{{asset('dealer/assets/img/imagebnr.png')}}" class="profile-img">
                    </div>

                    <div class="col-md-8 col-7">
                        <h5 class="mb-0">Atif Aslam</h5>
                        <small class="text-muted">+948225555</small><br>
                        <small class="text-muted">atif32@gmail.com</small>

                        <div class="star-rating mt-1">
                            ⭐⭐⭐⭐⭐ (123)
                        </div>
                    </div>

                    <div class="col-md-3 col-3 text-end qr-box">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://example.com">
                        <div class="mt-1 small">Share <i class="bi bi-share-fill"></i></div>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold">Puma</h6>
                <small class="text-muted">+948225555</small><br>
                <small class="text-muted">atif32@gmail.com</small>

                <p class="mt-2 mb-0">
                    C 19, Sector 63, Blue diamond road, Kuwait 
                </p>

            </div>
        </div>

      
        <div class="product-row d-flex align-items-center gap-4">
            <div class="product-item">
                <div class="add-circle">+</div>
                <small>Add</small>
            </div>

            <div class="product-item">
                <img src="{{asset('dealer/assets/img/tshirt.png')}}" class="product-circle">
                <small>T Shirt</small>
            </div>

            <div class="product-item">
                <img src="{{asset('dealer/assets/img/tshirt.png')}}" class="product-circle">
                <small>T Shirt</small>
            </div>

            <div class="product-item">
                <img src="{{asset('dealer/assets/img/tshirt.png')}}" class="product-circle">
                <small>T Shirt</small>
            </div>

            <div class="product-item">
                <img src="{{asset('dealer/assets/img/tshirt.png')}}" class="product-circle">
                <small>T Shirt</small>
            </div>

            <div class="product-item">
                <img src="{{asset('dealer/assets/img/tshirt.png')}}" class="product-circle">
                <small>T Shirt</small>
            </div>
        </div>

  
        <div class="tab-bar">
            <div class="active">My Reels</div>
            <div>Documents & Bank Details</div>
        </div>

    </div>
</section> -->

<style>
.brand-banner {
    height: 562.2px;
    width: 100%;
    border-radius: 10px;
}

.brand-banner img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 12px;
}

.profile-card {
    margin-top: -60px;
    background: #fff;
    border-radius: 12px;
    width: 83%;
    padding: 25px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 2;
    position: relative;
    margin-left: 3rem;
    margin-bottom: 3rem;
}

.profile-img {
    width: 70px;
    height: 84px;

}

.star-rating i,
.star-rating {
    color: #f6b100;
}

.qr-box img {
    width: 70px;
}

/* ---- Products Row ---- */
.product-row {

    background: #fff;
    border-radius: 12px;
    padding: 26px 21px;
    width: 73%;
    margin-left: 7rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
}

.product-item {
    width: 85px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.product-circle {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    object-fit: cover;
}


.add-circle {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: #f5f5f5;
    border: 2px dashed #c2c2c2;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    cursor: pointer;
}

/* ---- Tab Bar ---- */
.tab-bar {
    width: 83%;
    margin-left: 3rem;
    display: flex;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
}

.tab-bar div {
    flex: 1;
    text-align: center;
    padding: 12px;
    background: #fff;
    border: 1px solid #d8c2a6;
    cursor: pointer;
    font-weight: 600;
}

.tab-bar .active {
    background: linear-gradient(90deg, #b8864b, #d6b58d);
    color: #fff;
}
</style>


<div class="">

    <div class="container mt-4 position-relative">


        <div class="brand-banner">
            <img src="{{asset('dealer/assets/img/imagebnr.png')}}" alt="Profile">
        </div>


        <div class="profile-card">

            <div class="row align-items-center">
                <div class="col-md-1 col-2">
                    <img src="{{asset('dealer/assets/img/story.svg')}}" class="profile-img">
                </div>

                <div class="col-md-8 col-7">
                    <h5 class="mb-0">Atif Aslam</h5>
                    <small class="text-muted">+948225555</small><br>
                    <small class="text-muted">atif32@gmail.com</small>

                    <div class="star-rating mt-1">
                        ⭐⭐⭐⭐⭐ (123)
                    </div>
                </div>

                <div class="col-md-3 col-3 text-end qr-box">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://example.com">
                    <div class="mt-1 small">Share <i class="bi bi-share-fill"></i></div>
                </div>
            </div>

            <hr>

            <h6 class="fw-bold">Puma</h6>
            <small class="text-muted">+948225555</small><br>
            <small class="text-muted">atif32@gmail.com</small>

            <p class="mt-2 mb-0">
                C 19, Sector 63, Blue diamond road, Kuwait.
            </p>

        </div>
    </div>

    <div class="product-row d-flex align-items-center gap-4">

        <div class="product-item">
            <img src="{{asset('dealer/assets/img/hightlights-add.svg')}}" class="product-circle">

        </div>

        <div class="product-item">
            <img src="{{asset('dealer/assets/img/highlights.svg')}}" class="product-circle">
            <small>T Shirt</small>
        </div>

        <div class="product-item">
            <img src="{{asset('dealer/assets/img/highlights.svg')}}" class="product-circle">
            <small>T Shirt</small>
        </div>

        <div class="product-item">
            <img src="{{asset('dealer/assets/img/highlights.svg')}}" class="product-circle">
            <small>T Shirt</small>
        </div>

        <div class="product-item">
            <img src="{{asset('dealer/assets/img/highlights.svg')}}" class="product-circle">
            <small>T Shirt</small>
        </div>

        <div class="product-item">
            <img src="{{asset('dealer/assets/img/highlights.svg')}}" class="product-circle">
            <small>T Shirt</small>
        </div>

    </div>
    <div class="product_reels customContainer">
        <ul class="nav nav-tabs customNavTabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane"
                    type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">
                    My Reels
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reels-tab" data-bs-toggle="tab" data-bs-target="#reels-tab-pane"
                    type="button" role="tab" aria-controls="reels-tab-pane" aria-selected="false">
                    Documents & Bank Details
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
                tabindex="0">
                <div class="reels-wrapper">

                    <!-- Upload New Box -->
                    <div class="reel-upload-box">
                        <div class="upload-inner">
                            <img src="/dealer/assets/img/hightlights-add.svg" alt="">

                            <p>Upload New</p>
                        </div>
                    </div>

                    <!-- Reels Grid -->
                    <div class="reels-grid">

                        <div class="reel-card">
                            <img src="dealer/assets/img/reel-1.svg" alt="">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>

                        <div class="reel-card">
                            <img src="dealer/assets/img/reel-2.svg" alt="">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>

                        <div class="reel-card">
                            <img src="dealer/assets/img/reel-3.svg" alt="">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>

                        <div class="reel-card">
                            <img src="dealer/assets/img/reel-4.svg" alt="">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>

                        <div class="reel-card">
                            <img src="dealer/assets/img/reel-5.svg" alt="">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>

                        <div class="reel-card">
                            <img src="dealer/assets/img/reel-6.svg" alt="">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="tab-pane fade" id="reels-tab-pane" role="tabpanel" aria-labelledby="reels-tab" tabindex="0">
                <!-- content here -->
            </div>

        </div>
    </div>

</div>
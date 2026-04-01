@include('dealer.layout.header')

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

.profile-img {
    width: 70px;
    height: 84px;
}

.star-rating i,
.star-rating {
    color: #FFA41B;
}

.qr-box img {
    width: 70px;
}

/* ---- Products Row ---- */
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


<div class="onepage">
    <div class="customContainer position-relative">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
            <div class="title24">
                <a href="{{route('seller.dashboard')}}" style="color:rgb(57, 55, 55)">
                    <i class="bi bi-chevron-left"></i> Profile
                </a>
            </div>

            <a href="{{route('seller.edit_profile')}}" class="pencil-btn">
                <i class="bi bi-pencil"></i>
            </a>

        </div>


        <div class="brand-banner">
            <img src="{{ $seller_details->store_info?->store_image ?? asset('images/default-store.png') }}"
                alt="Profile">
        </div>

        <div class="profile_wapper">
            <div class="profile-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="user_view">
                            <div class="position-relative">
                                <div class="addprofile">
                                    <img src="{{$seller_details->profile_pic}}" class="img-fluid">
                                </div>
                                <a href="/add-story" class="addic">
                                    <img src="{{asset('dealer/assets/img/add.svg')}}" class="img-fluid">
                                </a>
                            </div>

                            <div class="user_content">
                                <h5 class="mb-0">{{ $seller_details->first_name }} {{ $seller_details->last_name }}</h5>
                                <small class="text-muted">{{ $seller_details->country_code }}
                                    {{ $seller_details->mobile }}</small><br>
                                <small class="text-muted">{{ $seller_details->email }}</small>

                                <div class="star-rating mt-1">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <span class="text-black">(123K)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-4 text-end qr-box">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://example.com">
                        <div class="mt-1 small">Share <i class="bi bi-share-fill"></i></div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold">{{ $seller_details->store_info->store_name??'N/A' }}</h6>
                    <small class="text-muted">{{ $seller_details->store_info->country_code??'N/A' }}
                        {{ $seller_details->store_info->store_phone ??'N/A'}}</small><br>
                    <small class="text-muted">{{ $seller_details->store_info->store_mail_id??'N/A' }}</small>

                    <p class="mt-2 mb-0">
                        {{ $seller_details->store_info->store_address??'N/A' }}
                    </p>
                    <p class="mt-2 mb-0">
                        {{ $seller_details->store_info->bio??'N/A' }}
                    </p>
                </div>

            </div>

            <div class="product-row d-flex align-items-center gap-4 profile-card">
                <div class="product-item">
                    <a href="/add-highlight">
                        <img src="{{asset('dealer/assets/img/hightlights-add.svg')}}" class="product-circle">
                    </a>
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
        </div>
    </div>
</div>

<div class="product_reels customContainer">
    <ul class="nav nav-tabs customNavTabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane"
                type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">
                My Reels
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reels-tab" data-bs-toggle="tab" data-bs-target="#reels-tab-pane" type="button"
                role="tab" aria-controls="reels-tab-pane" aria-selected="false">
                Documents & Bank Details
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
            tabindex="0">
            <div class="reels-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="reel-upload-box">
                            <div class="upload-inner" onclick="uploadReels(0)">
                                <img src="/dealer/assets/img/hightlights-add.svg" alt="">
                                <p>Upload New</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="reels-grid" onclick="showReels(0)">
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
                            <!-- <div class="play-icon">
                                    <i class="bi bi-play-fill"></i>
                                </div> -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="reels-grid">
                            <div class="reel-card">
                                <img src="{{asset('dealer/assets/img/reel-1.svg')}}" alt="image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="reels-grid">
                            <div class="reel-card">
                                <img src="{{asset('dealer/assets/img/reel-2.svg')}}" alt="image" class="img-fluid">
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="tab-pane fade" id="reels-tab-pane" role="tabpanel" aria-labelledby="reels-tab" tabindex="0">
            <div class="bank-show-panel">
                <div class="title24">Owner's Documents</div>
                <div class="row">

                    @foreach($seller_details->owner_document as $key=>$val)

                    <div class="col-lg-6 col-md-6">
                        <div class="document-view">
                            <div class="doc-views">
                                <img src="{{$val->document_path}}" alt="image" class="img-fluid">
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <h6>

                                @if($key==0)
                                Front
                                @else
                                Back
                                @endif


                            </h6>
                        </div>
                    </div>

                    @endforeach


                    <!-- <div class="col-lg-6 col-md-6">
                            <div class="document-view">
                                <div class="doc-views">
                                    <img src="{{asset('dealer/assets/img/doc.svg')}}" alt="image" class="img-fluid">
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <h6>Documents 02</h6>
                            </div>
                        </div> -->
                </div>
            </div>

            <div class="bank-show-panel">
                <div class="title24">Store Documents</div>
                <div class="row">

                    @foreach($seller_details->store_document as $key=>$val)

                    <div class="col-lg-6 col-md-6">
                        <div class="document-view">
                            <div class="doc-views">
                                <img src="{{$val->document_path}}" alt="image" class="img-fluid">
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <h6>
                                @if($key==0)
                                Front
                                @else
                                Back
                                @endif

                            </h6>
                        </div>
                    </div>

                    @endforeach

                    <!-- <div class="col-lg-6 col-md-6">
                            <div class="document-view">
                                <div class="doc-views">
                                    <img src="{{asset('dealer/assets/img/doc.svg')}}" alt="image" class="img-fluid">
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <h6>Documents 02</h6>
                            </div>
                        </div> -->

                </div>
            </div>

            <div class="bank-show-panel">
                <div class="title24">Bank details</div>
                <div class="bank-lists">
                    <div class="personal-list-2">
                        <div class="lightName">Account Type</div>
                        <div class="title_black">@if(@$seller_details->seller_bank_details->account_type=='0')
                            Personal @else business @endif </div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">IBAN</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->iban }}</div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">SWIFT/BIC</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->swift }}</div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">Bank Name</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->bank_name }}</div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">Account holder name</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->account_holder_name }}
                        </div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">Proof Of Documents</div>
                    </div>
                    <div class="doc-views2">
                        <img src="{{ @$seller_details->seller_bank_details->upload_proof }}" alt="image"
                            class="img-fluid">
                    </div>


                </div>
            </div>



        </div>

    </div>
</div>


<!-- Upload New reeels  section -->
<div class="status-viewer bgwhite" id="Addstory">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <div class="d-flex gap-2">
                <a href="#"><i class="bi bi-chevron-left"></i> </a>
                <h3>Upload new reel </h3>
            </div>
            <button type="button" class="btn btn-light" onclick="closeStatus1()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <label class="status-img" id="previewContainer">
                <div id="bannerPlaceholderImg" class="text-center">
                    <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                        style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                    <div class="py-2" style="color:#875C3A">
                        Upload Image/Video
                    </div>
                </div>
                <div class="status-img" id="previewContainer">
                    <img id="storyimg" class="img-fluid" style="display:none;" />
                    <video id="storyvideo" class="img-fluid" controls style="display:none;"></video>
                </div>
                <input type="file" id="storyUpload" accept="image/*,video/*" class="storyUpload" />
            </label>

        </div>

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100">Upload</button>
        </div>
    </div>
</div>

<!--  reeels show  section -->
<div class="status-viewer bgwhite" id="reelsview">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <div class="d-flex gap-2">
                <a href="#"><i class="bi bi-chevron-left"></i> </a>
                <h3>Reel </h3>
            </div>
            <button type="button" class="btn btn-light" onclick="closeStatus2()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <label class="status-img">
                <div class="status-img" id="previewContainer">
                    <img id="storyimg" class="img-fluid" style="display:none;" />
                    <video id="storyvideo" class="img-fluid" controls style="display:none;"></video>
                </div>
            </label>
        </div>

        <div class="dashboard-button mt-4 logostatus bgwhite d-flex justify-content-center gap-4">
            Active
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault" checked="">
                <label class="form-check-label" for="switchCheckDefault"></label>
            </div>
            <a href="#" class="pencil-btn-2 btn-red"><i class="bi bi-trash3"></i> </a>
            <a href="javascript:void(0)" class="pencil-btn-2 edt-btn" onclick="updateReels()"><i class="bi bi-pencil"></i> </a>
        </div>
    </div>
</div>

<!-- Update New reeels section -->
<div class="status-viewer bgwhite" id="updatestory">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <div class="d-flex gap-2">
                <a href="#"><i class="bi bi-chevron-left"></i> </a>
                <h3>Update New Reel </h3>
            </div>
            <button type="button" class="btn btn-light" onclick="closeStatus3()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="logostatus">
            <label class="status-img" id="previewContainer">
                <div id="bannerhide" class="text-center">
                    <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                        style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                    <div class="py-2" style="color:#875C3A">
                        Upload Image/Video
                    </div>
                </div>
                <div class="status-img" id="previewContainer">
                    <img id="storyimg2" class="img-fluid" style="display:none;" />
                    <video id="storyvideo2" class="img-fluid" controls style="display:none;"></video>
                </div>
                <input type="file" id="storyUpload2" accept="image/*,video/*" class="storyUpload" />
            </label>

        </div>

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100">Upload</button>
        </div>
    </div>
</div>


<script>

    function uploadReels() {
        $("#Addstory").show();
    }
    function closeStatus1() {
        $("#Addstory").hide();
    }
    // Upload Preview
    $("#storyUpload").on("change", function(e) {
        let file = e.target.files[0];
        if (!file) return;

        let url = URL.createObjectURL(file);

        $("#storyimg, #storyvideo").hide();

        if (file.type.startsWith("image/")) {
            $("#storyimg").attr("src", url).show();
            $("#bannerPlaceholderImg").hide();
        } else if (file.type.startsWith("video/")) {
            $("#storyvideo").attr("src", url).show();
        } else {
            alert("Only image/video allowed");
        }
    });

</script>

<script>
    function showReels() {
        $("#reelsview").show();
    }
    function closeStatus2() {
        $("#reelsview").hide();
    }

</script>

<script>
// update new reels  function

    function updateReels() {
        $("#updatestory").show();
    }
    function closeStatus3() {
        $("#updatestory").hide();
    }
    // Upload Preview
    $("#storyUpload2").on("change", function(e) {
        let file = e.target.files[0];
        if (!file) return;

        let url = URL.createObjectURL(file);

        $("#storyimg2, #storyvideo2").hide();

        if (file.type.startsWith("image/")) {
            $("#storyimg2").attr("src", url).show();
            $("#bannerhide").hide();
        } else if (file.type.startsWith("video/")) {
            $("#storyvideo2").attr("src", url).show();
        } else {
            alert("Only image/video allowed");
        }
    });

</script>


@include('dealer.layout.footer');
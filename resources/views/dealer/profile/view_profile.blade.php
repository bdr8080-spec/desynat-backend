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

#storyvideo2 {
    pointer-events: none;
}

#storyimg2 {
    pointer-events: none;
}

</style>


<div class="onepage">
    <div class="customContainer position-relative">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
            <div class="title24">
                <a href="{{route('seller.dashboard')}}" style="color:rgb(57, 55, 55)">
                    <i class="bi bi-chevron-left"></i> {{ __('seller_messages.Profile') }}
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
                                <div class="{{ !empty($stories) && count($stories) > 0 ? 'addprofile story-active' : 'addprofile' }}">
                                    <img src="{{$seller_details->profile_pic}}" class="img-fluid" onclick='openSellerStoryViewer(@json($stories), 0)'>
                                </div>
                                <a href="{{route('seller.add_story')}}" class="addic">
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
                        <div class="mt-1 small"> {{ __('seller_messages.Share') }} <i class="bi bi-share-fill"></i></div>
                    </div>
                </div>

                <div class="mt-4">
                   <h6 class="fw-bold">
                        {{ $seller_details->store_info->store_name ?? __('seller_messages.N_A') }}
                    </h6>
                    
                      <small class="text-muted">
                        {{ $seller_details->store_info->country_code ?? __('seller_messages.N_A') }}
                        {{ $seller_details->store_info->store_phone ?? __('seller_messages.N_A') }}
                    </small><br>

                    <small class="text-muted">
                        {{ $seller_details->store_info->store_mail_id ?? __('seller_messages.N_A') }}
                    </small>
                    
                    <p class="mt-2 mb-0">
                        {{ $seller_details->store_info->store_address ?? __('seller_messages.N_A') }}
                    </p>
                    <p class="mt-2 mb-0">
                        {{ $seller_details->store_info->bio ?? __('seller_messages.N_A') }}
                    </p>
                </div>

            </div>

            <div class="product-row d-flex align-items-center gap-4 profile-card">
                <div class="product-item">
                    <a href="{{route('seller.add_highlight')}}">
                        <img src="{{asset('dealer/assets/img/hightlights-add.svg')}}" class="product-circle">
                    </a>
                </div>
                @foreach($highlights as $index => $highlight)
                    <div class="product-item" onclick='openSellerHighlightViewer(@json($highlight))'>
                        @php
                            $extension = pathinfo($highlight->file, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                            <video class="product-circle" autoplay muted loop playsinline>
                                <source src="{{ $highlight->file }}" type="video/{{ $extension }}">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <img src="{{ $highlight->file }}" class="product-circle">
                        @endif

                        <small>{{ $highlight->title ?? '' }}</small>
                    </div>
                @endforeach

            </div>
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

<div class="product_reels customContainer">
    <ul class="nav nav-tabs customNavTabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane"
                type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">
                 {{ __('seller_messages.My_Reels') }}
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reels-tab" data-bs-toggle="tab" data-bs-target="#reels-tab-pane" type="button"
                role="tab" aria-controls="reels-tab-pane" aria-selected="false">
                {{ __('seller_messages.Documents_Bank_Details') }}
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
                               <p>{{ __('seller_messages.Upload_New') }}</p>
                            </div>
                        </div>
                    </div>
                    @foreach($reels as $index => $reel)
                        <div class="col-lg-3 col-md-3">
                            <div class="reels-grid" onclick="showReels({{ $index }})">
                                <div class="reel-card">
                                    @php
                                        $extension = pathinfo($reel->file, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                        <video class="img-fluid" autoplay muted loop playsinline>
                                            <source src="{{ $reel->file }}" type="video/{{ $extension }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ $reel->file }}" alt="image" class="img-fluid">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>

        <div class="tab-pane fade" id="reels-tab-pane" role="tabpanel" aria-labelledby="reels-tab" tabindex="0">
            <div class="bank-show-panel">
                <div class="title24"> {{ __('seller_messages.Owners_Documents') }}</div>
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
                <div class="title24"> {{ __('seller_messages.Store_Documents') }}</div>
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
                <div class="title24"> {{ __('seller_messages.Bank_Details') }}</div>
                <div class="bank-lists">
                    <div class="personal-list-2">
                        <div class="lightName">  {{ __('seller_messages.Account_Type') }}</div>
                        <div class="title_black">@if(@$seller_details->seller_bank_details->account_type=='0')
                            Personal @else business @endif </div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">{{ __('seller_messages.IBAN') }}</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->iban }}</div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">{{ __('seller_messages.SWIFT_BIC') }}</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->swift }}</div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">{{ __('seller_messages.Bank_Name') }}</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->bank_name }}</div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName"> {{ __('seller_messages.Account_Holder_Name') }}</div>
                        <div class="title_black">{{ @$seller_details->seller_bank_details->account_holder_name }}
                        </div>
                    </div>
                    <div class="personal-list-2">
                        <div class="lightName">  {{ __('seller_messages.Proof_Of_Documents') }}</div>
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
                <a href="javascript:void(0)" onclick="closeStatus1()"><i class="bi bi-chevron-left"></i> </a>
                <h3>{{ __('seller_messages.Upload_New_Reel') }}</h3>
            </div>
            <button type="button" class="btn btn-light" onclick="closeStatus1()"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="logostatus">
            <label class="status-img" id="previewContainer">
                <!-- Placeholder -->
                <div id="bannerPlaceholderImg" class="text-center">
                    <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                        style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                    <div class="py-2" style="color:#875C3A">
                        {{ __('seller_messages.Upload') }}
                    </div>
                </div>

                <!-- Preview -->
                <div class="status-img">
                    <img id="storyimg" class="img-fluid" style="display:none;" />
                    <video id="storyvideo" class="img-fluid" controls style="display:none;"></video>
                </div>

                <!-- File Input -->
                <input type="file" id="storyUpload" accept="video/*" class="storyUpload" />

                <!-- File Error -->
                <div id="fileError" style="color:red; font-size:0.9rem; margin-top:0.5rem;"></div>
            </label>

            <div class="add-caption mt-3">
                 <h6>{{ __('seller_messages.Caption') }}</h6>
                <textarea id="storyCaption" class="form-control" placeholder="Write here..."></textarea>

                <!-- Caption Error -->
                <div id="captionError" style="color:red; font-size:0.9rem; margin-top:0.5rem;"></div>
            </div>
        </div>

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100">{{ __('seller_messages.Upload') }}</button>
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

<!-- Update New reeels section -->
<!-- <div class="status-viewer bgwhite" id="updatestory">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <div class="d-flex gap-2">
                <a href="javascript:void(0)" onclick="closeStatus3()"><i class="bi bi-chevron-left"></i> </a>
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
            <div class="add-caption">
                <h6>Caption</h6>
                <textarea class="form-control" placeholder="Write here..."></textarea>
            </div>

        </div>

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100">Upload</button>
        </div>
    </div>
</div> -->
<div class="status-viewer bgwhite" id="updatestory">
    <div class="container">
        <div class="story-header d-flex justify-content-between py-4">
            <div class="d-flex gap-2">
                <a href="javascript:void(0)" onclick="closeStatus3()"><i class="bi bi-chevron-left"></i></a>
                <h3>{{ __('seller_messages.Update_Reel') }}</h3>
            </div>
            <button type="button" class="btn btn-light" onclick="closeStatus3()"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="logostatus">
            <label class="status-img">
                <!-- Placeholder -->
                <div id="bannerhide2" class="text-center">
                    <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                        style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                    <div class="py-2" style="color:#875C3A">{{ __('seller_messages.Upload_Video') }}</div>
                </div>

                <!-- Preview -->
                <div class="status-img" id="previewContainerUpdate">
                    <img id="storyimg2" class="img-fluid" style="display:none;" />
                    <video id="storyvideo2" class="img-fluid" controls style="display:none;"></video>
                </div>

                <!-- File Input -->
                <input type="file" id="storyUpload2" accept="video/*" class="storyUpload" />
                <div id="fileError2" style="color:red; font-size:0.9rem;"></div>
            </label>
            <input type="hidden" id="existing_file2" value="">

            

            <div class="add-caption">
                <h6>{{ __('seller_messages.Caption') }} </h6>
                <textarea id="caption2" class="form-control" placeholder="Write here..."></textarea>
                <div id="captionError2" style="color:red; font-size:0.9rem;"></div>
            </div>
        </div>

        <div class="dashboard-button mt-4 logostatus bgwhite">
            <button type="button" class="btn add-fillbtn w-100" onclick="updateReelSubmit()"> {{ __('seller_messages.Upload') }}</button>
        </div>
    </div>
</div>

<!-- story viewer -->
 <div class="status-viewer bgwhite" id="sellerStoryViewer" style="display:none;">
    <div class="container highlightStatus">
        <div class="story-header d-flex justify-content-between">
            <div></div>
            <button type="button" class="btn btn-light" onclick="closeSellerStoryViewer()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="logostatus">
            <!-- Progress bar container -->
            <div id="sellerStoryProgressContainer" class="progress-container"></div>
            
            <div class="status-img">
                <!-- Image & Video -->
                <img id="sellerStoryImage" class="img-fluid" style="display:none;" />
                
                <video id="sellerStoryVideo"
                       style="width:100%; height:100%; object-fit:contain; display:none;"
                       controls autoplay muted>
                </video>
            </div>
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
</script>


<script>
// update new reels  function

    // function updateReels() {
    //     $("#updatestory").show();
    // }
    // function closeStatus3() {
    //     $("#updatestory").hide();
    // }
    // // Upload Preview
    // $("#storyUpload2").on("change", function(e) {
    //     let file = e.target.files[0];
    //     if (!file) return;

    //     let url = URL.createObjectURL(file);

    //     $("#storyimg2, #storyvideo2").hide();

    //     if (file.type.startsWith("image/")) {
    //         $("#storyimg2").attr("src", url).show();
    //         $("#bannerhide").hide();
    //     } else if (file.type.startsWith("video/")) {
    //         $("#storyvideo2").attr("src", url).show();
    //     } else {
    //         alert("Only image/video allowed");
    //     }
    // });

</script>



<script>
    var reels = @json($reels);
</script>
<script>

var reels = @json($reels);
var currentReelIndex = null;

function showReels(index) {
    $("#reelsview").show();
    currentReelIndex = index;

    var reel = reels[index];
    var file = reel.file;

    // Format created_at to DD/MM/YYYY
    var addedOn = "N/A";
    if (reel.created_at) {
        var date = new Date(reel.created_at);
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        addedOn = `${day}/${month}/${year}`;
    }

    var caption = reel.caption && reel.caption.trim() ? reel.caption : "N/A";

    var img = $("#showImageReel");
    var video = $("#showVideoReel");

    // Reset preview
    img.hide();
    video.hide();
    video.get(0).pause();
    video.attr("src", "");

    // Show image or video
    if (file.match(/\.(mp4|webm|ogg)$/i)) {
        video.attr("src", file).show();
        video.get(0).play();
    } else {
        img.attr("src", file).show();
    }

    // Set added-on and caption dynamically
    $("#reelAddedOn").text("Added On " + addedOn);
    $("#reelCaption").text(caption);

    // Inject dynamic buttons
    renderReelActions(reel);
}

function renderReelActions(reel) {
    var actionsDiv = $("#reelActions");
    actionsDiv.empty(); // remove old buttons

    // Status Toggle
    // var checked = reel.status ? "checked" : "";
    // var statusHtml = `
    //     <div class="form-check form-switch">
    //         <input class="form-check-input" type="checkbox" role="switch" id="switchReelStatus" ${checked} data-id="${reel.id}">
    //         <label class="form-check-label" for="switchReelStatus">Active</label>
    //     </div>
    // `;
    // actionsDiv.append(statusHtml);
    var checked = reel.status == 1 ? "checked" : "";
    var labelText = reel.status == 1 ? "Active" : "Inactive";
    var statusHtml = `
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="switchReelStatus${reel.id}" ${checked} data-id="${reel.id}">
            <label class="form-check-label" for="switchReelStatus${reel.id}">${labelText}</label>
        </div>
    `;
    actionsDiv.append(statusHtml);

    // Delete Button
    actionsDiv.append(`
        <a href="javascript:void(0)" class="pencil-btn-2 btn-red deleteReelBtn" data-id="${reel.id}">
            <i class="bi bi-trash3"></i>
        </a>
    `);

    // Edit Button
    actionsDiv.append(`
        <a href="javascript:void(0)" class="pencil-btn-2 edt-btn" onclick="updateReels(${currentReelIndex})">
            <i class="bi bi-pencil"></i>
        </a>
    `);
}

function closeStatus2() {
    $("#reelsview").hide();

    // Stop video
    var video = $("#showVideoReel").get(0);
    if (video) {
        video.pause();
        video.src = "";
    }
}


function updateReels(index) {
    var reel = reels[index];
    $("#updatestory").show();

    // Populate update modal dynamically
    var file = reel.file;
    var caption = reel.caption || "";

    var img = $("#storyimg2");
    var video = $("#storyvideo2");
    var placeholder = $("#bannerhide2");

    // Reset
    img.hide();
    video.hide();
    video.get(0).pause();
    video.attr("src", "");
    placeholder.show();

    // Show preview
    if (file.match(/\.(mp4|webm|ogg)$/i)) {
        video.attr("src", file).show();
        placeholder.hide();
    } else {
        img.attr("src", file).show();
        placeholder.hide();
    }

    // Set caption
    $("#caption2").val(caption);

    // Store current reel ID for AJAX
    currentReelId = reel.id;

    // Clear previous errors
    $("#fileError2").text("");
    $("#captionError2").text("");
}
</script>

<!-- upload reel -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Get Elements ---
    const storyUpload = document.getElementById('storyUpload');
    const storyImg = document.getElementById('storyimg');
    const storyVideo = document.getElementById('storyvideo');
    const placeholder = document.getElementById('bannerPlaceholderImg');
    const uploadBtn = document.querySelector('.dashboard-button .add-fillbtn');

    // Add IDs for caption and errors if not exist
    const caption = document.querySelector('.add-caption textarea');
    caption.id = 'storyCaption';
    
    let captionError = document.getElementById('captionError');
    if (!captionError) {
        captionError = document.createElement('div');
        captionError.id = 'captionError';
        captionError.style.color = 'red';
        captionError.style.fontSize = '0.9rem';
        caption.parentNode.appendChild(captionError);
    }

    let fileError = document.getElementById('fileError');
    if (!fileError) {
        fileError = document.createElement('div');
        fileError.id = 'fileError';
        fileError.style.color = 'red';
        fileError.style.fontSize = '0.9rem';
        placeholder.parentNode.appendChild(fileError);
    }

    // --- Preview Image/Video ---
    storyUpload.addEventListener('change', function() {
        const file = this.files[0];
        fileError.textContent = '';
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            placeholder.style.display = 'none';
            if (file.type.startsWith('image/')) {
                storyImg.src = e.target.result;
                storyImg.style.display = 'block';
                storyVideo.style.display = 'none';
            } else if (file.type.startsWith('video/')) {
                storyVideo.src = e.target.result;
                storyVideo.style.display = 'block';
                storyImg.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    });

    // --- Remove errors when typing/selecting ---
    caption.addEventListener('input', () => captionError.textContent = '');
    storyUpload.addEventListener('change', () => fileError.textContent = '');

    // --- Upload AJAX ---
    uploadBtn.addEventListener('click', async function() {
        fileError.textContent = '';
        captionError.textContent = '';

        const file = storyUpload.files[0];
        const captionText = caption.value.trim();
        let hasError = false;

        if (!file) {
            fileError.textContent = 'Please upload image/video';
            hasError = true;
        }
        if (!captionText) {
            captionError.textContent = 'Please enter caption';
            hasError = true;
        }
        if (hasError) return;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('caption', captionText);

        // Optional: show loader here if you have one
        try {
            const response = await fetch("{{ route('seller.upload_reel') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                body: formData
            });

            const data = await response.json();

            if (data.status === 'success') {
                toastr.success(data.message || 'Reel uploaded successfully');
                setTimeout(() => location.reload(), 1200);
            } else if (data.status === 'failed') {
                toastr.error(data.message || 'Upload failed');

                setTimeout(() => {
                    window.location.href = "{{ route('seller.all_plans') }}";
                }, 1500);

            } else {
                toastr.error(data.message || 'Something went wrong');
            }

        } catch (error) {
            toastr.error('Something went wrong');
            console.error(error);
        }
    });
});
</script>

<!-- update reel -->
<script>
let currentReelId = null;

/* =========================
   OPEN EDIT MODAL
========================= */
function updateReels(index) {

    const reel = reels[index];

    $("#updatestory").show();

    currentReelId = reel.id;

    const file = reel.file;
    const caption = reel.caption || "";

    const img = document.getElementById("storyimg2");
    const video = document.getElementById("storyvideo2");
    const placeholder = document.getElementById("bannerhide2");

    // Reset preview
    img.style.display = "none";
    img.src = "";

    video.style.display = "none";
    video.pause();
    video.src = "";

    placeholder.style.display = "block";

    // Set existing file
    document.getElementById("existing_file2").value = file;

    // Show preview
    if (file && file.match(/\.(mp4|webm|ogg)$/i)) {
        video.src = file;
        video.style.display = "block";
        placeholder.style.display = "none";
    } else if (file) {
        img.src = file;
        img.style.display = "block";
        placeholder.style.display = "none";
    }

    // Set caption
    document.getElementById("caption2").value = caption;

    // Clear errors
    document.getElementById("fileError2").textContent = "";
    document.getElementById("captionError2").textContent = "";
}


/* =========================
   CLOSE MODAL
========================= */
function closeStatus3() {
    document.getElementById("updatestory").style.display = "none";

    const video = document.getElementById("storyvideo2");
    video.pause();
    video.src = "";

    document.getElementById("storyUpload2").value = "";
    document.getElementById("caption2").value = "";
    document.getElementById("existing_file2").value = "";

    document.getElementById("storyimg2").style.display = "none";
    document.getElementById("storyvideo2").style.display = "none";
    document.getElementById("bannerhide2").style.display = "block";

    document.getElementById("fileError2").textContent = "";
    document.getElementById("captionError2").textContent = "";
}


/* =========================
   FILE PREVIEW
========================= */
document.getElementById("storyUpload2").addEventListener("change", function(e) {

    const file = e.target.files[0];
    document.getElementById("fileError2").textContent = "";

    if (!file) return;

    const img = document.getElementById("storyimg2");
    const video = document.getElementById("storyvideo2");
    const placeholder = document.getElementById("bannerhide2");

    img.style.display = "none";
    video.style.display = "none";

    const fileURL = URL.createObjectURL(file);

    if (file.type.startsWith("image/")) {
        img.src = fileURL;
        img.style.display = "block";
        placeholder.style.display = "none";
    } 
    else if (file.type.startsWith("video/")) {
        video.src = fileURL;
        video.style.display = "block";
        placeholder.style.display = "none";
    }
});


/* =========================
   REMOVE ERROR ON INPUT
========================= */
document.getElementById("caption2").addEventListener("input", function() {
    document.getElementById("captionError2").textContent = "";
});


/* =========================
   SUBMIT UPDATE (FETCH)
========================= */
async function updateReelSubmit() {

    const file = document.getElementById("storyUpload2").files[0];
    const caption = document.getElementById("caption2").value.trim();
    const existingFile = document.getElementById("existing_file2").value;

    const fileError = document.getElementById("fileError2");
    const captionError = document.getElementById("captionError2");

    fileError.textContent = "";
    captionError.textContent = "";

    let hasError = false;

    // Validation
    if (!file && !existingFile) {
        fileError.textContent = "Please upload image/video";
        hasError = true;
    }

    if (!caption) {
        captionError.textContent = "Please enter caption";
        hasError = true;
    }

    if (hasError) return;

    const formData = new FormData();

    if (file) {
        formData.append("file", file);
    } else {
        formData.append("existing_file", existingFile);
    }

    formData.append("caption", caption);
    formData.append("reel_id", currentReelId);

    try {
        // ✅ SHOW LOADER
        if (window.loader) loader.style.display = 'block';

        const res = await fetch("{{ route('seller.update_reel') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        });

        const data = await res.json();

        // ✅ HIDE LOADER
        if (window.loader) loader.style.display = 'none';

        if (data.status === "success") {
            toastr.success(data.message || "Reel updated successfully");
            setTimeout(() => location.reload(), 1200);
        } else {
            toastr.error(data.message || "Failed to update reel");
        }

    } catch (error) {

        // ✅ HIDE LOADER ON ERROR
        if (window.loader) loader.style.display = 'none';

        toastr.error("Something went wrong");
        console.error(error);
    }
}
</script>

<!-- delete reel -->
<script>
document.body.addEventListener('click', function(e) {
    if (e.target.closest('.deleteReelBtn')) {
        const button = e.target.closest('.deleteReelBtn');
        const reelId = button.getAttribute('data-id');

        const originalHTML = button.innerHTML;
       // button.innerHTML = "Deleting...";
        button.disabled = true;

        fetch(`/seller/delete_reel/${reelId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            button.innerHTML = originalHTML;
            button.disabled = false;

            if (data.status === "success") {
                toastr.success(data.message || "Reel deleted successfully");
                setTimeout(() => location.reload(), 1000);
            } else {
                toastr.error(data.message || "Failed to delete reel");
            }
        })
        .catch(err => {
            button.innerHTML = originalHTML;
            button.disabled = false;
            toastr.error("Something went wrong.");
            console.error(err);
        });
    }
});
</script>

<script>
document.body.addEventListener('change', function(e) {
    // Check if the changed element is a reel status toggle
    if (e.target && e.target.classList.contains('form-check-input')) {
        const toggle = e.target;
        const reelId = toggle.getAttribute('data-id');
        const isActive = toggle.checked ? 1 : 0;

        // Update label next to the switch
        const label = toggle.nextElementSibling;
        if (label) label.textContent = isActive ? 'Active' : 'Inactive';

        // AJAX call to update status
        fetch('/seller/updateReelStatus', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ reel_id: reelId, status: isActive })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                toastr.success(data.message || 'Reel status updated');
            } else {
                toastr.error(data.message || 'Failed to update status');
                // Revert toggle if failed
                toggle.checked = !toggle.checked;
                if (label) label.textContent = toggle.checked ? 'Active' : 'Inactive';
            }
        })
        .catch(err => {
            toastr.error('Something went wrong');
            console.error(err);
            // Revert toggle on error
            toggle.checked = !toggle.checked;
            if (label) label.textContent = toggle.checked ? 'Active' : 'Inactive';
        });
    }
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

<script>
let sellerStories = [];
let sellerStoryIndex = 0;
let sellerStoryTimer = null;
let sellerStoryDuration = 3000;

// OPEN VIEWER
function openSellerStoryViewer(stories, startIndex = 0) {
    clearTimeout(sellerStoryTimer);

    sellerStories = stories;
    sellerStoryIndex = startIndex;

    document.getElementById("sellerStoryViewer").style.display = "block";

    renderProgressBars(); // ✅ create all bars once
    showSellerStory(sellerStoryIndex);
}

// CREATE ALL PROGRESS BARS
function renderProgressBars() {
    const container = document.getElementById("sellerStoryProgressContainer");
    container.innerHTML = '';

    sellerStories.forEach((_, i) => {
        container.innerHTML += `
            <div style="flex:1; margin:2px; background:#ddd; height:4px;">
                <div id="progress_${i}" 
                     style="width:0%; height:100%; background:#007bff;"></div>
            </div>
        `;
    });
}

// SHOW STORY
function showSellerStory(index) {
    clearTimeout(sellerStoryTimer);

    if (index >= sellerStories.length) {
        closeSellerStoryViewer();
        return;
    }

    const story = sellerStories[index];
    const imageEl = document.getElementById("sellerStoryImage");
    const videoEl = document.getElementById("sellerStoryVideo");

    // RESET MEDIA
    imageEl.style.display = "none";
    videoEl.style.display = "none";
    videoEl.pause();
    videoEl.src = "";

    // UPDATE PROGRESS BARS
    sellerStories.forEach((_, i) => {
        const bar = document.getElementById(`progress_${i}`);
        if (!bar) return;

        if (i < index) {
            bar.style.width = "100%";
        } else {
            bar.style.width = "0%";
        }
    });

    const currentBar = document.getElementById(`progress_${index}`);

    const file = story.file;
    const isVideo = file.match(/\.(mp4|webm|ogg)$/i);

    if (isVideo) {
        videoEl.src = file;
        videoEl.style.display = "block";

        videoEl.onloadedmetadata = function () {
            sellerStoryDuration = videoEl.duration * 1000;
            animateProgress(currentBar, sellerStoryDuration);
        };

        videoEl.onended = function () {
            nextSellerStory();
        };

    } else {
        imageEl.src = file;
        imageEl.style.display = "block";

        sellerStoryDuration = 3000;
        animateProgress(currentBar, sellerStoryDuration);
    }
}

// PROGRESS ANIMATION
function animateProgress(progressEl, duration) {
    clearTimeout(sellerStoryTimer);

    progressEl.style.transition = "none";
    progressEl.style.width = "0%";

    setTimeout(() => {
        progressEl.style.transition = `width ${duration}ms linear`;
        progressEl.style.width = "100%";
    }, 50);

    sellerStoryTimer = setTimeout(() => {
        nextSellerStory();
    }, duration);
}

// NEXT STORY
function nextSellerStory() {
    sellerStoryIndex++;

    if (sellerStoryIndex >= sellerStories.length) {
        closeSellerStoryViewer();
    } else {
        showSellerStory(sellerStoryIndex);
    }
}

// CLOSE VIEWER
function closeSellerStoryViewer() {
    clearTimeout(sellerStoryTimer);

    const imageEl = document.getElementById("sellerStoryImage");
    const videoEl = document.getElementById("sellerStoryVideo");

    document.getElementById("sellerStoryViewer").style.display = "none";

    imageEl.style.display = "none";

    videoEl.pause();
    videoEl.style.display = "none";
    videoEl.src = "";
}
</script>






@include('dealer.layout.footer')
@extends('admin.layout.app')
@section('content')
@php
$admin = auth('admin')->user();

$permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
->where('can_action', 1)
->pluck('module_id')
->toArray();
@endphp

<style>
#editPreviewImage {
    display: block;
}

.upload-box {
    width: 220px;
    height: 160px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.upload-icon {
    width: 60px;
    opacity: 0.5;
}

.upload-text {
    margin-top: 10px;
    font-size: 14px;
    color: #444;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    display: none;
}
</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">{{ __('admin_messages.story_management') }}</h2>
        </div>


    </div>
    <!-- <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    {{ __('admin_messages.seller_stories') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    {{ __('admin_messages.admin_platform_stories') }}
                </button>
            </li>

        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">


            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">

                <form method="GET" action="{{ route('admin.storyManagement') }}" id="filterForm">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="search-box" style="position: relative;">
                            <i class="bi bi-search" style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      ">
                            </i>
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group mb-5 ">
                            <select name="country"
                                class="form-select form-select-lg w-50 "
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">{{ __('admin_messages.select_country') }}</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['name'] }}"
                                    {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                    @if(app()->getLocale() == 'en')
                                        {{ $country['name'] }}
                                        @else
                                        {{ $country['name_ar'] }}
                                        @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                </form>



                <div class="table-responsive  w-100">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.posted_image_video') }}</th>
                                <th scope="col">{{ __('admin_messages.posted_on') }}</th>
                                @if(in_array(19, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sellerStory as $index => $story)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>

                                <td>
                                    {{ $story->seller_details?->first_name ?? __('admin_messages.na') }} 
                                    {{ $story->seller_details?->last_name ?? '' }}
                                </td>

                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $story->seller_details?->store_info?->country_info?->name ?? __('admin_messages.posted_on') }}
                                    @else
                                    {{ $story->seller_details?->store_info?->country_info?->name_ar ?? __('admin_messages.posted_on') }}
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $ext = strtolower(pathinfo($story->file, PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg','jpeg','png','gif','svg'];
                                        $videoExtensions = ['mp4','mov','avi','mkv'];
                                    @endphp

                                    @if(in_array($ext, $imageExtensions))
                                        <a href="{{ $story->file }}" target="_blank">
                                            <img src="{{ $story->file }}" alt="Story" width="40" height="40" class="square" />
                                        </a>
                                    @elseif(in_array($ext, $videoExtensions))
                                        <a href="{{ $story->file }}" target="_blank">
                                            <video width="40" height="40" class="square" muted playsinline loop>
                                                <source src="{{ $story->file }}" type="video/{{ $ext }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                    @else
                                        <span>File not supported</span>
                                    @endif
                                </td>

                                <td>
                                    
                                        {{formatDateTimeByLocale($story->created_at)}}
                                </td>

                                @if(in_array(19, $permissions) || $admin->type == 1)
                                <td>

                                    <div class="d-flex  justify-content-center">


                                        <a href="javascript:void(0);" class="table-button text-danger deleteStory mb-1 mt-1"
                                            data-id="{{ $story['id'] }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                    </div>
                                </td>
                                @endif

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('admin_messages.no_data_found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

  
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">

                <div class="row">
                    <div class="align-items-end d-flex">

                        <div class="col-lg-6 col-md-4 col-12">

                            <div class="search-box w-50" style="position: relative;">
                                <i class="bi bi-search" style="
                            position: absolute;
                            left: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                            font-size: 16px;
                            color: #888;
                          ">
                                </i>
                                <input type="text" class="form-control" placeholder="Search for..."
                                    style="padding-left: 35px" />
                            </div>

                        </div>
                        @if(in_array(19, $permissions) || $admin->type == 1)
                        <div class="col-lg-6 ">
                            <div class="d-flex  align-items-end justify-content-end">
                                <a class="btn btn-dark customBtn" data-bs-toggle="modal"
                                    data-bs-target="#sentModalphoto">
                                    <span>{{ __('admin_messages.add') }}</span>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>

                </div>

                <div class="table-responsive mt-2 w-100">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.posted_image_video') }}</th>
                                <th scope="col">{{ __('admin_messages.posted_on') }}</th>
                                <th scope="col">{{ __('admin_messages.status') }}</th>
                                @if(in_array(19, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($adminStory as $index => $story)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    @php
                                        $ext = strtolower(pathinfo($story['file'], PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg','jpeg','png','gif','svg'];
                                        $videoExtensions = ['mp4','mov','avi','mkv'];
                                    @endphp

                                    @if(in_array($ext, $imageExtensions))
                                        <a href="{{ $story['file'] }}" target="_blank">
                                            <img src="{{ $story['file'] }}" alt="Story" width="40" height="40" class="square" />
                                        </a>
                                    @elseif(in_array($ext, $videoExtensions))
                                        <a href="{{ $story['file'] }}" target="_blank">
                                            <video width="40" height="40" class="square" muted playsinline loop>
                                                <source src="{{ $story['file'] }}" type="video/{{ $ext }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                    @else
                                        <span>File not supported</span>
                                    @endif
                                </td>
                                <td>
                                    {{formatDateTimeByLocale($story['created_at'])}}
                                </td>
                                <td>{{ $story['status'] == 1 ? __('admin_messages.active') : __('admin_messages.inactive') }}</td>
                                @if(in_array(19, $permissions) || $admin->type == 1)
                                <td>

                                    <div class="d-flex  justify-content-center">


                                        <a href="javascript:void(0);" class="table-button text-danger deleteStory mb-1 mt-1"
                                            data-id="{{ $story['id'] }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                    </div>
                                </td>
                                @endif
                            </tr>
                             @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('admin_messages.no_data_found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div> -->
    <!-- MAIN TABS NAVIGATION (Seller Stories / Admin Platform Stories) -->
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="false">
                    {{ __('admin_messages.seller_stories') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    {{ __('admin_messages.admin_platform_stories') }}
                </button>
            </li>
        </ul>
    </div>

    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">

            <!-- ==================== MAIN TAB 1: SELLER STORIES ==================== -->
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">

                <!-- SELLER STORIES INNER SUB-TABS (Free / Promotional) WITH MAIN TAB CLASSES AND CENTERED -->
                <div class="d-flex justify-content-center">
                    <ul class="nav nav-pills mb-3 tabs-pnl custom" id="seller-sub-tab" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link active customBtn2 m-0" id="seller-free-tab" data-bs-toggle="pill"
                                data-bs-target="#seller-free" type="button" role="tab" aria-controls="seller-free"
                                aria-selected="true">Free</button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="seller-promotional-tab" data-bs-toggle="pill"
                                data-bs-target="#seller-promotional" type="button" role="tab"
                                aria-controls="seller-promotional" aria-selected="false">Promotional</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="seller-sub-tabContent">
                    <!-- FREE TAB CONTENT: Aapka Original Code With Table -->
                    <div class="tab-pane fade show active" id="seller-free" role="tabpanel"
                        aria-labelledby="seller-free-tab" tabindex="0">

                        <form method="GET" action="{{ route('admin.storyManagement') }}" id="filterForm">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group mb-5">
                                        <select name="country" class="form-select form-select-lg w-50"
                                            onchange="document.getElementById('filterForm').submit();">
                                            <option value="">{{ __('admin_messages.select_country') }}</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country['name'] }}"
                                                {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                                @if(app()->getLocale() == 'en')
                                                {{ $country['name'] }}
                                                @else
                                                {{ $country['name_ar'] }}
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive w-100">
                            <table id="myTable" class="table w-100">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                        <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                        <th scope="col">{{ __('admin_messages.country') }}</th>
                                        <th scope="col">{{ __('admin_messages.posted_image_video') }}</th>
                                        <th scope="col">{{ __('admin_messages.posted_on') }}</th>
                                        @if(in_array(19, $permissions) || $admin->type == 1)
                                        <th scope="col">{{ __('admin_messages.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sellerStory as $index => $story)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>
                                            {{ $story->seller_details?->first_name ?? __('admin_messages.na') }}
                                            {{ $story->seller_details?->last_name ?? '' }}
                                        </td>
                                        <td>
                                            @if(app()->getLocale() == 'en')
                                            {{ $story->seller_details?->store_info?->country_info?->name ?? __('admin_messages.posted_on') }}
                                            @else
                                            {{ $story->seller_details?->store_info?->country_info?->name_ar ?? __('admin_messages.posted_on') }}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                            $ext = strtolower(pathinfo($story->file, PATHINFO_EXTENSION));
                                            $imageExtensions = ['jpg','jpeg','png','gif','svg'];
                                            $videoExtensions = ['mp4','mov','avi','mkv'];
                                            @endphp

                                            @if(in_array($ext, $imageExtensions))
                                            <a href="{{ $story->file }}" target="_blank">
                                                <img src="{{ $story->file }}" alt="Story" width="40" height="40"
                                                    class="square" />
                                            </a>
                                            @elseif(in_array($ext, $videoExtensions))
                                            <a href="{{ $story->file }}" target="_blank">
                                                <video width="40" height="40" class="square" muted playsinline loop>
                                                    <source src="{{ $story->file }}" type="video/{{ $ext }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </a>
                                            @else
                                            <span>File not supported</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ formatDateTimeByLocale($story->created_at) }}
                                        </td>
                                        @if(in_array(19, $permissions) || $admin->type == 1)
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0);"
                                                    class="table-button text-danger deleteStory mb-1 mt-1"
                                                    data-id="{{ $story['id'] }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('admin_messages.no_data_found') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="tab-pane fade" id="seller-promotional" role="tabpanel"
                        aria-labelledby="seller-promotional-tab" tabindex="0">
                        <div class="table-responsive w-100">
                            <table id="myTable" class="table w-100">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                        <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                                        <th scope="col">{{ __('admin_messages.country') }}</th>
                                        <th scope="col">{{ __('admin_messages.posted_image_video') }}</th>
                                        <th scope="col">{{ __('admin_messages.posted_on') }}</th>
                                        @if(in_array(19, $permissions) || $admin->type == 1)
                                        <th scope="col">{{ __('admin_messages.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sellerStory as $index => $story)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>
                                            {{ $story->seller_details?->first_name ?? __('admin_messages.na') }}
                                            {{ $story->seller_details?->last_name ?? '' }}
                                        </td>
                                        <td>
                                            @if(app()->getLocale() == 'en')
                                            {{ $story->seller_details?->store_info?->country_info?->name ?? __('admin_messages.posted_on') }}
                                            @else
                                            {{ $story->seller_details?->store_info?->country_info?->name_ar ?? __('admin_messages.posted_on') }}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                            $ext = strtolower(pathinfo($story->file, PATHINFO_EXTENSION));
                                            $imageExtensions = ['jpg','jpeg','png','gif','svg'];
                                            $videoExtensions = ['mp4','mov','avi','mkv'];
                                            @endphp

                                            @if(in_array($ext, $imageExtensions))
                                            <a href="{{ $story->file }}" target="_blank">
                                                <img src="{{ $story->file }}" alt="Story" width="40" height="40"
                                                    class="square" />
                                            </a>
                                            @elseif(in_array($ext, $videoExtensions))
                                            <a href="{{ $story->file }}" target="_blank">
                                                <video width="40" height="40" class="square" muted playsinline loop>
                                                    <source src="{{ $story->file }}" type="video/{{ $ext }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </a>
                                            @else
                                            <span>File not supported</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ formatDateTimeByLocale($story->created_at) }}
                                        </td>
                                        @if(in_array(19, $permissions) || $admin->type == 1)
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0);"
                                                    class="table-button text-danger deleteStory mb-1 mt-1"
                                                    data-id="{{ $story['id'] }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('admin_messages.no_data_found') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">

                <div class="row align-items-center mb-4">
                    <div class="col-lg-6 col-md-6 col-12 d-flex gap-2">
                        <div class="search-box position-relative" style="width: 200px;">
                            <i class="bi bi-search"
                                style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #888;"></i>
                            <input type="text" class="form-control" placeholder="search"
                                style="padding-left: 35px; border-radius: 20px;" />
                        </div>
                        <select class="form-select w-auto" style="border-radius: 20px;">
                            <option>Country 1</option>
                        </select>
                    </div>
                    @if(in_array(19, $permissions) || $admin->type == 1)
                    <div class="col-lg-6 col-md-6 col-12 text-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModalphoto">
                            <span>{{ __('admin_messages.add') }}</span>
                        </a>
                    </div>
                    @endif
                </div>

                <div class="d-flex justify-content-center">
                    <ul class="nav nav-pills mb-3 tabs-pnl custom" id="admin-sub-tabs" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link active customBtn2 m-0" id="live-new-tab" data-bs-toggle="pill"
                                data-bs-target="#live-new" type="button" role="tab" aria-controls="live-new"
                                aria-selected="true">New</button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="live-approved-tab" data-bs-toggle="pill"
                                data-bs-target="#live-approved" type="button" role="tab" aria-controls="live-approved"
                                aria-selected="false">Approved</button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="live-rejected-tab" data-bs-toggle="pill"
                                data-bs-target="#live-rejected" type="button" role="tab" aria-controls="live-rejected"
                                aria-selected="false">Rejected</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="admin-sub-tabsContent">

                    <div class="tab-pane fade show active" id="live-new" role="tabpanel" aria-labelledby="live-new-tab"
                        tabindex="0">
                        <div class="table-responsive w-100">
                            <table class="table table-bordered w-100 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.R No</th>
                                        <th>Request ID</th>
                                        <th>Seller Name</th>
                                        <th>Seller Country</th>
                                        <th>Request On</th>
                                        <th>Story Image/Content</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>#22222</td>
                                        <td>Lorem</td>
                                        <td>UAE</td>
                                        <td>2nd September 2025 | 11 Am</td>
                                        <td><i class="bi bi-image" style="font-size: 20px;"></i></td>
                                        <td>10th September 2025</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button class="btn btn-sm btn-primary rounded-circle"
                                                    style="width:28px; height:28px; padding:0;"><i
                                                        class="bi bi-check-lg"></i></button>
                                                <button class="btn btn-sm btn-danger rounded-circle"
                                                    style="width:28px; height:28px; padding:0;"><i
                                                        class="bi bi-x-lg"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="live-approved" role="tabpanel" aria-labelledby="live-approved-tab"
                        tabindex="0">
                        <div class="table-responsive w-100">
                            <table class="table table-bordered w-100 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.R No</th>
                                        <th>Request ID</th>
                                        <th>Seller Name</th>
                                        <th>Seller Country</th>
                                        <th>Request On</th>
                                        <th>Story Image/Content</th>
                                        <th>Date</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>#22222</td>
                                        <td>Lorem</td>
                                        <td>UAE</td>
                                        <td>2nd September 2025 | 11 Am</td>
                                        <td><i class="bi bi-image" style="font-size: 20px;"></i></td>
                                        <td>10th September 2025</td>
                                        <td>KD 40</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="live-rejected" role="tabpanel" aria-labelledby="live-rejected-tab"
                        tabindex="0">
                        <div class="table-responsive w-100">
                            <table class="table table-bordered w-100 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.R No</th>
                                        <th>Request ID</th>
                                        <th>Seller Name</th>
                                        <th>Seller Country</th>
                                        <th>Request On</th>
                                        <th>Story Image/Content</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>#22222</td>
                                        <td>Lorem</td>
                                        <td>UAE</td>
                                        <td>2nd September 2025 | 11 Am</td>
                                        <td><i class="bi bi-image" style="font-size: 20px;"></i></td>
                                        <td>10th September 2025</td>
                                        <td>Lorem Lorem</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>

<!-- <div class="modal fade" id="sentModalphoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add New </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addBrandForm" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="upload-title text-center">Upload Image</div>

                                <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                    <img src="/admin/image/upload-icon.svg" id="uploadIcon" />
                                    <img id="previewImage" class="preview-image" style="display:none; max-width:216px; margin-top:-2px;" />
                                    <div class="upload-text">Upload Image</div>
                                    <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                                </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="modal fade" id="sentModalphoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.add_new_story') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addBrandForm" enctype="multipart/form-data">
                        <div class="row">

                            <!-- Upload Image/Video -->
                            <div class="col-lg-12">
                                <div class="upload-title text-center">{{ __('admin_messages.upload_image_or_video') }}
                                </div>

                                <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                    <img src="/admin/image/upload-icon.svg" id="uploadIcon" />
                                    <img id="previewImage" class="preview-image"
                                        style="display:none; max-width:216px; margin-top:-2px;" />
                                    <video id="previewVideo" class="preview-image"
                                        style="display:none; max-width:216px; margin-top:-2px;" controls></video>
                                    <div class="upload-text">{{ __('admin_messages.upload_image_or_video') }}</div>
                                    <input type="file" id="fileUpload" name="file" accept="image/*,video/*" hidden />
                                </label>
                                <div id="fileError" style="color:red; font-size: 0.875rem; margin-top:5px;"></div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <a type="button" id="submitStoryBtn"
                                    class="btn btn-dark customBtn mt-3">{{ __('admin_messages.submit') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get last active tab from localStorage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Save active tab to localStorage when switched
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteStory').forEach(button => {
        button.addEventListener('click', function() {
            let storyId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteStory/${storyId}`, {
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
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
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
document.addEventListener('DOMContentLoaded', function() {

    const fileUpload = document.getElementById('fileUpload');
    const uploadIcon = document.getElementById('uploadIcon');
    const previewImage = document.getElementById('previewImage');
    const previewVideo = document.getElementById('previewVideo');
    const submitBtn = document.getElementById('submitStoryBtn');
    const fileError = document.getElementById('fileError');

    /* ===== Preview Image/Video ===== */
    fileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        fileError.innerText = '';

        if (!file) return;

        const type = file.type;

        if (type.startsWith('image/')) {
            previewVideo.style.display = 'none';
            previewVideo.src = '';
            previewImage.src = URL.createObjectURL(file);
            previewImage.style.display = 'block';
        } else if (type.startsWith('video/')) {
            previewImage.style.display = 'none';
            previewImage.src = '';
            previewVideo.src = URL.createObjectURL(file);
            previewVideo.style.display = 'block';
        } else {
            fileError.innerText = "{{ __('admin_messages.file_must_be_image_or_video') }}";
            fileUpload.value = '';
            previewImage.style.display = 'none';
            previewVideo.style.display = 'none';
            return;
        }

        uploadIcon.style.display = 'none';
    });

    submitBtn.addEventListener('click', function() {
        fileError.innerText = '';

        const file = fileUpload.files[0];
        if (!file) {
            fileError.innerText = "{{ __('admin_messages.please_select_an_image_or_video') }}";
            return;
        }

        submitBtn.innerText = "{{ __('admin_messages.uploading') }}";
        submitBtn.classList.add('disabled');
        submitBtn.style.pointerEvents = 'none';

        const formData = new FormData();
        formData.append('file', file);

        fetch('{{ url("admin/addStory") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        $('#sentModalphoto').modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error(data.message);
            });
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('sentModalphoto');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
});
</script>

@endsection
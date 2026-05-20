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

@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp


<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">{{ __('admin_messages.banner_management') }}</h2>
        </div>
    </div>


    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0 active" id="pills-fullscreen-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-fullscreen" type="button" role="tab" aria-controls="pills-fullscreen"
                    aria-selected="true">
                    {{ __('admin_messages.full_screen') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link  customBtn2 m-0" id="pills-promo-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-promo" type="button" role="tab" aria-controls="pills-promo"
                    aria-selected="true">
                    {{ __('admin_messages.promotional') }}
                </button>
            </li>
        </ul>
    </div>


    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-fullscreen" role="tabpanel"
            aria-labelledby="pills-fullscreen-tab" tabindex="0">
            <div class="d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('admin.fullScreenBannerManagement') }}" id="filterForm">
                    <div class="form-group mb-3">
                        <label for="from" class="form-label">{{ __('admin_messages.select_country') }}</label>
                        <select name="country" class="form-select form-select-lg"
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
                </form>
                @if(in_array(21, $permissions) || $admin->type == 1)
                <div class="d-flex justify-content-end">
                    <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                        <span>{{ __('admin_messages.add_advertisement') }}</span>
                    </a>
                </div>
                @endif
            </div>

            <div class="userManagecontent">
                <div class="">
                    <div class="table-responsive mb-5 w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                    <th scope="col">{{ __('admin_messages.banner') }}</th>
                                    <th scope="col">{{ __('admin_messages.title') }}</th>
                                    <th scope="col">{{ __('admin_messages.type') }}</th>
                                    <th scope="col">{{ __('admin_messages.country') }}</th>
                                    <th scope="col">{{ __('admin_messages.start_date') }}</th>
                                    <th scope="col">{{ __('admin_messages.end_date') }}</th>
                                    @if(in_array(21, $permissions) || $admin->type == 1)
                                    <th scope="col">{{ __('admin_messages.action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $index => $banner)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>
                                        <a href="{{ $banner['image'] }}" target="_blank">
                                            <img src="{{ $banner['image'] }}" alt="" width="40" height="40"
                                                class="square">
                                        </a>
                                    </td>
                                    <td>{{ $banner['title'] }}</td>
                                    <td>
                                        @if($banner['type'] == '1')
                                        {{ __('admin_messages.mobile') }}
                                        @else
                                        {{ __('admin_messages.web') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(app()->getLocale() == 'en')
                                        {{ $banner['country_info']['name'] }}
                                        @else
                                        {{ $banner['country_info']['name_ar'] }}
                                        @endif
                                    </td>
                                    <td>{{ $banner['start_date'] }}</td>
                                    <td>{{ $banner['end_date'] }}</td>
                                    @if(in_array(21, $permissions) || $admin->type == 1)
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a href="javascript:void(0);" class="table-button edit-reason-btn"
                                                data-id="{{ $banner['id'] }}" data-title="{{ $banner['title'] }}"
                                                data-country-id="{{ $banner['country_id'] }}"
                                                data-type="{{ $banner['type'] }}"
                                                data-start-date="{{ $banner['start_date'] }}"
                                                data-end-date="{{ $banner['end_date'] }}"
                                                data-image="{{ $banner['image'] }}" data-bs-toggle="modal"
                                                data-bs-target="#editBannerModal">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="table-button text-danger deleteBanner mb-1 mt-1"
                                                data-id="{{ $banner->id }}">
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
        </div>

        <div class="tab-pane fade" id="pills-promo" role="tabpanel" aria-labelledby="pills-promo-tab" tabindex="0">
            <div class="d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('admin.fullScreenBannerManagement') }}" id="filterForm">
                    <!-- <div class="form-group mb-3">
                        <label for="from" class="form-label">Country Name</label>
                        <select name="country" class="form-select form-select-lg"
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}"
                                {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div> -->
                </form>
                @if(in_array(21, $permissions) || $admin->type == 1)
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#addPromotional">
                        <span>{{ __('admin_messages.add_promotional') }}</span>
                    </a>
                </div>
                @endif
            </div>

            <div class="userManagecontent">
                <div class="table-responsive mb-5 w-100">
                    <table id="myTable2" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.banner') }}</th>
                                <!-- <th scope="col">Title</th>
                                <th scope="col">Type</th> -->
                                <th scope="col">{{ __('admin_messages.position') }}</th>
                                <!-- <th scope="col">Country</th> -->
                                 <th scope="col">{{ __('admin_messages.category') }}</th>
                                 <th scope="col">{{ __('admin_messages.sub_category') }}</th>
                                <th scope="col">{{ __('admin_messages.start_date') }}</th>
                                <th scope="col">{{ __('admin_messages.end_date') }}</th>
                                @if(in_array(21, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                           @forelse($promotionalBanners as $index => $banner)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    <a href="{{ $banner['upload_banner'] }}" target="_blank">
                                            <img src="{{ $banner['upload_banner'] }}" alt="" width="40" height="40"
                                                class="square">
                                    </a>
                                </td>
                                <!-- <td>rreg</td>
                                <td>Mobile</td> -->
                                <td>
                                    @if($banner['banner_position'] == '1')
                                    {{ __('admin_messages.home_top') }}
                                    @elseif($banner['banner_position'] == '2')
                                    {{ __('admin_messages.home_bottom') }}
                                    @elseif($banner['banner_position'] == '3')
                                    {{ __('admin_messages.category') }}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($banner['category_details']))
                                        @if(app()->getLocale() == 'en')
                                        {{$banner['category_details']['name']}}
                                        @else
                                        {{$banner['category_details']['name_ar']}}
                                        @endif
                                    @else
                                    {{ __('admin_messages.na') }}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($banner['subcategory_details']))
                                        @if(app()->getLocale() == 'en')
                                        {{$banner['subcategory_details']['name_english']}}
                                        @else
                                        {{$banner['subcategory_details']['name_arabic']}}
                                        @endif
                                    @else
                                    {{ __('admin_messages.na') }}
                                    @endif
                                </td>
                                <!-- <td>India</td> -->
                                <td>{{ $banner['start_date'] }}</td>
                                <td>{{ $banner['end_date'] }}</td>
                                @if(in_array(21, $permissions) || $admin->type == 1)
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);"
                                            class="table-button edit-promotional-btn"
                                            data-id="{{ $banner['id'] }}"
                                            data-image="{{ $banner['upload_banner'] }}"
                                            data-position="{{ $banner['banner_position'] }}"
                                            data-category="{{ $banner['category'] }}"
                                            data-subcategory="{{ $banner['subcatgory'] }}"
                                            data-start-date="{{ $banner['start_date'] }}"
                                            data-end-date="{{ $banner['end_date'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPromotionalBannerModal">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>



                                        <a href="javascript:void(0);"
                                            class="table-button text-danger deletePromotionalBanner mb-1 mt-1" data-id="{{ $banner->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                         <div class="form-check form-switch d-flex justify-content-center align-items-center"">
                                            <input
                                                class="form-check-input toggleStatus"
                                                type="checkbox"
                                                role="switch"
                                                id="switch{{ $banner['id'] }}"
                                                data-id="{{ $banner['id'] }}"
                                                {{ $banner['status'] == 1 ? 'checked' : '' }}
                                            />
                                        </div>
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
    </div>
</div>



<!-- Add Promotional -->

<div class="modal fade" id="addPromotional" tabindex="-1" aria-labelledby="addPromotionalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.add_promotional') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <!-- Image Upload -->
                        <div class="col-lg-12">
                            <div class="upload-title text-center">{{ __('admin_messages.upload_image') }}</div>
                            <label for="fileUploadPromotional" class="upload-box" style="cursor:pointer;">
                                <img src="/admin/image/imge-upload.svg" id="uploadIconPromotional" />
                                <img id="previewImagePromotional" class="preview-image"
                                    style="display:none; max-width:216px; margin-top:-2px;" />
                                <div class="upload-text">{{ __('admin_messages.upload_image') }}</div>
                                <input type="file" id="fileUploadPromotional" name="upload_banner" accept="image/*" hidden />
                            </label>
                            <div class="text-danger text-center" id="imagePromotionalError"></div>
                        </div>

                        <!-- Banner Position -->
                        <div class="col-lg-12 mt-0">
                            <div class="form-group w-100">
                                <label class="form-label">{{ __('admin_messages.banner_position') }}</label>
                                <select id="bannerPosition" name="banner_position" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_position') }}</option>
                                    <option value="1">{{ __('admin_messages.home_top') }}</option>
                                    <option value="2">{{ __('admin_messages.home_bottom') }}</option>
                                    <option value="3">{{ __('admin_messages.category') }}</option>
                                </select>
                                <div class="text-danger" id="positionError"></div>
                            </div>

                            <!-- Category Dropdown (shown only if position = 3) -->
                            <div class="form-group w-100 mt-1" id="categoryWrapper" style="display:none;">
                                <label class="form-label">{{ __('admin_messages.category') }}</label>
                                <select id="categorySelect" name="category" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_category') }}</option>
                                </select>
                                <div class="text-danger" id="categoryError"></div>
                            </div>

                            <!-- Subcategory Dropdown (shown after category selection) -->
                            <div class="form-group w-100 mt-1" id="subCategoryWrapper" style="display:none;">
                                <label class="form-label">{{ __('admin_messages.sub_category') }}</label>
                                <select id="subCategorySelect" name="subcatgory" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_sub_category') }}</option>
                                </select>
                                <div class="text-danger" id="subcategoryError"></div>
                            </div>
                        </div>

                        <!-- Start and End Dates -->
                        <div class="col-lg-12 mt-2">
                            <div class="d-flex gap-2">
                                <div class="col-lg-6">
                                    <div class="form-group w-100">
                                        <label class="form-label">{{ __('admin_messages.from') }}</label>
                                        <input type="date" id="start_date_promotional" name="start_date_promotional" class="form-control" />
                                        <div class="text-danger" id="startDatePromotionalError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group w-100">
                                        <label class="form-label">{{ __('admin_messages.to') }}</label>
                                        <input type="date" id="end_date_promotional" name="end_date_promotional" class="form-control" />
                                        <div class="text-danger" id="endDatePromotionalError"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-12 mt-3 d-flex justify-content-center">
                            <button type="button" id="submitPromotionalBannerBtn" class="btn btn-dark customBtn">
                                {{ __('admin_messages.submit') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit  Promotional -->
<div class="modal fade" id="editPromotionalBannerModal" tabindex="-1"
     aria-labelledby="editPromotionalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit_promotional_banner') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <!-- hidden id -->
                        <input type="hidden" id="editBannerId">

                        <!-- Image Upload -->
                        <div class="col-lg-12">
                            <div class="upload-title text-center">{{ __('admin_messages.upload_image') }}</div>

                            <label for="editFileUploadPromotional"
                                   class="upload-box"
                                   style="cursor:pointer;">

                                <img src="/admin/image/imge-upload.svg"
                                     id="editUploadIconPromotional" />

                                <img id="editPreviewImagePromotional"
                                     class="preview-image"
                                     style="display:none; max-width:216px; margin-top:-2px;" />

                                <div class="upload-text">{{ __('admin_messages.upload_image') }}</div>

                                <input type="file"
                                       id="editFileUploadPromotional"
                                       accept="image/*"
                                       hidden />
                            </label>

                            <div class="text-danger text-center"
                                 id="editImagePromotionalError"></div>
                        </div>

                        <!-- Banner Position -->
                        <div class="col-lg-12 mt-3">
                            <div class="form-group w-100">
                                <label class="form-label">{{ __('admin_messages.banner_position') }}</label>

                                <select id="editBannerPosition"
                                        class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_position') }}</option>
                                    <option value="1">{{ __('admin_messages.home_top') }}</option>
                                    <option value="2">{{ __('admin_messages.home_bottom') }}</option>
                                    <option value="3">{{ __('admin_messages.category') }}</option>
                                </select>

                                <div class="text-danger"
                                     id="editPositionError"></div>
                            </div>

                            <!-- Category -->
                            <div class="form-group w-100 mt-2"
                                 id="editCategoryWrapper"
                                 style="display:none;">
                                <label class="form-label">{{ __('admin_messages.category') }}</label>

                                <select id="editCategorySelect"
                                        class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_category') }}</option>
                                </select>

                                <div class="text-danger"
                                     id="editCategoryError"></div>
                            </div>

                            <!-- Sub Category -->
                            <div class="form-group w-100 mt-2"
                                 id="editSubCategoryWrapper"
                                 style="display:none;">
                                <label class="form-label">{{ __('admin_messages.sub_category') }}</label>

                                <select id="editSubCategorySelect"
                                        class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_sub_category') }}</option>
                                </select>

                                <div class="text-danger"
                                     id="editSubcategoryError"></div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="col-lg-12 mt-3">
                            <div class="d-flex gap-2">

                                <div class="col-lg-6">
                                    <div class="form-group w-100">
                                        <label class="form-label">{{ __('admin_messages.from') }}</label>
                                        <input type="date"
                                               id="editStartDatePromotional"
                                               class="form-control" />
                                        <div class="text-danger"
                                             id="editStartDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group w-100">
                                        <label class="form-label">{{ __('admin_messages.to') }}</label>
                                        <input type="date"
                                               id="editEndDatePromotional"
                                               class="form-control" />
                                        <div class="text-danger"
                                             id="editEndDateError"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="col-lg-12 mt-3 d-flex justify-content-center">
                            <button type="button"
                                    id="updatePromotionalBannerBtn"
                                    class="btn btn-dark customBtn">
                                {{ __('admin_messages.update') }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>







<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.add_advertisement') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <!-- Image Upload -->
                        <div class="col-lg-12">
                            <div class="upload-title text-center">{{ __('admin_messages.upload_image') }}</div>

                            <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                <img src="/admin/image/imge-upload.svg" id="uploadIcon" />
                                <img id="previewImage" class="preview-image"
                                    style="display:none; max-width:216px; margin-top:-2px;" />
                                <div class="upload-text">{{ __('admin_messages.upload_image') }}</div>
                                <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                            </label>
                            <div class="text-danger text-center" id="imageError"></div>
                        </div>

                        <!-- Title -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="title">{{ __('admin_messages.title') }}</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="{{ __('admin_messages.enter_title') }}"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" />
                                <div class="text-danger" id="titleError"></div>
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label">{{ __('admin_messages.select_country') }}</label>
                                <select id="countrySelect" name="country_id" class="form-select form-select-lg"
                                    aria-label="Large select example">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        @if(app()->getLocale() == 'en')
                                        {{ $country->name }}
                                        @else
                                        {{ $country->name_ar }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="countryError"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label">{{ __('admin_messages.for') }}</label>
                                <select id="forSelect" name="type" class="form-select form-select-lg"
                                    aria-label="Large select example">
                                    <option value="">{{ __('admin_messages.select_type') }}</option>
                                    <option value="1">{{ __('admin_messages.mobile') }}</option>
                                    <option value="2">{{ __('admin_messages.web') }}</option>
                                </select>
                                <div class="text-danger" id="forError"></div>
                            </div>
                        </div>


                        <!-- Dates -->
                        <div class="col-lg-12">
                            <div class="d-flex gap-2">

                                <div class="col-lg-6">
                                    <div class="form-group  w-100">
                                        <label class="form-label">{{ __('admin_messages.from') }}:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" />
                                        <div class="text-danger" id="startDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group  w-100">
                                        <label class="form-label">{{ __('admin_messages.to') }}:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" />
                                        <div class="text-danger" id="endDateError"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBannerBtn" class="btn btn-dark customBtn mt-3">
                                {{ __('admin_messages.submit') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="editBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit_advertisement') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="upload-title text-center">{{ __('admin_messages.upload_image') }}</div>

                            <label for="editFileUpload" class="upload-box" style="cursor:pointer;">
                                <img src="/admin/image/imge-upload.svg" id="editUploadIcon" />
                                <img id="editPreviewImage" class="preview-image"
                                    style="display:none; max-width:216px; margin-top:-2px;" />
                                <div class="upload-text">{{ __('admin_messages.upload_image') }}</div>
                                <input type="file" id="editFileUpload" hidden />
                            </label>
                            <div class="text-danger text-center" id="editImageError"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">

                                <label class="form-label">{{ __('admin_messages.title') }}</label>
                                <input type="text" id="editTitle" class="form-control" placeholder="{{ __('admin_messages.enter_title') }}"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')">
                                <div class="text-danger" id="editTitleError"></div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group w-100">
                                <label class="form-label">{{ __('admin_messages.select_country') }}</label>
                                <select id="editCountrySelect" class="form-select form-select-lg">
                                    <option value="">{{ __('admin_messages.select_country') }}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        @if(app()->getLocale() == 'en')
                                        {{ $country->name }}
                                        @else
                                        {{ $country->name_ar }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="editCountryError"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label">{{ __('admin_messages.for') }}</label>
                                <select id="editForSelect" class="form-select form-select-lg"
                                    aria-label="Large select example">
                                    <option value="">{{ __('admin_messages.select_type') }}</option>
                                    <option value="1">{{ __('admin_messages.mobile') }}</option>
                                    <option value="2">{{ __('admin_messages.web') }}</option>
                                </select>
                                <div class="text-danger" id="editForError"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex gap-2">
                                <div class="col-lg-6">
                                    <div class="form-group  w-100">

                                        <label class="form-label">{{ __('admin_messages.from') }}</label>
                                        <input type="date" id="editStartDate" class="form-control">
                                        <div class="text-danger" id="editStartDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group  w-100">

                                        <label class="form-label">{{ __('admin_messages.to') }}</label>
                                        <input type="date" id="editEndDate" class="form-control">
                                        <div class="text-danger" id="editEndDateError"></div>
                                    </div>
                                </div>

                                <input type="hidden" id="editBannerId">
                            </div>

                        </div>
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a id="updateBannerBtn" class="btn btn-dark customBtn mt-3">
                                {{ __('admin_messages.update') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteBanner').forEach(button => {
        button.addEventListener('click', function() {
            let bannerId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteFullScreenBanner/${bannerId}`, {
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

    const modal = document.getElementById('sentModal2');
    const fileInput = document.getElementById('fileUpload');
    const preview = document.getElementById('previewImage');
    const icon = document.getElementById('uploadIcon');
    const uploadText = document.querySelector('.upload-text');

    modal.addEventListener('shown.bs.modal', () => {
        preview.style.display = 'none';
        icon.style.display = 'block';
        uploadText.style.display = 'block';

        fileInput.value = '';
        title.value = '';
        countrySelect.value = '';
        start_date.value = '';
        end_date.value = '';
        forSelect.value = '';

        imageError.innerText = '';
        titleError.innerText = '';
        countryError.innerText = '';
        startDateError.innerText = '';
        endDateError.innerText = '';
        forError.innerText = '';
    });

    fileInput.addEventListener('change', function() {
        if (this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                icon.style.display = 'none';
                uploadText.style.display = 'none';
                imageError.innerText = '';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    title.addEventListener('input', () => titleError.innerText = '');
    countrySelect.addEventListener('change', () => countryError.innerText = '');
    forSelect.addEventListener('change', () => forError.innerText = '');
    start_date.addEventListener('change', () => startDateError.innerText = '');
    end_date.addEventListener('change', () => endDateError.innerText = '');

    submitBannerBtn.addEventListener('click', function() {

        imageError.innerText = '';
        titleError.innerText = '';
        countryError.innerText = '';
        startDateError.innerText = '';
        endDateError.innerText = '';
        forError.innerText = '';

        let hasError = false;
        const formData = new FormData();

        formData.append('image', fileInput.files[0] ?? '');
        formData.append('title', title.value.trim());
        formData.append('country_id', countrySelect.value);
        formData.append('start_date', start_date.value);
        formData.append('end_date', end_date.value);
        formData.append('type', forSelect.value);

        if (!fileInput.files.length) {
            imageError.innerText = "{{ __('admin_messages.please_upload_image') }}";
            hasError = true;
        }
        if (!title.value.trim()) {
            titleError.innerText = "{{ __('admin_messages.please_enter_title') }}";
            hasError = true;
        }
        if (!countrySelect.value) {
            countryError.innerText = "{{ __('admin_messages.please_select_country') }}";
            hasError = true;
        }
        if (!start_date.value) {
            startDateError.innerText = "{{ __('admin_messages.please_select_start_date') }}";
            hasError = true;
        }
        if (!end_date.value) {
            endDateError.innerText = "{{ __('admin_messages.please_select_end_date') }}";
            hasError = true;
        }
        if (!forSelect.value) {
            forError.innerText = "{{ __('admin_messages.please_select_type') }}";
            hasError = true;
        }

        if (hasError) return;

        fetch('{{ route("admin.addFullBanner") }}', {
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
                        $('#sentModal2').modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message || 'Something went wrong');
                }
            })
            .catch(() => toastr.error('Server error'));
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {

    const editModalEl = document.getElementById('editBannerModal');
    const editModal = new bootstrap.Modal(editModalEl);

    // Inputs
    const editBannerId = document.getElementById('editBannerId');
    const editTitle = document.getElementById('editTitle');
    const editCountrySelect = document.getElementById('editCountrySelect');
    const editForSelect = document.getElementById('editForSelect');
    const editStartDate = document.getElementById('editStartDate');
    const editEndDate = document.getElementById('editEndDate');

    const editFileUpload = document.getElementById('editFileUpload');
    const editPreviewImage = document.getElementById('editPreviewImage');
    const editUploadIcon = document.getElementById('editUploadIcon');

    // Buttons
    const updateBannerBtn = document.getElementById('updateBannerBtn');

    // Errors
    const editImageError = document.getElementById('editImageError');
    const editTitleError = document.getElementById('editTitleError');
    const editCountryError = document.getElementById('editCountryError');
    const editForError = document.getElementById('editForError');
    const editStartDateError = document.getElementById('editStartDateError');
    const editEndDateError = document.getElementById('editEndDateError');

    /* ---------------- IMAGE PREVIEW ---------------- */
    editFileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                editPreviewImage.src = event.target.result;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        editImageError.innerText = '';
    });

    /* ---------------- OPEN EDIT MODAL ---------------- */
    document.querySelectorAll('.edit-reason-btn').forEach(function(button) {

        button.addEventListener('click', function() {

            editBannerId.value = this.dataset.id;
            editTitle.value = this.dataset.title;
            editCountrySelect.value = this.dataset.countryId;
            editForSelect.value = this.dataset.type; // ✅ MOBILE / WEB
            editStartDate.value = this.dataset.startDate;
            editEndDate.value = this.dataset.endDate;

            const image = this.dataset.image;

            if (image) {
                editPreviewImage.src = image;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            } else {
                editPreviewImage.style.display = 'none';
                editUploadIcon.style.display = 'block';
            }

            // Clear errors
            editImageError.innerText = '';
            editTitleError.innerText = '';
            editCountryError.innerText = '';
            editForError.innerText = '';
            editStartDateError.innerText = '';
            editEndDateError.innerText = '';
        });
    });

    /* ---------------- CLEAR ERRORS ON CHANGE ---------------- */
    editTitle.addEventListener('input', () => editTitleError.innerText = '');
    editCountrySelect.addEventListener('change', () => editCountryError.innerText = '');
    editForSelect.addEventListener('change', () => editForError.innerText = '');
    editStartDate.addEventListener('change', () => editStartDateError.innerText = '');
    editEndDate.addEventListener('change', () => editEndDateError.innerText = '');

    /* ---------------- UPDATE SUBMIT ---------------- */
    updateBannerBtn.addEventListener('click', function(e) {

        e.preventDefault();

        // Clear errors
        editImageError.innerText = '';
        editTitleError.innerText = '';
        editCountryError.innerText = '';
        editForError.innerText = '';
        editStartDateError.innerText = '';
        editEndDateError.innerText = '';

        let hasError = false;

        const id = editBannerId.value;
        const formData = new FormData();

        formData.append('title', editTitle.value.trim());
        formData.append('country_id', editCountrySelect.value);
        formData.append('type', editForSelect.value);
        formData.append('start_date', editStartDate.value);
        formData.append('end_date', editEndDate.value);

        if (editFileUpload.files.length > 0) {
            formData.append('image', editFileUpload.files[0]);
        }

        // Validation
        if (!editTitle.value.trim()) {
            editTitleError.innerText = "{{ __('admin_messages.please_enter_title') }}";
            hasError = true;
        }

        if (!editCountrySelect.value) {
            editCountryError.innerText = "{{ __('admin_messages.please_select_country') }}";
            hasError = true;
        }

        if (!editForSelect.value) {
            editForError.innerText = "{{ __('admin_messages.please_select_type') }}";
            hasError = true;
        }

        if (!editStartDate.value) {
            editStartDateError.innerText = "{{ __('admin_messages.please_select_start_date') }}";
            hasError = true;
        }

        if (!editEndDate.value) {
            editEndDateError.innerText = "{{ __('admin_messages.please_select_end_date') }}";
            hasError = true;
        }

        if (hasError) return;

        fetch(`{{ url('/admin/updateFullBanner') }}/${id}`, {
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
                        editModal.hide();
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            .catch(() => toastr.error('Server error.'));
    });

});
</script>



<script>
function getTodayLocal() {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function setTodayMinDate() {
    const fromInput = document.getElementById('start_date');
    fromInput.min = getTodayLocal();
}

function updateToDate() {
    const fromInput = document.getElementById('start_date');
    const toInput = document.getElementById('end_date');

    if (fromInput.value) {
        const minToDate = new Date(fromInput.value);
        minToDate.setDate(minToDate.getDate() + 1);

        const yyyy = minToDate.getFullYear();
        const mm = String(minToDate.getMonth() + 1).padStart(2, '0');
        const dd = String(minToDate.getDate()).padStart(2, '0');

        toInput.min = `${yyyy}-${mm}-${dd}`;
    } else {
        toInput.removeAttribute('min');
    }
}

function updateFromDate() {
    const fromInput = document.getElementById('start_date');
    const toInput = document.getElementById('end_date');

    if (toInput.value) {
        const maxFromDate = new Date(toInput.value);
        maxFromDate.setDate(maxFromDate.getDate() - 1);

        const yyyy = maxFromDate.getFullYear();
        const mm = String(maxFromDate.getMonth() + 1).padStart(2, '0');
        const dd = String(maxFromDate.getDate()).padStart(2, '0');

        fromInput.max = `${yyyy}-${mm}-${dd}`;
    } else {
        fromInput.removeAttribute('max');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setTodayMinDate();
    updateToDate();
    updateFromDate();

    document.getElementById('start_date').addEventListener('change', updateToDate);
    document.getElementById('end_date').addEventListener('change', updateFromDate);
});
</script>

<script>
function formatDateLocal(date) {
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function setEditStartMinToday() {
    const startInput = document.getElementById('editStartDate');
    const today = new Date();
    startInput.min = formatDateLocal(today);
}

function updateEditEndDate() {
    const fromInput = document.getElementById('editStartDate');
    const toInput = document.getElementById('editEndDate');

    if (fromInput.value) {
        const minToDate = new Date(fromInput.value);
        minToDate.setDate(minToDate.getDate() + 1);
        toInput.min = formatDateLocal(minToDate);
    } else {
        toInput.removeAttribute('min');
    }
}

function updateEditStartDate() {
    const fromInput = document.getElementById('editStartDate');
    const toInput = document.getElementById('editEndDate');

    if (toInput.value) {
        const maxFromDate = new Date(toInput.value);
        maxFromDate.setDate(maxFromDate.getDate() - 1);
        fromInput.max = formatDateLocal(maxFromDate);
    } else {
        fromInput.removeAttribute('max');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setEditStartMinToday();
    updateEditEndDate();
    updateEditStartDate();

    document.getElementById('editStartDate')
        .addEventListener('change', updateEditEndDate);

    document.getElementById('editEndDate')
        .addEventListener('change', updateEditStartDate);
});
</script>

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

 <!-- Delete promotional banner -->
  <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deletePromotionalBanner').forEach(button => {
        button.addEventListener('click', function() {
            let bannerId = this.getAttribute('data-id');

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
                    fetch(`/admin/deletePromotionalBanner/${bannerId}`, {
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

<!-- add promotional banner -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // =========================
    // DOM elements
    // =========================
    const bannerPosition = document.getElementById('bannerPosition');
    const categorySelect = document.getElementById('categorySelect');
    const subCategorySelect = document.getElementById('subCategorySelect');
    const categoryWrapper = document.getElementById('categoryWrapper');
    const subCategoryWrapper = document.getElementById('subCategoryWrapper');
    const fileInput = document.getElementById('fileUploadPromotional');
    const preview = document.getElementById('previewImagePromotional');
    const uploadIcon = document.getElementById('uploadIconPromotional');
    const start_date = document.getElementById('start_date_promotional');
    const end_date = document.getElementById('end_date_promotional');
    const submitBtn = document.getElementById('submitPromotionalBannerBtn');

    // =========================
    // Helper: clear error on change/input
    // =========================
    function clearErrorOnChange(element, errorElementId) {
        if (!element) return;

        const eventType = element.tagName === 'INPUT' ? 'input' : 'change';

        element.addEventListener(eventType, function () {
            const errorEl = document.getElementById(errorElementId);
            if (errorEl) {
                errorEl.innerText = '';
            }
        });
    }

    // =========================
    // Attach error clearing
    // =========================
    clearErrorOnChange(fileInput, 'imagePromotionalError');
    clearErrorOnChange(bannerPosition, 'positionError');
    clearErrorOnChange(categorySelect, 'categoryError');
    clearErrorOnChange(subCategorySelect, 'subcategoryError');
    clearErrorOnChange(start_date, 'startDatePromotionalError');
    clearErrorOnChange(end_date, 'endDatePromotionalError');

    // =========================
    // Show preview when image selected
    // =========================
    fileInput.addEventListener('change', function() {
        if (this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                uploadIcon.style.display = 'none';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // =========================
    // Show category only when position = 3
    // =========================
    bannerPosition.addEventListener('change', function() {
        document.getElementById('categoryError').innerText = '';
        document.getElementById('subcategoryError').innerText = '';

        if (this.value == 3) {
            categoryWrapper.style.display = 'block';
            fetchCategories();
        } else {
            categoryWrapper.style.display = 'none';
            subCategoryWrapper.style.display = 'none';
            categorySelect.value = '';
            subCategorySelect.value = '';
        }
    });

    // =========================
    // Fetch categories
    // =========================
    function fetchCategories() {
        fetch('/admin/getCategories')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    categorySelect.innerHTML =
                        '<option value="">{{ __("admin_messages.select_category") }}</option>';

                    data.data.forEach(cat => {
                        categorySelect.innerHTML +=
                            `<option value="${cat.id}">{{ app()->getLocale() == 'en' ? '${cat.name}' : '${cat.name_ar}' }}</option>`;
                    });
                }
            })
            .catch(err => console.error('Error fetching categories:', err));
    }

    // =========================
    // Fetch subcategories
    // =========================
    categorySelect.addEventListener('change', function() {
        document.getElementById('subcategoryError').innerText = '';

        const categoryId = this.value;
        if (!categoryId) {
            subCategoryWrapper.style.display = 'none';
            subCategorySelect.innerHTML = '';
            return;
        }

        fetch(`/admin/getSubCategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data && data.data.data) {
                    subCategoryWrapper.style.display = 'block';
                    subCategorySelect.innerHTML =
                        '<option value="">{{ __("admin_messages.select_sub_category") }}</option>';

                    data.data.data.forEach(sub => {
                        subCategorySelect.innerHTML +=
                            `<option value="${sub.id}">{{ app()->getLocale() == 'en' ? '${sub.name_english}' : '${sub.name_arabic}' }}</option>`;
                    });
                } else {
                    subCategoryWrapper.style.display = 'none';
                    subCategorySelect.innerHTML = '';
                }
            })
            .catch(err => {
                console.error('Error fetching subcategories:', err);
                subCategoryWrapper.style.display = 'none';
                subCategorySelect.innerHTML = '';
            });
    });

    // =========================
    // Submit form
    // =========================
    submitBtn.addEventListener('click', function() {

        // Clear previous errors
        document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');

        let hasError = false;

        if (!fileInput.files.length) {
            document.getElementById('imagePromotionalError').innerText = "{{ __('admin_messages.please_upload_image') }}";
            hasError = true;
        }

        if (!bannerPosition.value) {
            document.getElementById('positionError').innerText = "{{ __('admin_messages.please_select_banner_position') }}";
            hasError = true;
        }

        if (bannerPosition.value == 3 && !categorySelect.value) {
            document.getElementById('categoryError').innerText = "{{ __('admin_messages.please_select_category') }}";
            hasError = true;
        }

        if (bannerPosition.value == 3 && !subCategorySelect.value) {
            document.getElementById('subcategoryError').innerText = "{{ __('admin_messages.please_select_subcategory') }}";
            hasError = true;
        }

        if (!start_date.value) {
            document.getElementById('startDatePromotionalError').innerText = "{{ __('admin_messages.please_select_start_date') }}";
            hasError = true;
        }

        if (!end_date.value) {
            document.getElementById('endDatePromotionalError').innerText = "{{ __('admin_messages.please_select_end_date') }}";
            hasError = true;
        }

        if (hasError) return;

        // =========================
        // Build FormData
        // =========================
        const formData = new FormData();
        formData.append('image', fileInput.files[0]);
        formData.append('banner_position', bannerPosition.value);
        formData.append('category', categorySelect.value);
        formData.append('subcatgory', subCategorySelect.value);
        formData.append('start_date', start_date.value);
        formData.append('end_date', end_date.value);

        // =========================
        // Submit via fetch
        // =========================
        fetch('{{ route("admin.addPromotionalBanner") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => {
                    $('#addPromotional').modal('hide');
                    location.reload();
                }, 1500);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const el = document.getElementById(key + 'Error');
                        if (el) el.innerText = data.errors[key][0];
                    });
                } else {
                    toastr.error(data.message || 'Something went wrong');
                }
            }
        })
        .catch(err => {
            console.error('Server error:', err);
        });

    });

});
</script>


<!-- update promotional modal -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    let currentBannerId = null;

    // ===============================
    // EDIT BUTTON CLICK
    // ===============================
    document.querySelectorAll('.edit-promotional-btn').forEach(btn => {
        btn.addEventListener('click', function () {

            currentBannerId = this.dataset.id;
            document.getElementById('editBannerId').value = currentBannerId;

            document.getElementById('editStartDatePromotional').value = this.dataset.startDate;
            document.getElementById('editEndDatePromotional').value   = this.dataset.endDate;

            document.getElementById('editBannerPosition').value = this.dataset.position;

            const preview = document.getElementById('editPreviewImagePromotional');
            const icon    = document.getElementById('editUploadIconPromotional');

            if (this.dataset.image) {
                preview.src = this.dataset.image;
                preview.style.display = 'block';
                icon.style.display = 'none';
            } else {
                preview.style.display = 'none';
                icon.style.display = 'block';
            }

            resetCategorySection();

            if (this.dataset.position == 3) {
                document.getElementById('editCategoryWrapper').style.display = 'block';
                fetchEditCategories(this.dataset.category, this.dataset.subcategory);
            }
        });
    });

    // ===============================
    // IMAGE PREVIEW
    // ===============================
    document.getElementById('editFileUploadPromotional')
        .addEventListener('change', function () {
            if (this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('editPreviewImagePromotional').src = e.target.result;
                    document.getElementById('editPreviewImagePromotional').style.display = 'block';
                    document.getElementById('editUploadIconPromotional').style.display = 'none';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

    // ===============================
    // POSITION CHANGE
    // ===============================
    document.getElementById('editBannerPosition')
        .addEventListener('change', function () {

            resetCategorySection();

            if (this.value == 3) {
                document.getElementById('editCategoryWrapper').style.display = 'block';
                fetchEditCategories();
            }
        });

    // ===============================
    // CATEGORY CHANGE
    // ===============================
    document.getElementById('editCategorySelect')
        .addEventListener('change', function () {

            const subWrapper = document.getElementById('editSubCategoryWrapper');
            const subSelect  = document.getElementById('editSubCategorySelect');

            // Clear previous errors on category change
            document.getElementById('editCategoryError').innerText = '';
            document.getElementById('editSubcategoryError').innerText = '';

            subSelect.innerHTML = '<option value="">{{ __("admin_messages.select_sub_category") }}</option>';

            if (!this.value) {
                subWrapper.style.display = 'none';
                return;
            }

            // Show subcategory wrapper and fetch subcategories
            subWrapper.style.display = 'block';

            fetchEditSubCategories(this.value);
        });

    // ===============================
    // SUBCATEGORY CHANGE (CLEAR ERROR)
    // ===============================
    document.getElementById('editSubCategorySelect')
        .addEventListener('change', function () {
            document.getElementById('editSubcategoryError').innerText = '';
        });

    // ===============================
    // FETCH CATEGORIES
    // ===============================
    function fetchEditCategories(selectedCategory = null, selectedSub = null) {

        fetch('/admin/getCategories')
            .then(res => res.json())
            .then(data => {

                const catSelect = document.getElementById('editCategorySelect');
                catSelect.innerHTML = '<option value="">{{ __("admin_messages.select_category") }}</option>';

                const locale = "{{ app()->getLocale() }}";

                data.data.forEach(cat => {
                    catSelect.innerHTML += `
                        <option value="${cat.id}" ${cat.id == selectedCategory ? 'selected' : ''}>
                            ${locale === 'en' ? (cat.name || '') : (cat.name_ar || '')}
                        </option>`;
                });

                if (selectedCategory) {
                    document.getElementById('editSubCategoryWrapper').style.display = 'block';
                    fetchEditSubCategories(selectedCategory, selectedSub);
                }
            });
    }

    // ===============================
    // FETCH SUBCATEGORIES
    // ===============================
    function fetchEditSubCategories(categoryId, selectedSub = null) {

        fetch(`/admin/getSubCategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {

                const subSelect = document.getElementById('editSubCategorySelect');
                subSelect.innerHTML = '<option value="">{{ __("admin_messages.select_sub_category") }}</option>';

                const locale = "{{ app()->getLocale() }}";


                data.data.data.forEach(sub => {
                    subSelect.innerHTML += `
                        <option value="${sub.id}" ${sub.id == selectedSub ? 'selected' : ''}>
                            ${locale === 'en' ? sub.name_english : sub.name_arabic}
                        </option>`;
                });
            });
    }

    // ===============================
    // RESET CATEGORY SECTION
    // ===============================
    function resetCategorySection() {
        document.getElementById('editCategoryWrapper').style.display = 'none';
        document.getElementById('editSubCategoryWrapper').style.display = 'none';
        document.getElementById('editCategorySelect').innerHTML = '<option value="">{{ __("admin_messages.select_category") }}</option>';
        document.getElementById('editSubCategorySelect').innerHTML = '<option value="">{{ __("admin_messages.select_sub_category") }}</option>';
        // Clear errors when resetting
        document.getElementById('editCategoryError').innerText = '';
        document.getElementById('editSubcategoryError').innerText = '';
    }

    // ===============================
    // UPDATE SUBMIT
    // ===============================
    document.getElementById('updatePromotionalBannerBtn')
        .addEventListener('click', function () {

        let hasError = false;

        const position = document.getElementById('editBannerPosition').value;
        const category = document.getElementById('editCategorySelect').value;
        const subcat   = document.getElementById('editSubCategorySelect').value;

        // Clear all previous errors on submit attempt
        document.getElementById('editPositionError').innerText = '';
        document.getElementById('editCategoryError').innerText = '';
        document.getElementById('editSubcategoryError').innerText = '';

        if (position == 3) {
            if (!category) {
                document.getElementById('editCategoryError').innerText = "{{ __('admin_messages.please_select_category') }}";
                hasError = true;
            }
            if (!subcat) {
                document.getElementById('editSubcategoryError').innerText = "{{ __('admin_messages.please_select_subcategory') }}";
                hasError = true;
            }
        }

        if (hasError) return;

        const formData = new FormData();

        const imageFile = document.getElementById('editFileUploadPromotional').files[0];
        if (imageFile) formData.append('image', imageFile);

        formData.append('banner_position', position);
        formData.append('category', category);
        formData.append('subcatgory', subcat);
        formData.append('start_date', document.getElementById('editStartDatePromotional').value);
        formData.append('end_date', document.getElementById('editEndDatePromotional').value);

        fetch(`/admin/updatePromotionalBanner/${currentBannerId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => location.reload(), 1200);
            } else {
                toastr.error(data.message || 'Update failed');
            }
        });
    });

});
</script>


<script>
function getTodayLocal1() {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function setTodayMinDate1() {
    const fromInput = document.getElementById('start_date_promotional');
    fromInput.min = getTodayLocal1();
}

function updateToDate1() {
    const fromInput = document.getElementById('start_date_promotional');
    const toInput = document.getElementById('end_date_promotional');

    if (fromInput.value) {
        const minToDate = new Date(fromInput.value);
        minToDate.setDate(minToDate.getDate() + 1);

        const yyyy = minToDate.getFullYear();
        const mm = String(minToDate.getMonth() + 1).padStart(2, '0');
        const dd = String(minToDate.getDate()).padStart(2, '0');

        toInput.min = `${yyyy}-${mm}-${dd}`;
    } else {
        toInput.removeAttribute('min');
    }
}

function updateFromDate1() {
    const fromInput = document.getElementById('start_date_promotional');
    const toInput = document.getElementById('end_date_promotional');

    if (toInput.value) {
        const maxFromDate = new Date(toInput.value);
        maxFromDate.setDate(maxFromDate.getDate() - 1);

        const yyyy = maxFromDate.getFullYear();
        const mm = String(maxFromDate.getMonth() + 1).padStart(2, '0');
        const dd = String(maxFromDate.getDate()).padStart(2, '0');

        fromInput.max = `${yyyy}-${mm}-${dd}`;
    } else {
        fromInput.removeAttribute('max');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setTodayMinDate1();
    updateToDate1();
    updateFromDate1();

    document.getElementById('start_date_promotional').addEventListener('change', updateToDate1);
    document.getElementById('end_date_promotional').addEventListener('change', updateFromDate1);
});
</script>

<script>
function formatDateLocal1(date) {
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function setEditStartMinToday1() {
    const startInput = document.getElementById('editStartDatePromotional');
    const today = new Date();
    startInput.min = formatDateLocal1(today);
}

function updateEditEndDate1() {
    const fromInput = document.getElementById('editStartDatePromotional');
    const toInput = document.getElementById('editEndDatePromotional');

    if (fromInput.value) {
        const minToDate = new Date(fromInput.value);
        minToDate.setDate(minToDate.getDate() + 1);
        toInput.min = formatDateLocal1(minToDate);
    } else {
        toInput.removeAttribute('min');
    }
}

function updateEditStartDate1() {
    const fromInput = document.getElementById('editStartDatePromotional');
    const toInput = document.getElementById('editEndDatePromotional');

    if (toInput.value) {
        const maxFromDate = new Date(toInput.value);
        maxFromDate.setDate(maxFromDate.getDate() - 1);
        fromInput.max = formatDateLocal1(maxFromDate);
    } else {
        fromInput.removeAttribute('max');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setEditStartMinToday1();
    updateEditEndDate1();
    updateEditStartDate1();

    document.getElementById('editStartDatePromotional')
        .addEventListener('change', updateEditEndDate1);

    document.getElementById('editEndDatePromotional')
        .addEventListener('change', updateEditStartDate1);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let Id = this.getAttribute('data-id');

            fetch(`/admin/blockUnblockPromotionalBanner/${Id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // toastr.success(data.message);
                     if(data.status == 1){
                        toastr.success(data.message); // Green for active
                    } else {
                        toastr.error(data.message);   // Red for deactivated
                    }
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                //console.error(error);
                toastr.error('Something went wrong while updating status.');
            });
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('addPromotional');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
});
</script>











@endsection
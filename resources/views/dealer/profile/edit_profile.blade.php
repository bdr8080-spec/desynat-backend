@include('dealer.layout.header')


<style>
.country-option:hover {
    background-color: #f8f9fa;
}

.country-option img {
    border-radius: 2px;
}

.dropdown-menu {
    min-width: 250px;
}

#countrySearch {
    border-radius: 6px;
}

.pac-container {
    z-index: 9999;
}
</style>



<div class="onepage mb-5">
    <section class="section dashboard container">
        <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
            <a href="{{route('seller.view_profile')}}" style="color:rgb(57, 55, 55)" class="title24">
                <i class="bi bi-chevron-left"></i> {{ __('seller_messages.Edit') }}
            </a>

        </div>

        <div class="tabs-panel py-4">
            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                        aria-selected="true"> {{ __('seller_messages.Personal_Info') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100" id="pills-active-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active"
                        aria-selected="false">{{ __('seller_messages.Documents_Bank_Details') }}</button>
                </li>
            </ul>
        </div>



        <div class="tab-body-wapper">
            <div class="tab-content" id="pills-tabContent">



                <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                    aria-labelledby="pills-allproduct-tab" tabindex="0">

                    <form id="editprofile" action="{{ route('seller.editprofile') }}" method="post">

                        @csrf
                        <div class="personl-wapper">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                                        <div class="showcircle">
                                            <input type="hidden" value="{{$seller_details->profile_pic}}"
                                                name="old_profile_pic">
                                            <img id="previewProfile" src="{{$seller_details->profile_pic}}"
                                                class="img-fluid">
                                        </div>
                                        <label class="img_changes">
                                            <h6>{{ __('seller_messages.Change_Image') }}</h6>
                                            <input type="file" id="uploadImage2" class="form-control" accept="image/*"
                                                name="profile_pic">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.First_Name') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.Enter_First_Name') }}" name="first_name"
                                            value="{{$seller_details->first_name}}">

                                        <p class="text-danger" id="error-first_name"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Last_Name') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder=" {{ __('seller_messages.Enter_Last_Name') }}" name="last_name"
                                            value="{{$seller_details->last_name}}">
                                        <p class="text-danger" id="error-last_name"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Mobile_No') }}</label>
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{ __('seller_messages.Mobile_Number') }}" readonly
                                            value="{{$seller_details->country_code}} {{$seller_details->mobile}}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Email_Id') }}</label>
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{ __('seller_messages.Email_Id') }}" readonly
                                            value="{{$seller_details->email}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="store-panel py-3 d-flex justify-content-between align-items-center">
                                        <div class="store-img">
                                            <img id="previewImg" src="{{ $seller_details->store_info->store_image }}"
                                                class="img-fluid">
                                        </div>
                                        <label class="img_changes">
                                            <h6> {{ __('seller_messages.Change_Image') }}</h6>
                                            <input type="file" id="uploadImage" class="form-control" accept="image/*"
                                                name="store_image">

                                            <input type="hidden" value="{{$seller_details->store_info->store_image}}"
                                                name="old_store_image">


                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Store_Name') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.Enter_Store_Name') }}"
                                            value="{{ $seller_details->store_info->store_name }}" name="store_name">
                                        <p class="text-danger" id="error-store_name"></p>
                                    </div>
                                </div>

                                <input type="hidden" id="lat" name="let" value="{{ $seller_details->store_info->let }}">
                                <input type="hidden" id="lng" name="long"
                                    value="{{ $seller_details->store_info->long }}">

                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Choose_Country') }}</label>
                                        </div>
                                        <!-- <select class="form-select form-control" aria-label="Default select example"
                                            name="country">

                                            @foreach($all_country as $key=>$value)
                                            <option value="{{$value->id}}" @if($seller_details->
                                                store_info->country==$value->id)
                                                selected @endif >{{$value->name}}</option>
                                            @endforeach

                                        </select> -->

                                        <div class="dropdown">
                                            <button
                                                class="btn btn-light border dropdown-toggle d-flex  w-100 form-control justify-content-between align-items-center"
                                                type="button" id="countryDropdown1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <div>
                                                    <span id="selected-flag1">
                                                        <img src="{{$seller_details->store_info->country_info->flag1}}"
                                                            alt="flag" width="25" height="16">
                                                        {{$seller_details->store_info->country_info->name }}
                                                    </span>

                                                    <span id="selected-code1" class="ms-2">

                                                    </span>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="countryDropdown">
                                                @foreach ($all_country as $index => $item)
                                                <li class="py-1">
                                                    <label
                                                        class="dropdown-item d-flex align-items-center gap-3 country-option1"
                                                        style="cursor: pointer;">
                                                        <input type="radio" name="country" value="{{ $item->id }}"
                                                            data-flag="{{ $item->flag }}" data-name="{{ $item->name }}"
                                                            class="country-radio1"
                                                            {{ $seller_details->store_info->country == $item->id ? 'checked' : '' }}
                                                            hidden>
                                                        <div width="25" height="16">
                                                            <span>{{ $item->flag.' '.' '. $item->name }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>



                                    </div>
                                    <p class="text-danger" id="error-country"></p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Store_Address') }}</label>
                                        </div>
                                        <div class=" position-relative">
                                            <input type="text" class="form-control blockFirstTime"
                                                placeholder="{{ __('seller_messages.Enter_Store_Address') }} " name="store_address"
                                                value="{{$seller_details->store_info->store_address}}"
                                                id="store_address">
                                            <div class="gpsmap1" data-bs-toggle="offcanvas" data-bs-target="#gpspanel"
                                                aria-controls="offcanvasExample">
                                                <i class="bi bi-crosshair"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-danger" id="error-store_address"></p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Address_Line_1') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.Enter_Address_Line_1') }}" name="address_line1"
                                            value="{{$seller_details->store_info->address_line1}}" id="address_line1">
                                        <p class="text-danger" id="error-address_line1"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Address_Line_2') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.Enter_Address_Line_2') }}" name="address_line2"
                                            value="{{$seller_details->store_info->address_line2}}" id="address_line2">
                                        <p class="text-danger" id="error-address_line2"></p>
                                    </div>
                                </div>


                                <div class="col-lg-6 col-md-6">
                                    <!-- <div class="sub-form">
                                        <div class="label-flex">
                                            <label>Store Phone Number</label>
                                        </div>

                                        <select class="form-select form-control" aria-label="Default select example"
                                            name="country_code" @foreach($all_country as $key=>$value)
                                            <option value="{{$value->dial_code}}" @if($seller_details->
                                                store_info->country_code==$value->dial_code)
                                                selected @endif >{{$value->dial_code}}</option>
                                            @endforeach
                                        </select>

                                        <input type="text" class="form-control notapplyspace" placeholder="Phone number"
                                            name="store_phone" value="{{$seller_details->store_info->store_phone}}">
                                        <p class="text-danger" id="error-store_phone"></p>
                                    </div> -->
                                    <div class="label-flex">
                                        <label>{{ __('seller_messages.Store_Phone_Number') }}</label>
                                    </div>

                                    <div class="form-group d-flex gap-0 w-100">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">

                                                <span id="selected-flag">
                                                    <img src="{{$seller_details->store_info->dialer_info->flag1}}"
                                                        alt="flag" width="25" height="16">
                                                    {{$seller_details->store_info->country_code}}
                                                </span>

                                                <span id="selected-code" class="ms-2">
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="countryDropdown">
                                                @foreach ($all_country as $index => $item)
                                                <li>
                                                    <label
                                                        class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                        style="cursor: pointer;">
                                                        <input type="radio" name="country_code"
                                                            value="{{ $item->dial_code }}" data-flag="{{ $item->flag }}"
                                                            data-name="{{ $item->name }}" class="country-radio"
                                                            {{ $seller_details->store_info->country_code == $item->dial_code ? 'checked' : '' }}
                                                            hidden>

                                                        <div width="25" height="16">
                                                            <span>{{ $item->flag }}
                                                                {{ $item->dial_code }} {{ $item->name }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="w-100">
                                            <input class="form-control notapplyspace" type="number" id="phone"
                                                placeholder="{{ __('seller_messages.Enter_Mobile_Number') }}" name="store_phone"
                                                value="{{$seller_details->store_info->store_phone}}"
                                                value="{{ old('mobile') }}"
                                                oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">
                                            <p class="text-danger" id="error-store_phone"></p>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label> {{ __('seller_messages.Store_Mail_Id') }} </label>
                                        </div>
                                        <input type="text" class="form-control notapplyspace"
                                            placeholder="{{ __('seller_messages.Enter_Store_Email_Id') }}" name="store_mail_id"
                                            value="{{$seller_details->store_info->store_mail_id}}">

                                        <p class="text-danger" id="error-store_mail_id"></p>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Bio') }} </label>
                                        </div>
                                        <textarea rows="3" class="form-control" name="bio"
                                            placeholder="{{ __('seller_messages.Write_Text') }}"> {{$seller_details->store_info->bio}}</textarea>

                                        <p class="text-danger" id="error-store_mail_id"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-button mt-4">
                                <button type="submit" class="btn add-fillbtn w-100">{{ __('seller_messages.Save_Changes') }}</button>
                            </div>
                        </div>

                    </form>

                </div>


                <div class="tab-pane fade" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab"
                    tabindex="0">

                    <form id="editbankdetails" action="{{ route('seller.editbankdetails') }}" method="post"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="personl-wapper">
                            <div class="pt-3">
                                <div class="title24"> {{ __('seller_messages.Bank_Details') }}</div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div
                                            class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 pe-3 justify-content-between">
                                            <div class="check_radio">
                                                <label class="radio-group">
                                                    <input type="radio" name="account_type" value="0"
                                                        @if(@$seller_details->seller_bank_details->account_type=='0')
                                                    checked
                                                    @endif>
                                                    <span class="custom-radio"></span>
                                                    <span class="radio-label">{{ __('seller_messages.Personal') }}</span>
                                                </label>
                                            </div>
                                            <div class="check_radio">
                                                <label class="radio-group">
                                                    <input type="radio" name="account_type" value="1"
                                                        @if(@$seller_details->seller_bank_details->account_type=='1')
                                                    checked
                                                    @endif>
                                                    <span class="custom-radio"></span>
                                                    <span class="radio-label">{{ __('seller_messages.Business') }}</span>
                                                </label>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.IBAN') }}</label>
                                        </div>
                                        <input type="text" class="form-control notapplyspace" placeholder="{{ __('seller_messages.Enter_IBAN') }}"
                                            name="iban" value="{{ @$seller_details->seller_bank_details->iban }}">
                                        <p class="text-danger" id="error-iban"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.SWIFT_BIC') }}</label>
                                        </div>
                                        <input type="text" class="form-control notapplyspace"
                                            placeholder="{{ __('seller_messages.Enter_SWIFT_BIC') }}" name="swift"
                                            value="{{ @$seller_details->seller_bank_details->swift }}">
                                        <p class="text-danger" id="error-iban"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Bank_Name') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.Enter_Bank_Name') }}" name="bank_name"
                                            value="{{ @$seller_details->seller_bank_details->bank_name }}">
                                        <p class="text-danger" id="error-bank_name"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="sub-form">
                                        <div class="label-flex">
                                            <label>{{ __('seller_messages.Account_Holder_Name') }}</label>
                                        </div>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="{{ __('seller_messages.Enter_Account_Holder_Name') }}" name="account_holder_name"
                                            value="{{ @$seller_details->seller_bank_details->account_holder_name }}">
                                        <p class="text-danger" id="error-account_holder_name"></p>
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12">
                                    <div class="product-pnls mt-4">
                                        <div class="upload-image" style="height:170px;width: 270px;">
                                            <label id="uploadLabel"
                                                style="cursor:pointer;text-align:center;display:block;">
                                                <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                                    style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">
                                                <div class="py-2" style="color:#875C3A">{{ __('seller_messages.Upload_Proof_Of_Account') }} </div>
                                                <input type="file" accept="image/*" multiple id="edit_uploadChart"
                                                    style="opacity:0;" name="upload_proof">
                                            </label>
                                        </div>


                                        <input type="hidden" class="form-control" name="old_upload_proof"
                                            id="old_upload_proof"
                                            value="{{ @$seller_details->seller_bank_details->upload_proof }}">


                                        <div class="upload-passbook" style="">
                                            <img id="placeholderImg"
                                                src="{{ @$seller_details->seller_bank_details->upload_proof }}">
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="dashboard-button mt-4">
                                <button type="submit" class="btn add-fillbtn w-100">{{ __('seller_messages.Save_Changes') }}</button>
                            </div>
                        </div>

                    </form>

                </div>


            </div>


        </div>

    </section>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="gpspanel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"> {{ __('seller_messages.Set_Location') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="gps-wapper">

            <div class="setup-maps mb-0 position-relative">


                <input id="searchBox" type="text" placeholder="{{ __('seller_messages.Search_Your_Address') }}"
                    class="form-control position-absolute"
                    style="top:10px;left:10px;width:300px;z-index:9999;padding:6px 10px;border-radius:4px;">

                <div id="googleMap" style="width: 100%; height: 500px;"></div>

                <div id="useCurrentLocation" class="mt-3">
                    <i class="bi bi-crosshair"></i> {{ __('seller_messages.Use_Current_Location') }}
                </div>
            </div>

            <div class="find-location d-flex gap-3 py-4">
                <div><i class="bi bi-geo-alt-fill"></i></div>
                <p class="mb-0" id="selectedAddress"> </p>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="lng" name="lng">

            <!-- Done button -->
            <div class="setup-done">
                <button type="button" class="btn btn-success w-100" data-bs-dismiss="offcanvas">{{ __('seller_messages.Done') }}</button>
            </div>
        </div>
    </div>
</div>


@include('dealer.layout.custom_code');

@include('dealer.layout.footer');

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&callback=initMap&libraries=places">
</script>

<script>
let map, marker, circle, autocomplete;
let mapInitialized = false;

// IDs of input fields
const address1Id = "address_line1";
const address2Id = "address_line2";
// const cityId = "city";
// const pincodeId = "pincode";
// const countryId = "country";
const searchBoxId = "searchBox";
const latId = "lat";
const lngId = "lng";
const selectedAddressId = "selectedAddress";
const selectedAddressStore_address = "store_address";

// selectedAddress

function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const currentLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                loadMap(currentLocation);
            },
            () => loadMap({
                lat: 0,
                lng: 0
            }), {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        loadMap({
            lat: 0,
            lng: 0
        });
    }
}

function loadMap(loc) {
    map = new google.maps.Map(document.getElementById("googleMap"), {
        center: loc,
        zoom: 13
    });

    marker = new google.maps.Marker({
        position: loc,
        map,
        draggable: true
    });

    circle = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.3,
        map,
        center: loc,
        radius: 300
    });

    const input = document.getElementById(searchBoxId);

    // Clear input fields on map load
    // cityId, pincodeId, countryId
    [latId, lngId, address1Id, address2Id].forEach(id => {
        // document.getElementById(id).value = "";
    });
    input.value = "";
    document.getElementById(selectedAddressId).textContent = "";

    // Autocomplete setup
    autocomplete = new google.maps.places.Autocomplete(input, {
        fields: ["geometry", "name", "formatted_address", "address_components"]
    });
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) return;
        updateLocation(place.geometry.location, place);
    });

    // Manual address input on blur
    input.addEventListener("blur", () => {
        const address = input.value.trim();
        if (!address) return;
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                updateLocation(results[0].geometry.location, results[0]);
            } else {
                alert("Address not found!");
            }
        });
    });

    // Marker drag event
    marker.addListener("dragend", () => {
        updateLocation(marker.getPosition());
    });

    // Current location button
    document.getElementById("useCurrentLocation").addEventListener("click", () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    updateLocation({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });
                },
                () => alert("Failed to retrieve your location."), {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            alert("Geolocation is not supported.");
        }
    });
}

function updateLocation(loc, placeData = null) {
    map.setCenter(loc);
    map.setZoom(15);
    marker.setPosition(loc);
    circle.setCenter(loc);

    const lat = typeof loc.lat === "function" ? loc.lat() : loc.lat;
    const lng = typeof loc.lng === "function" ? loc.lng() : loc.lng;

    document.getElementById(latId).value = lat;
    document.getElementById(lngId).value = lng;

    const geocoder = new google.maps.Geocoder();

    if (placeData && placeData.address_components) {
        populateAddressFields(placeData);
    } else {
        // Reverse geocode
        geocoder.geocode({
            location: {
                lat,
                lng
            }
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                populateAddressFields(results[0]);
            } else {
                alert("Failed to retrieve address for this location.");
            }
        });
    }
}

function populateAddressFields(place) {
    const addr = place.formatted_address || "";
    document.getElementById(searchBoxId).value = addr;

    let city = "",
        state = "",
        zip = "",
        country = "";

    place.address_components.forEach(c => {

        // console.log(c);
        // if (c.types.includes("locality")) city = c.long_name;
        // if (c.types.includes("administrative_area_level_1")) state = c.long_name;
        // if (c.types.includes("postal_code")) zip = c.long_name;
        // if (c.types.includes("country")) country = c.long_name;
    });

    const addrParts = addr.split(",");

    console.log(addrParts);

    // // Remove city, state, zip, country from line 2
    // let addrLine2Parts = addrParts.slice(2).map(part => part.trim());
    // addrLine2Parts = addrLine2Parts.filter(part => {
    //     part = part.trim().toLowerCase();
    //     return part &&
    //         (!city || !part.includes(city.toLowerCase())) &&
    //         (!state || !part.includes(state.toLowerCase())) &&
    //         (!zip || !part.includes(zip.toLowerCase())) &&
    //         (!country || !part.includes(country.toLowerCase())) &&
    //         !part.includes("usa");
    // });

    document.getElementById(address1Id).value = addrParts.slice(0, 2).join(",").trim();
    document.getElementById(address2Id).value = addrParts.slice(2, 5).join(",").trim();

    document.getElementById(selectedAddressStore_address).value = addrParts;



    // document.getElementById(cityId).value = city;
    // document.getElementById(pincodeId).value = zip;
    // document.getElementById(countryId).value = country;

    // Optional: display full address somewhere
    document.getElementById(selectedAddressId).textContent = addr;
}

// Initialize map when offcanvas opens
document.addEventListener("DOMContentLoaded", () => {
    const gpsPanel = document.getElementById("gpspanel");
    const openMapBtn = document.querySelector('[data-bs-target="#gpspanel"]');

    if (gpsPanel && openMapBtn) {
        gpsPanel.addEventListener("shown.bs.offcanvas", () => {
            if (!mapInitialized) {
                setTimeout(() => {
                    initMap();
                    mapInitialized = true;
                }, 300);
            } else {
                setTimeout(() => {
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(marker.getPosition());
                }, 300);
            }
        });
    }
});



$(document).ready(function() {
    // When user types in any input or textarea
    $(document).on('input', '.form-control, .form-check-input', function() {
        // Check if input has a value (not empty)
        if ($(this).val().trim() !== '') {
            // Remove the nearby error message
            $(this).closest('.form-group').find('.text-danger').fadeOut(200, function() {
                $(this).remove();
            });
        }
    });
});
</script>

<script>
$("#uploadImage").change(function(event) {
    const file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $("#previewImg").attr("src", e.target.result);
        }
        reader.readAsDataURL(file);
    }
});

$("#uploadImage2").change(function(event) {
    const file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $("#previewProfile").attr("src", e.target.result);
        }
        reader.readAsDataURL(file);
    }
});

$("#edit_uploadChart").on("change", function(event) {
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $("#placeholderImg").attr("src", e.target.result);
            $(".upload-passbook").show(); // show div
        }
        reader.readAsDataURL(file);
    }
});

// Update Profile Update Code

$(document).on('submit', 'form#editprofile', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $("#file-error").html("");

    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

    $('.submit').attr('disabled', true);
    // $('.form-control').attr('readonly', true).addClass('disabled-link');
    $('.error-control').addClass('disabled-link');

    if ($('.submit').html() !== loadingText) {
        $('.submit').html(loadingText);
    }

    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        // beforeSend: function() {
        //     // Show loader
        //     $('#loader').show();
        // },
        success: function(response) {
            console.log(response);

            window.setTimeout(function() {
                $('.customBtn, .form-control').attr('disabled', false).removeClass(
                    'disabled-link');
                $('.submit').html('Upload');
            }, 2000);

            if (response.status === 'success') {
                toastr.success(response.message);

                $('.submit').attr('disabled', true);
                window.setTimeout(function() {
                    window.location = "{{ route('seller.view_profile') }}";
                }, 2000);
            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

            $.each(errors, function(field, messages) {

                console.log(field);

                let errorId = "#error-" + field;

                $(errorId).html(messages[0]);


                // 1️⃣ Handle array fields with index → product_spe_en.0
                if (field.includes(".")) {

                    let parts = field.split(".");
                    let fieldName = parts[0];
                    let index = parts[1];
                    let index1 = parts[2];


                    // Example → #error-product_spe_en_0

                    let errorId = "#error-" + fieldName + "_" + index;

                    // If second index exists, append it
                    if (typeof index1 !== "undefined" && index1 !== "") {
                        errorId += "_" + index1;
                    }
                    $(errorId).html(messages[0]);


                } else {

                    // 2️⃣ File special case
                    if (field === "file") {
                        $("#file-error").html(messages[0]);
                    }

                    // 3️⃣ Handle whole array errors (custom rule)
                    $("#error-" + field).html(messages[0]);
                }
            });
        },
        // complete: function() {
        //     // Hide loader (after success or error)
        //     $('#loader').hide();
        // }


    });

    return false;
});

// upDate Bank details Code 

$(document).on('submit', 'form#editbankdetails', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $("#file-error").html("");

    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

    $('.submit').attr('disabled', true);
    // $('.form-control').attr('readonly', true).addClass('disabled-link');
    $('.error-control').addClass('disabled-link');

    if ($('.submit').html() !== loadingText) {
        $('.submit').html(loadingText);
    }

    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        // beforeSend: function() {
        //     // Show loader
        //     $('#loader').show();
        // },
        success: function(response) {
            console.log(response);

            window.setTimeout(function() {
                $('.customBtn, .form-control').attr('disabled', false).removeClass(
                    'disabled-link');
                $('.submit').html('Upload');
            }, 2000);

            if (response.status === 'success') {
                toastr.success(response.message);

                $('.submit').attr('disabled', true);
                window.setTimeout(function() {
                    window.location = "{{ route('seller.view_profile') }}";
                }, 2000);
            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

            $.each(errors, function(field, messages) {

                // 1️⃣ Handle array fields with index → product_spe_en.0
                if (field.includes(".")) {

                    let parts = field.split(".");
                    let fieldName = parts[0];
                    let index = parts[1];
                    let index1 = parts[2];


                    // Example → #error-product_spe_en_0

                    let errorId = "#error-" + fieldName + "_" + index;

                    // If second index exists, append it
                    if (typeof index1 !== "undefined" && index1 !== "") {
                        errorId += "_" + index1;
                    }
                    $(errorId).html(messages[0]);


                } else {

                    // 2️⃣ File special case
                    if (field === "file") {
                        $("#file-error").html(messages[0]);
                    }

                    // 3️⃣ Handle whole array errors (custom rule)
                    $("#error-" + field).html(messages[0]);
                }
            });
        },
        // complete: function() {
        //     // Hide loader (after success or error)
        //     $('#loader').hide();
        // }


    });

    return false;
});
</script>

<script>
$(document).ready(function() {
    // When a user selects a country (clicks a label)
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });


    $(document).on('click', '.country-option1', function() {
        let radio = $(this).find('.country-radio1');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag1').html('');
        $('#selected-code1').text(flag + ' ' + ' ' + name);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown1').dropdown('hide');
    });

});
</script>
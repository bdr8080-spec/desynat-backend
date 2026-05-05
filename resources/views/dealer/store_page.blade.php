<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
    <!-- Favicons -->
    <link href="{{ asset('/dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" />
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/custom.css" rel="stylesheet">

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

    <!-- <style>

        iframe#\:1\.container {
    visibility: hidden !important;
}

/* Hide the Google Translate tooltip */
.goog-te-banner-frame.skiptranslate,
.goog-tooltip,
.goog-tooltip:hover,
.goog-tooltip-vertical {
    display: none !important;
}

/* Hide the feedback popup on selected text */
#goog-gt-tt {
    display: none !important;
}
    </style>

    <style>
  body {
    visibility: hidden;
  }
</style> -->


</head>

<body>

    <div class="login-header">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('/dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                    <span id="currentLang">EN</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                    <li>
                                        <a class="dropdown-item" data-lang="ar">
                                            <span>AR</span> Arabic
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" data-lang="en">
                                            <span>EN</span> English
                                        </a>
                                    </li>

                                </ul>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif

    <div class="login-wapper">
        <div class="container-fluid p-0">
            <div class="login-grid-bg">
                <div class="row g-0">
                    <div class="col-lg-6 bg-logo-wapper">
                        <div class="login-img">
                            <img src="{{ asset('/dealer') }}/assets/img/Desynat-logo-2.svg" alt="image"
                                class="img-fluid logo-login">
                        </div>
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-right.svg" alt="image"
                            class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2 signup-scroll pagescroll p-3">
                                <div class="cmn-header mb-3">
                                    <h1><a href="#"><i class="bi bi-chevron-left"></i></a> Store
                                        information</h1>
                                </div>

                                <form action="{{ route('seller.store_information', request()->id) }}" method="Post">


                                    <input type="hidden" id="lat" name="let">
                                    <input type="hidden" id="lng" name="long">


                                    <div class="step-progress py-4">
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>

                                    <div class="upload-image w-100">
                                        <label id="uploadLabel" style="cursor:pointer;text-align:center;">
                                            <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                                            <div>Upload Store Image </div>
                                            <input type="file" accept="image/*" hidden
                                                onchange="showPreview(event)" id="edit_imageUpload">
                                        </label>

                                        @if (isset($store_info->store_image))
                                            <div class="imgshow">
                                                <img id="preview" src="{{ $store_info->store_image }}"
                                                    style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                                                <span id="remove" class="removebtn"
                                                    onclick="removeImg()">&times;</span>
                                            </div>
                                        @else
                                            <div class="imgshow">
                                                <img id="preview"
                                                    style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                <span id="remove" class="removebtn"
                                                    style="display:none;cursor:pointer;font-size:24px;color:red;"
                                                    onclick="removeImg()">&times;</span>
                                            </div>
                                        @endif

                                    </div>
                                    <input type="hidden" class="form-control" name="store_image" id="store_image"
                                        value=" {{ old('store_image', @$store_info->store_image) }}">

                                    @error('store_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Store Name</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="Enter Store name" name="store_name"
                                            value="{{ old('store_address', @$store_info->store_name) }}">

                                        @error('store_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>



                                    <div class="form-group">
                                        <label for="name">Choose Country</label>
                                        <!-- <input type="text" class="form-control" placeholder="Enter Last Name" name="country" value="{{ old('country') }}"> -->

                                        <select name="country" class="form-control form-select">
                                            <option value=""> Please Select Country </option>
                                            @foreach ($country as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('country', @$store_info->country) == $val->id ? 'selected' : '' }}>
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>



                                    {{-- <div class="form-group">
                                        <label for="name">Store Address</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="Enter Store Address" name="store_address"
                                            value="{{ old('store_address', @$store_info->store_address) }}">
                                    </div> --}}

                                    <div class="form-group">
                                        <label for="name">Store Address</label>
                                        <div class="store-map  position-relative">
                                            <input type="text" class="form-control blockFirstTime"
                                                placeholder="Enter Store Address" name="store_address"
                                                value="{{ old('store_address', @$store_info->store_address) }}"
                                                id="store_address">
                                            {{-- <div class="mapIcon" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i
                                                    class="bi bi-crosshair "></i></div> --}}

                                            <button class="btn gpsmap" type="button" data-bs-toggle="offcanvas"
                                                data-bs-target="#gpspanel" aria-controls="offcanvasExample">
                                                <i class="bi bi-crosshair"></i>
                                            </button>


                                        </div>
                                        @error('store_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="name">Address line 1</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="Enter Address line 1" name="address_line1"
                                            value="{{ old('address_line1', @$store_info->address_line1) }}"
                                            id="address_line1">
                                        @error('address_line1')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Address line 2</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="Enter Address line 2" name="address_line2"
                                            value="{{ old('address_line2', @$store_info->address_line2) }}"
                                            id="address_line2">
                                        @error('address_line2')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>




                                    <div class="form-group phone-pnl">
                                        <label for="name">Store Phone Number</label>

                                        <div class="form-group d-flex gap-2">

                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                    type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">

                                                    <span id="selected-flag">
                                                        <img src="{{ old('country_flag', $country[0]->flag1) }}"
                                                            alt="flag" width="25" height="16">
                                                    </span>
                                                    <span id="selected-code" class="ms-2">
                                                        {{ old('country_code', $country[0]->dial_code) }}
                                                    </span>
                                                </button>

                                                <ul class="dropdown-menu p-2" aria-labelledby="countryDropdown"
                                                    style="max-height: 250px; overflow-y: auto; width: 100%;">

                                                    @foreach ($country as $index => $item)
                                                        <li>
                                                            <label
                                                                class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                                style="cursor: pointer;">
                                                                <input type="radio" name="country_code"
                                                                    value="{{ $item->dial_code }}"
                                                                    data-flag="{{ $item->flag1 }}"
                                                                    data-name="{{ $item->name }}"
                                                                    class="country-radio"
                                                                    {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                                    hidden>
                                                                <img src="{{ $item->flag1 }}"
                                                                    alt="Flag of {{ $item->name }}" width="25"
                                                                    height="16">
                                                                <span>{{ $item->dial_code }}
                                                                    ({{ $item->name }})
                                                                </span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            {{-- country code end  --}}

                                            <div class="w-100">
                                                <input class="form-control notapplyspace" type="number"
                                                    id="phone" placeholder="Enter Store Phone Number"
                                                    name="store_phone"
                                                    value="{{ old('store_phone', @$store_info->store_phone) }}"
                                                    oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">

                                                @error('store_phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Store email id</label>
                                        <input type="text" class="form-control notapplyspace"
                                            placeholder="Enter Store email Id" name="store_mail_id"
                                            value="{{ old('store_mail_id', @$store_info->store_mail_id) }}">
                                        @error('store_mail_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Bio</label>
                                        <textarea class="form-control blockFirstTime" rows="3" placeholder="Write a massage...." name="bio"> {{ old('bio', @$store_info->bio) }} </textarea>
                                        @error('bio')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="login-btn mt-5">
                                        <input type="submit" class="btn btn-success w-100" value="Continue">

                                        <!-- <a href="bank-details.php" class="btn btn-success w-100">Continue</a> -->
                                    </div>

                                </form>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title">Add Address</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="maps-wapper">

                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="search-box" placeholder="Search address">
                </div>
                <div id="map"></div>

                <div class="login-btn mt-5">
                    <label for="name">Location</label>
                    <p>HN-574, Street no,5 Block a new town hale </p>
                </div>

                <div class="login-btn mt-4">
                    <a href="bank-details.php" class="btn btn-success w-100">Continue</a>
                </div>

            </div>
        </div>
    </div> --}}


    <div class="offcanvas offcanvas-end" tabindex="-1" id="gpspanel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Set Location</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="gps-wapper">

                <div class="setup-maps mb-0 position-relative">


                    <input id="searchBox" type="text" placeholder="Search your address"
                        class="form-control position-absolute"
                        style="top:10px;left:10px;width:300px;z-index:9999;padding:6px 10px;border-radius:4px;">

                    <div id="googleMap" style="width: 100%; height: 500px;"></div>

                    <div id="useCurrentLocation">
                        <i class="bi bi-crosshair"></i> Use Current Location
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
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="offcanvas">Done</button>
                </div>
            </div>
        </div>
    </div>

            <!-- <div id="google_translate_element" style="display:none;"></div>
<div id="loaderTrans"
        style="display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:#ffffff; 
        z-index:999999;   
        /* display:flex;    */
        align-items:center;
        justify-content:center;">

        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"
                style="border:none; width:200px; height:200px;">
        </iframe>
    </div> -->



</body>


<!-- Vendor JS Files -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js"></script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&libraries=places">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const countryRadios = document.querySelectorAll('.country-radio');
        const selectedFlag = document.getElementById('selected-flag').querySelector('img');
        const selectedCode = document.getElementById('selected-code');
        const countryFlagInput = document.getElementById('country_flag');
        const countrySearch = document.getElementById('countrySearch');

        // Update selected flag and code when user picks a country
        countryRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const flag = this.dataset.flag;
                const dialCode = this.value;

                selectedFlag.src = flag;
                selectedCode.textContent = dialCode;
                countryFlagInput.value = flag;
            });
        });

        // Search filter
        countrySearch.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.country-option').forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
</script>



<script>
    // function showPreview(e) {
    //     const f = e.target.files[0],
    //         p = preview,
    //         r = remove,
    //         u = uploadLabel;

    //     if (f) {
    //         const rdr = new FileReader();
    //         rdr.onload = x => {
    //             p.src = x.target.result;
    //             p.style.display = 'block';
    //             r.style.display = 'inline';
    //             u.style.display = 'none';
    //         };
    //         rdr.readAsDataURL(f);

    //     }

    //     f.value = '';

    // }

    function showPreview(e) {
        const f = e.target.files[0],
            p = preview,
            r = remove,
            u = uploadLabel;

        if (f) {
            const rdr = new FileReader();
            rdr.onload = x => {
                p.src = x.target.result;
                p.style.display = 'block';
                r.style.display = 'inline';
                u.style.display = 'none';
            };
            rdr.readAsDataURL(f);
        }

        // ✅ Reset input so same file can be selected again
        // e.target.value = '';
    }


    function removeImg() {
        preview.src = '';
        preview.style.display = 'none';
        remove.style.display = 'none';
        uploadLabel.style.display = 'block';
        $('#store_image').val('');
    }


    $(document).on('change', '#edit_imageUpload', function(event) {

        event.preventDefault();
        let file = $(this)[0].files[0];
        let formData = new FormData();
        formData.append('image', file);
        // let name = formData.get('file').name;
        let name = file.name;

        sessionStorage.setItem('uploadedFileName', name);
        let uploadfile = sessionStorage.getItem('uploadedFileName', name);
        // $("#fileName").text(uploadfile);
        $("#fileName").text(name); // Display the file name in the UI

        $.ajax({
            method: 'POST', // Corrected from the comment
            url: "/api/upload",
            headers: {
                'Accept-Language': 'en'
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp) {
                $('#fileName').text(name);
                window.setTimeout(function() {
                    $('.submit').attr('disabled', false);
                    $('.form-control').attr('readonly', false);
                    $('.form-control').removeClass('disabled-link');
                    $('.error-control').removeClass('disabled-link');
                    $('.submit').html('Add');
                }, 2000);
                if (resp.status == 'success') {
                    sessionStorage.setItem('FileUrl', resp.data);
                    $('#store_image').val(resp.data.url);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                var response = xhr.responseJSON;
                // Optionally handle errors here
            }
        });
    });
</script>


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
            document.getElementById(id).value = "";
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

<!-- translator -->
<!-- <script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        autoDisplay: false
    }, 'google_translate_element');
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>

let currentLang = localStorage.getItem("selectedLang") || "en";
let translateReady = false;

/* WAIT FOR GOOGLE DROPDOWN (ROBUST VERSION) */
function waitForCombo(callback) {

    let attempts = 0;

    const timer = setInterval(() => {

        const combo = document.querySelector(".goog-te-combo");

        if (combo && combo.options.length > 1) {
            clearInterval(timer);
            translateReady = true;
            callback(combo);
        }

        attempts++;

        if (attempts > 30) {
            clearInterval(timer);
            console.warn("Google Translate not ready");
        }

    }, 200);
}


/* APPLY TRANSLATION (FIXED FIRST TIME ISSUE) */
function applyTranslation(lang) {

    const loader = document.getElementById("loaderTrans");
    if (loader) loader.style.display = "flex";

    currentLang = lang;
    localStorage.setItem("selectedLang", lang);

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // STEP 1: RESET
        trigger("en");

        setTimeout(() => {

            // STEP 2: APPLY LANGUAGE
            trigger(lang);

            // STEP 3: RETRY (VERY IMPORTANT FIX)
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                if (loader) loader.style.display = "none";

            }, 500);

        }, 300);

    });
}


/* UPDATE UI */
function updateUI(lang) {

    const current = document.getElementById("currentLang");
    if (current) current.innerText = lang.toUpperCase();

    document.querySelectorAll(".langu .dropdown-item")
        .forEach(el => el.style.background = "");

    const active = document.querySelector(`.langu .dropdown-item[data-lang="${lang}"]`);

    if (active) {
        active.style.background =
            "linear-gradient(73.47deg, #F9DBAB 0%, #7D532F 132.99%)";
    }
}


/* CLICK EVENTS */
document.querySelectorAll(".langu .dropdown-item").forEach(item => {

    item.addEventListener("click", function () {

        const lang = this.getAttribute("data-lang");

        // PREVENT CLICK BEFORE READY
        if (!translateReady) {
            console.log("Translate still loading...");
            return;
        }

        applyTranslation(lang);

    });

});


/* INITIAL LOAD */
function initLanguage() {

    const lang = localStorage.getItem("selectedLang") || "en";
    const loader = document.getElementById("loaderTrans");

    if (loader) loader.style.display = "flex";

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // RESET FIRST
        trigger("en");

        setTimeout(() => {

            trigger(lang);

            // RETRY FIX
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                // SHOW PAGE ONLY AFTER TRANSLATION
                document.body.style.visibility = "visible";

                if (loader) loader.style.display = "none";

            }, 600);

        }, 300);

    });

}

window.addEventListener("load", initLanguage);


/* BACK/FORWARD CACHE FIX */
window.addEventListener("pageshow", function (event) {

    if (event.persisted ||
        performance.getEntriesByType("navigation")[0]?.type === "back_forward") {

        setTimeout(() => {
            initLanguage();
        }, 200);
    }

});


/* HIDE GOOGLE TOOLTIP */
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.id === 'goog-gt-tt') {
                node.style.display = 'none';
            }
        });
    });
});

observer.observe(document.body, { childList: true, subtree: true });

</script> -->

{{-- @include('dealer.custom_code'); --}}


@include('dealer.layout.custom_code')

</html>

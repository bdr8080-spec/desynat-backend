<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Desynat Address</title>
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


</head>

<body>

    <div class="login-header">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('/dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('/dealer') }}/assets/img/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </div>
    </div>

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
                        <img src="{{ asset('/dealer') }}/assets/img/Vector-right.svg" alt="image" class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2 signup-scroll pagescroll p-3">
                                <div class="cmn-header mb-3">
                                    <h1><a href="#"><i class="bi bi-chevron-left"></i></a> Address</h1>
                                </div>

                                <form id="Affiliate_AddAddress" action="{{route('affiliate.affiliate_addaddress')}}"
                                    method="Post">


                                    <input type="hidden" name="affilated_id" value="{{$id}}">

                                    <input type="hidden" id="lat" name="let"
                                        value="{{ old('let', @$affiliate_address->let) }}">
                                    <input type="hidden" id="lng" name="long"
                                        value="{{ old('long', @$affiliate_address->long) }}">

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

                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Choose Country</label>
                                        <!-- <input type="text" class="form-control" placeholder="Enter Last Name" name="country" value="{{ old('country') }}"> -->

                                        <select name="country" class="form-control form-select">
                                            <option value=""> Please Select Country </option>
                                            @foreach ($country as $val)
                                            <option value="{{ $val->id }}"
                                                {{ old('country', @$affiliate_address->country) == $val->id ? 'selected' : '' }}>
                                                {{ $val->name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        <p class="text-danger" id="error-country"></p>

                                    </div>

                                    <div class="form-group">
                                        <label for="name">Choose Location</label>
                                        <div class="store-map  position-relative">
                                            <input type="text" class="form-control blockFirstTime"
                                                placeholder="Locations" name="locations"
                                                value="{{ old('locations' , @$affiliate_address->locations) }}"
                                                id="store_address">
                                            {{-- <div class="mapIcon" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i
                                                    class="bi bi-crosshair "></i></div> --}}

                                            <button class="btn gpsmap" type="button" data-bs-toggle="offcanvas"
                                                data-bs-target="#gpspanel" aria-controls="offcanvasExample">
                                                <i class="bi bi-crosshair"></i>
                                            </button>


                                        </div>

                                        <p class="text-danger" id="error-locations"></p>
                                    </div>


                                    <div class="form-group">
                                        <label for="name">Address line 1</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="Enter Address line 1" name="address1"
                                            value="{{ old('address1', @$affiliate_address->address1) }}"
                                            id="address_line1">

                                        <p class="text-danger" id="error-address1"></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Address line 2</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="Enter Address line 2" name="address2"
                                            value="{{ old('address2', @$affiliate_address->address2) }}"
                                            id="address_line2">
                                        <p class="text-danger" id="error-address2"></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Pin Code</label>
                                        <input type="text" class="form-control blockFirstTime applynumberOnly"
                                            placeholder="Enter Pincode" name="pincode"
                                            value="{{ old('pincode', @$affiliate_address->pincode) }}">
                                        <p class="text-danger" id="error-pincode"></p>

                                    </div>

                                    <div class="form-group">
                                        <label for="name">Locality Town</label>
                                        <input type="text" class="form-control blockFirstTime"
                                            placeholder="Enter town name" name="town"
                                            value="{{ old('town', @$affiliate_address->town) }}">

                                        <p class="text-danger" id="error-town"></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name"> State </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter State Name" name="state"
                                                        value="{{ old('town', @$affiliate_address->state) }}">
                                                    <p class="text-danger" id="error-state"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name"> City </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter City Name" name="city"
                                                        value="{{ old('town', @$affiliate_address->city) }}">
                                                    <p class="text-danger" id="error-city"></p>
                                                </div>
                                            </div>
                                        </div>
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



</body>



<!-- Vendor JS Files -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js"></script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk1iHVph8nvXAn0uigTvPzKDpb9cslR18&libraries=places">
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
                // alert("Address not found!");
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




$(document).on('submit', 'form#Affiliate_AddAddress', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $(".text-danger").html("");

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
        beforeSend: function() {
            //     // Show loader
            $('#loader').show();
        },
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

                setTimeout(() => {
                    location.href =
                        `affiliate-add-Bank-details?temp_user_id=${response.id}`;
                }, 1000);

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
        complete: function() {
            // Hide loader (after success or error)
            $('#loader').hide();
        }


    });

    return false;
});
</script>


@include('dealer.layout.custom_code')

</html>
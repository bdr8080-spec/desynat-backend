@extends('admin.layout.app')
@section('content')
<style>
    .pac-container {
            z-index: 9999;
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
.use-lc {
    /* background: #fff;
    box-shadow: 0px 2px 8px 0px #0000001f;
    padding: 10px; */
width: fit-content;
    border-radius: 50px;
    color: #a8824f;
    font-weight: 500;
    position: absolute;
    bottom: 239px;
    right: 568px;
    cursor: pointer;
    font-size: 17px;
}
.search-icon {
    position: absolute;
    left: 20px;
    top: 13px;
    font-size: 14px;
}
.card-body {
    background: #6c757d0a;
}
</style>

<div class="inner-content management">
    <div class="d-flex flex-column align-items-start back-btn-box">

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a href="{{route('admin.deliveryBoyManagement')}}" class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">Edit Delivery Boy</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <!-- Start Form -->

                    <form id="deliveryBoyForm" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="id" value="{{$deliveryBoy->id}}">
                            <!-- @if(isset($deliveryBoy->profile_pic) && !isset($step1Data['profile_pic']))
                                <input type="hidden" name="profile_pic_existing" value="{{ $deliveryBoy->profile_pic }}">
                            @endif -->
                            <input type="hidden" name="profile_pic_existing" 
                              value="{{ $step1Data['profile_pic'] ?? $deliveryBoy->profile_pic ?? '' }}">
                            <!-- Profile Image -->
                            <!-- <div class="col-lg-12">
                                <div class="upload-title text-center">Upload Profile Image</div>
                                <div class="upload-new text-center">
                                    <label for="profileUpload" class="upload-box">
                                        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                            id="profileUploadIcon"
                                            class="upload-icon"
                                            style="{{ isset($step1Data['profile_pic']) || isset($deliveryBoy->profile_pic) ? 'display:none;' : '' }}" />
                                        <div class="upload-text">Upload Profile Image</div>
                                        <input type="file" id="profileUpload" name="profile_pic" hidden accept="image/*" />
                                        <img id="profilePreview" class="preview-image"
                                            src="{{ $step1Data['profile_pic'] ?? $deliveryBoy->profile_pic ?? '' }}"
                                            style="{{ isset($step1Data['profile_pic']) || isset($deliveryBoy->profile_pic) ? 'display:block;' : 'display:none;' }}" />
                                    </label>
                                    <span class="text-danger" id="profile_image_error"></span>
                                </div>
                            </div> -->
                            <div class="col-lg-12">
                                <div class="upload-title text-center">Upload Profile Image</div>
                                <div class="upload-new text-center">
                                    <label for="profileUpload" class="upload-box">
                                        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                            id="profileUploadIcon"
                                            class="upload-icon"
                                            style="{{ ($step1Data['profile_pic'] ?? $deliveryBoy->profile_pic) ? 'display:none;' : '' }}" />
                                        
                                        <div class="upload-text">Upload Profile Image</div>
                                        <input type="file" id="profileUpload" name="profile_pic" hidden accept="image/*" />
                                        
                                        <img id="profilePreview" class="preview-image"
                                            src="{{ $step1Data['profile_pic'] ?? $deliveryBoy->profile_pic ?? '' }}"
                                            style="{{ ($step1Data['profile_pic'] ?? $deliveryBoy->profile_pic) ? 'display:block;' : 'display:none;' }}" />
                                    </label>
                                    <span class="text-danger" id="profile_image_error"></span>
                                </div>
                            </div>

                            <!-- Left Column -->
                            <div class="col-lg-6">
                                <!-- Full Name English -->
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="mb-0">Full Name</label>
                                        <span class="text-muted" style="font-size: 12px;">In English</span>
                                    </div>
                                    <input type="text" placeholder="Enter Full Name" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"  class="form-control mt-1"
                                        name="full_name_english"
                                        value="{{ $step1Data['full_name_english'] ?? $deliveryBoy->full_name_english ?? '' }}" />
                                    <span class="text-danger" id="full_name_en_error"></span>
                                </div>

                                <!-- Email -->
                                <div class="mt-3">
                                    <label>Email-id</label>
                                    <input type="email" placeholder="Enter Email-Id" class="form-control"
                                        name="email" value="{{ $step1Data['email'] ?? $deliveryBoy->email ?? '' }}" />
                                    <span class="text-danger" id="email_error"></span>
                                </div>

                                <!-- Address Line 1 -->
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="mb-0">Address line 01</label>
                                    </div>
                                    <div class="position-relative mt-1">
                                        <input type="text" class="form-control" name="address_line1"
                                            placeholder="Enter Address Line 01"
                                            value="{{ $step1Data['address_line1'] ?? $deliveryBoy->address_line1 ?? '' }}" />
                                        <i class="bi bi-crosshair" data-bs-toggle="modal" data-bs-target="#sentModal5"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor:pointer;"></i>
                                    </div>
                                    <span class="text-danger" id="address_line1_error"></span>
                                </div>

                                <!-- City -->
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="mb-0">City</label>
                                    </div>
                                    <input type="text" name="city" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"  placeholder="Enter City" class="form-control mt-1"
                                        value="{{ $step1Data['city'] ?? $deliveryBoy->city ?? '' }}" />
                                    <span class="text-danger" id="city_error"></span>
                                </div>

                                <!-- Password -->
                                <div class="mt-3 position-relative">
                                    <label>Password</label>
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Enter password" value="{{ $step1Data['password'] ?? $deliveryBoy->unhashed_password ?? '' }}"style="font-size: 17px;" />
                                    <i class="fas fa-eye toggle-password position-absolute" toggle="#password"
                                    style="right: 15px; cursor: pointer;"></i>
                                </div>
                                <span class="text-danger" id="password_error"></span>

                                <!-- Zone -->
                                <div class="mt-3">
                                    <label>Select Zone</label>
                                    <select class="form-select" name="zone_id">
                                        <option value="">Select Zone</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}"
                                                {{ (isset($step1Data['zone_id']) && $step1Data['zone_id'] == $zone->id) || 
                                                (!isset($step1Data['zone_id']) && isset($deliveryBoy->zone_id) && $deliveryBoy->zone_id == $zone->id) ? 'selected' : '' }}>
                                                {{ $zone->name_english }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="zone_error"></span>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-6">
                                <!-- Full Name Arabic -->
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="mb-0">Full Name</label>
                                        <span class="text-muted" style="font-size: 12px;">In Arabic</span>
                                    </div>
                                    <input type="text" placeholder="Enter Full Name" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control mt-1"
                                        name="full_name_arabic"
                                        value="{{ $step1Data['full_name_arabic'] ?? $deliveryBoy->full_name_arabic ?? '' }}" />
                                    <span class="text-danger" id="full_name_ar_error"></span>
                                </div>

                                <!-- Mobile -->
                                <div class="mt-3 position-relative mobile-field">
                                    <input type="hidden" id="country_code" name="country_code"
                                        value="{{ $step1Data['country_code'] ?? $deliveryBoy->country_code ?? '' }}">
                                    <input type="hidden" id="let" name="let"
                                        value="{{ $step1Data['let'] ?? $deliveryBoy->let ?? '' }}">
                                    <input type="hidden" id="long" name="long"
                                        value="{{ $step1Data['long'] ?? $deliveryBoy->long ?? '' }}">
                                    <label>Mobile Number</label>
                                    <input id="phone" type="tel"  class="form-control" name="mobile" oninput="this.value = this.value.replace(/[^0-9]/g,'').replace(/^\s+/,'')"
                                        value="{{ $step1Data['mobile'] ?? $deliveryBoy->mobile ?? '' }}" />
                                    <span class="text-danger" id="mobile_error"></span>
                                </div>

                                <!-- Address Line 2 -->
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="mb-0">Address line 02</label>
                                    </div>
                                    <input type="text" class="form-control" name="address_line2"
                                        placeholder="Enter Address Line 02"
                                        value="{{ $step1Data['address_line2'] ?? $deliveryBoy->address_line2 ?? '' }}" />
                                    <span class="text-danger" id="address_line2_error"></span>
                                </div>

                                <!-- State -->
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="mb-0">State</label>
                                    </div>
                                    <input type="text" name="state" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"  placeholder="Enter State" class="form-control mt-1"
                                        value="{{ $step1Data['state'] ?? $deliveryBoy->state ?? '' }}" />
                                    <span class="text-danger" id="state_error"></span>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-3 position-relative">
                                    <label>Confirm Password</label>
                                    <input type="password" id="confirmPassword" class="form-control" name="confirm_password"
                                        placeholder="Enter Confirm password"
                                        value="{{ $step1Data['password'] ?? $deliveryBoy->unhashed_password ?? '' }}"  style="font-size: 17px;"/>
                                    <i class="fas fa-eye toggle-password position-absolute" toggle="#confirmPassword"
                                    style="right: 15px; cursor: pointer; "></i>
                                </div>
                                <span class="text-danger" id="confirm_password_error"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 mt-4">
                            <button type="submit" class="btn btn-dark customBtn">Next</button>
                        </div>
                    </form>



                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="sentModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Address</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="appointment-container d-flex flex-column align-items-start">
                        <input id="searchBox" type="text" placeholder="Search your address"
                            class="form-control"
                            style="padding: 9px 18px;border-radius:4px;width: 80%;">

                        <div class="w-100 mb-3 d-flex justify-content-center">
                            <div id="map" style="width: 100%; height: 408px; border-radius: 10px; overflow: hidden;"></div>
                        </div>

                        <div class="find-location d-flex gap-3 py-4">
                            <div id="useCurrentLocation" class="use-lc">
                                <i class="bi bi-crosshair"></i> Use Current Location
                            </div>
                            <div class="d-flex justify-content-start" style="gap: 23px;">
                                <i class="bi bi-geo-alt-fill"></i>
                                <p class="mb-0" id="selectedAddress">9XHG+629, Kuwait City, Kuwait</p>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 mt-3">
                            <span id="locationError" style="color: red; display: none; margin-bottom: 10px;"></span>
                            <button class="btn btn-dark customBtn w-100 setup-done button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
// Toggle password visibility
document.querySelectorAll(".toggle-password").forEach((toggle) => {
    toggle.addEventListener("click", function() {
        const input = document.querySelector(this.getAttribute("toggle"));
        const type =
            input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);

        // Toggle icon between eye (fa-eye) and eye-slash (fa-eye-slash)
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});
</script>


<!-- country code -->
<script>
    // const input = document.querySelector("#phone");
    // const iti = window.intlTelInput(input, {
    //     initialCountry: "kw",  // Set Kuwait as initial country
    //     separateDialCode: true,
    //     utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    //     autoPlaceholder: "off"
    // });

    // document.querySelector("#country_code").value = "+" + iti.getSelectedCountryData().dialCode;

    // input.addEventListener("countrychange", function() {
    //     document.querySelector("#country_code").value = "+" + iti.getSelectedCountryData().dialCode;
    // });
    const input = document.querySelector("#phone");

    const iti = window.intlTelInput(input, {
        initialCountry: "kw",
        separateDialCode: true,
        allowDropdown: false,   // 🔒 DISABLE CHANGING COUNTRY
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        autoPlaceholder: "off",
    });

    // Always set Kuwait code
    document.querySelector("#country_code").value = "+965";
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&callback=initMap&libraries=places&loading=async">
</script>


<script>
let map, userMarker, geocoder, selectedLatLng = null;

function initMap() {
    const defaultLocation = { lat: 29.3759, lng: 47.9774 }; // Kuwait City

    // Initialize Map
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLocation,
        zoom: 12,
    });

    geocoder = new google.maps.Geocoder();

    // Marker setup
    userMarker = new google.maps.Marker({
        map: map,
        position: defaultLocation,
        draggable: true,
        title: "Drag to adjust location"
    });

    // Autocomplete setup
    const searchInput = document.getElementById("searchBox");
    const autocomplete = new google.maps.places.Autocomplete(searchInput);
    autocomplete.bindTo("bounds", map);
    autocomplete.setFields(['geometry', 'formatted_address', 'address_components']); // ✅ include address_components

    autocomplete.addListener("place_changed", function() {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) {
            showLocationError("Place has no geometry.");
            return;
        }
        clearLocationError();
        selectedLatLng = place.geometry.location;
        map.setCenter(selectedLatLng);
        map.setZoom(15);
        userMarker.setPosition(selectedLatLng);
        updateFullAddressUI(selectedLatLng);
    });

    // Marker dragged manually
    userMarker.addListener("dragend", function() {
        selectedLatLng = userMarker.getPosition();
        updateFullAddressUI(selectedLatLng);
    });

    // Use Current Location
    document.querySelector(".use-lc").addEventListener("click", function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                clearLocationError();
                selectedLatLng = new google.maps.LatLng(
                    position.coords.latitude,
                    position.coords.longitude
                );
                map.setCenter(selectedLatLng);
                map.setZoom(15);
                userMarker.setPosition(selectedLatLng);
                updateFullAddressUI(selectedLatLng);
            }, function(error) {
                showLocationError("Error getting location: " + error.message);
            });
        } else {
            showLocationError("Geolocation not supported.");
        }
    });
}

// Update input fields from latlng
function updateFullAddressUI(latlng) {
        geocoder.geocode({ location: latlng }, function (results, status) {

            if (status !== "OK" || !results.length) {
                showLocationError("Address not found");
                return;
            }

            let line1 = "", line2 = "", city = "", state = "", country = "", zip = "";

            results.forEach(res => {
                res.address_components.forEach(comp => {

                    if (!line1 && (
                        comp.types.includes("point_of_interest") ||
                        comp.types.includes("establishment") ||
                        comp.types.includes("premise")
                    )) {
                        line1 = comp.long_name;
                    }

                    if (!line2 && comp.types.includes("route")) {
                        line2 = comp.long_name;
                    }

                    // INDIA cities
                    if (!city && comp.types.includes("locality")) city = comp.long_name;

                    if (!city && comp.types.includes("administrative_area_level_2"))
                        city = comp.long_name;

                    // STATE / GOVERNORATE
                    if (!state && comp.types.includes("administrative_area_level_1"))
                        state = comp.long_name;

                    if (!zip && comp.types.includes("postal_code"))
                        zip = comp.long_name;

                    if (!country && comp.types.includes("country"))
                        country = comp.long_name;
                });
            });

            // ⭐ SPECIAL HANDLING: KUWAIT
            if (country === "Kuwait") {

                // Kuwait airport city = Governorate name
                if (state) {
                    city = state.replace(" Governorate", "");
                }

                // Guarantee no wrong subareas like "Al-Dajeej"
                if (city && city.toLowerCase().includes("dajeej")) {
                    city = "Farwaniya";
                }
            }

            // FALLBACK if line1 still empty
            if (!line1) line1 = results[0].formatted_address.split(",")[0];

            // APPLY TO UI
            document.querySelector('[name="address_line1"]').value = line1;
            document.querySelector('[name="address_line2"]').value = line2;
            document.querySelector('[name="city"]').value = city;
            document.querySelector('[name="state"]').value = state;

            document.getElementById("let").value = latlng.lat();
            document.getElementById("long").value = latlng.lng();

            document.getElementById("selectedAddress").innerText = results[0].formatted_address;

            clearAddressFieldErrors();
        });
    }

// Clears errors for address-related fields
function clearAddressFieldErrors() {
    const addressFields = [
        'address_line1_error',
        'address_line2_error',
        'city_error',
        'state_error',
        'let_error',
        'long_error'
    ];
    addressFields.forEach(id => {
        const el = document.getElementById(id);
        if(el) el.innerText = '';
    });
}


// Show / hide error span
function showLocationError(msg) {
    const errorSpan = document.getElementById('locationError');
    if (errorSpan) {
        errorSpan.innerText = msg;
        errorSpan.style.display = 'block';
    }
}

function clearLocationError() {
    const errorSpan = document.getElementById('locationError');
    if (errorSpan) {
        errorSpan.innerText = '';
        errorSpan.style.display = 'none';
    }
}

// Save button: modal close only
document.querySelector(".setup-done.button").addEventListener("click", function() {
    if (!selectedLatLng) {
        showLocationError("Please select a location first.");
        return;
    }
    clearLocationError();

    // Values already set by updateFullAddressUI
    const modalEl = document.getElementById('sentModal5');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.hide();
    }
});
</script>

<!-- reg1 validation -->

<script>


document.addEventListener("DOMContentLoaded", function() {
    const profileUpload = document.getElementById('profileUpload');
    const profilePreview = document.getElementById('profilePreview');
    const profileImageError = document.getElementById('profile_image_error');
    const profileIcon = document.getElementById('profileUploadIcon');
    const form = document.getElementById('deliveryBoyForm');

    // --- PROFILE IMAGE PREVIEW & VALIDATION ---
    profileUpload.addEventListener('change', function() {
        const file = this.files[0];
        profileImageError.innerText = '';
        profileImageError.style.display = 'none';

        if (!file) return;

        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            profileImageError.innerText = "Only JPG, JPEG, or PNG images are allowed.";
            profileImageError.style.display = 'block';
            this.value = '';
            return;
        }

        const maxSize = 4 * 1024 * 1024;
        if (file.size > maxSize) {
            profileImageError.innerText = "Image size must be less than 4MB.";
            profileImageError.style.display = 'block';
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            profilePreview.src = e.target.result;
            profilePreview.style.display = 'block';
            profileIcon.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    // --- FORM SUBMISSION ---
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Clear errors
        form.querySelectorAll('.text-danger, .text-success').forEach(span => {
            span.innerText = '';
            span.style.display = 'none';
            span.classList.remove('text-success', 'text-danger');
        });

        let hasError = false;

        // Check required fields
        const fields = [
            {name: 'full_name_english', errorId: 'full_name_en_error', message: 'Please enter full name (English)'},
            {name: 'full_name_arabic', errorId: 'full_name_ar_error', message: 'Please enter full name (Arabic)'},
            {name: 'email', errorId: 'email_error', message: 'Please enter email'},
            {name: 'mobile', errorId: 'mobile_error', message: 'Please enter mobile number'},
            {name: 'address_line1', errorId: 'address_line1_error', message: 'Please enter address line 1'},
            {name: 'address_line2', errorId: 'address_line2_error', message: 'Please enter address line 2'},
            {name: 'city', errorId: 'city_error', message: 'Please enter city'},
            {name: 'state', errorId: 'state_error', message: 'Please enter state'},
            {name: 'password', errorId: 'password_error', message: 'Please enter password'},
            {name: 'confirm_password', errorId: 'confirm_password_error', message: 'Please enter confirm password'},
            {name: 'zone_id', errorId: 'zone_error', message: 'Please select zone'}
        ];

        fields.forEach(field => {
            const input = form.querySelector(`[name="${field.name}"]`);
            if (!input.value.trim()) {
                const errorSpan = document.getElementById(field.errorId);
                errorSpan.innerText = field.message;
                errorSpan.style.display = 'block';
                errorSpan.classList.add('text-danger');
                hasError = true;
            }
        });

        // Password validation
        const password = form.querySelector('[name="password"]').value;
        const confirmPassword = form.querySelector('[name="confirm_password"]').value;
        // if (password && !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/.test(password)) {
        //     const ps = document.getElementById('password_error');
        //     ps.innerText = "Password must contain uppercase, lowercase, number, and special character.";
        //     ps.style.display = 'block';
        //     hasError = true;
        // }

        if (password.length > 0 && password.length < 6) {
            const ps = document.getElementById('password_error');
            ps.innerText = "Password should be minimum of 6 characters.";
            ps.style.display = 'block';
            hasError = true;
        }

        if (confirmPassword && confirmPassword !== password) {
            const cps = document.getElementById('confirm_password_error');
            cps.innerText = "Confirm password does not match.";
            cps.style.display = 'block';
            hasError = true;
        }

        if (hasError) return;

        const formData = new FormData(form);

        // If no new file, append existing session/DB URL
        if (profileUpload.files.length === 0) {
            const existing = form.querySelector('[name="profile_pic_existing"]').value;
            if (existing) formData.append('profile_pic', existing);
        }

        fetch('/admin/store_reg1_edit', {
            method: 'POST',
            body: formData,
            headers: {
                "X-CSRF-TOKEN": '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                // Keep preview intact
               // toastr.success(response.message);
                // Redirect to step2
                window.location.href = "{{ route('admin.edit_deliveryboy_step2') }}";
            } else if (response.errors) {
                Object.keys(response.errors).forEach(key => {
                    const errorSpan = document.getElementById(key + '_error');
                    if (errorSpan) {
                        errorSpan.innerText = response.errors[key][0];
                        errorSpan.style.display = 'block';
                        errorSpan.classList.add('text-danger');
                    }
                });
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Something went wrong. Check console for details.');
        });
    });

    // Clear errors on input/change
    form.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', () => clearError(input));
        input.addEventListener('change', () => clearError(input));
    });

    function clearError(input) {
        const err = document.getElementById(input.name + '_error');
        if (err) {
            err.innerText = '';
            err.style.display = 'none';
            err.classList.remove('text-danger', 'text-success');
        }
    }
});






</script>





















@endsection

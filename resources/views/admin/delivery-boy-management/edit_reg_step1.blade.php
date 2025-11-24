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
    background: #fff;
    box-shadow: 0px 2px 8px 0px #0000001f;
    padding: 10px;
    width: fit-content;
    border-radius: 50px;
    color: #a8824f;
    font-weight: 500;
    position: absolute;
    bottom: 20px;
    right: 20px;
    cursor: pointer;
}
.search-icon {
    position: absolute;
    left: 20px;
    top: 13px;
    font-size: 14px;
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
                            @if(isset($deliveryBoy->profile_pic) && !isset($step1Data['profile_pic']))
                                <input type="hidden" name="profile_pic_existing" value="{{ $deliveryBoy->profile_pic }}">
                            @endif
                            <!-- Profile Image -->
                            <div class="col-lg-12">
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
                                    style="right: 15px; cursor: pointer;top: 51px;"></i>
                                    <span class="text-danger" id="password_error"></span>
                                </div>

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
                                    style="right: 15px; cursor: pointer; top: 51px;"></i>
                                    <span class="text-danger" id="confirm_password_error"></span>
                                </div>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Address</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="appointment-container d-flex flex-column align-items-center">
                        <input id="searchBox" type="text" placeholder="Search your address"
                            class="form-control"
                            style="padding: 9px 18px;border-radius:4px;width: 80%;">

                        <div class="w-100 mb-3 d-flex justify-content-center">
                            <div id="map" style="width: 100%; height: 300px; border-radius: 10px; overflow: hidden;"></div>
                        </div>

                        <div class="find-location d-flex gap-3 py-4">
                            <div id="useCurrentLocation" class="use-lc">
                                <i class="bi bi-crosshair"></i> Use Current Location
                            </div>
                            <div><i class="bi bi-geo-alt-fill"></i></div>
                            <p class="mb-0" id="selectedAddress">20 Cooper Square, New Delhi, ND 110020</p>
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
    const input = document.querySelector("#phone");
    const iti = window.intlTelInput(input, {
        initialCountry: "kw",  // Set Kuwait as initial country
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        autoPlaceholder: "off"
    });

    document.querySelector("#country_code").value = "+" + iti.getSelectedCountryData().dialCode;

    input.addEventListener("countrychange", function() {
        document.querySelector("#country_code").value = "+" + iti.getSelectedCountryData().dialCode;
    });
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
    geocoder.geocode({ location: latlng }, function(results, status) {
        if (status === "OK" && results[0]) {
            const components = results[0].address_components;
            const formatted = results[0].formatted_address;

            let city = "", state = "", zip = "", country = "";

            components.forEach(comp => {
                if (comp.types.includes("locality")) city = comp.long_name;
                if (!city && comp.types.includes("administrative_area_level_2")) city = comp.long_name;
                if (comp.types.includes("administrative_area_level_1")) state = comp.long_name;
                if (comp.types.includes("postal_code")) zip = comp.long_name;
                if (comp.types.includes("country")) country = comp.long_name;
            });

            const countryAliases = [country.toLowerCase()];
            const parts = formatted.split(',').map(p => p.trim());
            const filteredParts = parts.filter(part => {
                const lower = part.toLowerCase();
                return lower !== city.toLowerCase() &&
                       lower !== state.toLowerCase() &&
                       !countryAliases.includes(lower) &&
                       !part.includes(zip);
            });

            let streetLine1 = '';
            let streetLine2 = '';

            if (filteredParts.length > 0) {
                const first = filteredParts[0];
                const match = first.match(/^([\d\/\-]+)\s+(.*)/);
                if (match) {
                    streetLine1 = match[1];
                    streetLine2 = match[2].trim();
                    const extraParts = filteredParts.slice(1).join(', ');
                    if (extraParts) streetLine2 += ', ' + extraParts;
                } else {
                    streetLine1 = first;
                    streetLine2 = filteredParts.slice(1).join(', ');
                }
            }

            // Set input values
            document.querySelector('[name="address_line1"]').value = streetLine1;
            document.querySelector('[name="address_line2"]').value = streetLine2;
            document.querySelector('[name="city"]').value = city;
            document.querySelector('[name="state"]').value = state;
            document.getElementById('let').value = latlng.lat();
            document.getElementById('long').value = latlng.lng();
            document.getElementById("selectedAddress").innerText = formatted;

            // ✅ Clear errors for these fields
            clearAddressFieldErrors();
        } else {
            showLocationError("Address not found");
        }
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
// document.addEventListener("DOMContentLoaded", function() {

//     const profileUpload = document.getElementById('profileUpload');
//     const profilePreview = document.getElementById('profilePreview');
//     const profileImageError = document.getElementById('profile_image_error');
//     const profileIcon = document.getElementById('profileUploadIcon');
//     const form = document.getElementById('deliveryBoyForm');

//     // -------------------------------
//     // PROFILE IMAGE PREVIEW & VALIDATION
//     // -------------------------------
//     profileUpload.addEventListener('change', function() {
//         const file = this.files[0];

//         // Reset previous state
//         profileImageError.innerText = '';
//         profileImageError.style.display = 'none';

//         if (!file) return;

//         // Validate file type
//         const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
//         if (!allowedTypes.includes(file.type)) {
//             profileImageError.innerText = "Only JPG, JPEG, or PNG images are allowed.";
//             profileImageError.style.display = 'block';
//             this.value = '';
//             return;
//         }

//         // Validate file size (max 4MB)
//         const maxSize = 4 * 1024 * 1024;
//         if (file.size > maxSize) {
//             profileImageError.innerText = "Image size must be less than 4MB.";
//             profileImageError.style.display = 'block';
//             this.value = '';
//             return;
//         }

//         // Show preview
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             profilePreview.src = e.target.result;
//             profilePreview.style.display = 'block';
//             profileIcon.style.display = 'none';
//         };
//         reader.readAsDataURL(file);
//     });

//     // -------------------------------
//     // FORM VALIDATION & SUBMISSION
//     // -------------------------------
//     form.addEventListener('submit', function(e) {
//         e.preventDefault();

//         // Clear previous errors
//         const errorSpans = form.querySelectorAll('.text-danger, .text-success');
//         errorSpans.forEach(span => {
//             span.innerText = '';
//             span.style.display = 'none';
//             span.classList.remove('text-success');
//         });

//         let hasError = false;

//         // Required fields
//         const fields = [
//             {name: 'profile_pic', errorId: 'profile_image_error', message: 'Please upload profile image'},
//             {name: 'full_name_english', errorId: 'full_name_en_error', message: 'Please enter full name (English)'},
//             {name: 'full_name_arabic', errorId: 'full_name_ar_error', message: 'Please enter full name (Arabic)'},
//             {name: 'email', errorId: 'email_error', message: 'Please enter email'},
//             {name: 'mobile', errorId: 'mobile_error', message: 'Please enter mobile number'},
//             {name: 'address_line1', errorId: 'address_line1_error', message: 'Please enter address line 1'},
//             {name: 'address_line2', errorId: 'address_line2_error', message: 'Please enter address line 2'},
//             {name: 'city', errorId: 'city_error', message: 'Please enter city'},
//             {name: 'state', errorId: 'state_error', message: 'Please enter state'},
//             {name: 'password', errorId: 'password_error', message: 'Please enter password'},
//             {name: 'confirm_password', errorId: 'confirm_password_error', message: 'Please confirm password'},
//             {name: 'zone_id', errorId: 'zone_error', message: 'Please select zone'}
//         ];

//         fields.forEach(field => {
//             const input = form.querySelector(`[name="${field.name}"]`);

//             if (field.name === 'profile_pic') {
//                 // If no new file, check existing hidden input or preview
//                 const existingImage = form.querySelector('input[name="profile_pic_existing"]');
//                 if (input.files.length === 0 && (!existingImage || !existingImage.value)) {
//                     const errorSpan = document.getElementById(field.errorId);
//                     errorSpan.innerText = field.message;
//                     errorSpan.classList.add('text-danger');
//                     errorSpan.style.display = 'block';
//                     hasError = true;
//                 }
//             } else if (!input.value.trim()) {
//                 const errorSpan = document.getElementById(field.errorId);
//                 errorSpan.innerText = field.message;
//                 errorSpan.classList.add('text-danger');
//                 errorSpan.style.display = 'block';
//                 hasError = true;
//             }
//         });

//         // Password validation
//         const password = form.querySelector('[name="password"]').value;
//         const confirmPassword = form.querySelector('[name="confirm_password"]').value;

//         if (password) {
//             const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
//             if (!passwordPattern.test(password)) {
//                 const ps = document.getElementById('password_error');
//                 ps.innerText = "Password must contain uppercase, lowercase, number, and special character.";
//                 ps.style.display = 'block';
//                 hasError = true;
//             }
//         }

//         if (confirmPassword && confirmPassword !== password) {
//             const cps = document.getElementById('confirm_password_error');
//             cps.innerText = "Confirm password does not match.";
//             cps.style.display = 'block';
//             hasError = true;
//         }

//         if (hasError) return;

//         const formData = new FormData(form);

//         fetch('/admin/store_reg1_edit', {
//             method: 'POST',
//             body: formData,
//             headers: {
//                 "X-CSRF-TOKEN": '{{ csrf_token() }}'
//             }
//         })
//         .then(res => res.json())
//         .then(response => {
//             if (response.success === 'success' || response.success === true) {
//                 form.reset();
//                 profilePreview.src = '';
//                 profilePreview.style.display = 'none';
//                 profileIcon.style.display = 'block';

//                 // Redirect to step2
//                 window.location.href = "{{ route('admin.edit_deliveryboy_step2') }}";
//             }

//             if (response.errors) {
//                 for (const key in response.errors) {
//                     const errorSpan = document.getElementById(key + '_error');
//                     if (errorSpan) {
//                         errorSpan.innerText = response.errors[key][0];
//                         errorSpan.style.display = 'block';
//                         errorSpan.classList.add('text-danger');
//                     }
//                 }
//             }
//         })
//         .catch(err => {
//             console.error('Error:', err);
//             alert('Something went wrong. Check console for details.');
//         });
//     });

//     // -------------------------------
//     // CLEAR ERRORS ON INPUT / CHANGE
//     // -------------------------------
//     const allInputs = form.querySelectorAll('input, select');
//     allInputs.forEach(input => {
//         input.addEventListener('input', function() {
//             const err = document.getElementById(this.name + '_error');
//             if (err) {
//                 err.innerText = '';
//                 err.style.display = 'none';
//                 err.classList.remove('text-success', 'text-danger');
//             }
//         });
//         input.addEventListener('change', function() {
//             const err = document.getElementById(this.name + '_error');
//             if (err) {
//                 err.innerText = '';
//                 err.style.display = 'none';
//                 err.classList.remove('text-success', 'text-danger');
//             }
//         });
//     });

//     // -------------------------------
//     // MOBILE & EMAIL AVAILABILITY
//     // -------------------------------
//     function checkAvailability(url, callback) {
//         fetch(url)
//         .then(res => res.json())
//         .then(callback)
//         .catch(err => console.error(err));
//     }

//     const deliveryBoyId = document.querySelector('[name="id"]').value;

//     // MOBILE
//     const mobileInput = document.querySelector('[name="mobile"]');
//     mobileInput.addEventListener('input', function() {
//         const mobileError = document.getElementById('mobile_error');
//         const value = this.value.trim();

//         if (value.length < 8 || value.length > 15) return; // skip invalid lengths

//         checkAvailability(`/admin/check-mobile-edit?value=${encodeURIComponent(value)}&id=${deliveryBoyId}`, function(data) {
//             if (data.exists) {
//                 mobileError.innerText = "This number is already registered.";
//                 mobileError.classList.remove('text-success');
//                 mobileError.classList.add('text-danger');
//             } else {
//                 mobileError.innerText = "Mobile number available.";
//                 mobileError.classList.remove('text-danger');
//                 mobileError.classList.add('text-success');
//             }
//             mobileError.style.display = 'block';
//         });
//     });

//     // EMAIL
//     const emailInput = document.querySelector('[name="email"]');
//     emailInput.addEventListener('input', function() {
//         const emailError = document.getElementById('email_error');
//         const value = this.value.trim();
//         const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

//         if (!pattern.test(value)) return;

//         checkAvailability(`/admin/check-email-edit?value=${encodeURIComponent(value)}&id=${deliveryBoyId}`, function(data) {
//             if (data.exists) {
//                 emailError.innerText = "Email already registered.";
//                 emailError.classList.remove('text-success');
//                 emailError.classList.add('text-danger');
//             } else {
//                 emailError.innerText = "Email available.";
//                 emailError.classList.remove('text-danger');
//                 emailError.classList.add('text-success');
//             }
//             emailError.style.display = 'block';
//         });
//     });

// });
// document.addEventListener("DOMContentLoaded", function() {

//     const profileUpload = document.getElementById('profileUpload');
//     const profilePreview = document.getElementById('profilePreview');
//     const profileImageError = document.getElementById('profile_image_error');
//     const profileIcon = document.getElementById('profileUploadIcon');
//     const form = document.getElementById('deliveryBoyForm');

//     // -------------------------------
//     // PROFILE IMAGE PREVIEW & VALIDATION
//     // -------------------------------
//     profileUpload.addEventListener('change', function() {
//         const file = this.files[0];

//         // Reset previous state
//         profileImageError.innerText = '';
//         profileImageError.style.display = 'none';

//         if (!file) return;

//         // Validate file type
//         const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
//         if (!allowedTypes.includes(file.type)) {
//             profileImageError.innerText = "Only JPG, JPEG, or PNG images are allowed.";
//             profileImageError.style.display = 'block';
//             this.value = '';
//             return;
//         }

//         // Validate file size (max 4MB)
//         const maxSize = 4 * 1024 * 1024;
//         if (file.size > maxSize) {
//             profileImageError.innerText = "Image size must be less than 4MB.";
//             profileImageError.style.display = 'block';
//             this.value = '';
//             return;
//         }

//         // Show preview
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             profilePreview.src = e.target.result;
//             profilePreview.style.display = 'block';
//             profileIcon.style.display = 'none';
//         };
//         reader.readAsDataURL(file);
//     });

//     // -------------------------------
//     // FORM VALIDATION & SUBMISSION
//     // -------------------------------
//     form.addEventListener('submit', function(e) {
//         e.preventDefault();

//         // Clear previous errors
//         const errorSpans = form.querySelectorAll('.text-danger, .text-success');
//         errorSpans.forEach(span => {
//             span.innerText = '';
//             span.style.display = 'none';
//             span.classList.remove('text-success');
//         });

//         let hasError = false;

//         // Required fields
//         const fields = [
//             {name: 'profile_pic', errorId: 'profile_image_error', message: 'Please upload profile image'},
//             {name: 'full_name_english', errorId: 'full_name_en_error', message: 'Please enter full name (English)'},
//             {name: 'full_name_arabic', errorId: 'full_name_ar_error', message: 'Please enter full name (Arabic)'},
//             {name: 'email', errorId: 'email_error', message: 'Please enter email'},
//             {name: 'mobile', errorId: 'mobile_error', message: 'Please enter mobile number'},
//             {name: 'address_line1', errorId: 'address_line1_error', message: 'Please enter address line 1'},
//             {name: 'address_line2', errorId: 'address_line2_error', message: 'Please enter address line 2'},
//             {name: 'city', errorId: 'city_error', message: 'Please enter city'},
//             {name: 'state', errorId: 'state_error', message: 'Please enter state'},
//             {name: 'password', errorId: 'password_error', message: 'Please enter password'},
//             {name: 'confirm_password', errorId: 'confirm_password_error', message: 'Please confirm password'},
//             {name: 'zone_id', errorId: 'zone_error', message: 'Please select zone'}
//         ];

//         fields.forEach(field => {
//             const input = form.querySelector(`[name="${field.name}"]`);

//             if (field.name === 'profile_pic') {
//                 // If no new file, check existing hidden input or preview
//                 const existingImage = form.querySelector('input[name="profile_pic_existing"]');
//                 if (input.files.length === 0 && (!existingImage || !existingImage.value)) {
//                     const errorSpan = document.getElementById(field.errorId);
//                     errorSpan.innerText = field.message;
//                     errorSpan.classList.add('text-danger');
//                     errorSpan.style.display = 'block';
//                     hasError = true;
//                 } else if (input.files.length === 0) {
//                     // If no new image and there is a preview, don't show error
//                     const previewImage = profilePreview.src;
//                     if (!previewImage || previewImage.trim() === '') {
//                         const errorSpan = document.getElementById(field.errorId);
//                         errorSpan.innerText = field.message;
//                         errorSpan.classList.add('text-danger');
//                         errorSpan.style.display = 'block';
//                         hasError = true;
//                     } else {
//                         // Add hidden input with current profile_pic value to formData if no new image
//                         if (!existingImage) {
//                             const hiddenInput = document.createElement('input');
//                             hiddenInput.type = 'hidden';
//                             hiddenInput.name = 'profile_pic_existing';
//                             hiddenInput.value = previewImage; // existing URL from session or DB
//                             form.appendChild(hiddenInput);
//                         }
//                     }
//                 }
//             } else if (!input.value.trim()) {
//                 const errorSpan = document.getElementById(field.errorId);
//                 errorSpan.innerText = field.message;
//                 errorSpan.classList.add('text-danger');
//                 errorSpan.style.display = 'block';
//                 hasError = true;
//             }
//         });

//         // Password validation
//         const password = form.querySelector('[name="password"]').value;
//         const confirmPassword = form.querySelector('[name="confirm_password"]').value;

//         if (password) {
//             const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
//             if (!passwordPattern.test(password)) {
//                 const ps = document.getElementById('password_error');
//                 ps.innerText = "Password must contain uppercase, lowercase, number, and special character.";
//                 ps.style.display = 'block';
//                 hasError = true;
//             }
//         }

//         if (confirmPassword && confirmPassword !== password) {
//             const cps = document.getElementById('confirm_password_error');
//             cps.innerText = "Confirm password does not match.";
//             cps.style.display = 'block';
//             hasError = true;
//         }

//         if (hasError) return;

//         const formData = new FormData(form);

//         fetch('/admin/store_reg1_edit', {
//             method: 'POST',
//             body: formData,
//             headers: {
//                 "X-CSRF-TOKEN": '{{ csrf_token() }}'
//             }
//         })
//         .then(res => res.json())
//         .then(response => {
//             if (response.success === 'success' || response.success === true) {
//                 form.reset();
//                 profilePreview.src = '';
//                 profilePreview.style.display = 'none';
//                 profileIcon.style.display = 'block';

//                 // Redirect to step2
//                 window.location.href = "{{ route('admin.edit_deliveryboy_step2') }}";
//             }

//             if (response.errors) {
//                 for (const key in response.errors) {
//                     const errorSpan = document.getElementById(key + '_error');
//                     if (errorSpan) {
//                         errorSpan.innerText = response.errors[key][0];
//                         errorSpan.style.display = 'block';
//                         errorSpan.classList.add('text-danger');
//                     }
//                 }
//             }
//         })
//         .catch(err => {
//             console.error('Error:', err);
//             alert('Something went wrong. Check console for details.');
//         });
//     });

//     // -------------------------------
//     // CLEAR ERRORS ON INPUT / CHANGE
//     // -------------------------------
//     const allInputs = form.querySelectorAll('input, select');
//     allInputs.forEach(input => {
//         input.addEventListener('input', function() {
//             const err = document.getElementById(this.name + '_error');
//             if (err) {
//                 err.innerText = '';
//                 err.style.display = 'none';
//                 err.classList.remove('text-success', 'text-danger');
//             }
//         });
//         input.addEventListener('change', function() {
//             const err = document.getElementById(this.name + '_error');
//             if (err) {
//                 err.innerText = '';
//                 err.style.display = 'none';
//                 err.classList.remove('text-success', 'text-danger');
//             }
//         });
//     });

//     // -------------------------------
//     // MOBILE & EMAIL AVAILABILITY
//     // -------------------------------
//     function checkAvailability(url, callback) {
//         fetch(url)
//         .then(res => res.json())
//         .then(callback)
//         .catch(err => console.error(err));
//     }

//     const deliveryBoyId = document.querySelector('[name="id"]').value;

//     // MOBILE
//     const mobileInput = document.querySelector('[name="mobile"]');
//     mobileInput.addEventListener('input', function() {
//         const mobileError = document.getElementById('mobile_error');
//         const value = this.value.trim();

//         if (value.length < 8 || value.length > 15) return; // skip invalid lengths

//         checkAvailability(`/admin/check-mobile-edit?value=${encodeURIComponent(value)}&id=${deliveryBoyId}`, function(data) {
//             if (data.exists) {
//                 mobileError.innerText = "This number is already registered.";
//                 mobileError.classList.remove('text-success');
//                 mobileError.classList.add('text-danger');
//             } else {
//                 mobileError.innerText = "Mobile number available.";
//                 mobileError.classList.remove('text-danger');
//                 mobileError.classList.add('text-success');
//             }
//             mobileError.style.display = 'block';
//         });
//     });

//     // EMAIL
//     const emailInput = document.querySelector('[name="email"]');
//     emailInput.addEventListener('input', function() {
//         const emailError = document.getElementById('email_error');
//         const value = this.value.trim();
//         const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

//         if (!pattern.test(value)) return;

//         checkAvailability(`/admin/check-email-edit?value=${encodeURIComponent(value)}&id=${deliveryBoyId}`, function(data) {
//             if (data.exists) {
//                 emailError.innerText = "Email already registered.";
//                 emailError.classList.remove('text-success');
//                 emailError.classList.add('text-danger');
//             } else {
//                 emailError.innerText = "Email available.";
//                 emailError.classList.remove('text-danger');
//                 emailError.classList.add('text-success');
//             }
//             emailError.style.display = 'block';
//         });
//     });

// });
document.addEventListener("DOMContentLoaded", function() {
    const profileUpload = document.getElementById('profileUpload');
    const profilePreview = document.getElementById('profilePreview');
    const profileImageError = document.getElementById('profile_image_error');
    const profileIcon = document.getElementById('profileUploadIcon');
    const form = document.getElementById('deliveryBoyForm');

    // -------------------------------
    // PROFILE IMAGE PREVIEW & VALIDATION
    // -------------------------------
    profileUpload.addEventListener('change', function() {
        const file = this.files[0];

        // Reset previous state
        profileImageError.innerText = '';
        profileImageError.style.display = 'none';

        if (!file) return;

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            profileImageError.innerText = "Only JPG, JPEG, or PNG images are allowed.";
            profileImageError.style.display = 'block';
            this.value = '';
            return;
        }

        // Validate file size (max 4MB)
        const maxSize = 4 * 1024 * 1024;
        if (file.size > maxSize) {
            profileImageError.innerText = "Image size must be less than 4MB.";
            profileImageError.style.display = 'block';
            this.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            profilePreview.src = e.target.result;
            profilePreview.style.display = 'block';
            profileIcon.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    // -------------------------------
    // FORM VALIDATION & SUBMISSION
    // -------------------------------
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        const errorSpans = form.querySelectorAll('.text-danger, .text-success');
        errorSpans.forEach(span => {
            span.innerText = '';
            span.style.display = 'none';
            span.classList.remove('text-success');
        });

        let hasError = false;

        // Required fields
        const fields = [
            {name: 'profile_pic', errorId: 'profile_image_error', message: 'Please upload profile image'},
            {name: 'full_name_english', errorId: 'full_name_en_error', message: 'Please enter full name (English)'},
            {name: 'full_name_arabic', errorId: 'full_name_ar_error', message: 'Please enter full name (Arabic)'},
            {name: 'email', errorId: 'email_error', message: 'Please enter email'},
            {name: 'mobile', errorId: 'mobile_error', message: 'Please enter mobile number'},
            {name: 'address_line1', errorId: 'address_line1_error', message: 'Please enter address line 1'},
            {name: 'address_line2', errorId: 'address_line2_error', message: 'Please enter address line 2'},
            {name: 'city', errorId: 'city_error', message: 'Please enter city'},
            {name: 'state', errorId: 'state_error', message: 'Please enter state'},
            {name: 'password', errorId: 'password_error', message: 'Please enter password'},
            {name: 'confirm_password', errorId: 'confirm_password_error', message: 'Please confirm password'},
            {name: 'zone_id', errorId: 'zone_error', message: 'Please select zone'}
        ];

        fields.forEach(field => {
            const input = form.querySelector(`[name="${field.name}"]`);

            if (field.name === 'profile_pic') {
                // If no new file AND no session-loaded preview, show error
                if (input.files.length === 0 && (!profilePreview.src || profilePreview.src.trim() === '')) {
                    const errorSpan = document.getElementById(field.errorId);
                    errorSpan.innerText = field.message;
                    errorSpan.classList.add('text-danger');
                    errorSpan.style.display = 'block';
                    hasError = true;
                }
            } else if (!input.value.trim()) {
                const errorSpan = document.getElementById(field.errorId);
                errorSpan.innerText = field.message;
                errorSpan.classList.add('text-danger');
                errorSpan.style.display = 'block';
                hasError = true;
            }
        });

        // Password validation
        const password = form.querySelector('[name="password"]').value;
        const confirmPassword = form.querySelector('[name="confirm_password"]').value;

        if (password) {
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
            if (!passwordPattern.test(password)) {
                const ps = document.getElementById('password_error');
                ps.innerText = "Password must contain uppercase, lowercase, number, and special character.";
                ps.style.display = 'block';
                hasError = true;
            }
        }

        if (confirmPassword && confirmPassword !== password) {
            const cps = document.getElementById('confirm_password_error');
            cps.innerText = "Confirm password does not match.";
            cps.style.display = 'block';
            hasError = true;
        }

        if (hasError) return;

        const formData = new FormData(form);

        fetch('/admin/store_reg1_edit', {
            method: 'POST',
            body: formData,
            headers: {
                "X-CSRF-TOKEN": '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(response => {
            if (response.success === 'success' || response.success === true) {
                form.reset();
                profilePreview.src = '';
                profilePreview.style.display = 'none';
                profileIcon.style.display = 'block';

                // Redirect to step2
                window.location.href = "{{ route('admin.edit_deliveryboy_step2') }}";
            }

            if (response.errors) {
                for (const key in response.errors) {
                    const errorSpan = document.getElementById(key + '_error');
                    if (errorSpan) {
                        errorSpan.innerText = response.errors[key][0];
                        errorSpan.style.display = 'block';
                        errorSpan.classList.add('text-danger');
                    }
                }
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Something went wrong. Check console for details.');
        });
    });

    // -------------------------------
    // CLEAR ERRORS ON INPUT / CHANGE
    // -------------------------------
    const allInputs = form.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('input', function() {
            const err = document.getElementById(this.name + '_error');
            if (err) {
                err.innerText = '';
                err.style.display = 'none';
                err.classList.remove('text-success', 'text-danger');
            }
        });
        input.addEventListener('change', function() {
            const err = document.getElementById(this.name + '_error');
            if (err) {
                err.innerText = '';
                err.style.display = 'none';
                err.classList.remove('text-success', 'text-danger');
            }
        });
    });

    // -------------------------------
    // MOBILE & EMAIL AVAILABILITY
    // -------------------------------
    function checkAvailability(url, callback) {
        fetch(url)
        .then(res => res.json())
        .then(callback)
        .catch(err => console.error(err));
    }

    const deliveryBoyId = document.querySelector('[name="id"]').value;

    // MOBILE
    const mobileInput = document.querySelector('[name="mobile"]');
    mobileInput.addEventListener('input', function() {
        const mobileError = document.getElementById('mobile_error');
        const value = this.value.trim();

        if (value.length < 8 || value.length > 15) return; // skip invalid lengths

        checkAvailability(`/admin/check-mobile-edit?value=${encodeURIComponent(value)}&id=${deliveryBoyId}`, function(data) {
            if (data.exists) {
                mobileError.innerText = "This number is already registered.";
                mobileError.classList.remove('text-success');
                mobileError.classList.add('text-danger');
            } else {
                mobileError.innerText = "Mobile number available.";
                mobileError.classList.remove('text-danger');
                mobileError.classList.add('text-success');
            }
            mobileError.style.display = 'block';
        });
    });

    // EMAIL
    const emailInput = document.querySelector('[name="email"]');
    emailInput.addEventListener('input', function() {
        const emailError = document.getElementById('email_error');
        const value = this.value.trim();
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!pattern.test(value)) return;

        checkAvailability(`/admin/check-email-edit?value=${encodeURIComponent(value)}&id=${deliveryBoyId}`, function(data) {
            if (data.exists) {
                emailError.innerText = "Email already registered.";
                emailError.classList.remove('text-success');
                emailError.classList.add('text-danger');
            } else {
                emailError.innerText = "Email available.";
                emailError.classList.remove('text-danger');
                emailError.classList.add('text-success');
            }
            emailError.style.display = 'block';
        });
    });
});






</script>





















@endsection

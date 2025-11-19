@extends('admin.layout.app')
@section('content')
<style>
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
    <div class="d-flex flex-column align-items-start back-btn-box">

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">Edit Delivery Boy</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <div class="row">
                          <div class="col-lg-12">
                            <div class="upload-title text-center">
                                Upload Profile Image
                            </div>

                            <div class="upload-new text-center">
                                <label for="profileUpload" class="upload-box">
                                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                        id="profileUploadIcon" class="upload-icon" />
                                    <div class="upload-text">Upload Profile Image</div>
                                    <input type="file" id="profileUpload" hidden accept="image/*" />
                                    <img id="profilePreview" class="preview-image" />
                                </label>
                            </div>
                        </div>
                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <!-- First Name -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Full Name</label>
                                    <span class="text-muted" style="font-size: 12px;">In English</span>
                                </div>

                                <input type="text"  placeholder="Enter Full Name" class="form-control mt-1" />
                            </div>

                            <!-- Email -->
                            <div class="mt-3">
                                <label>Email-id</label>
                                <input type="email" placeholder="Enter Email-Id"class="form-control" />
                            </div>
                            <div class="mt-3">

                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Address line 01</label>

                                </div>

                                <div class="position-relative mt-1">
                                    <input type="text" class="form-control" placeholder="Enter Address Line 01" />

                                    <i class="bi bi-crosshair"   data-bs-toggle="modal"
                                    data-bs-target="#sentModal5"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor:pointer;">
                                    </i>
                                </div>

                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">City</label>
                                </div>

                                <input type="text" placeholder="Enter City" class="form-control mt-1" />
                            </div>

                            <!-- Password -->
                            <div class="mt-3 position-relative">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control"
                                    placeholder="Enter password" />
                                <i class="fas fa-eye toggle-password position-absolute" toggle="#password"
                                    style="right: 15px;  cursor: pointer;"></i>
                            </div>

                            <!-- Select Role -->
                            <div class="mt-3">
                                <label>Select ZOne</label>
                                <select class="form-select">
                                    <option>select</option>
                                    <option value="1">Zone 1</option>
                                    <option value="2">Zone 2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Last Name -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Full Name</label>
                                    <span class="text-muted" style="font-size: 12px;">In Arabic</span>
                                </div>

                                <input type="text" placeholder="Enter Full Name" class="form-control mt-1" />
                            </div>

                            <!-- Mobile -->
                   <div class="mt-3 position-relative mobile-field">
                                <label>Mobile Number</label>
                                <input id="phone" type="tel" class="form-control"  placeholder=''/>
                                <input type="hidden" id="country_code" />
                            </div>


                            <div class="mt-3">

                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Address line 02</label>

                                </div>

                                <div class="position-relative mt-1">
                                    <input type="text" class="form-control"  placeholder="Enter Address Line 02" />

                                    
                                </div>

                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">State</label>
                                </div>

                                <input type="text"   placeholder="Enter State" class="form-control mt-1" />
                            </div>
                            <!-- Confirm Password -->
                            <div class="mt-3 position-relative">
                                <label>Confirm Password</label>
                                <input type="password" id="confirmPassword" class="form-control"
                                    placeholder="Enter password" />
                                <i class="fas fa-eye toggle-password position-absolute" toggle="#confirmPassword"
                                    style="right: 15px;  cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 mt-4 ">
                <a href="{{route('admin.edit_deliveryboy_step2')}}" class="btn btn-dark customBtn">Next</a>

            </div>
        </div>
    </div>
</div>


<!-- adreess model -->
<div class="modal fade" id="sentModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Address</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

             <div class="text-center mb-4">

  

    <div class="appointment-container d-flex flex-wrap justify-content-center">
      
<div id="map"></div>
  <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 mt-4 ">
                <button  class="btn btn-dark customBtn">Save</button>

            </div>
    </div>

</div>
   <script>
                const fileInput = document.getElementById("fileUpload");
                const previewImage = document.getElementById("previewImage");
                const uploadIcon = document.getElementById("uploadIcon");

                fileInput.addEventListener("change", function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewImage.style.display = "block";
                            uploadIcon.style.display = "none";
                        };
                        reader.readAsDataURL(file);
                    }
                });
                </script>

                <script>
                function preview(inputId, previewId, iconId) {
                    document.getElementById(inputId).addEventListener("change", function() {
                        const file = this.files[0];
                        if (file) {
                            document.getElementById(iconId).style.display = "none";
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById(previewId).src = e.target.result;
                                document.getElementById(previewId).style.display = "block";
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // PROFILE IMAGE PREVIEW CALL
                preview("profileUpload", "profilePreview", "profileUploadIcon");
                </script>

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
                <script>
                const input = document.querySelector("#phone");

                const iti = window.intlTelInput(input, {
                    initialCountry: "us",
                    separateDialCode: true,
                    preferredCountries: ["in", "us", "gb", "ae"],
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                     autoPlaceholder: "off"
                });

                input.addEventListener("countrychange", function() {
                    document.querySelector("#country_code").value = iti.getSelectedCountryData().dialCode;
                });
                </script>

                <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>

                <script>
                let map, marker;

                function initMap() {
                    const defaultLocation = {
                        lat: 28.6139,
                        lng: 77.209
                    }; // Delhi

                    map = new google.maps.Map(document.getElementById("map"), {
                        center: defaultLocation,
                        zoom: 11,
                    });

                    marker = new google.maps.Marker({
                        position: defaultLocation,
                        map,
                        draggable: true,
                    });

                    const input = document.createElement("input");
                    input.id = "pac-input";
                    input.type = "text";
                    input.placeholder = "Search Box...";
                    map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

                    const searchBox = new google.maps.places.SearchBox(input);

                    map.addListener("bounds_changed", () => {
                        searchBox.setBounds(map.getBounds());
                    });

                    searchBox.addListener("places_changed", () => {
                        const places = searchBox.getPlaces();
                        if (places.length === 0) return;

                        const place = places[0];
                        if (!place.geometry || !place.geometry.location) return;

                        map.setCenter(place.geometry.location);
                        map.setZoom(13);
                        marker.setPosition(place.geometry.location);
                    });
                }

                window.onload = initMap;
                </script>



@endsection
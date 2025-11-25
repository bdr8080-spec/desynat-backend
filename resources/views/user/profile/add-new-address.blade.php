@extends('user.layout.app')

@section('content')

<div class="my-profile customContainer">
    <div class="d-flex align-items-center mt-3 justify-content-between">
        <a href="{{route('user.view_address')}}"><i class="fa-solid fa-chevron-left"></i> Add New Address</a>
    </div>

        <form id="saveAddress">
            <div class="row mt-5">
    
            @csrf
            <input type="hidden" name="id" value="{{request()->id}}">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control notapplyspace" placeholder="Faizan Ansari" value="{{@$address->name}}" />
                    <span class="text-danger" id="error-name"></span>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Mobile No.</label>
                    <input type="hidden" value="+964" name="country_code">
                    <input type="text" name="mobile" class="form-control notapplyspace" placeholder="Enter Mobile No." value="{{@$address->mobile}}" />
                    <span class="text-danger" id="error-mobile"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group position-relative">
                    <label for="">Address</label>
                    <input type="text" id="full_address" name="address" class="form-control notapplyspace" placeholder="Enter Address" value="{{@$address->address}}" />
                    <a class="track" data-bs-toggle="modal" data-bs-target="#locationModal">
                        <i class="bi bi-crosshair"></i>
                    </a>
                    <span class="text-danger" id="error-address"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">House no./Building no/Area</label>
                    <input type="text" name="house_no" class="form-control notapplyspace" placeholder="Enter House no./Building no/Area" value="{{@$address->house_no}}" />
                    <span class="text-danger" id="error-house_no"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Block/Street</label>
                    <input type="text" id="block" name="street_no" class="form-control notapplyspace" placeholder="Enter Block/Street" value="{{@$address->street_no}}" />
                    <span class="text-danger" id="error-street_no"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Postal Code (optional)</label>
                    <input type="text" id="pincode" name="postal_code" class="form-control notapplyspace" placeholder="Enter Postal Code" value="{{@$address->postal_code}}" />
                    <span class="text-danger" id="error-postal_code"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">City/District</label>
                    <input type="text" id="city" name="city" class="form-control notapplyspace" placeholder="Enter City/District" value="{{@$address->city}}" />
                    <span class="text-danger" id="error-city"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">State</label>
                    <input type="text" id="state" name="state" class="form-control notapplyspace" placeholder="Enter State" value="{{@$address->state}}"/>
                    <span class="text-danger" id="error-state"></span>
                </div>
            </div>

            {{-- <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Landmark (optional)</label>
                    <input type="text" name="landmark" class="form-control notapplyspace" placeholder="Enter Landmark" />
                    <span class="text-danger" id="error-landmark"></span>
                </div>
            </div> --}}

            <div class="col-lg-12 mt-3">
                <div class="form-group">
                    <label for="">Save Address As</label>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group address-tab position-relative {{ (isset($address) && $address->save_address_as == 1) ? 'active' : '' }}">
                    <input type="radio" name="save_address_as" value="1" class="form-control notapplyspace" style="background: transparent;"  {{ (isset($address) && $address->save_address_as == 1) ? 'checked' : '' }} />
                    <span><i class="bi bi-house"></i> Home</span>
                    <span class="text-danger" id="error-save_address_as"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group address-tab position-relative  {{ (isset($address) && $address->save_address_as == 0) ? 'active' : '' }}">
                    <input type="radio" name="save_address_as" value="0" class="form-control notapplyspace" style="background: transparent;"  {{ (isset($address) && $address->save_address_as == 1) ? 'checked' : '' }}/>
                    <span><i class="bi bi-building"></i> Office</span>
                </div>
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="col-lg-12">
                <button class="customBtn w-100 mt-4">Add Address</button>
            </div>
        </div>
    </form>
</div>

  
<!-- MODAL -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="locationModalLabel">Change Location</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Search Box -->
                <div class="form-group position-relative search mb-3">
                    <input type="text" id="searchAddressInput" class="form-control notapplyspace" placeholder="Search address">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <!-- Map -->
                <div id="modalMap" style="height: 300px; width: 100%; border-radius: 6px;"></div>

                <!-- Selected Address -->
                <div class="mt-3">
                    <h5>Location</h5>
                    <p id="selectedLocationText" class="text-dark">Select a location…</p>
                </div>

                <button type="button" id="applyLocationBtn" class="customBtn mt-2 btn-close" data-bs-dismiss="modal">
                   save
                </button>

                <!-- Hidden Fields -->
                <input type="hidden" id="full_address">
                <input type="hidden" id="latitude">
                <input type="hidden" id="longitude">
                <input type="hidden" id="city">
                <input type="hidden" id="state">
                <input type="hidden" id="country">
                <input type="hidden" id="pincode">

            </div>
        </div>
    </div>
</div>



<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&libraries=places"></script>


<script>
let map, marker, autocomplete;

// Initialize map inside modal ONLY
function initMap() {
    const defaultLocation = { lat: 28.6139, lng: 77.2090 };

    map = new google.maps.Map(document.getElementById("modalMap"), {
        center: defaultLocation,
        zoom: 13,
    });

    marker = new google.maps.Marker({
        map: map,
        position: defaultLocation,
        draggable: true
    });

    // AUTOCOMPLETE
    const input = document.getElementById("searchAddressInput");
    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        map.setZoom(16);
        marker.setPosition(place.geometry.location);

        fillFields(place);
    });

    // DRAG MARKER
    google.maps.event.addListener(marker, "dragend", function () {
        const pos = marker.getPosition();
        reverseGeocode(pos.lat(), pos.lng());
    });
}


function fillFields(place) {

    $("#full_address").val(place.formatted_address);
    $("#latitude").val(place.geometry.location.lat());
    $("#longitude").val(place.geometry.location.lng());
    $("#selectedLocationText").text(place.formatted_address);

    let street_no = "",
        street_name = "",
        block = "",
        city = "",
        state = "",
        country = "",
        pincode = "";

    place.address_components.forEach(c => {
        if (c.types.includes("street_number")) street_no = c.long_name;
        if (c.types.includes("route")) street_name = c.long_name;

        // Block/Sector/Area
        if (c.types.includes("sublocality") || c.types.includes("sublocality_level_1")) {
            block = c.long_name;
        }

        if (c.types.includes("locality")) city = c.long_name;
        if (c.types.includes("administrative_area_level_1")) state = c.long_name;
        if (c.types.includes("country")) country = c.long_name;
        if (c.types.includes("postal_code")) pincode = c.long_name;
    });


    $("#block").val(block?? street_no);
    $("#city").val(city);
    $("#state").val(state);
    $("#country").val(country);
    $("#pincode").val(pincode);
}


// Reverse geocode
function reverseGeocode(lat, lng) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ location: { lat, lng } }, function (results, status) {
        if (status === "OK" && results[0]) {
            fillFields(results[0]);
        }
    });
}

// Load map when modal opens
$('#locationModal').on('shown.bs.modal', function () {
    setTimeout(() => { initMap(); }, 300);
});

// Apply location
$("#applyLocationBtn").click(function () {
    if ($("#full_address").val() == "") {
        alert("Please select a location.");
        return;
    }

    $("#locationModal").modal('hide');
});
</script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



        <script>

        $(document).on('submit', '#saveAddress', function (e) {
            e.preventDefault();
            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('user.save_address') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                             toastr.success(resp.message);
                        setTimeout(() => {
                             location.href = "{{route('user.view_address')}}";
                        }, 1000);
                    }

                    if(resp.status == false){
                        for (const key in resp.errors) {
                            console.log(resp.errors[key])
                            $(`#error-${key}`).html(resp.errors[key]);
                        }   
                    }

                },
                error: function (xhr) {
                   toastr.error(xhr.responseJSON.message);
                },
                complete: function () {
                   $('#loginButtom').prop('disabled', false);
                }
            });
        });


    </script>
    <script>
        $(document).ready(function () {
            $(".address-tab").click(function () {
                $(".address-tab").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>

@endsection
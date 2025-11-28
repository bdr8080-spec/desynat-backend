@extends('user.layout.app')

@section('content')

<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}

</style>

<div class="my-profile customContainer">
    <div class="my-profie-nav d-flex align-items-center mt-3 justify-content-between">
        <a class="text-black" href="{{route('user.view_address')}}"><i class="fa-solid fa-chevron-left"></i> Add New Address</a>
    </div>

        <form id="saveAddress">
            <div class="row mt-5">
    
            @csrf
            <input type="hidden" name="id" value="{{request()->id}}">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control notapplyspace" placeholder="Enter Name" value="{{@$address->name}}" />
                    <span class="text-danger" id="error-name"></span>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Mobile No.</label>

                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <div class="dropdown">
                                <button class="btn btn-light border dropdown-toggle d-flex align-items-center"
                                    type="button" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    
                                    <span id="selected-flag">
                                       @php
                                            $selectedCode = $address->country_code 
                                                            ?? old('country_code') 
                                                            ?? $country[0]->dial_code;

                                            $selectedItem = $country->firstWhere('dial_code', $selectedCode);
                                        @endphp

                                        <img src="{{ $selectedItem->flag }}" alt="flag" width="25" height="16">
                                    </span>

                                    <span id="selected-code" class="ms-2">{{ $selectedItem->dial_code }}</span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="countryDropdown" style="max-height: 250px; overflow-y: auto;">
                                    @foreach ($country as $item)
                                        <li>
                                            <label class="dropdown-item d-flex align-items-center gap-2 country-option" style="cursor: pointer;">
                                                
                                                <input type="radio"
                                                    name="country_code"
                                                    value="{{ $item->dial_code }}"
                                                    data-flag="{{ $item->flag }}"
                                                    class="country-radio"
                                                    {{ $selectedCode == $item->dial_code ? 'checked' : '' }}
                                                    hidden>

                                                <img src="{{ $item->flag }}" alt="Flag of {{ $item->name }}" width="25" height="16">
                                                <span>{{ $item->dial_code }} ({{ $item->name }})</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                
                        </div>

                    
                        <div class="w-100">
                            <input 
                                type="number" 
                                class="form-control"
                                placeholder="Enter Mobile Number"
                                name="mobile"
                                value="{{ old('mobile', $address->mobile ?? '') }}"
                                oninput="this.value = this.value.slice(0, 15);"
                                minlength="7"
                                maxlength="15"
                            >

                        

                                <span class="text-danger" id="error-mobile"></span>
                        </div>

                    </div>

                </div>
            </div>

           

            <div class="col-lg-6 mt-3">
                <div class="form-group position-relative">
                    <label for="">Address</label>
                    <input type="text" id="full_address" name="address" class="form-control notapplyspace" placeholder="Enter Address" value="{{@$address->address}}" />
                    <a class="saved_track_address" data-bs-toggle="modal" data-bs-target="#locationModal">
                        <i class="bi bi-crosshair"></i>
                    </a>
                    <span class="text-danger" id="error-address"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">House no./Building no/Area</label>
                    <input type="text" id="block" name="house_no" class="form-control notapplyspace" placeholder="Enter House no./Building no/Area" value="{{@$address->house_no}}" />
                    <span class="text-danger" id="error-house_no"></span>
                </div>
            </div>

            {{-- <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Block/Street</label>
                    <input type="text" id="block" name="street_no" class="form-control notapplyspace" placeholder="Enter Block/Street" value="{{@$address->street_no}}" />
                    <span class="text-danger" id="error-street_no"></span>
                </div>
            </div> --}}

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

            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Country</label>
                    <input type="text" id="country" class="form-control notapplyspace" value="{{$address->country_name}}" placeholder="Enter Country Name" name="country_name" />
                    <span class="text-danger" id="error-country_name"></span>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="form-group">
                    <label for="">Save Address As</label>
                </div>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group address-tab position-relative {{ (isset($address) && $address->save_address_as == 1) ? 'active' : '' }}">
                    <input type="radio" name="save_address_as" value="1" class="form-control notapplyspace" style="background: transparent;"  {{ (isset($address) && $address->save_address_as == 1) ? 'checked' : '' }} />
                    <span class="selectAddress_"><i class="bi bi-house"></i> Home</span>
                </div>
                <span class="text-danger" id="error-save_address_as"></span>
            </div>

            <div class="col-lg-6 mt-3">
                <div class="form-group address-tab position-relative  {{ (isset($address) && $address->save_address_as == 0) ? 'active' : '' }}">
                    <input type="radio" name="save_address_as" value="0" class="form-control notapplyspace" style="background: transparent;"  {{ (isset($address) && $address->save_address_as == 1) ? 'checked' : '' }}/>
                    <span class="selectAddress_"><i class="bi bi-building"></i> Office</span>
                </div>
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="col-lg-12">
                <button class="customBtn w-100 mt-4 mb-45">Add Address</button>
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
                    <h5 id="currentLocation">Current Location</h5>
                    <p id="selectedLocationText" class="text-dark">Select a location…</p>
                </div>

                <button type="button" id="applyLocationBtn" class="customBtn mt-2" data-bs-dismiss="modal">
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

function initMap() {
    const defaultLocation = { lat: 28.6139, lng: 77.2090 };

    map = new google.maps.Map(document.getElementById("modalMap"), {
        center: defaultLocation,
        zoom: 13
    });

    marker = new google.maps.Marker({
        map: map,
        position: defaultLocation,
        draggable: true
    });

    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("searchAddressInput")
    );
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        map.setZoom(16);
        marker.setPosition(place.geometry.location);

        fillFields(place);
    });

    google.maps.event.addListener(marker, "dragend", function () {
        const pos = marker.getPosition();
        reverseGeocode(pos.lat(), pos.lng());
    });
}

function fillFields(place) {
    $("#latitude").val(place.geometry.location.lat());
    $("#longitude").val(place.geometry.location.lng());
    $("#selectedLocationText").text(place.formatted_address);
    $("#searchAddressInput").val(place.formatted_address);

    let components = place.address_components;

    let city = "",
        state = "",
        country = "",
        pincode = "";

    components.forEach(c => {
        if (c.types.includes("locality")) city = c.long_name;
        if (c.types.includes("administrative_area_level_1")) state = c.long_name;
        if (c.types.includes("country")) country = c.long_name;
        if (c.types.includes("postal_code")) pincode = c.long_name;
    });

    let cleanFullAddress = components
        .filter(c =>
            !c.types.includes("locality") &&
            !c.types.includes("administrative_area_level_1") &&
            !c.types.includes("administrative_area_level_2") &&
            !c.types.includes("country") &&
            !c.types.includes("postal_code")
        )
        .map(c => c.long_name)
        .join(", ");
        let parts = cleanFullAddress.split(",");
        let full_address = parts.slice(0, 2).join(", ").trim();
        let block = parts.slice(2, 5).join(", ").trim();

    $("#full_address").val(full_address);
    $("#block").val(block);
    $("#city").val(city);
    $("#state").val(state);
    $("#country").val(country);
    $("#pincode").val(pincode);
}

function reverseGeocode(lat, lng) {
    const geocoder = new google.maps.Geocoder();

    geocoder.geocode({ location: { lat, lng } }, function (results, status) {
        if (status === "OK" && results[0]) {
            fillFields(results[0]);
        }
    });
}

$('#locationModal').on('shown.bs.modal', function () {
    setTimeout(() => initMap(), 300);
});

$("#applyLocationBtn").click(function () {
    if ($("#full_address").val() === "") {
        alert("Please select a location.");
        return;
    }
    $("#locationModal").modal('hide');
});

$("#currentLocation").click(function () {
    if (!navigator.geolocation) {
        alert("Geolocation not supported.");
        return;
    }

    navigator.geolocation.getCurrentPosition(function (pos) {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        const position = { lat, lng };

        map.setCenter(position);
        map.setZoom(16);
        marker.setPosition(position);

        reverseGeocode(lat, lng);
    });
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

        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('.country-radio');
            const selectedFlag = document.getElementById('selected-flag');
            const selectedCode = document.getElementById('selected-code');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const parent = this.closest('label');
                    const flagImg = parent.querySelector('img').src;
                    const dialCode = this.value;

                    selectedFlag.innerHTML = `<img src="${flagImg}" width="25" height="16">`;
                    selectedCode.textContent = dialCode;
                });
            });
        });

    </script>

@endsection
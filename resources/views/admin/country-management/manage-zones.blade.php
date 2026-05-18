@extends('admin.layout.app')
@section('content')
<style>
    .pac-container {
  z-index: 2000 !important; 
}
</style>


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{ route('manageCities', ['id' => $country->id]) }}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">{{ __('admin_messages.manage_zones') }}(@if(app()->getLocale() == 'en'){{$country->name}}@else{{$country->name_ar}}@endif->@if(app()->getLocale() == 'en'){{$city->name}}@else{{$city->name_ar}}@endif)</h6> 
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>{{ __('admin_messages.add_zone') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="mt-4">
                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                    <th scope="col">{{ __('admin_messages.zone_name_english') }}</th>
                                    <th scope="col">{{ __('admin_messages.zone_name_arabic') }}</th>
                                    <th scope="col">{{ __('admin_messages.view_on_map') }}</th>
                                    <th scope="col">{{ __('admin_messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($zones as $index => $zone)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $zone->name_english }}</td>
                                        <td>{{ $zone->name_arabic }}</td>
                                        <td>
                                            <a class="viewZoneBtn" type="button" data-bs-toggle="modal" data-bs-target="#sentModal3"
                                                data-name-english="{{ $zone->name_english }}"
                                                data-name-arabic="{{ $zone->name_arabic }}"
                                                data-coordinates='@json($zone->coordinates)'>
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <a href="javascript:void(0);" 
                                                    class="editZoneBtn text-primary"
                                                    data-zone-id="{{ $zone->id }}"
                                                    data-name-english="{{ $zone->name_english }}"
                                                    data-name-arabic="{{ $zone->name_arabic }}"
                                                    data-coordinates='@json($zone->coordinates)'>
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <a href="javascript:void(0);" class="table-button text-danger deleteZone mb-1 mt-1"
                                                    data-id="{{ $zone->id }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggleStatus" type="checkbox"
                                                        role="switch" id="switch{{ $zone->id }}" data-id="{{ $zone->id }}"
                                                        {{ $zone->status == 1 ? 'checked' : '' }} />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add modal -->

<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">{{ __('admin_messages.add_zone') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="addressSearch" class="form-control" placeholder="Search for an address">
                </div>

                <div id="map" style="height: 400px; width: 100%;"></div>
                <span id="error_zone_coordinates" style="color: red; font-size: 14px;"></span>

                <div class="row mt-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('admin_messages.zone_name_english') }}</label>
                        <input type="text" id="zone_name_en" placeholder="{{ __('admin_messages.enter_zone_name_in_english') }}" oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" class="form-control" />
                        <div class="text-danger mt-1" id="error_zone_name_en"></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('admin_messages.zone_name_arabic') }}</label>
                        <input type="text" id="zone_name_ar" placeholder="{{ __('admin_messages.enter_zone_name_in_arabic') }}" oninput="this.value=this.value.replace(/[^\u0600-\u06FF0-9 ]/g,'').replace(/^\s+/,'')" class="form-control" />
                        <div class="text-danger mt-1" id="error_zone_name_ar"></div>
                    </div>
                </div>

                <input type="hidden" id="zoneCoordinates" name="coordinates" />
                <input type="hidden" id="country_id" value="{{ $country->id }}">
                <input type="hidden" id="city_id" value="{{ $city->id }}">

                <div class="mt-3 text-center">
                    <button class="btn btn-dark customBtn" id="submitZone">{{ __('admin_messages.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- edit modal -->

<div class="modal fade" id="updateZoneModal" tabindex="-1" aria-labelledby="updateZoneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="updateZoneModalLabel">{{ __('admin_messages.update_zone') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="updateAddressSearch" class="form-control" placeholder="Search address...">
                </div>

                <div id="updateMap" style="height: 400px; width: 100%;"></div>
                <span id="update_error_zone_coordinates" style="color: red; font-size: 14px;"></span>

                <div class="row mt-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('admin_messages.zone_name_english') }}</label>
                        <input type="text" id="update_zone_name_en" placeholder="{{ __('admin_messages.enter_zone_name_in_english') }}" oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" class="form-control" />
                        <div class="text-danger mt-1" id="update_error_zone_name_en"></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('admin_messages.zone_name_arabic') }}</label>
                        <input type="text" id="update_zone_name_ar" placeholder="{{ __('admin_messages.enter_zone_name_in_arabic') }}" oninput="this.value=this.value.replace(/[^\u0600-\u06FF0-9 ]/g,'').replace(/^\s+/,'')" class="form-control" />
                        <div class="text-danger mt-1" id="update_error_zone_name_ar"></div>
                    </div>
                </div>

                <input type="hidden" id="update_zoneCoordinates" name="coordinates" />
                <input type="hidden" id="country_id" value="{{ $country->id }}">
                <input type="hidden" id="city_id" value="{{ $city->id }}">
                <input type="hidden" id="update_zone_id" />

                <div class="mt-3 text-center">
                    <button class="btn btn-dark customBtn" id="updateSubmitZone">{{ __('admin_messages.update') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- View Modal -->
<div class="modal fade" id="sentModal3" tabindex="-1" aria-labelledby="sentModal3Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sentModal3Label">Zone Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>{{ __('admin_messages.zone_name_english') }}:</strong> <span id="view_zone_name_en"></span></p>
                <p><strong>{{ __('admin_messages.zone_name_arabic') }}:</strong> <span id="view_zone_name_ar"></span></p>
                <div id="viewMap" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>




@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&libraries=places,drawing"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&libraries=places,drawing&language={{ app()->getLocale() }}"></script>



<script>
    let mapLocale = "{{ app()->getLocale() }}";
</script>

<!-- view zone -->
<script>
    let viewMap, viewPolygon;
    function loadGoogleMapsForView(callback) {
        if (typeof google !== 'undefined' && google.maps) {
            callback();
            return;
        }

        const script = document.createElement('script');
        // script.src = "https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}";
        script.src = "https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&language={{ app()->getLocale() }}";
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);

        script.onload = callback;
    }

    function initViewMap(zoneNameEn, zoneNameAr, coordinates) {
        $('#view_zone_name_en').text(zoneNameEn);
        $('#view_zone_name_ar').text(zoneNameAr);

        if (viewPolygon) {
            viewPolygon.setMap(null);
            viewPolygon = null;
        }

        const defaultLocation = coordinates.length > 0
            ? { lat: parseFloat(coordinates[0].lat), lng: parseFloat(coordinates[0].lng) }
            : { lat: 0, lng: 0 };

        viewMap = new google.maps.Map(document.getElementById('viewMap'), {
            center: defaultLocation,
            zoom: 13,
        });

        if (coordinates.length > 0) {
            const path = coordinates.map(coord => ({
                lat: parseFloat(coord.lat),
                lng: parseFloat(coord.lng)
            }));

            viewPolygon = new google.maps.Polygon({
                paths: path,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: viewMap,
                editable: false, 
                draggable: false
            });

            const bounds = new google.maps.LatLngBounds();
            path.forEach(p => bounds.extend(p));
            viewMap.fitBounds(bounds);
        }
    }

    $(document).on('click', '.viewZoneBtn', function () {
        const zoneNameEn = $(this).data('name-english') || '';
        const zoneNameAr = $(this).data('name-arabic') || '';
        const coordinates = $(this).data('coordinates') || [];

        $('#sentModal3').modal('show');

        // Load map
        loadGoogleMapsForView(() => {
            setTimeout(() => {
                initViewMap(zoneNameEn, zoneNameAr, coordinates);
            }, 300); 
        });
    });

    $('#sentModal3').on('shown.bs.modal', function () {
        if (viewMap) {
            google.maps.event.trigger(viewMap, 'resize');
            if (viewPolygon) {
                const bounds = new google.maps.LatLngBounds();
                viewPolygon.getPath().forEach(c => bounds.extend(c));
                viewMap.fitBounds(bounds);
            }
        }
    });
</script>

<!-- add and update zone -->
<script>

    let map, polygon, drawingManager, autocomplete, geocoder;
    let cityName = "{{ $city->name }}";

    function initAddMap() {
        geocoder = new google.maps.Geocoder();

        geocoder.geocode({ address: cityName }, (results, status) => {
            if (status !== "OK") {
                console.error("Geocode failed:", status);
                return;
            }

            const defaultLocation = results[0].geometry.location;

            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 13,
            });

            const input = document.getElementById('addressSearch');
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            google.maps.event.addDomListener(input, 'keydown', e => {
                if (e.key === 'Enter') e.preventDefault();
            });

            // move the autocomplete dropdown inside the modal
            setTimeout(() => {
                const pacContainer = document.querySelector('.pac-container');
                if (pacContainer) {
                    document.getElementById('sentModal2').appendChild(pacContainer);
                    pacContainer.style.zIndex = '2000';
                }
            }, 500);

            // when user selects a place from search
            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;

                map.setCenter(place.geometry.location);
                map.setZoom(14);

                // ✅ create polygon that covers the full place viewport
                createAddPolygonFromPlaceViewport(place);
            });

            // allow manual polygon drawing
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon']
                },
                polygonOptions: { editable: true, draggable: false }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
                if (polygon) polygon.setMap(null);
                polygon = event.overlay;
                updateAddZoneCoords(polygon);

                polygon.getPath().addListener('set_at', () => updateAddZoneCoords(polygon));
                polygon.getPath().addListener('insert_at', () => updateAddZoneCoords(polygon));
                polygon.getPath().addListener('remove_at', () => updateAddZoneCoords(polygon));
            });
        });
    }

    function createAddPolygonFromPlaceViewport(place) {
        if (!place.geometry || !place.geometry.viewport) {
            console.warn('No viewport found for this place');
            return;
        }

        const bounds = place.geometry.viewport;
        const ne = bounds.getNorthEast();
        const sw = bounds.getSouthWest();

        const nw = { lat: ne.lat(), lng: sw.lng() };
        const se = { lat: sw.lat(), lng: ne.lng() };

        const coords = [
            { lat: ne.lat(), lng: ne.lng() },
            se,
            { lat: sw.lat(), lng: sw.lng() },
            nw,
            { lat: ne.lat(), lng: ne.lng() } // close loop
        ];

        if (polygon) polygon.setMap(null);

        polygon = new google.maps.Polygon({
            paths: coords,
            editable: true,
            draggable: false,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.15
        });

        polygon.setMap(map);
        updateAddZoneCoords(polygon);
    }

    function updateAddZoneCoords(polygon) {
        const path = polygon.getPath();
        const coords = [];
        for (let i = 0; i < path.getLength(); i++) {
            coords.push({ lat: path.getAt(i).lat(), lng: path.getAt(i).lng() });
        }
        if (coords.length > 0) coords.push(coords[0]);
        $('#zoneCoordinates').val(JSON.stringify(coords));
        if (coords.length > 0) $('#error_zone_coordinates').text('');
    }

   //map initialization
    let updateMap, updatePolygon, updateAutocomplete, updateDrawingManager, updateGeocoder;
    let updateCityName = "{{ $city->name }}";
    let zoneId = null;

    function initUpdateMap(existingCoords = []) {
        updateGeocoder = new google.maps.Geocoder();

        updateGeocoder.geocode({ address: updateCityName }, (results, status) => {
            if (status !== "OK") {
                console.error("Geocode failed:", status);
                return;
            }

            const defaultLocation = results[0].geometry.location;

            updateMap = new google.maps.Map(document.getElementById("updateMap"), {
                center: defaultLocation,
                zoom: 13,
            });

            const input = document.getElementById('updateAddressSearch');
            updateAutocomplete = new google.maps.places.Autocomplete(input);
            updateAutocomplete.bindTo('bounds', updateMap);

            google.maps.event.addDomListener(input, 'keydown', e => {
                if (e.key === 'Enter') e.preventDefault();
            });

            setTimeout(() => {
                const pacContainer = document.querySelector('.pac-container');
                if (pacContainer) {
                    document.getElementById('updateZoneModal').appendChild(pacContainer);
                    pacContainer.style.zIndex = '2000';
                }
            }, 500);

            updateAutocomplete.addListener('place_changed', () => {
                const place = updateAutocomplete.getPlace();
                if (!place.geometry) return;

                updateMap.setCenter(place.geometry.location);
                updateMap.setZoom(14);

                // ✅ use viewport area for update polygon as well
                createUpdatePolygonFromPlaceViewport(place);
            });

            updateDrawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon']
                },
                polygonOptions: { editable: true, draggable: false }
            });
            updateDrawingManager.setMap(updateMap);

            if (existingCoords && existingCoords.length > 0) {
                const polygonPath = existingCoords.map(c => ({
                    lat: parseFloat(c.lat),
                    lng: parseFloat(c.lng)
                }));

                updatePolygon = new google.maps.Polygon({
                    paths: polygonPath,
                    editable: true,
                    draggable: false,
                    map: updateMap
                });

                const bounds = new google.maps.LatLngBounds();
                polygonPath.forEach(c => bounds.extend(c));
                updateMap.fitBounds(bounds);

                updatePolygonCoords(updatePolygon);
                updatePolygon.getPath().addListener('set_at', () => updatePolygonCoords(updatePolygon));
                updatePolygon.getPath().addListener('insert_at', () => updatePolygonCoords(updatePolygon));
                updatePolygon.getPath().addListener('remove_at', () => updatePolygonCoords(updatePolygon));
            }

            google.maps.event.addListener(updateDrawingManager, 'overlaycomplete', event => {
                if (updatePolygon) updatePolygon.setMap(null);
                updatePolygon = event.overlay;
                updatePolygonCoords(updatePolygon);
                updatePolygon.getPath().addListener('set_at', () => updatePolygonCoords(updatePolygon));
                updatePolygon.getPath().addListener('insert_at', () => updatePolygonCoords(updatePolygon));
                updatePolygon.getPath().addListener('remove_at', () => updatePolygonCoords(updatePolygon));
            });
        });
    }

    function createUpdatePolygonFromPlaceViewport(place) {
        if (!place.geometry || !place.geometry.viewport) {
            console.warn('No viewport found for this place');
            return;
        }

        const bounds = place.geometry.viewport;
        const ne = bounds.getNorthEast();
        const sw = bounds.getSouthWest();

        const nw = { lat: ne.lat(), lng: sw.lng() };
        const se = { lat: sw.lat(), lng: ne.lng() };

        const coords = [
            { lat: ne.lat(), lng: ne.lng() },
            se,
            { lat: sw.lat(), lng: sw.lng() },
            nw,
            { lat: ne.lat(), lng: ne.lng() }
        ];

        if (updatePolygon) updatePolygon.setMap(null);

        updatePolygon = new google.maps.Polygon({
            paths: coords,
            editable: true,
            draggable: false,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.15
        });

        updatePolygon.setMap(updateMap);
        updatePolygonCoords(updatePolygon);
    }

    function updatePolygonCoords(polygon) {
        const path = polygon.getPath();
        const coords = [];
        for (let i = 0; i < path.getLength(); i++) {
            coords.push({ lat: path.getAt(i).lat(), lng: path.getAt(i).lng() });
        }
        if (coords.length > 0) coords.push(coords[0]);
        $('#update_zoneCoordinates').val(JSON.stringify(coords));
        if (coords.length > 0) $('#update_error_zone_coordinates').text('');
    }

    //add update
    $(document).ready(function () {
        $('#sentModal2').on('shown.bs.modal', function () {
            if (typeof google !== 'undefined') initAddMap();
        });

        $('#submitZone').on('click', function () {
            let zoneNameEn = $('#zone_name_en').val().trim();
            let zoneNameAr = $('#zone_name_ar').val().trim();
            let coordinates = $('#zoneCoordinates').val().trim();
            let countryId = $('#country_id').val();
            let cityId = $('#city_id').val();
            let valid = true;

            if (!zoneNameEn) { $('#error_zone_name_en').text("{{ __('admin_messages.enter_zone_name_in_english') }}"); valid = false; }
            if (!zoneNameAr) { $('#error_zone_name_ar').text("{{ __('admin_messages.enter_zone_name_in_arabic') }}"); valid = false; }
            if (!coordinates || coordinates === '[]') {
                $('#error_zone_coordinates').text("{{ __('admin_messages.please_draw_or_select_a_polygon') }}"); valid = false;
            } else $('#error_zone_coordinates').text('');

            if (!valid) return;

            $.ajax({
                url: "{{ route('admin.add_zone') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    country_id: countryId,
                    city_id: cityId,
                    name_english: zoneNameEn,
                    name_arabic: zoneNameAr,
                    coordinates: JSON.parse(coordinates)
                },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        $('#sentModal2').modal('hide');
                        setTimeout(() => location.reload(), 2000);
                    } else toastr.error(res.message || 'Failed to add zone');
                },
                error: err => console.error(err)
            });
        });

        $(document).on('click', '.editZoneBtn', function () {
            const zoneIdVal = $(this).data('zone-id');
            const nameEn = $(this).data('name-english');
            const nameAr = $(this).data('name-arabic');
            const coordinates = $(this).data('coordinates');

            $('#update_zone_name_en').val(nameEn);
            $('#update_zone_name_ar').val(nameAr);
            $('#update_zone_id').val(zoneIdVal);
            $('#update_zoneCoordinates').val(JSON.stringify(coordinates));
            zoneId = zoneIdVal;

            $('#updateZoneModal').modal('show');
            setTimeout(() => initUpdateMap(coordinates), 500);
        });

        $('#updateZoneModal').on('shown.bs.modal', function () {
            if (typeof google !== 'undefined' && updateMap) {
                google.maps.event.trigger(updateMap, 'resize');
                if (updatePolygon) {
                    const bounds = new google.maps.LatLngBounds();
                    updatePolygon.getPath().forEach(c => bounds.extend(c));
                    updateMap.fitBounds(bounds);
                }
            }
        });

        $('#updateSubmitZone').on('click', function () {
            let zoneNameEn = $('#update_zone_name_en').val().trim();
            let zoneNameAr = $('#update_zone_name_ar').val().trim();
            let coordinates = $('#update_zoneCoordinates').val().trim();
            let zoneId = $('#update_zone_id').val();
            let countryId = $('#country_id').val();
            let cityId = $('#city_id').val();
            let valid = true;

            if (!zoneNameEn) { $('#update_error_zone_name_en').text("{{ __('admin_messages.enter_zone_name_in_english') }}"); valid = false; }
            if (!zoneNameAr) { $('#update_error_zone_name_ar').text("{{ __('admin_messages.enter_zone_name_in_arabic') }}"); valid = false; }
            if (!coordinates || coordinates === '[]') {
                $('#update_error_zone_coordinates').text("{{ __('admin_messages.please_draw_or_select_a_polygon') }}"); valid = false;
            } else $('#update_error_zone_coordinates').text('');

            if (!valid) return;

            $.ajax({
                url: "{{ route('admin.update_zone') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    country_id: countryId,
                    city_id: cityId,
                    zone_id: zoneId,
                    name_english: zoneNameEn,
                    name_arabic: zoneNameAr,
                    coordinates: JSON.parse(coordinates)
                },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        $('#updateZoneModal').modal('hide');
                        setTimeout(() => location.reload(), 2000);
                    } else toastr.error(res.message || 'Failed to update zone');
                },
                error: () => toastr.error('Something went wrong while updating!')
            });
        });
    });
</script>


<!-- delete zone -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteZone').forEach(button => {
        button.addEventListener('click', function() {
            let zoneId = this.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deleteZone/${zoneId}`, {
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
                                this.closest('tr').remove();
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

<!-- Update zone status -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let zoneId = this.getAttribute('data-id');

            fetch(`/admin/change_zone_status/${zoneId}`, {
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
                        if (data.status == 1) {
                            toastr.success(data.message); // Green for active
                        } else {
                            toastr.error(data.message); // Red for deactivated
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








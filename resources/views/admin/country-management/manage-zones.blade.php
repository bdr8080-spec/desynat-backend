@extends('admin.layout.app')
@section('content')


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
                        <h6 class="m-0">Manage Zone({{$country->name}}->{{$city->name}})</h6>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Zone</span>
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
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Zone Name(English)</th>
                                    <th scope="col">Zone Name(Arabic)</th>
                                    <th scope="col">View on Map</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($zones as $index => $zone)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $zone->name_english }}</td>
                                        <td>{{ $zone->name_arabic }}</td>
                                        <td>
                                            <a class="table-button" type="button" data-bs-toggle="modal" data-bs-target="#sentModal3">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <a class="table-button" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#sentModal2"
                                                    data-plan-id="{{ $zone->id }}"
                                                    data-english-name="{{ $zone->name_english }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="table-button text-danger deleteZone"
                                                    data-id="{{ $zone->id }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No zones found.</td>
                                    </tr>
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
                <h3 class="modal-title fs-5" id="exampleModalLabel">Add Zone</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="map" style="height: 400px; width: 100%;"></div>
                <span id="error_zone_coordinates" style="color: red; font-size: 14px;"></span>

                <div class="row mt-3">
                    <div class="col-lg-6">
                        <label class="form-label">Zone Name (English)</label>
                        <input type="text" id="zone_name_en" placeholder="Enter Zone Name in Enlish" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control" />
                        <div class="text-danger mt-1" id="error_zone_name_en"></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Zone Name (Arabic)</label>
                        <input type="text" id="zone_name_ar" placeholder="Enter Zone Name in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control" />
                        <div class="text-danger mt-1" id="error_zone_name_ar"></div>
                    </div>
                </div>

                <input type="hidden" id="zoneCoordinates" name="coordinates" />
                <input type="hidden" id="country_id" value="{{ $country->id }}">
                <input type="hidden" id="city_id" value="{{ $city->id }}">

                <div class="mt-3 text-center">
                    <button class="btn btn-dark customBtn" id="submitZone">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&libraries=places,drawing"></script>



<script>
    let map, polygon;
    let cityName = "{{ $city->name }}";

    function loadGoogleMaps() {
        const script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&libraries=places,drawing&callback=initMap";
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }

    // Initialize Map
    function initMap() {
        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ address: cityName }, (results, status) => {
            if (status === "OK") {
                const defaultLocation = results[0].geometry.location;

                map = new google.maps.Map(document.getElementById("map"), {
                    center: defaultLocation,
                    zoom: 13,
                });

                const drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: ['polygon']
                    },
                    polygonOptions: {
                        editable: true,
                        draggable: false
                    }
                });
                drawingManager.setMap(map);

                // Capture polygon
                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                    if (polygon) polygon.setMap(null); 
                    polygon = event.overlay;
                    updatePolygonCoords(polygon);

                    polygon.getPath().addListener('set_at', () => updatePolygonCoords(polygon));
                    polygon.getPath().addListener('insert_at', () => updatePolygonCoords(polygon));
                    polygon.getPath().addListener('remove_at', () => updatePolygonCoords(polygon));
                });

            } else {
                //alert("Geocode was not successful: " + status);
            }
        });
    }

    // Update coordinates textarea
    function updatePolygonCoords(polygon) {
        const path = polygon.getPath();
        const coords = [];

        for (let i = 0; i < path.getLength(); i++) {
            coords.push({ lat: path.getAt(i).lat(), lng: path.getAt(i).lng() });
        }

        if (coords.length > 0) coords.push(coords[0]);

        document.getElementById("zoneCoordinates").value = JSON.stringify(coords);

        if (coords.length > 0) $('#error_zone_coordinates').text('');
    }

    $(document).ready(function() {
        loadGoogleMaps();

        $('#zone_name_en').on('input', function() { $('#error_zone_name_en').text(''); });
        $('#zone_name_ar').on('input', function() { $('#error_zone_name_ar').text(''); });

        $('#submitZone').on('click', function() {
            let zoneNameEn = $('#zone_name_en').val().trim();
            let zoneNameAr = $('#zone_name_ar').val().trim();
            let coordinates = $('#zoneCoordinates').val().trim();
            let countryId = $('#country_id').val();
            let cityId = $('#city_id').val();

            let valid = true;

            if (!zoneNameEn) { $('#error_zone_name_en').text('Enter Zone Name in English'); valid = false; }
            if (!zoneNameAr) { $('#error_zone_name_ar').text('Enter Zone Name in Arabic'); valid = false; }

            if (!coordinates || coordinates === '[]') {
                $('#error_zone_coordinates').text('Please draw a polygon on the map');
                valid = false;
            } else {
                $('#error_zone_coordinates').text('');
            }

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
                success: function(res) {
                    if (res.status === 'success') {
                       toastr.success(res.message);
                        $('#sentModal2').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(res.message || 'Failed to add zone');
                    }
                },
                error: function(err) {
                    console.log(err);
                    //alert('Something went wrong!');
                }
            });
        });
    });

</script>





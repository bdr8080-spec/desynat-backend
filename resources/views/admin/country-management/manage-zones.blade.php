@extends('admin.layout.app')
@section('content')


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                 <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('manageCities')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">Manage Zone</h6>
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
                    <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative; ">
                            <i class="bi bi-search" style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      ">
                            </i>
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div>
                    </div>

                    <div class="table-responsive w-100">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Zone Name</th>
                                    <th scope="col">View on Map</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Dubai </td>
                                    <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal2">
                                            <i class="bi bi-eye-fill"></i>
                                        </a></td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a class="table-button" type="button">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>


                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Dubai </td>
                                    <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal2">
                                            <i class="bi bi-eye-fill"></i>
                                        </a></td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a class="table-button" type="button">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>


                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">
                    Add Zone
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                  <div class="">
    

    

      <div id="map"></div>
        <div class="form-row">
        <input type="text" placeholder="Zone Name (In English)" />
        <input type="text" placeholder="Zone Name (in Arabic)" />
      
      </div>
       <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <a class="btn btn-dark customBtn" href=""> Submit</a>
                                </div>
                            </div>
    </div>
  </div>

            </div>
        </div>
    </div>
</div>



  <script
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"
  ></script>

  <script>
    let map, marker;

    function initMap() {
      const defaultLocation = { lat: 28.6139, lng: 77.209 }; // Delhi

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
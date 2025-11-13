   <script src="{{asset('user/assets/js/custom.js')}}"></script>
    <script src="{{asset('user/assets/js/bootstrap.bundle.min.js')}}" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->
    <script src="{{asset('user/assets/js/custom.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
     <script src="{{asset('user/assets/js/owl.carousel.js')}}"></script>
    <script src="{{asset('user/assets/js/custom.js')}}"></script>
    
    <script>
let map, marker, autocomplete;
let mapInitialized = false;

function initMap(currentLoc) {
   
    map = new google.maps.Map(document.getElementById("googleMap"), {
        center: currentLoc,
        zoom: 15,
    });


    marker = new google.maps.Marker({
        position: currentLoc,
        map,
        draggable: true,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
        },
    });

    const input = document.querySelector('#changeLocation input[type="text"]');
    const addressDisplay = document.querySelector('#locationUpdate');

   
    autocomplete = new google.maps.places.Autocomplete(input, {
        fields: ["geometry", "formatted_address"],
    });
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) return;
        const cityField = document.getElementById('cityField');
        cityField.textContent = place.formatted_address;
        updateLocation(place.geometry.location, place.formatted_address);
    });

    marker.addListener("dragend", () => {
        const pos = marker.getPosition();
        updateLocation(pos);
    });

    updateLocation(currentLoc);
}

function updateLocation(loc, formattedAddress = null) {
    const input = document.querySelector('#changeLocation input[type="text"]');
    const addressDisplay = document.querySelector('#locationUpdate');
    const latValue = document.getElementById('lat');
    const lngValue = document.getElementById('lng');
    const cityField = document.getElementById('cityField');

    map?.setCenter(loc);
    marker?.setPosition(loc);

    const lat = typeof loc.lat === "function" ? loc.lat() : loc.lat;
    const lng = typeof loc.lng === "function" ? loc.lng() : loc.lng;

    latValue.value = lat;
    lngValue.value = lng;

    const geocoder = new google.maps.Geocoder();

    if (formattedAddress) {
        input.value = formattedAddress;
        addressDisplay.textContent = formattedAddress;
        cityField.textContent = formattedAddress;
    } else {
        geocoder.geocode({ location: { lat, lng } }, (results, status) => {
            if (status === "OK" && results[0]) {
                const addr = results[0].formatted_address;
                input.value = addr;
                addressDisplay.textContent = addr;
                cityField.textContent = addr
            } else {
                addressDisplay.textContent = "Address not found.";
            }
        });
    }
}

function loadMapWithCurrentLocation() {
    const latValue = document.getElementById('lat');
    const lngValue = document.getElementById('lng');
    const lat = parseFloat(latValue?.value);
    const lng = parseFloat(lngValue?.value);

    // ✅ If saved lat/lng exist, use them
    if (!isNaN(lat) && !isNaN(lng)) {
        initMap({ lat, lng });
        return;
    }

    // ✅ Else, get current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                initMap({
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                });
            },
            () => {
                initMap({ lat: 20.5937, lng: 78.9629 }); 
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        initMap({ lat: 20.5937, lng: 78.9629 });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const modalEl = document.getElementById("changeLocation");

    modalEl.addEventListener("shown.bs.modal", () => {
        initMapInModal(modalEl);
    });

    if (!mapInitialized) {
        const imgPlaceholder = modalEl.querySelector("img");
        if (imgPlaceholder) {
            const mapDiv = document.createElement("div");
            mapDiv.id = "googleMap";
            mapDiv.style.height = "300px";
            mapDiv.style.borderRadius = "10px";
            imgPlaceholder.replaceWith(mapDiv);
        }

        setTimeout(() => {
            loadMapWithCurrentLocation();
            mapInitialized = true;
        }, 400);
    }
});


$(document).on('click', '.saveCurrentAddress', function (e) {
    e.preventDefault();

    let lat = $('#lat').val();
    let lng = $('#lng').val();
    let address = $('#locationUpdate').text();

    if (!lat || !lng || !address) {
        toastr.error('Please select a valid location first!');
        return;
    }

    $.ajax({
        url: "{{ route('userSaveCurrentLocation') }}",
        type: 'POST',
        data: {
            latitude: lat,
            longitude: lng,
            address: address,
            _token: "{{ csrf_token() }}"
        },
        beforeSend: function() {
            $('.saveCurrentAddress').prop('disabled', true);
        },
        success: function (response) {
            if(response.status == true){
                toastr.success(response.message);
                $('.saveCurrentAddress').prop('disabled', false);
                $('#changeLocation').modal('hide');
            }else{
                    $('.saveCurrentAddress').prop('disabled', false);
                    $('#changeLocation').modal('hide');
            }
        },
        error: function () {
            $('.saveCurrentAddress').prop('disabled', false).text('Change Location');
        }
    });
});
</script>



     <script>
        $('.customOwlcarousel').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            nav:false,
            dots:true,
            responsive:{
                0:{
                    items:1,
                },
                600:{
                    items:1,
                },
                1000:{
                    items:1,
                    dots:true
                }
            }
        })
    </script>

    <script>
        $('.storeCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 8
                }
            },
            slideBy: 1 // slides one by one
        });

        $('.bestSellingCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            },
            slideBy: 1 // slides one by one
        });

        $('.topRatedCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            },
            slideBy: 1 // slides one by one
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#fileInput").change(function (e) {
                const file = e.target.files[0];
                if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $("#profileImg").attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
                }
            });
            });
    </script>


    <script>

 
        document.querySelectorAll('.notapplyspace').forEach(function(input) {
            input.addEventListener('keydown', function(e) {
                if (e.key === ' ') {
                    e.preventDefault();
                }
            });
            });



    $("input, textarea, select").on("input", function() {
        var field = $(this).attr("name");
        $("#error-" + field).text("");
    });



    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>

</body>
</html>
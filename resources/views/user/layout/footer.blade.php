     <footer>
        <div class="container-fluid">
            <div class="row justify-content-between">
            <div class="col-lg-3 col-md-3 col-12">
                <div class="footer_logo">
                    <img src="{{asset('user/assets/images/logo.svg')}}" class="img-fluid" />

                </div>
                <span class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </span>
                <button class="customBtn1">Become an Affiliate Customer</button> 
            </div>
            <div class="col-lg-5 col-md-5 col-12">
                <div class="footerNavLink ms-20percenter">
                    <div class="footerNavLink_content">
                        <h6>Customer Policy</h6>
                        <ul class="navs list-unstyled">
                            <li>
                                <a href="">About Us</a>
                            </li>
                             <li>
                                <a href="">Terms & Condition</a>
                            </li>
                             <li>
                                <a href="">Return Policy</a>
                            </li>
                             <li>
                                <a href="">Exchange Policy</a>
                            </li>
                             <li>
                                <a href="">FAQs</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footerNavLink_content">
                        <h6>Customer Policy</h6>
                        <ul class="navs list-unstyled">
                            <li>
                                <a href="">XYZgmail.com</a>
                            </li>
                             <li>
                                <a href="">+ 965 36214565</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="footerNavLink">
                    <div class="footerNavLink_content ms-lg-auto ms-md-auto">
                        <h6>Get the App</h6>
                        <div class="getTheApp gap-2 d-flex align-items-end">
                            <div style="width: 40%;">
                                <img src="{{asset('user/assets/images/play-store.svg')}}" class="img-fluid" />
                            </div>
                            <div style="width: 40%;">
                                <img src="{{asset('user/assets/images/ios-app.svg')}}" class="img-fluid" />
                            </div>
                        </div>
                        <ul class="list-unstyled social_icon">
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/Social icon.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/Instagram_logo_2016.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/social_facebook.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/social_x_circle 1.svg')}}" class="img-fluid" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </footer>

     
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
    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key.key') }}&callback=initMap&libraries=places">
</script>


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
    const addressDisplay = document.querySelector('#changeLocation p');

    // Initialize Autocomplete
    autocomplete = new google.maps.places.Autocomplete(input, {
        fields: ["geometry", "formatted_address", "address_components"],
    });
    autocomplete.bindTo("bounds", map);

    // When user selects from autocomplete
    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) return;
        updateLocation(place.geometry.location, place.formatted_address, place.address_components);
    });

    // When marker is dragged
    marker.addListener("dragend", () => {
        const pos = marker.getPosition();
        updateLocation(pos);
    });

    updateLocation(currentLoc);
}

function updateLocation(loc, formattedAddress = null, addressComponents = null) {
    const input = document.querySelector('#changeLocation input[type="text"]');
    const addressDisplay = document.querySelector('#changeLocation p');
    const cityField = document.getElementById('cityField');
    const locationUpdate = document.getElementById('locationUpdate');

    map?.setCenter(loc);
    marker?.setPosition(loc);

    const lat = typeof loc.lat === "function" ? loc.lat() : loc.lat;
    const lng = typeof loc.lng === "function" ? loc.lng() : loc.lng;

    const geocoder = new google.maps.Geocoder();

    if (formattedAddress) {
        // Directly use formatted address
        input.value = formattedAddress;
        addressDisplay.textContent = formattedAddress;
        if (locationUpdate) locationUpdate.textContent = formattedAddress;
        if (cityField) cityField.textContent = formattedAddress;
    } else {
        // Reverse geocoding to get address
        geocoder.geocode({ location: { lat, lng } }, (results, status) => {
            if (status === "OK" && results[0]) {
                const addr = results[0].formatted_address;
                input.value = addr;
                addressDisplay.textContent = addr;
                if (cityField) cityField.textContent = addr;
            } else {
                if (cityField) cityField.textContent = "Address not found.";
            }
        });
    }
}

function loadMapWithCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLoc = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                initMap(userLoc);
            },
            () => {
                const fallback = { lat: 20.5937, lng: 78.9629 }; // Default India
                initMap(fallback);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        const fallback = { lat: 20.5937, lng: 78.9629 };
        initMap(fallback);
    }
}

// ✅ Automatically show current address in cityField on page reload
function showCurrentLocationInCityField() {
    const cityField = document.getElementById('cityField');
    if (!cityField) return;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                    if (status === "OK" && results[0]) {
                        cityField.textContent = results[0].formatted_address;
                    } else {
                        cityField.textContent = "Location not found.";
                    }
                });
            },
            () => {
                cityField.textContent = "Unable to fetch location.";
            }
        );
    } else {
        cityField.textContent = "Geolocation not supported.";
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // ✅ Show address in cityField immediately when page loads
    showCurrentLocationInCityField();

    const modalEl = document.getElementById("changeLocation");
    modalEl.addEventListener("shown.bs.modal", () => {
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
        } else {
            setTimeout(() => {
                google.maps.event.trigger(map, "resize");
                map.setCenter(marker.getPosition());
            }, 300);
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


<script>
document.addEventListener("DOMContentLoaded", function () {
  function isVisible(element) {
    // Check if element exists and is actually visible
    if (!element) return false;
    const style = window.getComputedStyle(element);
    return style.display !== "none" && style.visibility !== "hidden" && style.opacity !== "0";
  }

  function adjustProfileHeight() {
    const profile = document.querySelector(".mid-content");
    const footer = document.querySelector("footer");
    const header = document.querySelector("header");
    if (!profile) return;

    const footerVisible = isVisible(footer);
    const footerHeight = footerVisible && footer ? footer.offsetHeight : 0;
    const headerHeight = header ? header.offsetHeight : 0;
    const windowHeight = window.innerHeight;
    const windowWidth = window.innerWidth;

    // ✅ Script sirf 1024px se zyada screens par chale
    if (windowWidth > 1024) {
      const availableHeight = windowHeight - (headerHeight + footerHeight + (footerVisible ? 50 : 0));
      profile.style.height = availableHeight + "px";
      profile.style.overflowY = "auto";
      profile.style.paddingBottom = "0";
    } else {
      // ❌ Mobile/tablet me disable
      profile.style.height = "auto";
      profile.style.overflowY = "visible";
      profile.style.paddingBottom = "0";
    }
  }

  // Run on load
  adjustProfileHeight();

  // Recalculate on resize/orientation change
  window.addEventListener("resize", adjustProfileHeight);
  window.addEventListener("orientationchange", adjustProfileHeight);

  // Observe footer height changes (only when visible)
  const footer = document.querySelector("footer");
  if (footer) {
    const observer = new ResizeObserver(() => {
      if (window.innerWidth > 1024) adjustProfileHeight();
    });
    observer.observe(footer);
  }
});
</script>

</body>
</html>
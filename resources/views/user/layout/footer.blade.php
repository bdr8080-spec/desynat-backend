     <style>
.notification-pnl.read {
    opacity: 0.7;
}

.notification-pnl.not-clickable {
    pointer-events: none;
    cursor: default;
}

/* Optional: keep unread visually distinct */
.notification-pnl.unread {
    background-color: #f1f7ff;
    border-left: 4px solid #0d6efd;
    cursor: pointer;
}
     </style>
     <footer>
         <div class="container-fluid">
             <div class="row justify-content-between">
                 <div class="col-lg-3 col-md-3 col-12">
                     <div class="footer_logo">
                         <img src="{{ asset('user/assets/images/logo.svg') }}" class="img-fluid" />

                     </div>
                     <span class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                         tempor
                         incididunt ut labore et dolore magna aliqua. Ut enim ad minim </span>
                     <button class="customBtn1 become-ln">Become an Affiliate Customer</button>
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
                             <div class="getTheApp gap-2 ">
                                 <div style="width: 80%;">
                                     <img src="{{ asset('user/assets/images/play-store.svg') }}"
                                         class="img-fluid mb-2" />
                                 </div>
                                 <div style="width: 80%;">
                                     <img src="{{ asset('user/assets/images/ios-app.svg') }}" class="img-fluid" />
                                 </div>
                             </div>
                             <ul class="list-unstyled social_icon">
                                 <li>
                                     <a href=""><img src="{{ asset('user/assets/images/Social icon.svg') }}"
                                             class="img-fluid" /></a>
                                 </li>
                                 <li>
                                     <a href=""><img src="{{ asset('user/assets/images/Instagram_logo_2016.svg') }}"
                                             class="img-fluid" /></a>
                                 </li>
                                 <li>
                                     <a href=""><img src="{{ asset('user/assets/images/social_facebook.svg') }}"
                                             class="img-fluid" /></a>
                                 </li>
                                 <li>
                                     <a href=""><img src="{{ asset('user/assets/images/social_x_circle 1.svg') }}"
                                             class="img-fluid" /></a>
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="footer-copyright">
                 <p>Lorem ipsum dolor sit odo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                     cillum dolore eu fugiat nulla pariatur. </p>
             </div>


         </div>
     </footer>

     <!-- WhatsApp Status Viewer -->
     <div class="status-viewer" id="statusViewer">
         <!-- Multiple Progress Bars -->
         <div id="progressContainer" class="progress-container"></div>
         <span class="status-close" onclick="closeStatus()">&times;</span>
         <img id="statusImage" class="status-img" />
         <!-- Tap Zones -->
         <!-- <div class="status-left" onclick="showPrev()">
             <span>
                 <i class="fa-solid fa-chevron-left"></i>
             </span>
         </div>
         <div class="status-right" onclick="showNext()">
             <span>
                 <i class="fa-solid fa-chevron-right"></i>
             </span>
         </div> -->
     </div>

     <!-- Admin status -->
     <!-- <div class="status-viewer" id="statusViewer">
        <div id="progressContainer" class="progress-container"></div>
        <span class="status-close" onclick="closeStatus()">&times;</span>
        <img id="statusImage" class="status-img" />
       
     </div> -->

     <!-- Notification Management -->

     @php
     use Illuminate\Support\Facades\Auth;
     use App\Models\Notification;

     $notifications = [];

     if (Auth::guard('web')->check()) {

     $notifications = Notification::where('receiver_id', auth()->id())
     ->where('receiver_type', '2')
     ->orderBy('id', 'desc')
     ->get();
     }
     @endphp

     <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="notificationDialogUser">

         <div class="offcanvas-header">
             <h5 class="offcanvas-title">Notifications</h5>
             <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
         </div>

         <div class="offcanvas-body">

             @forelse($notifications as $notification)

             <div class="notification-pnl d-flex gap-3 mb-3 
                {{ $notification->is_read == 0 ? 'unread clickable' : 'read not-clickable' }}"
                 data-id="{{ $notification->id }}">

                 <!-- ICON -->
                 <div>
                     <div class="bell-icon-1">
                         <i class="bi bi-bell-fill"></i>
                     </div>
                 </div>

                 <!-- CONTENT -->
                 <div class="noti-content w-100">

                     <div class="noti-header d-flex justify-content-between">
                         <div class="noti-title">
                             {{ $notification->title_english ?? 'Notification' }}
                         </div>

                         <div class="post-date">
                             {{ \Carbon\Carbon::parse($notification->created_at)->format('M d, h:i A') }}
                         </div>
                     </div>

                     <p>
                         {{ $notification->description_english }}
                     </p>

                 </div>

             </div>

             @empty
             <div class="text-center text-muted">
                 No notifications found
             </div>
             @endforelse

         </div>
     </div>


     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="{{ asset('user/assets/js/custom.js') }}"></script>
     <script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
     <!-- <script src="assets/js/fontawesome.min.js"></script> -->
     <!-- <script src="{{ asset('user/assets/js/custom.js') }}"></script> -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
     <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
     <script src="{{ asset('user/assets/js/owl.carousel.js') }}"></script> -->
     <!-- <script src="{{ asset('user/assets/js/custom.js') }}"></script> -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

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
        geocoder.geocode({
            location: {
                lat,
                lng
            }
        }, (results, status) => {
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
        initMap({
            lat,
            lng
        });
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
                initMap({
                    lat: 20.5937,
                    lng: 78.9629
                });
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        initMap({
            lat: 20.5937,
            lng: 78.9629
        });
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


$(document).on('click', '.saveCurrentAddress', function(e) {
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
        success: function(response) {
            if (response.status == true) {
                toastr.success(response.message);
                $('.saveCurrentAddress').prop('disabled', false);
                $('#changeLocation').modal('hide');
            } else {
                $('.saveCurrentAddress').prop('disabled', false);
                $('#changeLocation').modal('hide');
            }
        },
        error: function() {
            $('.saveCurrentAddress').prop('disabled', false).text('Change Location');
        }
    });
});
     </script>


     <script>
$('.customOwlcarousel').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    nav: false,
    dots: true,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
            dots: true
        }
    }
})

$('.bannerpop').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 3000,
    smartSpeed: 3000,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
            dots: true
        }
    }
})
$('.storeBanner').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    smartSpeed: 2000,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
            dots: true
        }
    }
})

$('.adsbannerpop2').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    smartSpeed: 5000,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
            dots: true
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
$(document).ready(function() {
    $("#fileInput").change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $("#profileImg").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});
     </script>

     <script>
$('#headerSearchInput').on('keyup', function() {
    if ($(this).val().length > 0) {
        $('.searchdrop').fadeIn();
    } else {
        $('.searchdrop').fadeOut();
    }
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
// padding between bottom and mid-content
$(document).ready(function() {
    function adjustContentPadding() {
        const $header = $('header');
        const $footer = $('footer');
        const $content = $('.mid-content');

        if (!$content.length) return; // safety check

        const windowHeight = $(window).height();
        const headerHeight = $header.outerHeight() || 0;
        const footerHeight = $footer.outerHeight() || 0;
        const contentHeight = $content.outerHeight() || 0;

        // total height excluding padding
        const totalHeight = headerHeight + footerHeight + contentHeight;

        // remaining space after accounting for header and footer
        const remaining = windowHeight - totalHeight;

        if (remaining > 0) {
            // divide remaining height into top & bottom padding
            const pad = remaining / 2;

            // Add padding + adjust for fixed header overlap
            $content.css({
                'padding-top': (pad + headerHeight) + 'px',
                'padding-bottom': pad + 'px'
            });
        } else {
            // fallback when content is tall enough
            $content.css({
                'padding-top': headerHeight + 20 + 'px',
                'padding-bottom': '20px'
            });
        }
    }

    // Run on load
    adjustContentPadding();

    // Run on window resize
    $(window).on('resize', adjustContentPadding);
});

// scroll on category
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector(".scroll-content");
    const leftArrow = document.querySelector(".scroll-left");
    const rightArrow = document.querySelector(".scroll-right");

    if (!scrollContainer || !leftArrow || !rightArrow) return;

    // Scroll amount per click (one column width + spacing)
    const scrollAmount = scrollContainer.children[0] ?
        scrollContainer.children[0].offsetWidth + 20 :
        300;

    // Prevent dropdown from closing on click
    function safeClickHandler(e, callback) {
        e.stopPropagation();
        e.preventDefault();
        if (callback) callback();
    }

    // Scroll right smoothly
    rightArrow.addEventListener("click", (e) => {
        safeClickHandler(e, () => {
            scrollContainer.scrollBy({
                left: scrollAmount,
                behavior: "smooth"
            });
        });
    });

    // Scroll left smoothly
    leftArrow.addEventListener("click", (e) => {
        safeClickHandler(e, () => {
            scrollContainer.scrollBy({
                left: -scrollAmount,
                behavior: "smooth"
            });
        });
    });

    // Prevent closing when clicking inside the scroll container
    scrollContainer.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    // Show/hide arrows based on scroll position
    function updateArrows() {
        const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
        leftArrow.style.display = scrollContainer.scrollLeft > 10 ? 'flex' : 'none';
        rightArrow.style.display = scrollContainer.scrollLeft < maxScrollLeft - 10 ? 'flex' : 'none';
    }

    // Update arrows on scroll
    scrollContainer.addEventListener("scroll", updateArrows);
    window.addEventListener("resize", updateArrows);

    // Initial check
    updateArrows();
});
     </script>

     <script>
$(document).ready(function() {
    $('.nav-item.dropdown').hover(
        function() {
            $(this).find('.dropdown-menu').addClass('show');
        },
        function() {
            $(this).find('.dropdown-menu').removeClass('show');
        }
    );
});
     </script>

     <script>
function addWishListFunctionproduct(val) {
    var id = val;

    $.ajax({
        url: "{{ url('user/addOremovewishlist') }}",
        type: "get",
        dataType: 'json',
        data: {
            "_token": "{{ csrf_token() }}",
            product_id: id,
        },
        beforeSend: function() {
            $('#user_loder').show();
        },
        success: function(data) {
            $('#user_loder').hide();
            if (data.status == 'success') {

                // Show Toastr Notification
                if (data.data == 1) {
                    toastr.success(data.message);
                    location.reload();

                } else {
                    toastr.error(data.message);
                    location.reload();
                }

                // $('#wishlistProduct' + id).val();
                var icon = $('#wishlistProduct' + id);

                var icon1 = $('#wishlistProduct1' + id);

                // Toggle between fa-regular and fa-solid
                if (icon.hasClass('fa-regular')) {
                    icon.removeClass('fa-regular').addClass('fa-solid');
                } else {
                    icon.removeClass('fa-solid').addClass('fa-regular');
                }

                if (icon1.hasClass('fa-regular')) {
                    icon1.removeClass('fa-regular').addClass('fa-solid');
                } else {
                    icon1.removeClass('fa-solid').addClass('fa-regular');
                }

                // Reload the page after 2 seconds
                // setTimeout(function() {
                //     window.location.replace("{{ url('user/dashboard') }}");
                // }, 2000);

                if (data.count <= 0) {
                    $(`#hideWisListProduct${id}`).text("No WishList Found");
                }

                $(`#hideWisListProduct${id}`).hide();



            } else {
                toastr.error("There was a problem deleting the subcategory.");
            }
        },
        error: function(xhr) {
            $('#user_loder').hide();
            toastr.error("Error occurred: " + xhr.responseText);
        }
    });


}
     </script>

     <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('headerSearchInput');

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = searchInput.value.trim();
            if (!query) return;

            fetch("{{ route('user.headerSearch') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        search: query
                    })
                })
                .then(res => res.json())
                .then(data => {
                    //console.log(data);

                    // Corrected path to products array
                    const products = data?.data?.data?.data || [];

                    if (data.status === 'success' && products.length > 0) {
                        const storeId = products[0].store_id;
                        window.location.href = `/user/all-product/`;
                    } else {
                        toastr.error('No products found for your search.');
                    }
                })
                .catch(err => console.error(err));
        }
    });
});
     </script>

     <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('headerSearchInput');
    const searchDrop = document.querySelector('.searchdrop');
    const latestSearchDiv = document.getElementById('latestSearchResults');
    const recentSearchResults = document.getElementById('recentSearchResults');

    const recommendedResults = document.getElementById('recommendedResults');

    const recommendedDiv = document.getElementById('recommendedResults');



    const searchForm = document.getElementById("searchForm");

    // Fetch recent search data if user is logged in
    function fetchRecentSearch() {
        fetch("{{ route('user.getSearchData') }}", {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(res => res.json())
            .then(data => {
                console.log(data); // debug console

                if (data.status === 'success' && data.data?.data?.length > 0) {
                    latestSearchDiv.innerHTML = ''; // Clear previous results

                    data.data.data.forEach(item => {
                        const div = document.createElement('div');
                        // Use item.name instead of item.search
                        div.innerHTML =
                            `<a href="{{url('/')}}/user/all-product?search=${item.name}">${item.name}</a>`;
                        latestSearchDiv.appendChild(div);


                        div.addEventListener("click", () => {
                            searchInput.value = item.name; // e.g. "shirt"
                            searchForm.requestSubmit(); // ✅ redirects
                        });

                    });

                    searchDrop.style.display = 'block';

                } else {
                    searchDrop.style.display = 'none';
                }

                // Recommended section (static example)
                // recommendedDiv.innerHTML = `
                //     <div><a href="#">Puma</a></div>
                //     <div><a href="#">Nike</a></div>
                // `;
            })
            .catch(err => console.error(err));

        fetch("{{ route('user.getRecommandedlatestSearch') }}", {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(res => res.json())
            .then(data => {
                console.log(data); // debug console

                if (data.status === 'success' && data.data?.data?.length > 0) {
                    recommendedResults.innerHTML = ''; // Clear previous results

                    data.data.data.forEach(item => {
                        const div = document.createElement('div');
                        // Use item.name instead of item.search
                        div.innerHTML =
                            `<a href="{{url('/')}}/user/all-product?search=${item.name_english}">${item.name_english}</a>`;
                        recommendedResults.appendChild(div);


                        div.addEventListener("click", () => {
                            searchInput.value = item.name_english; // e.g. "shirt"
                            searchForm.requestSubmit(); // ✅ redirects
                        });

                    });

                    searchDrop.style.display = 'block';

                } else {
                    searchDrop.style.display = 'none';
                }

                // Recommended section (static example)
                // recommendedDiv.innerHTML = `
                //     <div><a href="#">Puma</a></div>
                //     <div><a href="#">Nike</a></div>
                // `;
            })
            .catch(err => console.error(err));



        // Recent SEarch code 
        fetch("{{ route('user.getlatestSearch') }}", {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(res => res.json())
            .then(data => {
                console.log(data); // debug console

                if (data.status === 'success' && data.data?.data?.length > 0) {
                    recentSearchResults.innerHTML = ''; // Clear previous results

                    data.data.data.forEach(item => {
                        const div = document.createElement('div');
                        // Use item.name instead of item.search
                        div.innerHTML =
                            `<a href="{{url('/')}}/user/all-product?search=${item.name}">${item.name}</a>`;
                        recentSearchResults.appendChild(div);


                        div.addEventListener("click", () => {
                            searchInput.value = item.name; // e.g. "shirt"
                            searchForm.requestSubmit(); // ✅ redirects
                        });

                    });

                    searchDrop.style.display = 'block';

                } else {
                    searchDrop.style.display = 'none';
                }

                // Recommended section (static example)
                // recommendedDiv.innerHTML = `
                //     <div><a href="#">Puma</a></div>
                //     <div><a href="#">Nike</a></div>
                // `;
            })
            .catch(err => console.error(err));





    }

    // Show recent searches when input is focused
    searchInput.addEventListener('focus', function() {
        fetchRecentSearch();
    });

    // Optional: hide dropdown on blur after short delay
    searchInput.addEventListener('blur', function() {
        setTimeout(() => {
            searchDrop.style.display = 'none';
        }, 200);
    });
});
     </script>


     <script>
document.getElementById("headerSearchInput").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        sendSearch();
    }
});

function sendSearch() {
    const value = document.getElementById("headerSearchInput").value.trim();
    if (value !== "") {
        window.location.href = "/user/all-product?search=" + encodeURIComponent(value);
    }
}
     </script>

     <script>
        $(window).on('load', function() {
            if (window.location.pathname === '/') {
                const $modal1 = $('#showBanner');
                $modal1.fadeIn();
               //  $('body').addClass('overflow-hidden');

            }

        });
     </script>

     <!-- mark notification as read -->
     <script>
$(document).ready(function() {

    $(".notification-pnl.unread").on("click", function() {

        let notificationId = $(this).data("id");
        let element = $(this);

        if (!notificationId) return;

        $.ajax({
            url: "{{ route('user.mark_notification_as_read') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                notification_id: [notificationId]
            },
            success: function(res) {

                if (res.status === "success") {

                    toastr.success(res.message || "Marked as read");
                    element.removeClass("unread clickable")
                        .addClass("read not-clickable");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);

                } else {
                    toastr.error(res.message || "Something went wrong");
                }

            },
            error: function() {
                toastr.error("Something went wrong");
            }
        });

    });

});
     </script>



     <!-- Firebase geberate Token and Save token Code  -->




     <script type="module">
import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js";
import {
    getMessaging,
    getToken,
    onMessage
} from "https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyCYQyk6P8Gpp6YA7HgLE_Gf_aXDxze_big",
    authDomain: "desynat.firebaseapp.com",
    databaseURL: "https://desynat-default-rtdb.firebaseio.com",
    projectId: "desynat",
    storageBucket: "desynat.firebasestorage.app",
    messagingSenderId: "89320198276",
    appId: "1:89320198276:web:1d3c84f812a338529d32d1",
    measurementId: "G-7MVP5BHENE"
};


const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Ask user for notification permission
Notification.requestPermission().then((permission) => {
    if (permission === 'granted') {
        console.log('Notification permission granted.');

        getToken(messaging, {
            vapidKey: "BBPk2muPnGI7gfY99rJLaHaUyQhB2HqWS_87X3VtjU_EzQFymAd742YmWH6SkApA-3javZ5JqIRfr9ERqS5FSiU"
        }).then((currentToken) => {
            if (currentToken) {
                console.log("Device Token:", currentToken);

                // save Token Code
                $.ajax({
                    url: "{{ url('user-save-token') }}",
                    type: "get",
                    dataType: 'json',
                    data: {
                        token: currentToken,
                    },
                    success: function(response) {
                        $('#user_loder').hide();
                        if (response.success) {

                            console.log(response);

                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#user_loder').hide();
                        // toastr.error("Error occurred: " + xhr.responseText);
                    }
                });

                // save Token Code end Here



                // send to server
            } else {
                console.log('No registration token available.');
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
        });

    } else {
        console.log('Notification permission not granted.');
    }
});


onMessage(messaging, (payload) => {
    console.log('Foreground message:', payload);
    const {
        title,
        body
    } = payload.notification;

    new Notification(title, {
        body: body,
        icon: '/icon.png',
    });
});
     </script>




     <!-- firebAse code End here  -->

     </body>

     </html>
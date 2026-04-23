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
                                     <a href="{{route('user.aboutUs')}}">About Us</a>
                                 </li>
                                 <li>
                                     <a href="{{route('user.termCondition')}}">Terms & Condition</a>
                                 </li>
                                 <li>
                                     <a href="{{route('user.returnPolicy')}}">Return Policy</a>
                                 </li>
                                 <li>
                                     <a href="{{route('user.exchangePolicy')}}">Exchange Policy</a>
                                 </li>
                                 <li>
                                     <a href="{{route('user.cancellationPolicy')}}">Cancellation Policy</a>
                                 </li>
                                 <li>
                                     <a href="{{route('user.faq')}}">FAQs</a>
                                 </li>
                             </ul>
                         </div>
                         <div class="footerNavLink_content">
                             <h6>Customer Policy</h6>
                             <ul class="navs list-unstyled">
                                @php
                                    $contact = \App\Models\Content::where('slug', 'contact_us')->where('type','1')->first();
                                    $contactData = [];
                                    if ($contact) {
                                        $contactData = is_array($contact->content_english)
                                            ? $contact->content_english
                                            : json_decode($contact->content_english, true);
                                    }
                                @endphp
                                 <li>
                                     <a href="">{{ $contactData['email'] ?? 'XYZgmail.com' }}</a>
                                 </li>
                                 <li>
                                     <a href="">{{ $contactData['mobile'] ?? '+96536214565' }}</a>
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

  <!-- Admin logo story section -->
<div class="status-viewer bgwhite" id="statusAdmin">
    <div class="container adminstatus">
        <div class="story-header d-flex justify-content-between">
            <div></div>
            <button type="button" class="btn btn-light" onclick="closeStatus()"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="logostatus">
            <div id="progressContainer" class="progress-container"></div>
            
            <div class="status-img">
                <img id="statusImage" class="img-fluid" alt="status" />
                <video id="statusVideo" style="max-width: 100%; max-height: 400px; display: none;" controls></video>
            </div>
        </div>    
    </div>
</div>
     


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
    loop: false,
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
function addWishListFunctionproduct(val,homepage=null) {
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

                if(homepage){ 
                    // if the wishlist called from home Page 

                if (data.data == 1) {
                    toastr.success(data.message);
                    // location.reload();

                } else {
                    toastr.error(data.message);
                    // location.reload();
                }

                var iconClass = $('.wishlistProduct' + id);

                iconClass.each(function () {
                        if ($(this).hasClass('fa-regular')) {
                            $(this).removeClass('fa-regular').addClass('fa-solid');
                        } else {
                            $(this).removeClass('fa-solid').addClass('fa-regular');
                        }
                    });

                }else{
                    

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


<script>
var stories = null;   
var currentIndex = 0;
var timer = null;
var duration = 3000;
var redirected = false;  


function loadAdminStories(openIndex = 0, callback) {
    //console.log("[DEBUG] loadAdminStories called, openIndex:", openIndex);

    // Avoid multiple calls if stories already loaded or redirect happened
    if (stories !== null || redirected) {
        //console.log("[DEBUG] Stories already loaded or redirected, skipping API call");
        if (callback) callback();
        return;
    }

    // Ensure jQuery is loaded
    if (typeof $ === "undefined") {
        //console.error("[ERROR] jQuery is not loaded!");
        return;
    }

    $.ajax({
        url: "{{ route('user.get_admin_story') }}",  // Blade route
        type: "GET",
        dataType: "json",
        success: function (res) {
            //console.log("[DEBUG] API RESPONSE:", res);

            if (res.status === "success" && Array.isArray(res.data.data)) {
                stories = res.data.data;
            } else {
                stories = [];
            }

            if (stories.length === 0) {
                redirected = true;
               // console.log("[INFO] No stories found, redirecting to dashboard");
                //window.location.href = "{{ route('dashboard') }}";
                return;  // Stop further execution
            }

            // Stories loaded successfully
            if (callback) callback();
        },
        error: function (err) {
           // console.error("[ERROR] AJAX failed:", err);
            stories = [];  // Set empty to avoid retrying infinitely
            if (callback) callback();
        }
    });
}

// call this on icon click
function onAdminIconClick(index = 0) {
   // console.log("[DEBUG] onAdminIconClick, index:", index);

    if (redirected) {
       // console.log("[DEBUG] Already redirected, ignoring click");
        return;
    }

    if (stories === null) {
        // Stories not loaded, load from API, then open gallery if stories present
        loadAdminStories(index, function() {
            if (!redirected && stories.length > 0) {
                openGallery(index);
            }
        });
    } else if (stories.length > 0) {
        // Stories already loaded, open gallery directly
        openGallery(index);
    } else {
        // Stories empty, redirect immediately
        redirected = true;
        //console.log("[INFO] No stories present, redirecting to dashboard");
        //window.location.href = "{{ route('dashboard') }}";
    }
}

// ✅ OPEN VIEWER
function openGallery(index) {
    currentIndex = index;
    console.log("[DEBUG] openGallery called, index:", currentIndex);

    if (!stories || stories.length === 0) {
        //console.log("[INFO] No stories found, redirecting to dashboard");
        //window.location.href = "{{ route('dashboard') }}";
        return;
    }

    var statusAdmin = document.getElementById("statusAdmin");
    if (!statusAdmin) {
        //console.error("[ERROR] #statusAdmin element not found!");
        return;
    }

    statusAdmin.style.display = "block";

    generateProgressBars();
    showStory();
}

//  GENERATE PROGRESS BARS
function generateProgressBars() {
    const container = document.getElementById("progressContainer");
    if (!container) {
        console.error("[ERROR] #progressContainer element not found!");
        return;
    }

    container.innerHTML = "";

    stories.forEach((s, i) => {
        container.innerHTML += `
            <div class="progress-bar">
                <div class="progress-fill" id="bar${i}"></div>
            </div>
        `;
    });
}

//  SHOW STORY
function showStory() {
    let story = stories[currentIndex];
    //console.log("[DEBUG] showStory, currentIndex:", currentIndex, story);

    if (!story) {
        //console.warn("[WARN] No story at index", currentIndex);
        closeStatus();
        return;
    }

    let img = document.getElementById("statusImage");
    let video = document.getElementById("statusVideo");

    if (!img || !video) {
       // console.error("[ERROR] #statusImage or #statusVideo not found!");
        return;
    }

    img.style.display = "none";
    video.style.display = "none";
    video.pause();
    video.currentTime = 0;

    let file = story.file;

    if (!file) {
        //console.warn("[WARN] Story has no file, skipping:", story);
        showNext();
        return;
    }

    if (file.match(/\.(mp4|webm|ogg)$/i)) {
        video.src = file;
        video.style.display = "block";

        video.onloadedmetadata = function () {
            duration = (video.duration * 1000) || 3000;
            startProgress();
            video.play();
        };
    } else {
        img.src = file;
        img.style.display = "block";
        duration = 3000;
        startProgress();
    }
}

// START PROGRESS
function startProgress() {
    clearTimeout(timer);

    document.querySelectorAll(".progress-fill").forEach(bar => {
        bar.style.width = "0%";
        bar.style.transition = "none";
    });

    setTimeout(() => {
        let bar = document.getElementById("bar" + currentIndex);
        if (bar) {
            bar.style.transition = `${duration}ms linear`;
            bar.style.width = "100%";
        }
    }, 10);

    timer = setTimeout(() => {
        showNext();
    }, duration);
}

//  NEXT STORY
function showNext() {
    if (currentIndex < stories.length - 1) {
        currentIndex++;
        showStory();
    } else {
        closeStatus();
    }
}

//  PREVIOUS STORY
function showPrev() {
    if (currentIndex > 0) {
        currentIndex--;
        showStory();
    }
}

// CLOSE VIEWER
function closeStatus() {
    clearTimeout(timer);

    let video = document.getElementById("statusVideo");
    if (video) {
        video.pause();
        video.currentTime = 0;
    }

    let statusAdmin = document.getElementById("statusAdmin");
    if (statusAdmin) {
        statusAdmin.style.display = "none";
    }
}
</script>

<!-- google translator code -->


<!-- <script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        autoDisplay: false
    }, 'google_translate_element');
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>

let currentLang = localStorage.getItem("selectedLang") || "en";
let translateReady = false;

/* WAIT FOR GOOGLE DROPDOWN (ROBUST VERSION) */
function waitForCombo(callback) {

    let attempts = 0;

    const timer = setInterval(() => {

        const combo = document.querySelector(".goog-te-combo");

        if (combo && combo.options.length > 1) {
            clearInterval(timer);
            translateReady = true;
            callback(combo);
        }

        attempts++;

        if (attempts > 30) {
            clearInterval(timer);
            console.warn("Google Translate not ready");
        }

    }, 200);
}


/* APPLY TRANSLATION (FIXED FIRST TIME ISSUE) */
function applyTranslation(lang) {

    const loader = document.getElementById("loaderTrans");
    if (loader) loader.style.display = "flex";

    currentLang = lang;
    localStorage.setItem("selectedLang", lang);

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // STEP 1: RESET
        trigger("en");

        setTimeout(() => {

            // STEP 2: APPLY LANGUAGE
            trigger(lang);

            // STEP 3: RETRY (VERY IMPORTANT FIX)
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                if (loader) loader.style.display = "none";

            }, 500);

        }, 300);

    });
}


/* UPDATE UI */
function updateUI(lang) {

    const current = document.getElementById("currentLang");
    if (current) current.innerText = lang.toUpperCase();

    document.querySelectorAll(".langu .dropdown-item")
        .forEach(el => el.style.background = "");

    const active = document.querySelector(`.langu .dropdown-item[data-lang="${lang}"]`);

    if (active) {
        active.style.background =
            "linear-gradient(73.47deg, #F9DBAB 0%, #7D532F 132.99%)";
    }
}


/* CLICK EVENTS */
document.querySelectorAll(".langu .dropdown-item").forEach(item => {

    item.addEventListener("click", function () {

        const lang = this.getAttribute("data-lang");

        // PREVENT CLICK BEFORE READY
        if (!translateReady) {
            console.log("Translate still loading...");
            return;
        }

        applyTranslation(lang);

    });

});


/* INITIAL LOAD */
function initLanguage() {

    const lang = localStorage.getItem("selectedLang") || "en";
    const loader = document.getElementById("loaderTrans");

    if (loader) loader.style.display = "flex";

    updateUI(lang);

    waitForCombo(function(combo) {

        function trigger(value) {
            combo.value = value;
            combo.dispatchEvent(new Event("change"));
        }

        // RESET FIRST
        trigger("en");

        setTimeout(() => {

            trigger(lang);

            // RETRY FIX
            setTimeout(() => {

                if (combo.value !== lang) {
                    trigger(lang);
                }

                // SHOW PAGE ONLY AFTER TRANSLATION
                document.body.style.visibility = "visible";

                if (loader) loader.style.display = "none";

            }, 600);

        }, 300);

    });

}

window.addEventListener("load", initLanguage);


/* BACK/FORWARD CACHE FIX */
window.addEventListener("pageshow", function (event) {

    if (event.persisted ||
        performance.getEntriesByType("navigation")[0]?.type === "back_forward") {

        setTimeout(() => {
            initLanguage();
        }, 200);
    }

});


/* HIDE GOOGLE TOOLTIP */
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.id === 'goog-gt-tt') {
                node.style.display = 'none';
            }
        });
    });
});

observer.observe(document.body, { childList: true, subtree: true });

</script> -->






     </body>

     </html>
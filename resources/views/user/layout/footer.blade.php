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
                        <div class="getTheApp gap-2 d-flex align-items-end flex-lg-column">
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
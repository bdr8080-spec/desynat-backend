</main>

<!-- Notification Management -->

<div class="offcanvas  offcanvas-end" data-bs-scroll="true" tabindex="-1" id="notificationDialog">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Notification</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="notification-pnl d-flex gap-3 mb-3">
        <div>
            <div class="bell-icon-1">
                <i class="bi bi-bell-fill"></i>
            </div>
        </div>
        <div class="noti-content">
            <div class="noti-header d-flex justify-content-between">
                <div class="noti-title">Booking Confirmation</div>
                <div class="post-date">Today 11:55 am</div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste voluptatem dolores culpa atque nostrum quasi nihil sit itaque sapiente magni fuga,</p>
        </div>
    </div>
    <div class="notification-pnl d-flex gap-3 mb-3">
        <div>
            <div class="bell-icon-1">
                <i class="bi bi-bell-fill"></i>
            </div>
        </div>
        <div class="noti-content">
            <div class="noti-header d-flex justify-content-between">
                <div class="noti-title">Booking Confirmation</div>
                <div class="post-date">Today 11:55 am</div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste voluptatem dolores culpa atque nostrum quasi nihil sit itaque sapiente magni fuga,</p>
        </div>
    </div>

  </div>
</div>



<!-- app story -->
<div class="storywapper" style="display:none;">
  <div class="container">
    <div class="modal-content-2 pt-5">
      <div class="story-header d-flex justify-content-between">
        <h3>Story </h3>
        <button type="button" id="btnclose"><i class="bi bi-x-lg"></i></button>
      </div>
      <div class="modal-body">
        <div class="status-panel">
            <div class="owl-carousel owl-theme storeBanner">
                <div class="item">
                    <div class="sellerstatus">
                        <img src="{{ asset('dealer') }}/assets/img/reel-1.svg" alt="banner" class="img-fluid" />
                    </div>
                </div>
                <div class="item">
                    <div class="sellerstatus">
                        <img src="{{ asset('dealer') }}/assets/img/reel-3.svg" alt="banner" class="img-fluid" />
                    </div>
                </div>
               


            </div>
        
        </div>

      </div>
    </div>
  </div>
</div>


<!-- Vendor JS Files -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>
<!--Main JS File -->
<script src="{{ asset('dealer') }}/assets/custom-file/table-lib/table-data.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/main.js"></script>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- jQuery (required by Toastr) -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).on('click', '#storyModal', function (e) {
        e.preventDefault();       
        $('.storywapper').toggle();
    });

    $(document).on('click', '#btnclose', function () {
        $('.storywapper').hide();
    });

    $('.storeBanner').owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        dots: true,
        // autoplay: true,
        // autoplayTimeout: 5000,
        // smartSpeed: 5000,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            }
        }
    })

</script>

<script>
    document.querySelectorAll('.notapplyspace').forEach(function(input) {
        input.addEventListener('keydown', function(e) {
            if (e.key === ' ') {
                e.preventDefault();
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const restrictedInputs = document.querySelectorAll('.blockFirstTime');

        restrictedInputs.forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === ' ' && this.value.length === 0) {
                    e.preventDefault();
                }
            });

            input.addEventListener('input', function() {
                if (this.value.startsWith(' ')) {
                    this.value = this.value.trimStart();
                }
            });
        });
    });



    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if (session('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>

</body>

</html>

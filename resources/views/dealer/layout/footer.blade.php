</main>
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
<!-- Notification Management -->

@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Notification;

    $notifications = [];

    if (Auth::guard('seller')->check()) {
        $sellerId = Auth::guard('seller')->user()->id;

        $notifications = Notification::where('receiver_id', $sellerId)
            ->where('receiver_type', '3')
            ->orderBy('created_at', 'desc')
            ->get();
    }
@endphp

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="notificationDialog">
    
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Notifications</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">

        @forelse($notifications as $notification)

            <div class="notification-pnl d-flex gap-3 mb-3 
                {{ $notification->is_read == 0 ? 'unread clickable' : 'read not-clickable' }}"
                
                data-id="{{ $notification->id }}"
            >

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

<!-- mark notification as read -->
<script>
$(document).ready(function () {

    $(".notification-pnl.unread").on("click", function () {

        let notificationId = $(this).data("id");
        let element = $(this);

        if (!notificationId) return;

        $.ajax({
            url: "{{ route('seller.mark_notification_as_read') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                notification_id: [notificationId]
            },
            success: function (res) {

                if (res.status === "success") {

                    toastr.success(res.message || "Marked as read");
                    element.removeClass("unread clickable")
                           .addClass("read not-clickable");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else {
                    toastr.error(res.message || "Something went wrong");
                }

            },
            error: function () {
                toastr.error("Something went wrong");
            }
        });

    });

});
</script>

</body>

</html>

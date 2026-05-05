@include('affiliatedUser.layout.header')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('affiliate.affiliateDashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Settings</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="live-pnl mb-3">
                <div class="d-flex justify-content-between">
                    <div class="inapp-list d-flex gap-3">
                            <div><img src="{{asset('user/assets/images/in-app.png')}}" class="img-fluid"></div>
                            <h6>In-app Notifications</h6>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault" {{ $data->app_notification == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="switchCheckDefault"></label>
                    </div>
                </div>
            </div>

            <div class="live-pnl mb-3">
                <div class="d-flex justify-content-between">
                <div class="inapp-list d-flex gap-3">
                           <div> <img src="{{asset('user/assets/images/push-icon.png')}}" class="img-fluid"></div>
                            <h6>Push Notifications</h6>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault1" {{ $data->notification == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="switchCheckDefault1"></label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="payment-box mt-5">
        <div class="login-btn py-3 text-center">
            <input type="submit" class="btn btn-success w-25" name="submit" value="Delete Account">
        </div>

    </div>


</div>
@include('affiliatedUser.layout.footer')

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
$(document).on('change', '#switchCheckDefault', function () {


    $.ajax({
        url: "{{ route('affiliate.affiliate_app_notification_on_off') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
        },
        success: function (response) {
            if (response.status === 'success') {
                toastr.success(response.message);

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else {
                toastr.error(response.message);
            }
        },
        error: function () {
            toastr.error('Something went wrong');
        }
    });
});
</script>

<script>
$(document).on('change', '#switchCheckDefault1', function () {


    $.ajax({
        url: "{{ route('affiliate.affiliate_notification_on_off') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
        },
        success: function (response) {
            if (response.status === 'success') {
                toastr.success(response.message);

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else {
                toastr.error(response.message);
            }
        },
        error: function () {
            toastr.error('Something went wrong');
        }
    });
});
</script>



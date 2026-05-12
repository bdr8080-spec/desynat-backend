@extends('user.layout.app')

@section('content')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="/"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>{{ __('user_messages.settings') }}</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="live-pnl mb-3">
                <div class="d-flex justify-content-between">
                    <div class="inapp-list d-flex gap-3">
                            <div><img src="{{asset('user/assets/images/in-app.png')}}" class="img-fluid"></div>
                            <h6>{{ __('user_messages.in_app_notifications') }}</h6>
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
                            <h6>{{ __('user_messages.push_notifications') }}</h6>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault1" {{ $data->notification == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="switchCheckDefault1"></label>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="cart-panel mt-5 text-center">
        <button type="submit" id="userDelete" class="customBtn customBtn5 w-25"> {{ __('user_messages.delete_account') }} </button>
    </div>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('change', '#switchCheckDefault', function () {


    $.ajax({
        url: "{{ route('user.app_notification_on_off') }}",
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
        url: "{{ route('user.notification_on_off') }}",
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
$(document).on('click', '#userDelete', function () {

    Swal.fire({
        title: "{{ __('admin_messages.are_you_sure?') }}",
                text: "{{ __('admin_messages.you_wont_be_able_to_revert_this') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "{{ __('admin_messages.yes_delete_it') }}",
                cancelButtonText: "{{ __('admin_messages.cancel') }}"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('user.delete_account') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function (response) {

                    if (response.status === 'success') {
                        toastr.success(response.message);

                        setTimeout(function () {
                            window.location.href = "{{ route('dashboard') }}";
                        }, 1000);

                    } else {
                        toastr.error(response.message || 'Something went wrong');
                    }
                },

                error: function () {
                    toastr.error('Something went wrong');
                }

            });

        }

    });

});
</script>

@endsection




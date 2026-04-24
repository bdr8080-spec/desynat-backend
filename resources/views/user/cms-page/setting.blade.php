@extends('user.layout.app')

@section('content')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="/"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
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
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault" checked="">
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
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault" checked="">
                        <label class="form-check-label" for="switchCheckDefault"></label>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>

@endsection


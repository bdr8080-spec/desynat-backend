@extends('user.auth.layout.app')


@section('content')


<div class="login_contenar">
    <header class="inner-header">
        <a href="{{route('dashboard')}}"><img src="assets/images/logo.svg" class="img-fluid" /></a>
        <div class="d-flex align-items-center becomSeller">
            <div class="dropdown ms-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="assets/images/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="login_content login_content_left">
        <img src="assets/images/left-img.svg" class="left-imgone" />
        <img src="assets/images/logoone.svg" class="left-img" />
        <img src="assets/images/right-img.svg" class="left-imgtwo" />
    </div>
    <div class="login_content login_content_right">
        <div class="login_content_content align-self-center">
            <div class="login-content pt-40">
                <div class="login-grid-2">
                    <form>
                        <div class="review-image mb-4">
                            <img src="{{ asset('/dealer') }}/assets/img/review.svg" alt="image" class="img-fluid">
                        </div>
                        <div class="group-radio-btn text-center">
                            <h2 class="mb-3">Your account registration is under review !!</h2>
                            <p>Please wait for 3-4 hrs. Thank you for your patience. Team Desynat App</p>
                        </div>

                        <div class="login-btn padding-top-60">
                            <a href="{{ route('affiliateLogout') }}" class="btn btn-success w-100">Logout</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
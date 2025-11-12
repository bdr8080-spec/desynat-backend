<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> desynat seller </title>
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="login-header">
        <div class="des-logo">
            <a href="{{ route('seller.dashboard') }}"><img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg"
                    alt="image" class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('dealer') }}/assets/img/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="login-wapper">
        <div class="login-grid-bg planheight"></div>
        <div class="container-fluid custom-container">
            <div class="plan-wapper">
                <div class="row">

                    @foreach ($plans as $key => $item)
                        <div class="col-lg-3 col-md-4">
                            <div class="plan-card plan-shadow">
                                <div
                                    class="plan-header  text-center 
                                     @if ($key == 0) bg-yellow-1 
                                      @elseif($key == 1)  bg-yellow-2
                                      @elseif($key == 2)  bg-yellow-3
                                      @elseif($key == 3)  bg-yellow-4
                                      @else
                                      bg-yellow-1 @endif ">

                                    {{ $item->plan_name_english }}

                                </div>
                                <div class="plan-content text-center plan-shadow">
                                    <h4>KD {{ $item->price }} </h4>
                                    <div>for {{ $item->duration }} @if ($item->duration_type == '1')
                                            Month
                                        @else
                                            Year
                                        @endif
                                    </div>
                                </div>

                                <div class="plan-body p-3">
                                    <ul class="list-inline">
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Products:
                                            <span class="font-600">{{ $item->no_of_products }}</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Videos
                                            (Reels)
                                            : <span class="font-600">{{ $item->no_of_videos }}</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Highlights:
                                            <span class="font-600">{{ $item->no_of_highlights }} </span>
                                        </li>

                                        @if ($item->stories == '1')
                                            <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">
                                                15 stories
                                                within
                                                24
                                                hours</li>
                                        @endif

                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store
                                            Employees
                                        </li>

                                        @if ($item->commission == '1')
                                            <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                                <span class="font-600">{{ $item->commission_percentage }}</span>
                                            </li>
                                        @endif

                                    </ul>
                                    <div class="py-3">
                                        <a href="{{ route('seller.single_plans', $item->id) }}"
                                            class="btn btn-success w-100">Purchase</a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    @endforeach


                    {{-- <div class="col-lg-3 col-md-4">
                        <div class="plan-card plan-shadow">
                            <div class="plan-header bg-yellow-2 text-center">Pro Package</div>
                            <div class="plan-content text-center plan-shadow">
                                <h4>KD 250.00</h4>
                                <div>for 1 Month</div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Products:
                                        <span>120</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                        (Reels): <span>60</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                        Highlights: <span>10</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within 24
                                        hours</li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store Employees
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                        <span>2.5%</span>
                                    </li>
                                </ul>
                                <div class="py-3">
                                    <a href="#" class="btn btn-success w-100">Purchase</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="plan-card plan-shadow">
                            <div class="plan-header bg-yellow-3 text-center">Plus Package</div>
                            <div class="plan-content text-center plan-shadow">
                                <h4>KD 250.00</h4>
                                <div>for 1 Month</div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Products:
                                        <span>120</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                        (Reels): <span>60</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                        Highlights: <span>10</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within 24
                                        hours</li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store Employees
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                        <span>2.5%</span>
                                    </li>
                                </ul>
                                <div class="py-3">
                                    <a href="#" class="btn btn-success w-100">Purchase</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="plan-card plan-shadow">
                            <div class="plan-header bg-yellow-4 text-center">Growth Package</div>
                            <div class="plan-content text-center plan-shadow">
                                <h4>KD 250.00</h4>
                                <div>for 1 Month</div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Products:
                                        <span>120</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                        (Reels): <span>60</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                        Highlights: <span>10</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within 24
                                        hours</li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store Employees
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                        <span>2.5%</span>
                                    </li>
                                </ul>
                                <div class="py-3">
                                    <a href="#" class="btn btn-success w-100">Purchase</a>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('seller.skip_plan') }}" class="link-color">Skip</a>
            </div>
        </div>
    </div>

</body>


<!-- Vendor JS Files -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>


<!--Main JS File -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/main.js"></script>



@include('dealer.layout.custom_code');


</html>

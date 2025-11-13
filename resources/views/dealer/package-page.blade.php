<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> desynat seller </title>
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/favicon.png" rel="icon">
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

    <div class="login-wapper">
        <div class="login-grid-bg2 planheight"></div>
        <div class="container">
            <div class="plan-wapper">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="plan-card plan-shadow plan-circle">
                            <div class="plan-circle plan-shadow p-3">
                                <div class="pkg-list">
                                    <h6>Package Name</h6>
                                    <h6 class="font-600">{{ $plans->plan_name_english }}</h6>
                                </div>
                                <div class="pkg-list">
                                    <h6>Price</h6>
                                    <h6 class="font-600">{{ $plans->price }} KD </h6>
                                </div>
                                <div class="pkg-list">
                                    <h6>Duration</h6>
                                    <h6 class="font-600">{{ $plans->duration }} @if ($plans->duration_type == '1')
                                            Month
                                        @else
                                            Year
                                        @endif
                                    </h6>
                                </div>
                            </div>

                            <div class="plan-body p-3">
                                <ul class="list-inline">
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Products:
                                        <span class="font-600">{{ $plans->no_of_products }}</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                        (Reels): <span class="font-600">{{ $plans->no_of_videos }}</span></li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                        Highlights:
                                        <span class="font-600">{{ $plans->no_of_highlights }}</span>
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within 24
                                        hours</li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">5 Store Employees
                                    </li>
                                    <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Commission :
                                        <span class="font-600">2.5%</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-5 col-md-6">

                        <form action="{{ route('seller.create_subcription') }}" method="post">

                            <input type="hidden" name="plan_id" value="{{ $plans->id }}">
                            @csrf
                            <div class="plan-card plan-shadow plan-circle">
                                <div class="plan-body p-3 pt-4">
                                    <div class="cmn-header">
                                        <h1><a href="#"><i class="bi bi-chevron-left"></i></a> Payment method</h1>
                                    </div>
                                    <div class="payment">SELECT PAYMENT METHOD</div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            value="Myfatoorah" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Myfatoorah
                                        </label>
                                    </div>

                                    @error('payment_method')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror


                                    <div class="total-pnl mt-4">
                                        <div class="tamount">Total Amount</div>
                                        <div class="price-kd">KD {{ $plans->price }}</div>
                                    </div>


                                    <div class="py-3 mt-3">

                                        <input type="submit" name="submit" value="Pay Now"
                                            class="btn btn-success w-100">

                                        {{-- <a href="package-page.php" class="btn btn-success w-100">Pay Now</a> --}}
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{ asset('dealer') }}/assets/img/success.svg" alt="icon" class="img-fluid">
                        <div class="title24 py-3">Plan Purchased Successfully!</div>
                    </div>
                </div>
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success1'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
    });
</script>

</html>


    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="py-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5>Total Products Added</h5>
                        <div class="title30">{{$dashboardData['total_products']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class="total-revenu border20 shadow20 p20 mt-4">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content">
                        <h5>Total Revenue Generated</h5>
                        <h1 class="font-34 py-3">{{$dashboardData['total_revenue']}} KD</h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer') }}/assets/img/profit.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="title24">Total Orders <span class="gold-title">({{$dashboardData['total_orders']}})</span></div>
        <div class="row mt-3">
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-4">
                    <div class="dash-content">
                        <h5>Ongoing </h5>
                        <div class="title30">{{$dashboardData['total_ongoing']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-3">
                    <div class="dash-content">
                        <h5>Completed</h5>
                        <div class="title30">{{$dashboardData['total_completed']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5>Returned </h5>
                        <div class="title30">{{$dashboardData['total_returned']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5 style="color:#CD0E26;">Cancelled</h5>
                        <div class="title30">{{$dashboardData['total_cancelled']}}</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

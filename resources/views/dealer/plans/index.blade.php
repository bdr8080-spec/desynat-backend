@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Subscription Plans</div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-listed-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-listed" type="button" role="tab" aria-controls="pills-listed"
                    aria-selected="true">Listed Plans</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-plan-tab" data-bs-toggle="pill" data-bs-target="#pills-plan"
                    type="button" role="tab" aria-controls="pills-plan" aria-selected="false">My Plan</button>
            </li>
        </ul>
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-listed" role="tabpanel" aria-labelledby="pills-listed-tab"
                tabindex="0">
                <div class="plan-wapper-2">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="plan-card plan-shadow">
                                <div class="plan-header bg-yellow-2 text-center">Pro Package</div>
                                <div class="plan-content text-center plan-shadow">
                                    <h4>KD 250.00</h4>
                                    <div>for 1 Month</div>
                                </div>

                                <div class="plan-body p-3">
                                    <ul class="list-inline">
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Products:
                                            <span>120</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                            (Reels): <span>60</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Highlights: <span>10</span></li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within
                                            24
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
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Products:
                                            <span>120</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                            (Reels): <span>60</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Highlights: <span>10</span></li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within
                                            24
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
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Products:
                                            <span>120</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of Videos
                                            (Reels): <span>60</span>
                                        </li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">Number of
                                            Highlights: <span>10</span></li>
                                        <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">15 stories within
                                            24
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

                    </div>
                </div>
            </div>

            <!-------------  my plan ------------>

            <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-plan-tab" tabindex="0">
                
                <div class="rounded-4 desc-box shadow-sm bg-white mb-4">
                    <div class="card-header d-flex justify-content-between p-2 planmont">
                        <div class="monthly-color fw-semibold">Active</div>
                        <div class="monthly-color fw-semibold">Monthly</div>
                    </div>
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="col-6">Purchased On</div>
                            <div class="col-6">
                                <div class="text-end">21/03/2026 at 10:00 AM  </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Amount </div>
                            <div class="col-6">
                                <div class="text-end">200 KD</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Plan </div>
                            <div class="col-6">
                                <div class="text-end">Pro Plan </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-4 desc-box shadow-sm bg-white mb-4">
                    <div class="card-header d-flex justify-content-between p-2 planmont">
                        <div class="monthly-black fw-semibold">Expired</div>
                        <div class="monthly-color fw-semibold">Monthly</div>
                    </div>
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="col-6">Purchased On</div>
                            <div class="col-6">
                                <div class="text-end">21/03/2026 at 10:00 AM  </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Amount </div>
                            <div class="col-6">
                                <div class="text-end">200 KD</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Plan </div>
                            <div class="col-6">
                                <div class="text-end">Pro Plan </div>
                            </div>
                        </div>
                    </div>
                </div>

                


            </div>

        </div>
    </div>
    </div>
</section>

@include('dealer.layout.footer');
@include('dealer.product.ajax.datatablejs');
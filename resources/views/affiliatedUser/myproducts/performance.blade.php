@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="d-flex justify-content-between mt-4 mb-5">
        <a href="/my-product" class="title24 alink">
            <i class="bi bi-chevron-left"></i> Item Performance
        </a>
    </div>
    
    <div class="performance-pnl my-4 mb-5">
        <div class="d-flex gap-4">
            <div class="performance-img">
                <img src="{{ asset('dealer') }}/assets/img/all-icons/dashboard.svg" alt="icon" class="img-fluid">
            </div>
            <div class="performance-content">
                <div class="sub-title"> Solid Mens Cotton Full Sleeve</div>
                <div class="af-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span>(123K)</span>
                </div>
                <div class="per-size d-flex gap-2 py-1">
                    <div class="per-1">Size: <span> M </span></div>
                    <div class="per-1">Color: <span> <i class="bi bi-circle-fill"></i> </span></div>
                    <div class="per-1">Qnt: <span> 20</span></div>
                </div>
                <div class="af-price-line"><span class="af-price text-black">739 KD</span> <span class="text-decoration-line-through"> 239 KD </span> 20% Off </div>
                <div class="commission-text">5% Commission </div>

            </div>
        </div>
        <div class="link-copy">
            <div class="link-title"> Link: <span>http://www.desynat.com/</span> <i class="bi bi-copy"></i> </div>
        </div>
    </div>


    <div class="group-radio-btn d-flex gap-4 justify-content-between flex-wrap">
        <div class="title24">Quick Summary</div>
        <div class="show-date d-flex gap-2  flex-wrap">
            <div class="date-form-pnl">
                <input type="date" class="form-control">
            </div>
            <div class="date-form-pnl">
                <input type="date" class="form-control">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="py-4 pb-0">
                <div class="dash-box border20 shadow20 p20 pnl-flex total-revenue-bg">
                    <div class="dash-content ">
                        <h5 class="text-white">Total Revenue</h5>
                        <div class="title30 text-white">120</div>
                    </div>
                    <div class="dash-circle-2">
                        <img src="{{ asset('dealer') }}/assets/img/m3-icon/ren-icon.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class=" border20 shadow20 p20 mt-4 my-earning-bg">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content ">
                        <h5 class="text-white">My Earnings</h5>
                        <h1 class="font-34 py-3 text-white">12,542 KD</h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer') }}/assets/img/m3-icon/white-ic.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="py-2">
        <div class="row mt-3">
            <div class="col-lg-4 col-md-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-4 click-bg">
                    <div class="dash-content">
                        <h5>Total Clicks </h5>
                        <div class="title30">120</div>
                    </div>
                    <div class="dash-circle-2">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/or-click.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-3 order-bg-box">
                    <div class="dash-content">
                        <h5>Total Orders</h5>
                        <div class="title30">50</div>
                    </div>
                    <div class="dash-circle-2">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/total-order.svg" alt="icon" class="img-fluid">

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="total-revenu border20 shadow20 p20 mb-3">
                    <div class="total-revenu-box pnl-flex">
                        <div class="dash-content">
                            <h5>Conversion rate</h5>
                            <div class="title30">2.3%</div>
                        </div>
                        <div class="total-revenu-image">
                            <img src="{{ asset('dealer') }}/assets/img/profit.svg" alt="icon" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>
           
            
        </div>
    </div>









</section>





@include('affiliatedUser.layout.footer')